@php
    $sale_price = $value->new_price ?? 0;
    $old_price = $value->old_price ?? 0;

    $variable_sale_price = optional($value->variable)->new_price ?? 0;
    $variable_old_price = optional($value->variable)->old_price ?? 0;

    if (Auth::guard('customer')->check()) {
        $customer = Auth::guard('customer')->user();

        if ($customer->type == 2) {
            $sale_price = $value->wholesale_price ?? 0;
            $old_price = $value->new_price ?? 0;

            $variable_sale_price = optional($value->variable)->wholesale_price ?? 0;
            $variable_old_price = optional($value->variable)->new_price ?? 0;
        }
    }
@endphp

<div class="product_item_inner">
    @if ($old_price)
        <div class="discount">
            <p>@php $discount=(((($old_price)-($sale_price))*100) / ($old_price)) @endphp {{ number_format($discount, 0) }}% Discount</p>
        </div>
    @endif
    <div class="pro_img">
        <a href="{{ route('product', $value->slug) }}">
            <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}" />
        </a>
    </div>
    <div class="pro_des">
        <div class="pro_name">
            <a href="{{ route('product', $value->slug) }}">{{ Str::limit($value->name, 80) }}</a>
        </div>
        <div class="pro_price">
            @if ($value->variable_count > 0 && $value->type == 0)
                <p>
                    @if ($variable_old_price)
                        <del>৳ {{ $variable_old_price }}</del>
                    @endif
                    ৳ {{ $variable_sale_price }}
                </p>
            @else
                <p>
                    @if ($old_price)
                        <del>৳ {{ $old_price }}</del>
                    @endif
                    ৳ {{ $sale_price }}
                </p>
            @endif
        </div>
        <div class="pro_btn">
            @if ($value->variable_count > 0 && $value->type == 0)
                <a href="{{ route('product', $value->slug) }}"><button class="variable-modals">কার্টে যোগ
                        করুন</button></a>
            @else
                <div class="cart_btn">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $value->id }}" />
                        <button type="submit"> অর্ডার করুন</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
