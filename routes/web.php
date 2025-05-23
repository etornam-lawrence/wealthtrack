<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SavingsPlanController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsAccountController;
use App\Http\Controllers\BudgetController;
use App\Models\Review;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\CurrentAccountController;
use App\Http\Controllers\SavingsTransactionController;
use App\Http\Controllers\UserAccountController;
use App\Models\SavingsAccount;


Route::get('/', function () {
    $reviews = Review::latest()->take(3)->get();
    return view('home', compact('reviews'));
})->name('home');


Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);

Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

//Protected routes. Only authenticated user access.
Route::middleware('auth')->group(function (){

    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/accounts', [UserAccountController::class, 'index'])->name('accounts.index'); 
    Route::get('/accounts/create', [UserAccountController::class, 'create'])->name('accounts.create');

    //savings account routes
    Route::get('/accounts/savings/create', [SavingsAccountController::class, 'create'])->name('accounts.savings.create');
    Route::post('/accounts/savings', [SavingsAccountController::class, 'store'])->name('accounts.savings.store');
    Route::get('/accounts/savings/{savings}', [SavingsAccountController::class, 'show'])->name('accounts.savings.show');
    Route::delete('/accounts/savings/{savings}', [SavingsAccountController::class, 'destroy'])->name('accounts.savings.destroy');

    // savings transaction routes
    Route::get('/transactions/{savings}/savings', [SavingsTransactionController::class, 'index'])->name('transactions.savings.index');
    Route::get('/transactions/savings/create/{savings}', [SavingsTransactionController::class, 'create'])->name('transactions.savings.create');
    Route::post('/transactions/savings', [SavingsTransactionController::class, 'store'])->name('transactions.savings.store');


    //current account routes
    Route::get('/accounts/current/create', [CurrentAccountController::class, 'create'])->name('accounts.current.create');
    Route::post('/accounts/current', [CurrentAccountController::class, 'store'])->name('accounts.current.store');
    Route::get('/accounts/current/{current}', [CurrentAccountController::class, 'show'])->name('accounts.current.show');
    Route::get('/accounts/current/{current}/edit', [CurrentAccountController::class, 'edit'])->name('accounts.current.edit');
    Route::patch('/accounts/current/{current}', [CurrentAccountController::class, 'update'])->name('accounts.current.update');
    Route::delete('/accounts/current/{current}', [CurrentAccountController::class, 'destroy'])->name('accounts.current.destroy');
    
    // savings plan routes
    Route::resource('savings', SavingsPlanController::class);
    Route::get('/savings/{saving}/deposit', [SavingsPlanController::class, 'showDepositForm'])->name('savings.deposit.form');
    Route::get('/savings/{saving}/withdraw', [SavingsPlanController::class, 'showWithdrawForm'])->name('savings.withdraw.form');
    Route::post('/savings/{saving}/withdraw', [SavingsPlanController::class, 'processWithdraw'])->name('savings.withdraw.process');
    Route::post('/savings/{saving}/deposit', [SavingsPlanController::class, 'processDeposit'])->name('savings.deposit.process');
    
    // Budget Routes
    Route::resource('budgets', BudgetController::class);



    // Help Route
    Route::get('/help', [HelpController::class, 'index'])->name('help');



    //Reviews
    Route::get('/profile/review', [UserController::class, 'showReviewForm'])->name('profile.review');
    Route::post('/profile/review', [UserController::class, 'storeReview'])->name('profile.review.store');
    Route::resource('transactions', TransactionController::class);

    
});



