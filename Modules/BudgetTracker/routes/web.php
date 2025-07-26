<?php

use App\Http\Middleware\EnsureUserIsUnLocked;
use Illuminate\Support\Facades\Route;
use Modules\BudgetTracker\Http\Controllers\Web\BudgetTrackerCategoryController;
use Modules\BudgetTracker\Http\Controllers\Web\BudgetTrackerController;
use Modules\BudgetTracker\Http\Controllers\Web\BudgetTrackerReportController;

Route::middleware(['auth', 'verified', EnsureUserIsUnLocked::class])->group(function () {
    Route::get('/dashboard', [BudgetTrackerReportController::class, 'getOverviewReport'])->name('dashboard');
    Route::get('/recent-budgets', [BudgetTrackerReportController::class, 'getRecentBudgets'])->name('recent-budgets');
    Route::resource('/categories', BudgetTrackerCategoryController::class);
    Route::resource('/budgets', BudgetTrackerController::class);
    Route::get('/budgets/{type}/create', [BudgetTrackerController::class, 'create'])->name('budgets.create');
    Route::get('/budgets/{type}/{id}/edit', [BudgetTrackerController::class, 'edit'])->name('budgets.edit');

    Route::get('/reports/monthly', [BudgetTrackerReportController::class, 'getMonthlyReport'])->name('budget-reports.monthly');
    Route::get('/reports/yearly', [BudgetTrackerReportController::class, 'getYearlyReport'])->name('budget-reports.yearly');
    Route::get('/reports/custom', [BudgetTrackerReportController::class, 'getCustomReport'])->name('budget-reports.custom');
});
