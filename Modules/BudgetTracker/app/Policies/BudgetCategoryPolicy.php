<?php

namespace Modules\BudgetTracker\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}
}
