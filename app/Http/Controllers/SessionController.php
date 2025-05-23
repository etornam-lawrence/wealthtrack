<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validated = request()->validate([
            'email'=> 'required',
            'password' => 'required',
        ]);

        if(! Auth::attempt($validated)){
            throw ValidationException::withMessages([
            'email' =>"invalid email",
            'password' =>"invalid password"
            ]);
        };

        // recycling the token to prevent malicious attacks
        request()->session()->regenerate();
        Auth::login(Auth::user());

        return redirect('/dashboard');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
