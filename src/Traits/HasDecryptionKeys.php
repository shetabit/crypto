<?php

namespace Shetabit\Crypto\Traits;

use Shetabit\Crypto\Models\DecryptionKey;

trait HasDecryptionKeys
{
    /**
     * Get all of the user's decryption keys.
     */
    public function decryptionKeys()
    {
        return $this->morphMany(DecryptionKey::class);
    }
}