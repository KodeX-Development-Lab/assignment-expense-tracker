<div class="modal fade" id="roleUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('users.role.change') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="padding-left: 130px;">Outlet Order Status Update Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="list-title mb-5">
                            <strong>Current Status: </strong><span class="badge badge-primary" id="currentStatus"></span>
                        </div>
                        <select class="form-select" name="role_id" id="">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>