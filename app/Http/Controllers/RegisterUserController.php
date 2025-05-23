<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RegisterUserController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            $new = request()->validate([
                'first_name' => ['required', 'string', 'min:3','max:255'],
                'last_name' => ['required', 'string', 'min:3','max:255'],
                'phone' => ['required', 'string'],
                'location' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'confirmed']
            ]);
            
            // Additional phone validation
            $phone = $new['phone'];
            $phone = preg_replace('/[^0-9+]/', '', $phone); // Remove all non-numeric characters except +
            
            // Check if the phone number is valid
            if (!preg_match('/^\+[0-9]{3}[0-9]{9}$/', $phone)) {
                return back()->withErrors(['phone' => 'Please enter a valid phone number starting with country code (e.g., +233050123456)'])->withInput();
            }
            
            $new['phone'] = $phone;
            
            $user = User::create($new);
            Auth::login($user);

            return redirect('/dashboard');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $update = request()->validate([
            'first_name' => ['required', 'string', 'min:3','max:255'],
            'last_name' => ['required', 'string', 'min:3','max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string']
        ]);
    
        $user->update($update);
        
        return redirect('users');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        $user->delete();
                $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('users');
    }
}
