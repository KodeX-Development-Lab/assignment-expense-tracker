<?php
namespace Modules\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetTrackerIcon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function categories()
    {
        return $this->hasMany(BudgetTrackerCategory::class, 'icon_id');
    }
}
