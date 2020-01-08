<?php

namespace Shetabit\Crypto;

class Crypto
{
    /**
     * Types of encryption keys.
     */
    const KEY_TYPE_RSA = OPENSSL_KEYTYPE_RSA;
    const KEY_TYPE_DSA = OPENSSL_KEYTYPE_DSA;
    const KEY_TYPE_DH = OPENSSL_KEYTYPE_DH;
    const KEY_TYPE_EC = OPENSSL_KEYTYPE_EC;

    /**
     * Defualt configs
     */
    const DEFAULT_KEY_TYPE = OPENSSL_KEYTYPE_EC;
    const DEFUALT_KEY_BITS = 2048;
    const DEFUALT_CURVE_NAME = 'sect571r1';

    /**
     * Create a new private key.
     *
     * @param $keyType
     * @param array $options
     *
     * @return string
     */
    public function createPrivateKey($keyType = null, array $options = []) : string
    {
        $keyType = $keyType ?? static::DEFAULT_KEY_TYPE;

        $defaults = array(
            'private_key_bits' => self::DEFUALT_KEY_BITS,
            'private_key_type' => $keyType
        );

        $options = array_merge($defaults, $options);

        if ($keyType === SELF::KEY_TYPE_EC && empty($options['curve_name'])) {
            $options['curve_name'] = self::DEFUALT_CURVE_NAME;
        }

        $handle = openssl_pkey_new($options);

        openssl_pkey_export($handle, $privateKey);

        openssl_free_key($handle);

        return $privateKey;
    }

    /**
     * Create a pair public key for given private key.
     *
     * @param string $privateKey
     *
     * @return string
     */
    public function createPublicKey(string $privateKey)
    {
        $keyId = openssl_pkey_get_private($privateKey);

        if (!$keyId) {
            return false;
        }

        $publicKey = openssl_pkey_get_details($keyId)['key'];
        openssl_free_key($keyId);

        return $publicKey;
    }

    /**
     * Encrypt the given data.
     *
     * @param string $publicKey
     * @param string $data
     *
     * @return string
     */
    public function encrypt(string $publicKey, string $data) : string
    {
        openssl_public_encrypt($data , $crypted , $publicKey , OPENSSL_PKCS1_PADDING);

        return $crypted;
    }

    /**
     * Decrypt the given data.
     *
     * @param string $privateKey
     * @param string $cryptedData
     *
     * @return string
     */
    public function decrypt(string $privateKey, string $cryptedData) : string
    {
        openssl_private_decrypt($cryptedData, $decrypted, $privateKey, OPENSSL_PKCS1_PADDING);

        return $decrypted;
    }

    /**
     * Sign the given data.
     *
     * @param string $privateKey
     * @param string $data
     *
     * @return string
     */
    public function sign($privateKey, $data) : string
    {
        $keyId = openssl_pkey_get_private($privateKey);
        openssl_sign($data, $signature, $keyId, OPENSSL_ALGO_SHA1);
        openssl_free_key($keyId);

        return $signature;
    }

    /**
     * Verify signed data.
     *
     * @param string $publicKey
     * @param string $data
     * @param string $signature
     *
     * @return bool
     */
    public function verify($publicKey, $data, $signature)
    {
        // fetch public key from certificate and ready it
        $keyid = openssl_pkey_get_public($publicKey);

        // state whether signature is okay or not
        $result = openssl_verify($data, $signature, $keyid, OPENSSL_ALGO_SHA1);

        // free the key from memory
        openssl_free_key($keyid);

        return (bool) $result;
    }
}