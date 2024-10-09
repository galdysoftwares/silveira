<?php declare(strict_types = 1);

namespace App\Http\Controllers\Auth\Google;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(): \Illuminate\Http\RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name'              => $googleUser->getName(),
            'email'             => $googleUser->getEmail(),
            'password'          => bcrypt($googleUser->getNickname()),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
