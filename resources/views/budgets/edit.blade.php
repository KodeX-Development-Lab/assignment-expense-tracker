@extends('layouts.master')
@section('title', 'Budgets')
@section('breadcrumb', 'Budgets')
@section('breadcrumb-info', 'Edit Budget')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('budgets.update', ['budget' => $budget->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="{{ request('type') ?? 'income' }}">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <div class="list-title">
                                            <label for="category_id" class="form-label">Category</label>
                                        </div>
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id== $budget->category_id || $category->id == old('category_id') ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="processed_at" class="form-label">Choose Date & Time</label>
                                    <input type="text" id="processed_at" name="processed_at" class="form-control"
                                        placeholder="Select Date and Time" value="{{ old('processed_at') }}">
                                    {!! $errors->first('processed_at', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="list-title">
                                            <label for="amount" class="form-label">Amount</label>
                                        </div>
                                        <input type="number" name="amount" value="{{ old('amount') ?? $budget->amount }}" id="amount"
                                            class="form-control">
                                        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                                        <div class="list-title">
                                            <label for="remark" class="form-label">Remark</label>
                                        </div>
                                        <input type="text" name="remark" value="{{ old('remark') ?? $budget->remark }}" id="remark"
                                            class="form-control">
                                        {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>





                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="float-left">
                                                <a href="{{ route('budgets.index') }}">
                                                    <button type="button" class="btn btn-secondary btn-sm cancel">
                                                        <i class="bi bi-x" aria-hidden="true"></i> Cancel</button>
                                                </a>

                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                        class="bi bi-save"></i>
                                                    Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#processed_at", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
        });
    </script>
@endpush
