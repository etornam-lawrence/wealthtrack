<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SavingsPlan extends Model
{
    /** @use HasFactory<\Database\Factories\SavingsFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'savings_account_id',
        'planName',
        'desiredAmount',
        'status',
        'amount_per_interval',
        'regularity',
        'start_date',
        'end_date',
        'automatic',
        'description',
    ];

    protected $casts = [
        'desiredAmount' => 'decimal:2',
        'savedAmount' => 'decimal:2',
        'amount_per_interval' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function current_account()
    {
        return $this->belongsTo(CurrentAccount::class, 'current_account_id');
    }

    public function savings_account()
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }   

    protected $appends = ['amount_saved', 'progress', 'remaining_amount', 'days_remaining'];

    public function getAmountSavedAttribute()
    {
        return $this->savedAmount ?? 0;
    }

    public function getProgressAttribute()
    {
        if ($this->desiredAmount == 0) return 0;
        return round(($this->savedAmount / $this->desiredAmount) * 100, 2);
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->desiredAmount - $this->savedAmount);
    }

    public function getDaysRemainingAttribute()
    {
        $endDate = \Carbon\Carbon::parse($this->end_date);
        $now = \Carbon\Carbon::now();
        return max(0, $now->diffInDays($endDate, false));
    }

    public function canDeposit($amount)
    {
        return ($this->savedAmount + $amount) <= $this->desiredAmount;
    }

    public function isCompleted()
    {
        return $this->status === 'completed' || $this->savedAmount >= $this->desiredAmount;
    }
}
