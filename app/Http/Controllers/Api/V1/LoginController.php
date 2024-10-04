<?php declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\User;
use App\Traits\Api\Responses;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Responses;

    public function __invoke(LoginRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error(__('Invalid credentials'), 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'user'  => $user,
                'token' => $user->createToken('API Token for' . $user->email)->plainTextToken,
            ]
        );
    }
}
