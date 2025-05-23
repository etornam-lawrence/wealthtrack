<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\SavingsPlan;
use App\Models\Account;
use App\Models\SavingsAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SavingsPlanController extends Controller
{
    // List all savings plans for user
    public function index()
    {
        $user = Auth::user();
        $savings = $user->savingsPlans;
        return view('savings.index', compact('savings', 'user'));
    }

    // Show form to create new savings plan
    public function create()
    {
        $user = Auth::user();
        $plans = $user->savingsPlans;
        
        $accounts = $user->savingsAccounts;
            
        if ($accounts->isEmpty()) {
            return redirect()->route('accounts.create')
                ->with('error', 'You need to create an account first before creating a savings plan.');
        }
            
        return view('savings.create', compact('accounts'));
    }

    // Store a new savings plan
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'planName' => 'required|string|max:255|unique:savings_plans',
            'desiredAmount' => 'required|gt:0|numeric|max:999999999.99',
            'amount_per_interval' => 'nullable|gt:0|numeric|max:999999999.99',
            'regularity' => 'required|string|in:daily,weekly,biweekly,monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:1000',
        ]);


        // Confirm the account belongs to the user
        $account = $user->savingsAccounts->firstWhere('id', $validated['savings_account_id']);


        if (!$account) {
            return back()->with('error', 'Selected account not found or does not belong to you.');
        }

        // Validate if amount per interval makes sense with the desired amount
        if (isset($validated['amount_per_interval']) && !empty($validated['amount_per_interval'])) {
            $startDate = new \DateTime($validated['start_date']);
            $endDate = new \DateTime($validated['end_date']);
            $interval = $endDate->diff($startDate);
            $totalDays = $interval->days;
            
            $periodsMap = [
                'daily' => 1,
                'weekly' => 7,
                'biweekly' => 14,
                'monthly' => 30,
                'quarterly' => 90,
                'yearly' => 365
            ];
            
            $periodDays = $periodsMap[$validated['regularity']];
            $numberOfPeriods = ceil($totalDays / $periodDays);
            $totalPossibleAmount = $validated['amount_per_interval'] * $numberOfPeriods;
            
            if ($totalPossibleAmount < $validated['desiredAmount']) {
                return back()->withInput()->with('error', 
                    'With the current amount per interval, you cannot reach your desired amount within the specified time period.');
            }
        }

        // Set default values
        $validated['user_id'] = $user->id;
        $validated['savedAmount'] = 0;
        $validated['status'] = 'active';

        // dd($validated);

        // Create the new savings plan
        $user->savingsPlans()->create($validated);

        return redirect()->route('savings.index')
            ->with('success', 'Savings plan created successfully.');
    }

    // Show a single savings plan
    public function show($id)
    {
        $user = Auth::user();
        $savings = SavingsPlan::with('savings_account')->where('user_id', $user->id)->find($id);
        $account = $savings->savings_account;
        return view('savings.show', compact('savings', 'account'));
    }

    // Show form to edit a savings plan
    public function edit($id)
    {
        $user = Auth::user();
        $savings = $user->savingsPlans()->with('savings_account')->find($id);
        $accounts = $user->savingsAccounts;
        return view('savings.edit', compact('savings', 'accounts'));
    }

    // Update a savings plan
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $savings = SavingsPlan::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'planName' => 'required|string|max:255',
            'desiredAmount' => 'required|gt:0|numeric|max:999999999.99',
            'status' => 'required|string|in:active,paused,completed',
            'amount_per_interval' => 'nullable|gt:0|numeric|max:999999999.99',
            'regularity' => 'required|string|in:daily,weekly,biweekly,monthly,quarterly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:1000',
        ]);

        // Verify account ownership
        $account = SavingsAccount::where('id', $validated['savings_account_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$account) {
            return back()->with('error', 'Selected account not found or does not belong to you.');
        }

        $savings->update($validated);

        return redirect()->route('savings.index')
            ->with('success', 'Savings plan updated successfully.');
    }

    //Deposit into the savings

    public function showDepositForm(SavingsPlan $saving)
    {
        // Verify the savings plan belongs to the authenticated user
        if (Auth::id() !== $saving->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('savings.show', compact('saving'));
    }

    public function showWithdrawForm(SavingsPlan $saving)
    {
        // Verify the savings plan belongs to the authenticated user
        if (Auth::id() !== $saving->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('savings.show', compact('saving'));
    }

    public function processWithdraw(Request $request, SavingsPlan $saving)
    {
        // Verify the savings plan belongs to the authenticated user
        if (Auth::id() !== $saving->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/' // only 2 decimal places
            ],
        ], [
            'amount.max' => 'The amount cannot exceed 999,999,999.99',
            'amount.regex' => 'The amount must have no more than 2 decimal places',
        ]);

        $account = $saving->savings_account;

        // Check if the withdrawal would exceed the saved amount
        if ($saving->savedAmount < $validated['amount']) {
            return back()->with('error', 'Insufficient funds in your savings plan.');
        }

        try {
            DB::transaction(function () use ($account, $saving, $validated) {
                $amount = $validated['amount'];
                $account->balance += $amount;
                $saving->savedAmount -= $amount;

                if ($saving->savedAmount < 0) {
                    throw new \Exception('Negative saved amount');
                }

                if (!$account->save() || !$saving->save()) {
                    throw new \Exception('Failed to save account or savings plan');
                }
            });

            return redirect()
                ->route('savings.show', $saving->id)
                ->with('success', 'Withdrawal successful.');

        } catch (\Exception $e) {
            Log::error('Savings withdrawal failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'savings_id' => $saving->id,
                'amount' => $validated['amount']
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function processDeposit(Request $request, SavingsPlan $saving)
    {
        // Verify the savings plan belongs to the authenticated user
        if (Auth::id() !== $saving->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/' // only 2 decimal places
            ],
        ], [
            'amount.max' => 'The amount cannot exceed 999,999,999.99',
            'amount.regex' => 'The amount must have no more than 2 decimal places',
        ]);

        $account = $saving->savings_account;

        // Check if account has sufficient balance
        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Insufficient balance in your account.');
        }

        // Check if the deposit would exceed the desired amount
        if (($saving->savedAmount + $validated['amount']) > $saving->desiredAmount) {
            return back()->with('error', 'This deposit would exceed your target amount.');
        }

        try {
        DB::transaction(function () use ($account, $saving, $validated) {
            $amount = $validated['amount'];
            $account->balance -= $amount;
            $saving->savedAmount += $amount;

            if ($saving->savedAmount >= $saving->desiredAmount) {
                $saving->status = 'completed';
            }

                if (!$account->save() || !$saving->save()) {
                    throw new \Exception('Failed to save account or savings plan');
                }
        });

        return redirect()
            ->route('savings.show', $saving->id)
            ->with('success', 'Deposit successful.');

        } catch (\Exception $e) {
            Log::error('Savings deposit failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'savings_id' => $saving->id,
                'amount' => $validated['amount']
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    // Delete a savings plan
    public function destroy($id)
    {
        $user = Auth::user();
        $savings = SavingsPlan::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
            
        $savings->delete();
        
        return redirect()->route('savings.index')
            ->with('success', 'Savings plan deleted successfully.');
    }
}
