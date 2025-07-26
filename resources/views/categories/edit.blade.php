@extends('layouts.master')
@section('title', 'Categories')
@section('breadcrumb', 'Categories')
@section('breadcrumb-info', 'Edit Category')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Category
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <div class="list-title">
                                            <label for="name" class="form-label">Category Name</label>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') ?? $category->name }}" id="name" class="form-control">
                                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                        <div class="list-title">
                                            <label for="type" class="form-label">Type</label>
                                        </div>
                                        <select name="type" id="type" class="form-select">
                                            <option value="">Select Type</option>
                                            <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Income</option>
                                            <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Expense</option>
                                        </select>
                                        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                                        <div class="list-title mb-3">
                                            <label for="color" class="form-label">Color</label>
                                        </div>
                                        <input type="color" name="color" value={{ old('color') ?? $category->color }} id="color"
                                            class="form-control form-control-color" value="#563d7c"
                                            title="Choose your color">
                                        {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="float-left">
                                                <a href="{{ route('categories.index') }}">
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
