<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\JwtToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        try{
            $user = User::whereEmail($request->email)->first();
            if(!Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ]);
            }

            $userData = [
                'email' => $user->email,
                'id' => $user->id,
            ];
            $exp = time() + 3600 * 24;
            $token = JwtToken::createToken($userData,$exp);

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
            ],200)->cookie('token', $token['token'], $exp);

        }catch (\Exception $e){
            Log::critical($e->getMessage() . ' ' .  $e->getFile() . ' ' . $e->getLine());
            return response([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
