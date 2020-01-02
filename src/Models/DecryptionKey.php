<?php

namespace Shetabit\Crypto\Models;

use Illuminate\Database\Eloquent\Model;

class DecryptionKey extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crypto_decryption_keys';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'algorithm', 'scope', 'crypto_encryption_key_id',
        'user_id', 'user_type', 'expired_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Retrieve encryption key
     *
     * @return mixed
     */
    public function encryptionKey()
    {
        return $this->belongsTo(EncryptionKey::class, 'crypto_encryption_key_id');
    }
}
