<div class="d-flex justify-content-end me-2" data-kt-customer-table-toolbar="base">
    <div class="w-180px d-flex align-items-center">
        <label class="text-uppercase fs-9 fw-bold">Display</label>
        <select name="display" class="form-select form-select-sm mx-2 w-100px h-40px" aria-label="select" id="display">
            <option value="10" {{ request('display') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('display') == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('display') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('display') == 100 ? 'selected' : '' }}>100</option>
        </select>
        <label class="text-uppercase fs-9 fw-bold">Items</label>
    </div>
</div>