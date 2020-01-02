<?php

namespace Shetabit\Crypto\Traits;

use Shetabit\Crypto\Models\EncryptionKey;

trait HasEcryptionKeys
{
    /**
     * Get all of the user's encryption keys.
     */
    public function encryptionKeys()
    {
        return $this->morphMany(EncryptionKey::class);
    }
}