<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'current_account_id',
        'amount',
        'transaction_type',
        'description',
        'budget_id',
        'user_id',
        'date',
    ];

    // protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function current_account()
    {
        return $this->belongsTo(CurrentAccount::class , 'current_account_id');
    }

    public function savings_account()
    {
        return $this->belongsTo(SavingsAccount::class , 'current_account_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
