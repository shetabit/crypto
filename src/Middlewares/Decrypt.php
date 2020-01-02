<?php

namespace Shetabit\Crypto\Middlewares;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Decrypt
{
    protected $algorithem;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $algorithem = 'RSA')
    {
        $this->algorithem = $algorithem;

        return $next($request);
    }
}
