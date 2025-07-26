@extends('layouts.master')
@section('title', content: 'Custom Report')
@section('breadcrumb', 'Custom Report')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card">
                    
                    <form method="get" action="{{ route('budget-reports.custom') }}" id="search-filter-form"
                        class="filter-clear-form">
                        <div class="card-header border-0">
                            <div class="card-title filter-style">
                                <div class="filter-section">
                                    <label class="fs-7 fw-bold">Start Date</label>
                                    <div class="card-toolbar mx-4">
                                        <div class="d-flex justify-content-center min-w-150px">
                                            <input type="date" name="start_date" id="start_date"
                                                value="{{ request('start_date') ?? '' }}"
                                                class="form-control form-control-solid flatpickr-input" placeholder="Start">
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-section">
                                    <label class="fs-7 fw-bold">End Date</label>
                                    <div class="card-toolbar mx-4">
                                        <div class="d-flex justify-content-center min-w-150px">
                                            <input type="date" name="end_date" id="end_date"
                                                value="{{ request('end_date') ?? '' }}"
                                                class="form-control form-control-solid flatpickr-input" placeholder="End">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <!--call template to get table display-->
                                <x-table-display />
                            </div>
                        </div>
                    </form>
                    <div class="card-content">
                        <x-budget-brief :brief="$brief" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card pt-5 px-3">
                    <div class="card-header">
                        Income
                    </div>
                    <div class="mb-5">
                        <canvas id="income-category-pie"></canvas>
                    </div>
                    <div>
                        @foreach ($income_budget_on_categories['items'] as $item)
                            <div class="row py-2">
                                <div class="col-1">
                                    <div
                                        style="width: 20px; height: 20px; background-color: {{ $item['category']->color }};">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <span class="transaction-source">{{ $item['category']->name }}</span>

                                </div>
                                <div class="col-2">{{ App\MoneyFormatter::format_money($item['amount']) }} </div>
                                <div class="col-2">{{ $item['percentage'] }} %</div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card pt-5 px-3">
                    <div class="card-header">
                        Expense
                    </div>
                    <div class="mb-5">
                        <canvas id="expense-category-pie"></canvas>
                    </div>
                    <div>
                        @foreach ($expense_budget_on_categories['items'] as $item)
                            <div class="row py-2">
                                <div class="col-1">
                                    <div
                                        style="width: 20px; height: 20px; background-color: {{ $item['category']->color }};">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <span class="transaction-source">{{ $item['category']->name }}</span>

                                </div>
                                <div class="col-2">{{ App\MoneyFormatter::format_money($item['amount']) }} </div>
                                <div class="col-2">{{ $item['percentage'] }} %</div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#start_date').on('change', function() {
                $('#search-filter-form').submit();
            });

            $('#end_date').on('change', function() {
                $('#search-filter-form').submit();
            })
        });

        const income_categories_items = @json($income_budget_on_categories['items'])

        const total_inc_cat_pie_data = {
            labels: income_categories_items.map(item => item.category.name),
            datasets: [{
                backgroundColor: income_categories_items.map(item => item.category.color),
                data: income_categories_items.map(item => item.percentage),
                hoverOffset: 1
            }]
        };

        const total_inc_cat_config_pie = {
            type: "pie",
            data: total_inc_cat_pie_data,
            options: {
                responsive: true
            }
        };

        const total_inc_cat_pie_chart = new Chart(
            document.getElementById("income-category-pie"),
            total_inc_cat_config_pie
        );

        const expense_categories_items = @json($expense_budget_on_categories['items'])

        const total_expense_cat_pie_data = {
            labels: expense_categories_items.map(item => item.category.name),
            datasets: [{
                backgroundColor: expense_categories_items.map(item => item.category.color),
                data: expense_categories_items.map(item => item.percentage),
                hoverOffset: 1
            }]
        };

        const total_expense_cat_config_pie = {
            type: "pie",
            data: total_expense_cat_pie_data,
            options: {
                responsive: true
            }
        };

        const total_expense_cat_pie_chart = new Chart(
            document.getElementById("expense-category-pie"),
            total_expense_cat_config_pie
        );
    </script>
@endpush
