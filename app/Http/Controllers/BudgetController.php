<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Auth::user()->budgets()->with('transactions')->get();
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $accounts = Auth::user()->currentAccounts()->get();
        $user = Auth::user();
        return view('budgets.create', compact('accounts', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'current_account_id' => 'required|exists:current_accounts,id',
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        // Check if the account belongs to the authenticated user
        $account = $user->currentAccounts->firstWhere('id', $validated['current_account_id']);

        if (!$account) {
            return back()->with('error', 'Selected account not found.');
        }
        
        // Check if the new budget amount would exceed the account balance
         // Check if the budget amount exceeds the account balance
        if ($validated['amount'] > $account->balance) {
            return back()->withErrors([
                'amount' => "Your account balance (GHS {$account->balance}) is less than the budget limit you set (GHS {$validated['amount']}). Please reduce the budget amount or choose a different account."
            ])->withInput();
        }

        // dd($validated);

        $validated['status'] = 'active'; // Default status
        $user->budgets()->create($validated);
        
        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
        
    }

    public function show(Budget $budget)
    {
        $budget->load('transactions');
        $budget->load('currentAccount');
        $remainigAmount = $budget->remaining_amount;

        // calculation to get current budget limit progress.
        $progressPercentage = $budget->progress_percentage;
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:active,closed',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }

}
