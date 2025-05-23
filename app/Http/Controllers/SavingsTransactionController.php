<?php

namespace App\Http\Controllers;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SavingsTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\SavingsAccount  $savings
     * @return \Illuminate\Http\Response
     */
    public function index(SavingsAccount $savings)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to view an account.']);
        }

        // Pass as $account to match Blade file
        $accounts = $savings;
        $transactions = $user->savings_transactions;

       
        if ($accounts->count() === 0) {
            return redirect()->route('accounts.savings.create')->with('error', 'You must create an account before creating a transaction.');
        }

        return view('transactions.savings.index', compact('accounts', 'user', 'transactions'));
    }

    


    public function create($accountId)
        {
            $user = Auth::user();

            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'You must be logged in.']);
            }

            // Get only the account that belongs to this user
            $account = $user->savingsAccounts()->where('id', $accountId)->firstOrFail();

            // Get all plans linked to this specific account
            $plans = $account->savingsPlans;

            return view('transactions.savings.create', compact('account', 'plans'));
        }


public function store(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->back()->withErrors(['error' => 'You must be logged in to perform this action.']);
    }

    // Validate the request
    $validatedData = $request->validate([
        'savings_account_id' => 'required|exists:savings_accounts,id',
        'amount' => 'required|numeric|gt:0',
        'type' => 'required|in:deposit,withdrawal',
        'description' => 'nullable|string|max:255',
    ]);

    // Fetch the specific savings account
    $savings = $user->savingsAccounts()->find($validatedData['savings_account_id']);
    $validatedData['user_id'] = $user->id;

    if (!$savings) {
        return back()->withErrors(['error' => 'Invalid savings account selected.']);
    }

    // Check balance for withdrawals
    if ($validatedData['type'] === 'withdrawal' && $savings->balance < $validatedData['amount']) {
        Log::info('Insufficient funds for withdrawal', [
            'user_id' => $user->id,
            'savings_account_id' => $savings->id,
            'balance' => $savings->balance,
            'amount' => $validatedData['amount'],
        ]);

        return back()
            ->withInput()
            ->withErrors(['amount' => 'Insufficient funds for withdrawal.']);
    }

    try {
        DB::beginTransaction();

        // Adjust balance
        if ($validatedData['type'] === 'deposit') {
            $savings->balance += $validatedData['amount'];
        } else {
            $savings->balance -= $validatedData['amount'];
        }
        $savings->save();

        if( ! $savings->save()){
            throw new \Exception('Transaction failed.');
        }   

        // dd($request->all());
        // Create the transaction
        $transaction = $savings->savings_transactions()->create($validatedData);
        // SavingsTransaction::create($validatedData);

        if(! $transaction){
            throw new \Exception('Transaction creation failed.');
        }

        DB::commit();

        return redirect()->route('transactions.savings.index', $savings->id)->with('success', 'Transaction created successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Transaction failed', [
            'user_id' => $user->id,
            'savings_account_id' => $savings->id,
            'error' => $e->getMessage()
        ]);
        // return $e;
        return back()->withErrors(['error' => 'Transaction failed.']);
    }
}



}
