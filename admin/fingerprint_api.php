<?php
/**
 * WebAuthn Fingerprint API Endpoint
 * Handles registration and authentication of fingerprint/biometric credentials
 */

include_once("../dbconnection.php");
include_once("webauthn_helper.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Determine the RP ID and origin from the current request
$rpId = $_SERVER['HTTP_HOST'];
// Remove port from rpId if present
if (strpos($rpId, ':') !== false) {
    $rpId = explode(':', $rpId)[0];
}
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$origin = $scheme . '://' . $_SERVER['HTTP_HOST'];

$webauthn = new WebAuthnHelper('Yash Coldrinks', $rpId, $origin);

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    // ─── REGISTRATION FLOW ──────────────────────────────────────
    case 'register_options':
        handleRegisterOptions();
        break;
    case 'register_verify':
        handleRegisterVerify();
        break;

    // ─── AUTHENTICATION FLOW ────────────────────────────────────
    case 'login_options':
        handleLoginOptions();
        break;
    case 'login_verify':
        handleLoginVerify();
        break;

    // ─── MANAGEMENT ─────────────────────────────────────────────
    case 'get_credentials':
        handleGetCredentials();
        break;
    case 'delete_credential':
        handleDeleteCredential();
        break;
    case 'check_support':
        handleCheckSupport();
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}

// ═══════════════════════════════════════════════════════════════════
// HANDLER FUNCTIONS
// ═══════════════════════════════════════════════════════════════════

/**
 * Step 1 of Registration: Generate options for navigator.credentials.create()
 * Requires the user to be logged in
 */
function handleRegisterOptions()
{
    global $webauthn, $conn;

    // Must be logged in to register fingerprint
    if (!isset($_SESSION['USERID'])) {
        echo json_encode(['error' => 'Not authenticated']);
        return;
    }

    $userId = $_SESSION['USERID'];
    $userName = $_SESSION['USERNAME'];

    // Create table if not exists
    ensureTableExists();

    $options = $webauthn->getRegistrationOptions(
        strval($userId),
        $userName,
        $userName
    );

    echo json_encode(['success' => true, 'options' => $options]);
}

/**
 * Step 2 of Registration: Verify the attestation response
 */
function handleRegisterVerify()
{
    global $webauthn, $conn;

    if (!isset($_SESSION['USERID'])) {
        echo json_encode(['error' => 'Not authenticated']);
        return;
    }

    $clientDataJSON = isset($_POST['clientDataJSON']) ? $_POST['clientDataJSON'] : '';
    $attestationObject = isset($_POST['attestationObject']) ? $_POST['attestationObject'] : '';
    $credentialName = isset($_POST['credentialName']) ? $_POST['credentialName'] : 'My Fingerprint';

    if (empty($clientDataJSON) || empty($attestationObject)) {
        echo json_encode(['error' => 'Missing data']);
        return;
    }

    $result = $webauthn->verifyRegistration($clientDataJSON, $attestationObject);

    if (isset($result['error'])) {
        echo json_encode(['error' => 'Verification failed: ' . $result['error']]);
        return;
    }

    // Store credential in database
    $userId = $_SESSION['USERID'];
    $credentialId = $result['credentialId'];
    $publicKey = $result['publicKey'];
    $signCount = $result['signCount'];

    ensureTableExists();

    $stmt = $conn->prepare("INSERT INTO `webauthn_credentials` (`user_id`, `credential_id`, `public_key`, `sign_count`, `credential_name`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $userId, $credentialId, $publicKey, $signCount, $credentialName);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Fingerprint registered successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to save credential']);
    }
}

/**
 * Step 1 of Authentication: Generate options for navigator.credentials.get()
 */
function handleLoginOptions()
{
    global $webauthn, $conn;

    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';

    ensureTableExists();

    // If mobile provided, get credentials for that user
    $allowCredentials = [];
    $userId = null;

    if (!empty($mobile)) {
        $stmt = $conn->prepare("SELECT a.id, wc.credential_id FROM `admin` a JOIN `webauthn_credentials` wc ON a.id = wc.user_id WHERE a.mobile = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $allowCredentials[] = $row['credential_id'];
            $userId = $row['id'];
        }

        if (empty($allowCredentials)) {
            echo json_encode(['error' => 'No fingerprint registered for this mobile number']);
            return;
        }
    } else {
        // Get ALL credentials (for discoverable credentials / passkeys)
        $result = $conn->query("SELECT credential_id FROM `webauthn_credentials`");
        while ($row = $result->fetch_assoc()) {
            $allowCredentials[] = $row['credential_id'];
        }

        if (empty($allowCredentials)) {
            echo json_encode(['error' => 'No fingerprints registered yet']);
            return;
        }
    }

    // Store mobile in session for login verification
    $_SESSION['webauthn_mobile'] = $mobile;

    $options = $webauthn->getAuthenticationOptions($allowCredentials);

    echo json_encode(['success' => true, 'options' => $options]);
}

/**
 * Step 2 of Authentication: Verify the assertion response
 */
function handleLoginVerify()
{
    global $webauthn, $conn;

    $credentialId = isset($_POST['credentialId']) ? $_POST['credentialId'] : '';
    $clientDataJSON = isset($_POST['clientDataJSON']) ? $_POST['clientDataJSON'] : '';
    $authenticatorData = isset($_POST['authenticatorData']) ? $_POST['authenticatorData'] : '';
    $signature = isset($_POST['signature']) ? $_POST['signature'] : '';

    if (empty($credentialId) || empty($clientDataJSON) || empty($authenticatorData) || empty($signature)) {
        echo json_encode(['error' => 'Missing data']);
        return;
    }

    ensureTableExists();

    // Look up the credential
    $stmt = $conn->prepare("SELECT wc.*, a.username, a.role, a.id as admin_id FROM `webauthn_credentials` wc JOIN `admin` a ON wc.user_id = a.id WHERE wc.credential_id = ?");
    $stmt->bind_param("s", $credentialId);
    $stmt->execute();
    $result = $stmt->get_result();
    $credential = $result->fetch_assoc();

    if (!$credential) {
        echo json_encode(['error' => 'Credential not found']);
        return;
    }

    // Verify the assertion
    $verifyResult = $webauthn->verifyAuthentication(
        $clientDataJSON,
        $authenticatorData,
        $signature,
        $credential['public_key'],
        $credential['sign_count']
    );

    if (isset($verifyResult['error'])) {
        echo json_encode(['error' => 'Authentication failed: ' . $verifyResult['error']]);
        return;
    }

    // Update sign count
    $newSignCount = $verifyResult['signCount'];
    $updateStmt = $conn->prepare("UPDATE `webauthn_credentials` SET `sign_count` = ?, `last_used` = NOW() WHERE `id` = ?");
    $updateStmt->bind_param("ii", $newSignCount, $credential['id']);
    $updateStmt->execute();

    // Set session (same as normal login)
    $_SESSION["LOGIN"] = true;
    $_SESSION["USERID"] = $credential['admin_id'];
    $_SESSION["USERNAME"] = $credential['username'];
    $_SESSION["ROLE"] = $credential['role'];

    echo json_encode([
        'success' => true,
        'result'  => 1,
        'message' => 'Login successful via fingerprint!'
    ]);
}

/**
 * Get registered credentials for the current user
 */
function handleGetCredentials()
{
    global $conn;

    if (!isset($_SESSION['USERID'])) {
        echo json_encode(['error' => 'Not authenticated']);
        return;
    }

    ensureTableExists();

    $userId = $_SESSION['USERID'];
    $stmt = $conn->prepare("SELECT `id`, `credential_name`, `created_at`, `last_used` FROM `webauthn_credentials` WHERE `user_id` = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $credentials = [];
    while ($row = $result->fetch_assoc()) {
        $credentials[] = $row;
    }

    echo json_encode(['success' => true, 'credentials' => $credentials]);
}

/**
 * Delete a specific credential
 */
function handleDeleteCredential()
{
    global $conn;

    if (!isset($_SESSION['USERID'])) {
        echo json_encode(['error' => 'Not authenticated']);
        return;
    }

    $credId = isset($_POST['credId']) ? intval($_POST['credId']) : 0;
    $userId = $_SESSION['USERID'];

    $stmt = $conn->prepare("DELETE FROM `webauthn_credentials` WHERE `id` = ? AND `user_id` = ?");
    $stmt->bind_param("ii", $credId, $userId);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Credential deleted']);
    } else {
        echo json_encode(['error' => 'Failed to delete credential']);
    }
}

/**
 * Check if any fingerprints exist for a mobile number
 */
function handleCheckSupport()
{
    global $conn;

    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';

    ensureTableExists();

    if (!empty($mobile)) {
        $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM `admin` a JOIN `webauthn_credentials` wc ON a.id = wc.user_id WHERE a.mobile = ?");
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'hasFingerprint' => $row['cnt'] > 0]);
    } else {
        echo json_encode(['success' => true, 'hasFingerprint' => false]);
    }
}

// ═══════════════════════════════════════════════════════════════════
// DATABASE HELPER
// ═══════════════════════════════════════════════════════════════════

/**
 * Create the webauthn_credentials table if it doesn't exist
 */
function ensureTableExists()
{
    global $conn;

    $conn->query("CREATE TABLE IF NOT EXISTS `webauthn_credentials` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `credential_id` text NOT NULL,
        `public_key` text NOT NULL,
        `sign_count` int(11) NOT NULL DEFAULT 0,
        `credential_name` varchar(255) NOT NULL DEFAULT 'My Fingerprint',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `last_used` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `fk_webauthn_user` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
}
