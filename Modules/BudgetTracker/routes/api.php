<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use Modules\BudgetTracker\Http\Controllers\BudgetTrackerCategoryController;
use Modules\BudgetTracker\Http\Controllers\BudgetTrackerConfigurationController;
use Modules\BudgetTracker\Http\Controllers\BudgetTrackerController;
use Modules\BudgetTracker\Http\Controllers\BudgetTrackerIconController;
use Modules\BudgetTracker\Http\Controllers\BudgetTrackerReportController;

Route::middleware(JwtMiddleware::class)->prefix('v1/budget-tracker/')->name('budget-tracker.')->group(function () {
    Route::get('configuration', [BudgetTrackerConfigurationController::class, 'show'])->name('configuration.show');
    Route::put('configuration', [BudgetTrackerConfigurationController::class, 'update'])->name('configuration.update');

    Route::get('icons', [BudgetTrackerIconController::class, 'index'])->name('icons.index');
    Route::resource('categories', BudgetTrackerCategoryController::class);
    Route::resource('budgets', BudgetTrackerController::class);

    Route::get('overview-report', [BudgetTrackerReportController::class, 'getOverviewReport'])->name('reports.overview');
    Route::get('brief-budget', [BudgetTrackerReportController::class, 'getBriefBudget'])->name('reports.brief-budget');
    Route::get('monthly-budgets', [BudgetTrackerReportController::class, 'getMonthlyBudgets'])->name('reports.monthly-budgets');
    Route::get('budgets', [BudgetTrackerController::class, 'index'])->name('reports.all-budgets');
    Route::get('budgets-summary', [BudgetTrackerReportController::class, 'getBudgetSummary'])->name('reports.budgets-summary');
    Route::get('budget-report-on-categories', [BudgetTrackerReportController::class, 'getBudgetReportOnCategories'])->name('reports.budget-report-on-categories');
});
