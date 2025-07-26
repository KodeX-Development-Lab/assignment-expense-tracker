<?php
namespace Modules\BudgetTracker\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BudgetTracker\Enums\BudgetTypes;

// use Modules\BudgetTracker\Database\Factories\DailyBudgetFactory;

class DailyBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $appends = [
        'total_income',
        'total_expense',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(DailyBudgetItem::class, 'budget_id');
    }

    public function getTotalIncomeAttribute(): float
    {
        return $this->items
            ->where('type', BudgetTypes::INCOME->value)
            ->sum('amount');
    }

    public function getTotalExpenseAttribute(): float
    {
        return $this->items
            ->where('type', BudgetTypes::EXPENSE->value)
            ->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return $this->getTotalIncomeAttribute() - $this->getTotalExpenseAttribute();
    }
}
