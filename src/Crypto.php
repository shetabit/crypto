<?php

namespace Shetabit\Crypto;

class Crypto
{
    public function createPrivateKey()
    {
        $handle = openssl_pkey_new(array(
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ));

        openssl_pkey_export($handle, $privateKey);

        openssl_free_key($handle);

        return $privateKey;
    }

    public function createPublicKey($privateKey)
    {
        $keyId = openssl_pkey_get_private($privateKey);

        if (!$keyId) {
            return false;
        }

        $publicKey = openssl_pkey_get_details($keyId)['key'];
        openssl_free_key($keyId);

        return $publicKey;
    }

    public function encrypt($publicKey, $data)
    {
        openssl_public_encrypt($data , $crypted , $publicKey , OPENSSL_PKCS1_PADDING);

        return $crypted;
    }

    public function decrypt($privateKey, $cryptedData)
    {
        openssl_private_decrypt($cryptedData, $decrypted, $privateKey, OPENSSL_PKCS1_PADDING);

        return $decrypted;
    }

    public function sign($privateKey, $data)
    {
        $keyId = openssl_pkey_get_private($privateKey);
        openssl_sign($data, $signature, $keyId, OPENSSL_ALGO_SHA1);
        openssl_free_key($keyId);

        return $signature;
    }

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