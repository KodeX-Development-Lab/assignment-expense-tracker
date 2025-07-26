@extends('layouts.master')
@section('title', content: 'Current Month')
@section('breadcrumb', 'Current Month')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="py-3">{{ Carbon\Carbon::now()->format('M Y') }}</h1>
                    </div>
                    <div class="card-content">
                        <div class="container px-5 py-5">
                            <x-budget-brief :brief="$brief" />
                        </div>
                    </div>


                </div>
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            @foreach ($daily_budgets as $key => $daily_budget)
                                <div class="card p-4 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">
                                            {{ Carbon\Carbon::parse($daily_budget->date)->format('d M') }}
                                        </h5>
                                        <div>
                                            <span class="me-3">income: <span
                                                    class="text-success">{{ $daily_budget->total_income }}</span></span>
                                            <span>expense: <span
                                                    class="text-danger">{{ $daily_budget->total_expense }}</span></span>
                                        </div>
                                    </div>


                                    @forelse ($daily_budget->items as $item)
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
                                                {{ $item->amount }}</div>
                                            <div class="col-2">
                                                <form method="POST"
                                                    action="{{ route('budgets.destroy', ['budget' => $item->id]) }}"
                                                    class="deleteForm" style="display: inline;">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                    <button type="submit"
                                                        class="btn btn-icon btn-active-light-danger btn btn-danger w-30px h-30px show_confirm_delete"
                                                        title='Delete'><i class="bi bi-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
                                    @empty
                                        <p>No Record</p>
                                    @endforelse

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
