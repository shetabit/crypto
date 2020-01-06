<?php

use Shetabit\Crypto\Facade\Crypto;

if (! function_exists('crypto')) {
    function crypto() {
        return new Crypto;
    }
};