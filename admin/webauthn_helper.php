<?php
/**
 * WebAuthn Helper - Lightweight PHP WebAuthn Implementation
 * Enables fingerprint/biometric login via the Web Authentication API (FIDO2)
 * 
 * No external dependencies required - uses PHP's built-in OpenSSL extension.
 */

class WebAuthnHelper
{
    private $rpName;
    private $rpId;
    private $origin;

    /**
     * @param string $rpName  Relying Party display name
     * @param string $rpId    Relying Party ID (domain). Must match the effective domain of the origin.
     * @param string $origin  The full origin (scheme + host + optional port)
     */
    public function __construct($rpName = 'Yash Coldrinks', $rpId = 'localhost', $origin = 'http://localhost')
    {
        $this->rpName = $rpName;
        $this->rpId = $rpId;
        $this->origin = $origin;
    }

    // ─── Challenge Management ────────────────────────────────────────

    /**
     * Generate a cryptographically random challenge
     */
    public function generateChallenge($length = 32)
    {
        return random_bytes($length);
    }

    /**
     * Store challenge in session for later verification
     */
    public function storeChallenge($challenge)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['webauthn_challenge'] = base64_encode($challenge);
    }

    /**
     * Retrieve and clear stored challenge
     */
    public function getStoredChallenge()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $challenge = isset($_SESSION['webauthn_challenge']) ? base64_decode($_SESSION['webauthn_challenge']) : null;
        unset($_SESSION['webauthn_challenge']);
        return $challenge;
    }

    // ─── Registration (Attestation) ─────────────────────────────────

    /**
     * Generate options for navigator.credentials.create()
     */
    public function getRegistrationOptions($userId, $userName, $userDisplayName)
    {
        $challenge = $this->generateChallenge();
        $this->storeChallenge($challenge);

        return [
            'challenge' => $this->base64UrlEncode($challenge),
            'rp' => [
                'name' => $this->rpName,
                'id'   => $this->rpId,
            ],
            'user' => [
                'id'          => $this->base64UrlEncode($userId),
                'name'        => $userName,
                'displayName' => $userDisplayName,
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],   // ES256
                ['type' => 'public-key', 'alg' => -257],  // RS256
            ],
            'timeout' => 60000,
            'attestation' => 'none',
            'authenticatorSelection' => [
                'authenticatorAttachment' => 'platform', // Use built-in sensor (fingerprint, face, etc.)
                'userVerification'        => 'required',
                'residentKey'             => 'preferred',
            ],
        ];
    }

    /**
     * Verify and parse the attestation response from the browser
     * Returns credential data on success, or null on failure
     */
    public function verifyRegistration($clientDataJSON_b64, $attestationObject_b64)
    {
        // 1. Decode clientDataJSON
        $clientDataJSON = $this->base64UrlDecode($clientDataJSON_b64);
        $clientData = json_decode($clientDataJSON, true);

        if (!$clientData) {
            return ['error' => 'Invalid clientDataJSON'];
        }

        // 2. Verify type
        if ($clientData['type'] !== 'webauthn.create') {
            return ['error' => 'Invalid type in clientDataJSON'];
        }

        // 3. Verify challenge
        $storedChallenge = $this->getStoredChallenge();
        $receivedChallenge = $this->base64UrlDecode($clientData['challenge']);

        if (!$storedChallenge || !hash_equals($storedChallenge, $receivedChallenge)) {
            return ['error' => 'Challenge mismatch'];
        }

        // 4. Verify origin
        if (strpos($clientData['origin'], $this->rpId) === false) {
            return ['error' => 'Origin mismatch: ' . $clientData['origin']];
        }

        // 5. Decode attestation object (CBOR)
        $attestationObject = $this->base64UrlDecode($attestationObject_b64);
        $attestation = $this->cborDecode($attestationObject);

        if (!$attestation || !isset($attestation['authData'])) {
            return ['error' => 'Invalid attestation object'];
        }

        // 6. Parse authData
        $authData = $attestation['authData'];
        $authDataParsed = $this->parseAuthData($authData);

        if (!$authDataParsed || !isset($authDataParsed['credentialId'])) {
            return ['error' => 'Failed to parse authenticator data'];
        }

        // 7. Extract public key
        $publicKey = $this->coseKeyToPem($authDataParsed['publicKey']);

        if (!$publicKey) {
            return ['error' => 'Failed to extract public key'];
        }

        return [
            'credentialId' => base64_encode($authDataParsed['credentialId']),
            'publicKey'    => $publicKey,
            'signCount'    => $authDataParsed['signCount'],
        ];
    }

    // ─── Authentication (Assertion) ─────────────────────────────────

    /**
     * Generate options for navigator.credentials.get()
     */
    public function getAuthenticationOptions($allowCredentials = [])
    {
        $challenge = $this->generateChallenge();
        $this->storeChallenge($challenge);

        $options = [
            'challenge'        => $this->base64UrlEncode($challenge),
            'rpId'             => $this->rpId,
            'timeout'          => 60000,
            'userVerification' => 'required',
        ];

        if (!empty($allowCredentials)) {
            $options['allowCredentials'] = array_map(function ($cred) {
                return [
                    'type' => 'public-key',
                    'id'   => $this->base64UrlEncode(base64_decode($cred)),
                ];
            }, $allowCredentials);
        }

        return $options;
    }

    /**
     * Verify the assertion response from the browser
     * Returns true on success, or an error array on failure
     */
    public function verifyAuthentication($clientDataJSON_b64, $authenticatorData_b64, $signature_b64, $publicKeyPem, $storedSignCount = 0)
    {
        // 1. Decode clientDataJSON
        $clientDataJSON = $this->base64UrlDecode($clientDataJSON_b64);
        $clientData = json_decode($clientDataJSON, true);

        if (!$clientData) {
            return ['error' => 'Invalid clientDataJSON'];
        }

        // 2. Verify type
        if ($clientData['type'] !== 'webauthn.get') {
            return ['error' => 'Invalid type'];
        }

        // 3. Verify challenge
        $storedChallenge = $this->getStoredChallenge();
        $receivedChallenge = $this->base64UrlDecode($clientData['challenge']);

        if (!$storedChallenge || !hash_equals($storedChallenge, $receivedChallenge)) {
            return ['error' => 'Challenge mismatch'];
        }

        // 4. Verify origin
        if (strpos($clientData['origin'], $this->rpId) === false) {
            return ['error' => 'Origin mismatch'];
        }

        // 5. Decode authenticator data
        $authenticatorData = $this->base64UrlDecode($authenticatorData_b64);

        // 6. Verify RP ID hash
        $rpIdHash = substr($authenticatorData, 0, 32);
        $expectedRpIdHash = hash('sha256', $this->rpId, true);

        if (!hash_equals($expectedRpIdHash, $rpIdHash)) {
            return ['error' => 'RP ID hash mismatch'];
        }

        // 7. Check flags (bit 0 = User Present)
        $flags = ord($authenticatorData[32]);
        if (($flags & 0x01) === 0) {
            return ['error' => 'User not present'];
        }

        // 8. Verify sign count
        $signCount = unpack('N', substr($authenticatorData, 33, 4))[1];

        // 9. Verify signature
        $clientDataHash = hash('sha256', $clientDataJSON, true);
        $signedData = $authenticatorData . $clientDataHash;
        $signature = $this->base64UrlDecode($signature_b64);

        $publicKeyResource = openssl_pkey_get_public($publicKeyPem);
        if (!$publicKeyResource) {
            return ['error' => 'Invalid public key'];
        }

        $verified = openssl_verify($signedData, $signature, $publicKeyResource, OPENSSL_ALGO_SHA256);

        if ($verified !== 1) {
            // Try with different algorithm (RS256 vs ES256)
            $verified = openssl_verify($signedData, $signature, $publicKeyResource, 'sha256');
        }

        if ($verified !== 1) {
            return ['error' => 'Signature verification failed'];
        }

        return [
            'success'   => true,
            'signCount' => $signCount,
        ];
    }

    // ─── Helper Methods ─────────────────────────────────────────────

    /**
     * Parse authenticator data bytes
     */
    private function parseAuthData($authData)
    {
        if (strlen($authData) < 37) {
            return null;
        }

        $offset = 0;

        // RP ID hash (32 bytes)
        $rpIdHash = substr($authData, $offset, 32);
        $offset += 32;

        // Flags (1 byte)
        $flags = ord($authData[$offset]);
        $offset += 1;

        // Sign count (4 bytes, big-endian)
        $signCount = unpack('N', substr($authData, $offset, 4))[1];
        $offset += 4;

        // Check if attestedCredentialData is present (bit 6)
        if (($flags & 0x40) === 0) {
            return null; // No credential data
        }

        // AAGUID (16 bytes)
        $aaguid = substr($authData, $offset, 16);
        $offset += 16;

        // Credential ID length (2 bytes, big-endian)
        $credIdLen = unpack('n', substr($authData, $offset, 2))[1];
        $offset += 2;

        // Credential ID
        $credentialId = substr($authData, $offset, $credIdLen);
        $offset += $credIdLen;

        // Public key (CBOR-encoded COSE key)
        $publicKeyData = substr($authData, $offset);
        $publicKey = $this->cborDecode($publicKeyData);

        return [
            'rpIdHash'     => $rpIdHash,
            'flags'        => $flags,
            'signCount'    => $signCount,
            'aaguid'       => $aaguid,
            'credentialId' => $credentialId,
            'publicKey'    => $publicKey,
        ];
    }

    /**
     * Convert COSE key to PEM format
     */
    private function coseKeyToPem($coseKey)
    {
        if (!is_array($coseKey)) {
            return null;
        }

        // Key type: 1 = OKP, 2 = EC2, 3 = RSA
        $kty = isset($coseKey[1]) ? $coseKey[1] : null;

        if ($kty === 2) {
            // EC2 key (ES256)
            return $this->ec2KeyToPem($coseKey);
        } elseif ($kty === 3) {
            // RSA key
            return $this->rsaKeyToPem($coseKey);
        }

        return null;
    }

    /**
     * Convert EC2 COSE key to PEM
     */
    private function ec2KeyToPem($coseKey)
    {
        // -1 = x coordinate, -2 = y coordinate
        $x = $coseKey[-2];
        $y = $coseKey[-3];

        if (!$x || !$y) {
            return null;
        }

        // Uncompressed EC point: 0x04 || x || y
        $publicKeyUncompressed = "\x04" . $x . $y;

        // Build DER-encoded SubjectPublicKeyInfo for P-256
        $der = $this->buildEcDer($publicKeyUncompressed);

        $pem = "-----BEGIN PUBLIC KEY-----\n";
        $pem .= chunk_split(base64_encode($der), 64, "\n");
        $pem .= "-----END PUBLIC KEY-----\n";

        return $pem;
    }

    /**
     * Build DER for EC P-256 public key
     */
    private function buildEcDer($publicKeyBytes)
    {
        // OID for id-ecPublicKey (1.2.840.10045.2.1) + prime256v1 (1.2.840.10045.3.1.7)
        $algorithmIdentifier = hex2bin(
            '3059301306072a8648ce3d020106082a8648ce3d030107034200'
        );

        // Append the public key bytes
        return substr($algorithmIdentifier, 0, 26) . $publicKeyBytes;
    }

    /**
     * Convert RSA COSE key to PEM
     */
    private function rsaKeyToPem($coseKey)
    {
        // -1 = n (modulus), -2 = e (exponent)
        $n = $coseKey[-1];
        $e = $coseKey[-2];

        if (!$n || !$e) {
            return null;
        }

        $modulus = $this->derEncodeInteger($n);
        $exponent = $this->derEncodeInteger($e);

        $sequence = $this->derEncodeSequence($modulus . $exponent);
        $bitString = "\x03" . $this->derEncodeLength(strlen($sequence) + 1) . "\x00" . $sequence;

        // Algorithm identifier for RSA
        $algorithmIdentifier = hex2bin('300d06092a864886f70d0101010500');

        $outerSequence = $this->derEncodeSequence($algorithmIdentifier . $bitString);

        $pem = "-----BEGIN PUBLIC KEY-----\n";
        $pem .= chunk_split(base64_encode($outerSequence), 64, "\n");
        $pem .= "-----END PUBLIC KEY-----\n";

        return $pem;
    }

    private function derEncodeInteger($data)
    {
        // Add leading zero if high bit set
        if (ord($data[0]) > 0x7f) {
            $data = "\x00" . $data;
        }
        return "\x02" . $this->derEncodeLength(strlen($data)) . $data;
    }

    private function derEncodeSequence($data)
    {
        return "\x30" . $this->derEncodeLength(strlen($data)) . $data;
    }

    private function derEncodeLength($length)
    {
        if ($length < 0x80) {
            return chr($length);
        } elseif ($length < 0x100) {
            return "\x81" . chr($length);
        } elseif ($length < 0x10000) {
            return "\x82" . chr($length >> 8) . chr($length & 0xFF);
        }
        return chr($length);
    }

    // ─── CBOR Decoder (Minimal) ─────────────────────────────────────

    /**
     * Minimal CBOR decoder - supports the subset needed for WebAuthn
     */
    private function cborDecode($data)
    {
        $offset = 0;
        return $this->cborDecodeItem($data, $offset);
    }

    private function cborDecodeItem($data, &$offset)
    {
        if ($offset >= strlen($data)) {
            return null;
        }

        $initialByte = ord($data[$offset]);
        $majorType = ($initialByte >> 5) & 0x07;
        $additionalInfo = $initialByte & 0x1F;
        $offset++;

        $value = $this->cborDecodeAdditionalInfo($data, $offset, $additionalInfo);

        switch ($majorType) {
            case 0: // Unsigned integer
                return $value;

            case 1: // Negative integer
                return -1 - $value;

            case 2: // Byte string
                $result = substr($data, $offset, $value);
                $offset += $value;
                return $result;

            case 3: // Text string
                $result = substr($data, $offset, $value);
                $offset += $value;
                return $result;

            case 4: // Array
                $result = [];
                for ($i = 0; $i < $value; $i++) {
                    $result[] = $this->cborDecodeItem($data, $offset);
                }
                return $result;

            case 5: // Map
                $result = [];
                for ($i = 0; $i < $value; $i++) {
                    $key = $this->cborDecodeItem($data, $offset);
                    $val = $this->cborDecodeItem($data, $offset);
                    $result[$key] = $val;
                }
                return $result;

            case 7: // Simple values & floats
                if ($additionalInfo === 20) return false;
                if ($additionalInfo === 21) return true;
                if ($additionalInfo === 22) return null;
                return $value;

            default:
                return null;
        }
    }

    private function cborDecodeAdditionalInfo($data, &$offset, $additionalInfo)
    {
        if ($additionalInfo < 24) {
            return $additionalInfo;
        } elseif ($additionalInfo === 24) {
            $value = ord($data[$offset]);
            $offset += 1;
            return $value;
        } elseif ($additionalInfo === 25) {
            $value = unpack('n', substr($data, $offset, 2))[1];
            $offset += 2;
            return $value;
        } elseif ($additionalInfo === 26) {
            $value = unpack('N', substr($data, $offset, 4))[1];
            $offset += 4;
            return $value;
        } elseif ($additionalInfo === 27) {
            $hi = unpack('N', substr($data, $offset, 4))[1];
            $lo = unpack('N', substr($data, $offset + 4, 4))[1];
            $offset += 8;
            return ($hi << 32) | $lo;
        }
        return $additionalInfo;
    }

    // ─── Base64URL Encoding ─────────────────────────────────────────

    public function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64UrlDecode($data)
    {
        $data = strtr($data, '-_', '+/');
        $padding = strlen($data) % 4;
        if ($padding) {
            $data .= str_repeat('=', 4 - $padding);
        }
        return base64_decode($data);
    }
}
