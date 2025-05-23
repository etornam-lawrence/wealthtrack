<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory, HasUuids;
    
    protected $table = null;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
   
    public static function generateSavingsAccountNumber()
    {
        return 'SAV' .'-'. strtoupper(Str::random(3)) . rand(10000, 99999);
    }

    public static function generateCurrentAccountNumber()
    {
        return 'CURR' .'-'. strtoupper(Str::random(3)) . rand(10000, 99999);
    }

    public function updateBalance($amount, $type)
    {
        if ($type === 'deposit') {
            $this->balance += $amount;
        } else {
            $this->balance -= $amount;
        }
        return $this->save();
    }
}
