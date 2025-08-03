@extends('layouts.master')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-content">
                        <x-budget-brief :brief="$brief" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 col-lg-6">
                <div class="card pt-5 px-3">
                    <div class="d-flex justify-content-between">
                        <p>
                        <h3>This month</h3> income: <span
                            class="text-success">{{ App\MoneyFormatter::format_money($current_month_recent_budgets['total_income']) }}</span>,
                        expense: <span
                            class="text-danger">{{ App\MoneyFormatter::format_money($current_month_recent_budgets['total_expense']) }}
                        </span>
                        </p>
                        <a href="{{ route('recent-budgets') }}" title="Edit Member">
                            <button class="btn btn-icon btn-active-light-primary btn btn-primary w-30px h-30px">
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </button>
                        </a>
                    </div>
                    <div class="card-content pt-3">
                        @forelse ($current_month_recent_budgets['items'] as $item)
                            <div class="row py-2">
                                <div class="col-1">
                                    <div
                                        style="width: 20px; height: 20px; background-color: {{ $item->category?->color }};">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <span class="transaction-source">{{ $item->category?->name }}</span>
                                    <div class="text-muted small">{{ $item->remark }}</div>
                                </div>
                                <div class="col-2 amount">{{ $item->type == 'income' ? '+' : '-' }}
                                    {{ App\MoneyFormatter::format_money($item->amount) }}</div>
                                <div class="col-2">
                                    <form method="POST" action="{{ route('budgets.destroy', ['budget' => $item->id]) }}"
                                        class="deleteForm" style="display: inline;">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <button type="submit"
                                            class="btn btn-icon btn-active-light-danger btn btn-danger w-30px h-30px show_confirm_delete"
                                            title='Delete'><i class="bi bi-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                        @empty
                            <p>No Record</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card pt-5 px-3">
                    <div class="card-header">
                        <h3>This Year</h3>
                    </div>
                    <div class="card-content">
                        <canvas id="income-expense-multi-line" style="height: 350px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const inputData = @json($summary_budgets);

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
    </script>
@endpush
