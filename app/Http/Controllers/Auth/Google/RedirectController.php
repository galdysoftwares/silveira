<?php declare(strict_types = 1);

namespace App\Http\Controllers\Auth\Google;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }
}
