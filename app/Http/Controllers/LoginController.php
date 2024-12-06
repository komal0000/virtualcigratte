<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->getMethod() == "GET") {
            return view('admin.login');
        } else {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $email = $validatedData['email'];
            $password = $validatedData['password'];

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return redirect()->route('admin.index');
            }

            return back()->withErrors(['message' => 'Invalid credentials or unauthorized access']);
        }
    }
}
