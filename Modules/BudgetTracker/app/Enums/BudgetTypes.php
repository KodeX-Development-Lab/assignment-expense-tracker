<?php
namespace Modules\BudgetTracker\Enums;

enum BudgetTypes: string {
    case INCOME  = 'income';
    case EXPENSE = 'expense';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
