<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavingsTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'savings_account_id',
        'user_id',
        'amount',
        'type',
        'description',
    ];
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];
    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function savings_account(): BelongsTo
    {
        return $this->belongsTo(SavingsAccount::class);
    }

    public function savings_plan(): BelongsTo
    {
        return $this->belongsTo(SavingsPlan::class);
    }

    public function savings_transactions(): HasMany
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getAmountAttribute($value): string
    {
        return number_format($value, 2);
    }

    public function getCreatedAtAttribute($value): string
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    
}
