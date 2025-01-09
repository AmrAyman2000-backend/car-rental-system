<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Traits\apiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use apiResponse;

    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? "user"
        ]);
        return $this->apiResponse("200","Register successfully",null,200);
    }
    public function login(loginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->apiResponse(400,'unauthorized');
        }

        return $this->respondWithToken($token);
    }
    protected function respondWithToken($token)
    {
         $array = [
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
         return $this->apiResponse(200, 'login success',null ,$array);
    }
    public function logout()
    {
        auth()->logout();

        return $this->apiResponse(200, 'Logout successfully');
    }
}
