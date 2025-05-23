<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Budget extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'user_id',
        'current_account_id',
        'category',
        'amount',
        'period',
        'start_date',
        'end_date',
        'description',
        'status' // active, completed, cancelled
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(CurrentAccount::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function currentAccount()
    {
        return $this->belongsTo(CurrentAccount::class, 'current_account_id');
    }

    public function getRemainingAmountAttribute()
    {
        $spent = $this->transactions()->where('transaction_type', 'withdrawal')->sum('amount');
        return $this->amount - $spent;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->amount == 0) return 0;
        return ($this->transactions()->where('transaction_type', 'withdrawal')->sum('amount') / $this->amount) * 100;
    }
}
