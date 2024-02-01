<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\shop;
use Illuminate\Support\Facades\Hash; 

use Illuminate\Support\Facades\Auth; 


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Authentication was successful
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;
            $authenticated = true;
         
            return response()->json(['token' => $token, 'authenticated' => $authenticated ,'user' => Auth::user()], 200);
        } else {
            // Authentication failed
            $authenticated = false;
            return response()->json(['error' => 'Invalid credentials', 'authenticated' => $authenticated], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


    public function fetchUser(){
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }



   

    public function checkAuth(Request $request)
    {
        if (Auth::check()) {
            return response()->json(['authenticated' => true]);
        } else {
            return response()->json(['authenticated' => false]);
        }
    }
}