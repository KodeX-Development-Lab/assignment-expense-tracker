<?php

namespace Modules\BudgetTracker\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nnjeim\World\Models\Currency;
// use Modules\BudgetTracker\Database\Factories\BudgetTrackerConfigurationFactory;

class BudgetTrackerConfiguration extends Model
{
   protected $fillable = [
        'user_id',
        'currency_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class); // Assuming you have a Currency model
    }
}
