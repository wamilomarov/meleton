<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomValidationException;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return mixed
     * @throws CustomValidationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $token = env('API_TOKEN');
        if ($request->bearerToken() == $token)
        {
            return $next($request);
        }

        throw CustomValidationException::withMessage('Invalid token');
    }
}
