<?php

namespace Shetabit\Crypto\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Crypto
 *
 * @package Shetabit\Crypto\Facade
 */
class Crypto extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shetabit-crypto';
    }
}
