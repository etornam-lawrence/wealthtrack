<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CurrentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {

        $user = Auth::user();
        $accounts = $user->currentAccounts;
        if ($accounts->count() === 0) {
            
            return redirect()->route('accounts.create')->with('error', 'You must create an account before creating a transaction.');
        }
        
        $transactions = $accounts->flatMap(function ($account) {
            return $account->transactions;
        });

        return view('transactions.index', compact('accounts', 'transactions', 'user'));
        
        
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $accounts = $user->currentAccounts;
        $budgets = $user->budgets;
        return view('transactions.create', compact('accounts', 'user','budgets'));
       
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // 1. Get the authenticated user and validate input
        $user = Auth::user();
        $validated = request()->validate([
            'user_id' => ['required', 'exists:users,id'],
            'current_account_id' => ['required', 'exists:current_accounts,id'],
            'budget_id' => 'nullable|exists:budgets,id',
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999.99', // Maximum amount 
                'regex:/^\d+(\.\d{1,2})?$/' // only 2 decimal places
            ],
            'transaction_type' => [
                'required',
                'string',
                'in:deposit,withdrawal'
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'amount.max' => 'The amount cannot exceed 999,999,999.99',
            'amount.regex' => 'The amount must have no more than 2 decimal places',
        ]);

        // 2. Get the account and check if it belongs to user
        $account = CurrentAccount::where('id', $validated['current_account_id'])
                         ->where('user_id', $user->id)
                         ->first();
                         
        if (!$account) {
            Log::warning('Invalid account access attempt', [
                'user_id' => $user->id,
                'current_account_id' => $validated['current_account_id']
            ]);
            return back()->withErrors(['current_account_id' => 'Invalid account selected.']);
        }

        // 3. Check if withdrawal is possible
        if ($validated['transaction_type'] === 'withdrawal' && $account->balance < $validated['amount']) {
            Log::info('Insufficient funds for withdrawal', [
                'user_id' => $user->id,
                'current_account_id' => $account->id,
                'balance' => $account->balance,
                'amount' => $validated['amount']
            ]);
            return back()
                ->withInput()
                ->withErrors(['amount' => 'Insufficient funds for withdrawal.']);
        }

        // 4. Update balance
        try {
            DB::beginTransaction();

            if (!$account->updateBalance($validated['amount'], $validated['transaction_type'])) {
                throw new \Exception('Failed to update account balance');
        }

            // Create the transaction
            $transaction = $account->transactions()->create($validated);

            if (!$transaction) {
                throw new \Exception('Failed to create transaction');
            }

            DB::commit();

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaction completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Transaction failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'current_account_id' => $account->id,
                'amount' => $validated['amount'],
                'transaction_type' => $validated['transaction_type']
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    
}