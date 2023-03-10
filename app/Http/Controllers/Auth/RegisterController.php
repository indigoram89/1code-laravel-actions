<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Users\CreateUserData;
use App\Actions\Users\CreateUserAction;
use App\Http\Requests\Auth\RegisterRequest;
use App\Actions\Auth\AuthenticateUserAction;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();

        $data = new CreateUserData(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
        );

        $user = (new CreateUserAction)->run($data);

        (new AuthenticateUserAction)->withSession($user);

        return redirect()->route('user');
    }
}
