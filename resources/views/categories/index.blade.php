@extends('layouts.master')
@section('title', 'Categories')
@section('breadcrumb', 'Categories')
@section('breadcrumb-info', 'Category Lists')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            Categories
                        </h3>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <form method="get" action="{{ route('categories.index') }}" id="search-filter-form" class="filter-clear-form">
                        <div class="card-header border-0">
                            <div class="card-title filter-style">
                                <div class="d-flex align-items-center position-relative my-1 me-3">
                                    <div class="input-group input-group">
                                        <input type="text" id="search" class="search-box form-control" aria-label="Sizing example input" name="search"
                                            placeholder="Search...." aria-describedby="inputGroup-sizing-sm"  style="background-color: #F3F6F9;max-width: 250px;" 
                                            value="{{ request('search') }}">
                                        @isset($keyword)<i class="bi bi-x" onclick="clearSearch()" style="position: absolute; top: 11px; right: 60px; font-size: 22px;"></i>@endisset
                                        <button class="btn btn-sm btn-secondary input-group-text" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="filter-section">
                                    <label for="" style="font-size: 12px;">Type</label>
                                    <div class="card-toolbar mx-4">
                                        <div class="d-flex justify-content-center" style="min-width: 150px;">
                                            <select onchange="this.form.submit()" class="form-select form-select-solid" id="type" name="type" data-control="select2" data-hide-search="true" data-placeholder="type" data-kt-ecommerce-product-filter="type" data-allow-clear="true">
                                                <option>All</option>
                                                <option value="income" {{ Request::get('type') == 'income' ? 'selected' : '' }}>Income</option>
                                                <option value="expense" {{ Request::get('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                            </select>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-bordered gy-4 gs-7">
                                <thead class="table-light text-black text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-10px" style="padding-left: 10px;">#</th>
                                        <th>Color</th>
                                        <th>Color Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Default By System</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td style="padding-left: 10px;">{{ $loop->iteration }}</td>
                                            <td>

                                                <div
                                                    style="width: 20px; height: 20px; margin-right: 10px; background-color: {{ $item->color }};">
                                                </div>

                                            </td>
                                            <td>{{ $item->color }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item->type == 'income' ? 'success' : 'danger' }}">{{ $item->type }}</span>
                                            </td>
                                             <td>
                                                @if($item->is_default_by_system)  <span class="badge badge-primary">Default</span>  @endif
                                            </td>
                                            <td class="sticky">
                                                @if(!$item->is_default_by_system)
                                                <a href="{{ route('categories.edit', ['category' => $item->id]) }}"
                                                    title="Edit">
                                                    <button
                                                        class="btn btn-icon btn-active-light-primary btn btn-primary w-30px h-30px">
                                                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                                    </button>
                                                </a>

                                                <form method="POST" action="{{ route('categories.destroy', ['category' => $item->id]) }}"
                                                    class="deleteForm" style="display: inline;">
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                    <button type="submit"
                                                        class="btn btn-icon btn-active-light-danger btn btn-danger w-30px h-30px show_confirm_delete"
                                                        title='Delete'><i class="bi bi-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                                @else
                                                ---
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row my-3">
                            <div
                                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            </div>
                            <div
                                class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                <div class="pagination-wrapper"> {!! $categories->appends([
                                        'search' => Request::get('search'),
                                        'page' => Request::get('page'),
                                        'display' => Request::get('display'),
                                    ])->links('pagination::bootstrap-4')->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#display').change(function() {
                $('#search-filter-form').submit();
            })
        });
    </script>
@endpush
