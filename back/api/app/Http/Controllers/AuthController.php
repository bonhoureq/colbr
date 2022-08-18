<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:45',
            'lastname' => 'required|max:45',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:155',
        ]);

        $validated = $validator->validated();
        $validated['password'] = Hash::make($request->password);
        //$user = User::create($validated);
        //return response()->json([
        //    'token' =>$user->createToken('API Token')->plainTextToken
        //],201);
    }

    public function connect(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:155'
        ]);


        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return response()->json("200");
        }
        return response()->json("400");
    }
}
