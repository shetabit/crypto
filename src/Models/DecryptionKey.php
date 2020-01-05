<?php

namespace Shetabit\Crypto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Shetabit\Crypto\Traits\Expiring;

class DecryptionKey extends Model
{
    use Expiring;

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
        'entity_id', 'entity_type', 'expired_at',
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

    /**
     * Retrieve related entity
     *
     * @return MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
