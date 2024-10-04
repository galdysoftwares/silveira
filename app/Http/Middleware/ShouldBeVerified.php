<?php declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShouldBeVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (is_null($request->user()->email_verified_at)) {
            return to_route('auth.email-validation');
        }

        return $next($request);
    }
}
