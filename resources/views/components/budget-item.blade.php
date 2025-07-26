<li class="d-flex py-2 px-3">
    <span style="width: 20px; height: 20px; margin-right: 10px; background-color: {{ $item->category?->color }};"></span>
    <span class="flex-fill my-auto me-3">{{ $item->category?->name }} <br> <span class="text-muted">{{ $item->remark }}</span></span>
    <span class="plus my-auto">{{ $item->type == 'income' ? '+' : '' }} {{ $item->remark }}&nbsp;ks</span>
    <form action="" class="my-auto ms-2" style="box-sizing: border-box;width: 40px;height: 40px;">
        <button style="outline: none;border: none;background-color: unset;" type="submit">
            <i class="fas fa-times-circle my-auto"></i>
        </button>
    </form>
</li>
