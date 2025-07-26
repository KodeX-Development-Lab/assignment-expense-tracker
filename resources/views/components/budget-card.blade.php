<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">{{ Carbon\Carbon::parse($daily_budget->date)->format('d M') }}</h5>
        <div>
            <span class="me-3">income: <span class="income-amount">{{ $daily_budget->total_income }}</span></span>
            <span>expense: <span class="text-danger">{{ $daily_budget->total_expense }}</span></span>
        </div>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="transaction-source">Part-time Job</span>
            <div class="text-muted small">Teaching</div>
        </div>
        <div class="income-amount">+60,000 ks</div>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="expense-item">
            <span class="transaction-source">Home & Hostel Fee</span>
        </div>
        <div class="text-danger">20,000 ks</div>
    </div>

    <hr>

    <div class="text-center mt-3">
        <span class="percentage-badge p-2 rounded">17.39% of your monthly income was spent.</span>
    </div>
</div>
