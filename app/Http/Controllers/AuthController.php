<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        try {
            $data = $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('laravel_token')->plainTextToken;

            return $this->success('login successfully', new UserResource($user), $token);
        } catch (ValidationException $v) {
            return $this->validationError('invalid data', $v->errors());
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return $this->success('logout successfully');
    }
}
