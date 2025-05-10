@extends('frontEnd.layouts.master') @section('title', 'Customer Checkout') @push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
@endpush @section('content')
<section class="brade__cum">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="brade_text"><a href="{{route('home')}}">Home</a> <i class="fa-solid fa-angle-right"></i><i class="fa-solid fa-angle-right"></i> checkout</p>
            </div>
        </div>
    </div>
</section>
<section class="checkout__top_sec text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"> 
            <div class="main__checkout">
                <div class="check__out">
                <p class="checkout__after">Checkout</p>
            </div>
            <div class="check__complete">
                <p>Completed</p>
            </div>
            </div>
        </div>    
    </div>
    </div>
</section>
<section class="chheckout-section">
    @php $subtotal = Cart::instance('shopping')->subtotal(); $subtotal = str_replace(',', '', $subtotal); $subtotal = str_replace('.00', '', $subtotal); $shipping = Session::get('shipping') ? Session::get('shipping') : 0; $coupon =
    Session::get('coupon_amount') ? Session::get('coupon_amount') : 0; $discount = Session::get('discount') ? Session::get('discount') : 0; $cart = Cart::instance('shopping')->content(); @endphp
    <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
        @csrf
        <div class="container">
            <div class="row">
                <div class="main__check_sec">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="main__title__checkout">
                                    <p>অর্ডার করতে সঠিক তথ্য দিয়ে নিচের ফরম পূরন করুন</p>
                                </div>
                            </div>
                            <div class="col-sm-6 cus-order-2">
                                <div class="checkout-shipping">
                                    <div class="cards">
                                        <p class="shipping__header">বিলিং ডিটেইল</p>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group customized-input-box mb-3">
                                                        <label for="name">Your Name - আপনার নাম  <span class="requere_text">*</span></label>

                                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="সম্পূর্ণ নামটি লিখুন" required />
                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- col-end -->
                                                <div class="col-sm-12">
                                                    <div class="form-group customized-input-box mb-3">
                                                        <label for="phone">Mobile Number - মোবাইল নাম্বার<span class="requere_text">*</span></label>
                                                        <input
                                                            type="text"
                                                            minlength="11"
                                                            id="phone"
                                                            maxlength="11"
                                                            pattern="0[0-9]+"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            name="phone"
                                                            value="{{ old('phone') }}"
                                                            placeholder="১১ ডিজিটের মোবাইল নাম্বারটি লিখুন"
                                                            required
                                                        />
                                                        @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- col-end -->
                                                <div class="col-sm-12">
                                                    <div class="form-group customized-input-box mb-3">
                                                        <label for="address">Address - সম্পূর্ণ ঠিকানা <span class="requere_text">*</span></label>

                                                        <input
                                                            type="text"
                                                            id="address"
                                                            class="form-control @error('address') is-invalid @enderror"
                                                            name="address"
                                                            placeholder="গ্রাম/শহর, থানা, জেলা"
                                                            value="{{ old('address') }}"
                                                            required
                                                        />
                                                        @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group customized-input-box mb-3">
                                                        <label for="district">District - জেলা সিলেক্ট করুন <span class="requere_text">*</span></label>

                                                        <select id="district" name="district" class="form-control form-select @error('district') is-invalid @enderror" required>
                                                            <option value="">Select</option>
                                                            @foreach($districts as $district)
                                                            <option value="{{ $district->district }}">
                                                                {{ $district->district }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                        @error('district')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group customized-input-box mb-3">
                                                        <label for="note">Note - নির্দেশনা</label>
                                                        <textarea id="note" class="form-control @error('note') is-invalid @enderror" name="note" rows="3" placeholder="আপনার স্পেশাল কোন রিকোয়ারমেন্ট থাকলে এখানে লিখুন">{{ old('note') }}</textarea>
                                                        @error('note')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- card end -->
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-6 cust-order-1">
                                <div class="cart_details table-responsive-sm">
                                    <div class="cardss">
                                        <p class="card__title">প্রোডাক্ট ডিটেইল</p>
                                        <div class="card-bodys cartlist">
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
                                                            <p>{{ Str::limit($value->name, 20) }}</p>
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
                                                            <p class="item__delete"><a class="cart_remove" data-id="{{ $value->rowId }}">Remove</a></p>
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
                                                   
                                                   
                                                    <div class="area-items">
                                                        <input name="area" id="area" class="areas" type="radio" value="{{$select_charge->id}}" checked />
                                                        <label for="area">{{ $select_charge->name}}</label>
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
                                            <input type="text" id="coupon_code" 
                                                placeholder="@if (Session::get('coupon_used')) {{ Session::get('coupon_used') }} @else If you have a Promo Code, Enter Here... @endif" 
                                                class="border-0 shadow-none form-control" 
                                                @if (Session::get('coupon_used')) disabled @endif 
                                            />
                                            
                                            <button type="button" id="coupon_btn">
                                                @if (Session::get('coupon_used')) Remove @else Apply @endif
                                            </button>
                                        </div>

                                            <!-- Success/Error message -->
                                            <div id="coupon_message"></div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button class="order_place" type="submit"><i class="fa-solid fa-lock"></i> অর্ডারটি কনফর্ম করুন</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- col end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection @push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>

<script>
    $(document).ready(function () {
        $('#district').on('change', function () {
            var id = $(this).val();
             // alert(id);
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('shipping.charge') }}", 
                    data: {
                        id: id,
                    },
                    dataType: "html",
                    success: function (response) {
                        $(".cartlist").html(response); 
                    },
                    error: function () {
                        console.log('Something Went Wrong !');
                    }
                });
            }
        });
    });
</script>

<script>
    $("#district").on("click", function () {
        var id = $(this).val();
        var name = $("#name").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        if (id && name && phone && address) {
            $.ajax({
                type: "GET",
                data: { id, name, phone, address },
                url: "{{route('order.store.draft')}}",
                success: function (data) {
                    if (data) {
                        return data;
                    }
                },
            });
        }
    });
</script>
<script type="text/javascript">
    dataLayer.push({
        ecommerce: null
    }); // Clear the previous ecommerce object.
    dataLayer.push({
        event: "view_cart",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brand }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<script type="text/javascript">
    // Clear the previous ecommerce object.
    dataLayer.push({
        ecommerce: null
    });

    // Push the begin_checkout event to dataLayer.
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
