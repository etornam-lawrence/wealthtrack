<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsAccount extends Account
{
    /** @use HasFactory<\Database\Factories\SavingsAccountFactory> */
    use HasFactory, HasUuids;

    protected $table = 'savings_accounts';

    protected $fillable = [
        'alias',
        'balance',
        'user_id',
        'account_number',
        'savings_plan_id',
    ];


    protected $casts = [
        'balance' => 'decimal:2',
        'id' => 'string', // Cast the UUID to string
    ];


    public function savings_transactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingsPlans()
    {
        return $this->hasMany(SavingsPlan::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
