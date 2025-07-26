@extends('layouts.master')
@section('title', content: 'Yearly Report')
@section('breadcrumb', 'Yearly Report')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    
                    <form method="get" action="{{ route('budget-reports.yearly') }}" id="search-filter-form"
                        class="filter-clear-form">
                        <div class="card-header border-0">
                            <div class="card-title filter-style">
                                <div class="filter-section">
                                    <label class="fs-7 fw-bold">Year</label>
                                    <div class="card-toolbar mx-4">
                                        <div class="d-flex justify-content-center min-w-150px">
                                            <select name="year" id="year" class="form-control">
                                                @php
                                                    $currentYear = now()->year;
                                                    $startYear = 1980; 
                                                    $endYear = $currentYear + 5;
                                                @endphp
                                                @for ($year = $startYear; $year <= $endYear; $year++)
                                                    <option value="{{ $year }}"
                                                        {{  (request('year') ?? $currentYear) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="card-content">
                        <x-budget-brief :brief="$brief" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">

                <div class="card pt-5 px-3">
                    <canvas id="income-expense-multi-line" style="height: 400px;"></canvas>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card pt-5 px-3">
                    <div class="card-header">
                        <h3>Income</h3>
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
                        <h3>Expense</h3>
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
            $('#year').on('change', function() {
                $('#search-filter-form').submit();
            });
        });
        const inputData = @json($summary_budgets)

        const allMonths = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        const filledData = allMonths.map(month => {
            const existing = inputData.find(item => item.label === month);
            if (existing) return existing;

            return {
                label: month,
                income: 0,
                expense: 0,
                balance: 0 // income - expense
            };
        });

        const data = {
            labels: filledData.map(data => data.label),
            datasets: [{
                    label: 'Income',
                    backgroundColor: "#08fa08",
                    borderColor: "#08fa08",
                    data: filledData.map(data => data.income),
                },
                {
                    label: 'Expense',
                    backgroundColor: "#fa0808",
                    borderColor: "#fa0808",
                    data: filledData.map(data => data.expense),
                }
            ]
        };

        const table_config = {
            type: "line",
            data,
        };

        var table = new Chart(
            document.getElementById("income-expense-multi-line"),
            table_config,
        );

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
