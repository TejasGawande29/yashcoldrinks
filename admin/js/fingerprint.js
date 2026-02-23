/**
 * WebAuthn Fingerprint Client - Handles browser-side biometric authentication
 * Uses the Web Authentication API (WebAuthn / FIDO2)
 */

const FingerprintAuth = {
    apiUrl: 'fingerprint_api.php',

    /**
     * Check if WebAuthn is supported in this browser
     */
    isSupported() {
        return window.PublicKeyCredential !== undefined &&
            typeof window.PublicKeyCredential === 'function';
    },

    /**
     * Check if platform authenticator (fingerprint/face) is available
     */
    async isPlatformAvailable() {
        if (!this.isSupported()) return false;
        try {
            return await PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable();
        } catch (e) {
            return false;
        }
    },

    /**
     * Base64URL helpers
     */
    base64UrlToBuffer(base64url) {
        const base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
        const padding = '='.repeat((4 - base64.length % 4) % 4);
        const binary = atob(base64 + padding);
        const bytes = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) {
            bytes[i] = binary.charCodeAt(i);
        }
        return bytes.buffer;
    },

    bufferToBase64Url(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.length; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    },

    // ─── REGISTRATION ────────────────────────────────────────────

    /**
     * Register a fingerprint for the currently logged-in user
     * @param {string} credentialName - Friendly name for this fingerprint
     */
    async register(credentialName = 'My Fingerprint') {
        if (!this.isSupported()) {
            throw new Error('Your browser does not support fingerprint login.');
        }

        const available = await this.isPlatformAvailable();
        if (!available) {
            throw new Error('No fingerprint sensor detected on this device.');
        }

        // Step 1: Get registration options from server
        const optionsResponse = await this.postToServer({ action: 'register_options' });

        if (optionsResponse.error) {
            throw new Error(optionsResponse.error);
        }

        const options = optionsResponse.options;

        // Convert base64url strings to ArrayBuffers
        const publicKeyOptions = {
            challenge: this.base64UrlToBuffer(options.challenge),
            rp: options.rp,
            user: {
                id: this.base64UrlToBuffer(options.user.id),
                name: options.user.name,
                displayName: options.user.displayName,
            },
            pubKeyCredParams: options.pubKeyCredParams,
            timeout: options.timeout,
            attestation: options.attestation,
            authenticatorSelection: options.authenticatorSelection,
        };

        // Step 2: Ask the browser to create a credential (triggers fingerprint prompt)
        let credential;
        try {
            credential = await navigator.credentials.create({
                publicKey: publicKeyOptions,
            });
        } catch (err) {
            if (err.name === 'NotAllowedError') {
                throw new Error('Fingerprint registration was cancelled.');
            }
            throw new Error('Fingerprint registration failed: ' + err.message);
        }

        // Step 3: Send the credential to the server for verification
        const verifyResponse = await this.postToServer({
            action: 'register_verify',
            clientDataJSON: this.bufferToBase64Url(credential.response.clientDataJSON),
            attestationObject: this.bufferToBase64Url(credential.response.attestationObject),
            credentialName: credentialName,
        });

        if (verifyResponse.error) {
            throw new Error(verifyResponse.error);
        }

        return verifyResponse;
    },

    // ─── AUTHENTICATION ──────────────────────────────────────────

    /**
     * Login with fingerprint
     * @param {string} mobile - The user's mobile number
     */
    async login(mobile = '') {
        if (!this.isSupported()) {
            throw new Error('Your browser does not support fingerprint login.');
        }

        // Step 1: Get authentication options from server
        const optionsResponse = await this.postToServer({
            action: 'login_options',
            mobile: mobile,
        });

        if (optionsResponse.error) {
            throw new Error(optionsResponse.error);
        }

        const options = optionsResponse.options;

        // Convert base64url strings to ArrayBuffers
        const publicKeyOptions = {
            challenge: this.base64UrlToBuffer(options.challenge),
            rpId: options.rpId,
            timeout: options.timeout,
            userVerification: options.userVerification,
        };

        if (options.allowCredentials && options.allowCredentials.length > 0) {
            publicKeyOptions.allowCredentials = options.allowCredentials.map(cred => ({
                type: cred.type,
                id: this.base64UrlToBuffer(cred.id),
            }));
        }

        // Step 2: Ask the browser to authenticate (triggers fingerprint prompt)
        let assertion;
        try {
            assertion = await navigator.credentials.get({
                publicKey: publicKeyOptions,
            });
        } catch (err) {
            if (err.name === 'NotAllowedError') {
                throw new Error('Fingerprint authentication was cancelled.');
            }
            throw new Error('Fingerprint authentication failed: ' + err.message);
        }

        // Step 3: Send the assertion to the server for verification
        const credentialIdBase64 = btoa(String.fromCharCode(...new Uint8Array(assertion.rawId)));

        const verifyResponse = await this.postToServer({
            action: 'login_verify',
            credentialId: credentialIdBase64,
            clientDataJSON: this.bufferToBase64Url(assertion.response.clientDataJSON),
            authenticatorData: this.bufferToBase64Url(assertion.response.authenticatorData),
            signature: this.bufferToBase64Url(assertion.response.signature),
        });

        if (verifyResponse.error) {
            throw new Error(verifyResponse.error);
        }

        return verifyResponse;
    },

    // ─── CREDENTIAL MANAGEMENT ───────────────────────────────────

    /**
     * Get registered credentials for the current user
     */
    async getCredentials() {
        return await this.postToServer({ action: 'get_credentials' });
    },

    /**
     * Delete a registered credential
     * @param {number} credId - Database ID of the credential
     */
    async deleteCredential(credId) {
        return await this.postToServer({ action: 'delete_credential', credId: credId });
    },

    /**
     * Check if a mobile number has a fingerprint registered
     * @param {string} mobile
     */
    async checkFingerprint(mobile) {
        return await this.postToServer({ action: 'check_support', mobile: mobile });
    },

    // ─── HELPERS ─────────────────────────────────────────────────

    /**
     * POST data to the fingerprint API
     */
    async postToServer(data) {
        const formData = new URLSearchParams();
        for (const [key, value] of Object.entries(data)) {
            formData.append(key, value);
        }

        const response = await fetch(this.apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString(),
        });

        return await response.json();
    },
};
