<?php
namespace Modules\BudgetTracker\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\BudgetTracker\Database\Factories\BudgetTrackerCategoryFactory;

class BudgetTrackerCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
        'color',
        'is_default_by_system',
        'status',
    ];

    protected $casts = [
        'is_default_by_system' => 'boolean',
        'status'               => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyBudgetItems()
    {
        return $this->hasMany(DailyBudgetItem::class, 'category_id');
    }
}
