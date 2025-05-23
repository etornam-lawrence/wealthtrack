<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\SavingsPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display the user's profile
     */
    public function index()
    {
        try {
            $user = Auth::user();
            return view('customer.profile', compact('user'));

        } catch (\Exception $e) {
            // return $e;
            return redirect()->route('dashboard')->with('error', 'An error occurred while loading your profile.');
        }
    }

    /**
     * Display the user's dashboard
     */
    public function dashboard()
{
    try {
        $user = Auth::user();

        // Fetch accounts separately
        $accounts = $user->currentAccounts()->with('transactions')->get();

        // Merge all transactions from both account types
        $transactions = $accounts->flatMap(function ($account) {
            return $account->transactions;
        })->sortByDesc('created_at')->values();

        // Get budget only for current accounts
        $budget = $user->budgets;

        // Total expenses from all accounts
        $totalExpenses = Transaction::where(function ($query) use ($user) {
            $query->whereHas('current_account', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->orWhereHas('savings_account', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->where('transaction_type', 'withdrawal')->sum('amount');

        // Total savings (sum of saved_amount from all savings plans)
        $totalSavings = SavingsPlan::whereHas('savings_account', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('savedAmount');

        return view('dashboard', compact(
            'user',
            'accounts',
            'transactions',
            'budget',
            'totalExpenses',
            'totalSavings'
        ));

    } catch (\Exception $e) {
        return $e;
        // return redirect()->route('login')->with('error', 'An error occurred while loading your dashboard.');
    }
}


    /**
     * Show the review form
     */
    public function showReviewForm()
    {
        try {
        $user = Auth::user();
        
            if ($user->review()->exists()) {
                return redirect()->route('dashboard')
                    ->with('info', 'You have already submitted a review.');
            }

            return view('customer.profile');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while loading the review form.');
        }
    }

    /**
     * Store a new review
     */
    public function storeReview(Request $request)
    {
        try {
        $user = Auth::user();

            if ($user->review()->exists()) {
                return redirect()->route('profile')
                    ->with('error', 'You have already submitted a review. You can only submit one review.');
            }

        $validated = $request->validate([
            'review' => 'required|string|max:1000',  
                'rating' => 'required|integer|min:0|max:5',
        ]);

            DB::transaction(function () use ($user, $validated) {
                $user->review()->create($validated);
            });

            return redirect()->route('profile')
                ->with('success', 'Thank you for your review! Your feedback helps us improve our service.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->route('profile')
                ->with('error', 'There was an error submitting your review. Please try again later.');
        }
    }

    /**
     * Show the form for editing the user's profile
     */
    public function edit()
    {
        try {
            $user = Auth::user();
        return view('customer.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'An error occurred while loading the edit form.');
        }
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        try {
        $user = Auth::user();
        
        $validated = $request->validate([
                'first_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'last_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'phone' => ['required', 'string', 'max:15', 'regex:/^\+?[0-9\s-]+$/'],
                'location' => ['required', 'string', 'min:2', 'max:255'],
                'email' => ['required', 'email:rfc,dns', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/']
            ], [
                'first_name.regex' => 'First name can only contain letters and spaces',
                'last_name.regex' => 'Last name can only contain letters and spaces',
                'phone.regex' => 'Please enter a valid phone number',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character'
            ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

            DB::transaction(function () use ($user, $validated) {
        $user->update($validated);
            });

            return redirect()->route('profile')
                ->with('success', 'Your profile has been updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->route('profile')
                ->with('error', 'There was an error updating your profile. Please try again later.');
        }
    }

    /**
     * Delete the user's account
     */
    public function destroy(Request $request)
    {
        try {
        $user = Auth::user();
        
            DB::transaction(function () use ($user) {
        $user->delete();
            });
        
            Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
            return redirect()->route('login')
                ->with('success', 'Your account has been deleted successfully. We\'re sorry to see you go.');
        } catch (\Exception $e) {
            return redirect()->route('profile')
                ->with('error', 'There was an error deleting your account. Please try again later.');
        }
    }
}

