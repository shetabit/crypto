<?php

namespace Shetabit\Crypto\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateKey extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crypto_private_keys';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'method', 'request', 'url', 'referer',
        'languages', 'useragent', 'headers',
        'device', 'platform', 'browser', 'ip',
        'visitor_id', 'visitor_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request' => 'array',
        'languages' => 'array',
        'headers' => 'array',
    ];
}
