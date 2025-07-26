<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BudgetCard extends Component
{
    public $daily_budget;

    public function __construct($daily_budget)
    {
        $this->daily_budget = $daily_budget;
    }

    public function render()
    {
        return view('components.budget-card');
    }
}
