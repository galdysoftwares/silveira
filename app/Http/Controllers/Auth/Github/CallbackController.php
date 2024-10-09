<?php declare(strict_types = 1);

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(): \Illuminate\Http\RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'email' => $githubUser->getEmail(),
        ], [
            'name'              => $githubUser->getName(),
            'email'             => $githubUser->getEmail(),
            'password'          => bcrypt($githubUser->getNickname()),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
