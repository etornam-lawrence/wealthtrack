<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\CurrentAccount;
use App\Models\SavingsAccount;

class UserAccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $savings = SavingsAccount::where('user_id', $user->id)->get();
        $current = CurrentAccount::where('user_id', $user->id)->get();
        $accounts = $savings->merge($current);
        return view('accounts.index', compact('savings', 'user', 'current', 'accounts'));
    }

    public function create()
    {
        
        $user = Auth::user();
        if(!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to create an account.']);
        }
        return view('accounts.create');
    }


}