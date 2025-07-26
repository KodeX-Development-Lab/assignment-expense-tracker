<?php
namespace Modules\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\BudgetTracker\Database\Factories\DailyBudgetItemFactory;

class DailyBudgetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'type',
        'category_id',
        'amount',
        'remark',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount'    => 'double',
    ];

    public function budget()
    {
        return $this->belongsTo(DailyBudget::class, 'budget_id');
    }

    public function category()
    {
        return $this->belongsTo(BudgetTrackerCategory::class, 'category_id');
    }
}
