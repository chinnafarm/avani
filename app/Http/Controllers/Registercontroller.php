<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Registercontroller extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string||max:255',
            'city' => 'required|string',
            'email' => 'required|string|email|unique:register|max:255', // Update to use the 'register' table
            'password' => 'required|string|min:6|max:255',
            
        ]);
    
        $user = User::create($validatedData);
    
        return response()->json($user, 201);
    }

    public function getUsers(Request $request)
    {
        // Retrieve the authenticated admin
        $admin = Auth::user();

        // Fetch users belonging to the village of the authenticated admin
        $users = User::where('village', $admin->village_name)->get();

        return response()->json($users, 200);
    }
}
