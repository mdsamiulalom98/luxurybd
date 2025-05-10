@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $coupon = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;

    $bkash_gateway = App\Models\PaymentGateway::where(['status' => 1, 'type' => 'bkash'])->first();
    $shurjopay_gateway = App\Models\PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
@endphp
<div class="card-bodys">
    <div class="card__items__header">
        <div class="items__header">
            <div class="items__header_left"><p>প্রোডাক্ট নাম</p></div>
            <div class="items__header_right"><p>বিক্রয় মূল্য</p></div>
        </div>
        @foreach (Cart::instance('shopping')->content() as $value)
        <div class="main__items">
            <div class="main__items_image">
                <a href="{{ route('product', $value->options->slug) }}"> <img src="{{ asset($value->options->image) }}" /></a>
            </div>
            <div class="main__items_data">
                <div class="pro___name">
                    <p>{{ Str::limit($value->name, 40) }}</p>
                </div>
                <div class="pro___size__color">
                    @if($value->options->product_size)
                    <p>Size: {{ $value->options->product_size }}</p>
                    @endif @if($value->options->product_color)
                    <p>Color: {{ $value->options->product_color }}</p>
                    @endif
                </div>
                <div class="pro__qty qty-cart vcart-qty">
                    <div class="label_qty">Qty:</div>
                    <div class="quantity">
                        <a class="minus cart_decrement" data-id="{{ $value->rowId }}">-</a>
                        <input type="text" value="{{ $value->qty }}" readonly />
                        <a class="plus cart_increment" data-id="{{ $value->rowId }}">+</a>
                    </div>
                </div>
            </div>
            <div class="main__items_prices">
                <div class="price_sec">
                    <p class="price__item">TK. {{ $value->price }}</p>
                </div>
                <div class="delete_sec">
                    <p class="item__delete">
                        <a class="cart_remove" data-id="{{ $value->rowId }}"></a>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="items__headers">
        <div class="items__header_lefts"><p>সাব-টোটাল (+)</p></div>
        <div class="items__header_rights"><p>TK. {{ $subtotal }}</p></div>
    </div>
    <div class="items__headers">
        <div class="items__header_lefts"><p>ডিসকাউন্ট (-)</p></div>
        <div class="items__header_rights"><p>TK. {{ $discount + $coupon }}</p></div>
    </div>
    <div class="items__charges">
        <div class="items_charges__left"><p>ডেলিভারি চার্জ (+)</p></div>
        <div class="items__charges__right">
            <div class="form-group mb-3">
               @if(Session::get('district_area') == 1)
                <div class="area-items">
                    <input name="area" id="area" class="areas" type="radio" value="1" checked/>
                    <label for="area">ঢাকা সিটির ভিতরে TK. {{$shipping}}</label>
                </div>
                @else
                <div class="area-items">
                    <input name="area" id="area" class="areas" type="radio" value="2" checked/>
                    <label for="area">ঢাকা সিটির বাহিরে TK. {{$shipping}}</label>
                </div>
                @endif
               
            </div>
        </div>
    </div>
    <div class="items__total">
        <div class="items_total__left"><p>টোটাল</p></div>
        <div class="items__total__right"><p>TK. {{ $subtotal + $shipping - ($discount + $coupon) }}</p></div>
    </div>
    <div class="col-sm-12">
        <div class="payment-methods">
            <div class="form-check p_cash payment_method" data-id="cod">
                <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="Cash On Delivery" checked required />
                <label class="form-check-label" for="inlineRadio1">
                    Cash on delivery
                </label>
            </div>
            @if ($bkash_gateway)
            <div class="form-check p_bkash payment_method" data-id="bkash">
                <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" value="bkash" required />
                <label class="form-check-label" for="inlineRadio2">
                    Bkash
                </label>
            </div>
            @endif @if ($shurjopay_gateway)
            <div class="form-check p_shurjo payment_method" data-id="nagad">
                <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio3" value="shurjopay" required />
                <label class="form-check-label" for="inlineRadio3">
                    Nagad
                </label>
            </div>
            @endif
        </div>
    </div>
    <div class="pament__note">
        <p>৩-৭ দিনের মধ্যে হোম ডেলিভারি করা হবে। এর মধ্যে কল দেয়া হবে না</p>
    </div>

    <div class="coupon_sec">
    <input
        type="text"
        id="coupon_code"
        placeholder="@if (Session::get('coupon_used')) {{ Session::get('coupon_used') }} @else If you have a Promo Code, Enter Here... @endif"
        class="border-0 shadow-none form-control"
        @if (Session::get('coupon_used')) disabled @endif
    />
    <button type="button" id="coupon_btn">
        @if (Session::get('coupon_used')) Remove @else Apply @endif
    </button>
</div>



<script src="{{ asset('public/frontEnd/js/jquery-3.7.1.min.js') }}"></script>
<!-- cart js start -->
<script>
    $('#coupon_btn').on('click', function () {
        let coupon = $('#coupon_code').val();
        let isUsed = '{{ Session::get('coupon_used') ? "yes" : "no" }}';
        let url = '';
        let data = {};

        if (isUsed === 'yes') {
            url = "{{ route('customer.coupon_remove') }}";
            data = {
                 coupon_code: coupon,
                _token: "{{ csrf_token() }}"
            };
        } else {
            url = "{{ route('customer.coupon') }}";
            data = {
                coupon_code: coupon,
                _token: "{{ csrf_token() }}"
            };
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (response) {
             toastr.success(response.message, "Success");
             location.reload();
            },
            error: function (xhr) {
                if (xhr.responseJSON?.message) {
                    toastr.error(xhr.responseJSON.message, "Sorry");
                } else {
                    toastr.error("Something went wrong. Please try again.", "Error");
                }
            }

        });
    });
</script>
<script>
    $('.cart_store').on('click', function() {
        var id = $(this).data('id');
        var qty = $(this).parent().find('input').val();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id,
                    'qty': qty ? qty : 1
                },
                url: "{{ route('cart.store') }}",
                success: function(data) {
                    if (data) {
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_remove').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.remove') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_increment').on('click', function() {
        var id = $(this).data('id');
        console.log('ajax hit from partial');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.increment_camp') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    $('.cart_decrement').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id
                },
                url: "{{ route('cart.decrement_camp') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                        return cart_count();
                    }
                }
            });
        }
    });

    function cart_count() {
        $.ajax({
            type: "GET",
            url: "{{ route('cart.count') }}",
            success: function(data) {
                if (data) {
                    $("#cart-qty").html(data);
                } else {
                    $("#cart-qty").empty();
                }
            }
        });
    };
</script>
<!-- cart js end -->
