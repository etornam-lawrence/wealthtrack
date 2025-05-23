<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\CurrentAccount;

class CurrentAccountController extends Controller
{
    public function create(){
        $user = Auth::user();
        return view('accounts.current.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alias' => 'required|string|min:3|unique:current_accounts',
        ]);

        $validated['account_number'] = Account::generateCurrentAccountNumber();
        $validated['user_id'] = Auth::id(); 
        
        if(!$validated['user_id']) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to create an account.']);
        }

        CurrentAccount::create($validated);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }


    
    public function show(CurrentAccount $current)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to view an account.']);
        }

        // Check if the savings account belongs to the authenticated user
        if ($current->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Pass as $account to match Blade file
        $account = $current;

        return view('accounts.current.show', compact('account', 'user'));
    }

    public function edit(CurrentAccount $current)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to edit an account.']);
        }
        $account = $current;

        // Check if the savings account belongs to the authenticated user
        if ($current->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('accounts.current.edit', compact('current', 'user', 'account'));
    }

    public function update(Request $request, CurrentAccount $current)
    {
        $validated = $request->validate([
            'alias' => 'required|string|min:3|unique:current_accounts,alias,' . $current->id,
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to update an account.']);
        }

        // Check if the savings account belongs to the authenticated user
        if ($current->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $current->update($validated);

        return redirect()->route('accounts.current.show', ['current' => $current])->with('success', 'Account updated successfully.');
    }


    public function destroy(CurrentAccount $current)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to delete an account.']);
        }

        // Check if the savings account belongs to the authenticated user
        if ($current->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $current->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }

}
