@extends('layouts.master')
@section('title', 'Users')
@section('breadcrumb', 'Users')
@section('breadcrumb-info', 'User Lists')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('users.modal')
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            Users
                        </h3>

                    </div>
                    <form method="get" action="{{ route('users.index') }}" id="users-form">
                        <div class="card-header border-0">
                            <div class="card-title filter-style">
                                <div class="d-flex align-items-center position-relative my-1 me-3">
                                    <div class="input-group input-group">
                                        <input type="text" id="homefaq_search" class="form-control"
                                            aria-label="Sizing example input" name="search" placeholder="Search...."
                                            aria-describedby="inputGroup-sizing-sm"
                                            style="background-color: #F3F6F9;max-width: 250px;"
                                            value="{{ Request::get('search') }}">
                                        <button class="btn btn-sm btn-secondary input-group-text" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Locked</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td style="padding-left: 10px;">{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <span class="roleChange badge badge-primary"
                                                    style="cursor: pointer;" data-status="{{ $item->role?->name }}"
                                                    data-id="{{ $item->id }}"
                                                    >{{ $item->role?->name }}</span>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input"
                                                        id="switcher_checkbox_{{ $item->id }}" type="checkbox"
                                                        onclick="statusChange({{ $item->id }}, 'user-lock-status-change')"
                                                        name="status{{ $item->id }}"
                                                        {{ $item->is_locked ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>---
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
                                <div class="pagination-wrapper"> {!! $users->appends([
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
                $('#users-form').submit();
            })

            $('.roleChange').on('click', function() {
                $('#roleUpdate').modal('show');

                var id = $(this).data('id');
                var status = $(this).data('status');

                $("input[name='user_id']").val(id);
                $('#currentStatus').html(status);

            });
        });
    </script>
@endpush
