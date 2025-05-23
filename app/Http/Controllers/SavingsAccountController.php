<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\SavingsAccount;



class SavingsAccountController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to create an account.']);
        }
        return view('accounts.savings.create', compact('user'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'alias' => 'required|string|min:3|unique:savings_accounts',
            'savings_plan_id' => 'nullable|exists:savings_plans,id',
        ]);

        $validated['account_number'] = Account::generateSavingsAccountNumber();
        $validated['user_id'] = Auth::id(); 
        
        if(!$validated['user_id']) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to create an account.']);
        }

        SavingsAccount::create($validated);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }


    public function show(SavingsAccount $savings)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to view an account.']);
        }

        // Check if the savings account belongs to the authenticated user
        if ($savings->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        
        $account = $savings;
        $transactions = $account->savings_transactions()
                        ->latest()
                        ->take(2)
                        ->get();

        $plans = $savings->savingsPlans;


        return view('accounts.savings.show', compact('account', 'user', 'transactions'));
    }



    public function destroy(SavingsAccount $savings)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to delete an account.']);
        }

        // Check if the savings account belongs to the authenticated user
        if ($savings->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $savings->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
