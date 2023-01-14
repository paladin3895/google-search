<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenController extends Controller
{
    // create user's token
    public function create(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) {
            /** @var User */
            $user = Auth::user();
            return [
                'user' => $user,
                'token' => $user->createToken('auth')->plainTextToken,
            ];
        }

        throw new UnauthorizedHttpException('Invalid user credentials');
    }
}
