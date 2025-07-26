<div class="row gy-5 g-xl-8">
    <div class="col-lg">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8"
            style="background-color: #1BC5BD !important;">
            <!--begin::Body-->
            <div class="card-body">
                
                <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                    {{ App\MoneyFormatter::format_money($brief['total_income']) }} </div>
                <div class="fw-bold text-white">Total Income</div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>
    <div class="col-lg">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #e8092e !important">
            <!--begin::Body-->
            <div class="card-body">
                
                <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">
                     {{ App\MoneyFormatter::format_money($brief['total_expense']) }}</div>
                <div class="fw-bold text-gray-100">Total Expense</div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>

    <div class="col-lg">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card hoverable card-xl-stretch mb-5 mb-xl-8"
            style="background-color: #6993FF !important">
            <!--begin::Body-->
            <div class="card-body">
                
                <div class="text-white fw-bolder fs-2 mb-2 mt-5">

                     {{ App\MoneyFormatter::format_money($brief['balance']) }}
                </div>
                <div class="fw-bold text-white">Balance</div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>
</div>
