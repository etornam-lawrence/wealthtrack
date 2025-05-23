<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentAccount extends Account
{
    /** @use HasFactory<\Database\Factories\CurrentAccountFactory> */
    use HasFactory;

    protected $table = 'current_accounts';

    protected $casts = [
        'balance' => 'decimal:2',
        'id' => 'string', // Cast the UUID to string
    ];

    protected $fillable = [
        'account_number', 
        'alias',
        'balance',
        'user_id', 
        
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
