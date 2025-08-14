<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            User::create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully'
            ],201);
        }catch (\Exception $e){
            Log::critical($e->getMessage() . ' '  . $e->getFile() . ' ' . $e->getLine());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ],500);
        }
    }
}
