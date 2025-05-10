<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $generalsetting->name }}</title>
    <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" type="image/x-icon" />
    <!-- fot awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <!-- core css -->
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/assets/css/toastr.min.css" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.theme.default.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.carousel.min.css" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/style.css?v=1.0.0" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/responsive.css?v=1.0.0" />
    @foreach ($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixel->code }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $pixel->code }}&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endforeach

    <meta name="app-url" content="{{ route('campaign', $campaign->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $campaign->short_description }}" />
    <meta name="keywords" content="{{ $campaign->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $campaign->name }}" />
    <meta name="twitter:title" content="{{ $campaign->name }}" />
    <meta name="twitter:description" content="{{ $campaign->short_description }}" />
    <meta name="twitter:creator" content="" />
    <meta property="og:url" content="{{ route('campaign', $campaign->slug) }}" />
    <meta name="twitter:image" content="{{ asset($campaign->banner) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $campaign->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('campaign', $campaign->slug) }}" />
    <meta property="og:image" content="{{ asset($campaign->banner) }}" />
    <meta property="og:description" content="{{ $campaign->short_description }}" />
    <meta property="og:site_name" content="{{ $campaign->name }}" />
</head>

<body>
    @php $subtotal = Cart::instance('shopping')->subtotal(); $subtotal = str_replace(',', '', $subtotal); $subtotal = str_replace('.00', '', $subtotal); $shipping = Session::get('shipping') ? Session::get('shipping') : 0; $coupon =
    Session::get('coupon_amount') ? Session::get('coupon_amount') : 0; $discount = Session::get('discount') ? Session::get('discount') : 0; $cart = Cart::instance('shopping')->content();
    @endphp

    <section class="heading-section">
        <div class="shape_bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-10">
                        <div class="heading-inner">
                            <div class="heading_title">
                                <h2>{{ $campaign->name }}</h2>
                                <h5>{{ $campaign->sub_title }}</h5>
                            </div>
                            <a href="#order_form" class="order_btn2">অর্ডার করতে চাই</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner_shape">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="none">
                    <path class="wsit-shape-fill"
                        d="M283.5,9.7c0,0-7.3,4.3-14,4.6c-6.8,0.3-12.6,0-20.9-1.5c-11.3-2-33.1-10.1-44.7-5.7	s-12.1,4.6-18,7.4c-6.6,3.2-20,9.6-36.6,9.3C131.6,23.5,99.5,7.2,86.3,8c-1.4,0.1-6.6,0.8-10.5,2c-3.8,1.2-9.4,3.8-17,4.7	c-3.2,0.4-8.3,1.1-14.2,0.9c-1.5-0.1-6.3-0.4-12-1.6c-5.7-1.2-11-3.1-15.8-3.7C6.5,9.2,0,10.8,0,10.8V0h283.5V9.7z M260.8,11.3	c-0.7-1-2-0.4-4.3-0.4c-2.3,0-6.1-1.2-5.8-1.1c0.3,0.1,3.1,1.5,6,1.9C259.7,12.2,261.4,12.3,260.8,11.3z M242.4,8.6	c0,0-2.4-0.2-5.6-0.9c-3.2-0.8-10.3-2.8-15.1-3.5c-8.2-1.1-15.8,0-15.1,0.1c0.8,0.1,9.6-0.6,17.6,1.1c3.3,0.7,9.3,2.2,12.4,2.7	C239.9,8.7,242.4,8.6,242.4,8.6z M185.2,8.5c1.7-0.7-13.3,4.7-18.5,6.1c-2.1,0.6-6.2,1.6-10,2c-3.9,0.4-8.9,0.4-8.8,0.5	c0,0.2,5.8,0.8,11.2,0c5.4-0.8,5.2-1.1,7.6-1.6C170.5,14.7,183.5,9.2,185.2,8.5z M199.1,6.9c0.2,0-0.8-0.4-4.8,1.1	c-4,1.5-6.7,3.5-6.9,3.7c-0.2,0.1,3.5-1.8,6.6-3C197,7.5,199,6.9,199.1,6.9z M283,6c-0.1,0.1-1.9,1.1-4.8,2.5s-6.9,2.8-6.7,2.7	c0.2,0,3.5-0.6,7.4-2.5C282.8,6.8,283.1,5.9,283,6z M31.3,11.6c0.1-0.2-1.9-0.2-4.5-1.2s-5.4-1.6-7.8-2C15,7.6,7.3,8.5,7.7,8.6	C8,8.7,15.9,8.3,20.2,9.3c2.2,0.5,2.4,0.5,5.7,1.6S31.2,11.9,31.3,11.6z M73,9.2c0.4-0.1,3.5-1.6,8.4-2.6c4.9-1.1,8.9-0.5,8.9-0.8	c0-0.3-1-0.9-6.2-0.3S72.6,9.3,73,9.2z M71.6,6.7C71.8,6.8,75,5.4,77.3,5c2.3-0.3,1.9-0.5,1.9-0.6c0-0.1-1.1-0.2-2.7,0.2	C74.8,5.1,71.4,6.6,71.6,6.7z M93.6,4.4c0.1,0.2,3.5,0.8,5.6,1.8c2.1,1,1.8,0.6,1.9,0.5c0.1-0.1-0.8-0.8-2.4-1.3	C97.1,4.8,93.5,4.2,93.6,4.4z M65.4,11.1c-0.1,0.3,0.3,0.5,1.9-0.2s2.6-1.3,2.2-1.2s-0.9,0.4-2.5,0.8C65.3,10.9,65.5,10.8,65.4,11.1	z M34.5,12.4c-0.2,0,2.1,0.8,3.3,0.9c1.2,0.1,2,0.1,2-0.2c0-0.3-0.1-0.5-1.6-0.4C36.6,12.8,34.7,12.4,34.5,12.4z M152.2,21.1	c-0.1,0.1-2.4-0.3-7.5-0.3c-5,0-13.6-2.4-17.2-3.5c-3.6-1.1,10,3.9,16.5,4.1C150.5,21.6,152.3,21,152.2,21.1z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M269.6,18c-0.1-0.1-4.6,0.3-7.2,0c-7.3-0.7-17-3.2-16.6-2.9c0.4,0.3,13.7,3.1,17,3.3	C267.7,18.8,269.7,18,269.6,18z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M227.4,9.8c-0.2-0.1-4.5-1-9.5-1.2c-5-0.2-12.7,0.6-12.3,0.5c0.3-0.1,5.9-1.8,13.3-1.2	S227.6,9.9,227.4,9.8z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M204.5,13.4c-0.1-0.1,2-1,3.2-1.1c1.2-0.1,2,0,2,0.3c0,0.3-0.1,0.5-1.6,0.4	C206.4,12.9,204.6,13.5,204.5,13.4z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M201,10.6c0-0.1-4.4,1.2-6.3,2.2c-1.9,0.9-6.2,3.1-6.1,3.1c0.1,0.1,4.2-1.6,6.3-2.6	S201,10.7,201,10.6z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M154.5,26.7c-0.1-0.1-4.6,0.3-7.2,0c-7.3-0.7-17-3.2-16.6-2.9c0.4,0.3,13.7,3.1,17,3.3	C152.6,27.5,154.6,26.8,154.5,26.7z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M41.9,19.3c0,0,1.2-0.3,2.9-0.1c1.7,0.2,5.8,0.9,8.2,0.7c4.2-0.4,7.4-2.7,7-2.6	c-0.4,0-4.3,2.2-8.6,1.9c-1.8-0.1-5.1-0.5-6.7-0.4S41.9,19.3,41.9,19.3z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M75.5,12.6c0.2,0.1,2-0.8,4.3-1.1c2.3-0.2,2.1-0.3,2.1-0.5c0-0.1-1.8-0.4-3.4,0	C76.9,11.5,75.3,12.5,75.5,12.6z">
                    </path>
                    <path class="wsit-shape-fill"
                        d="M15.6,13.2c0-0.1,4.3,0,6.7,0.5c2.4,0.5,5,1.9,5,2c0,0.1-2.7-0.8-5.1-1.4	C19.9,13.7,15.7,13.3,15.6,13.2z">
                    </path>
                </svg>
            </div>
        </div>
    </section>
    <!-- banner section end -->
    <section class="banner-section2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="campaign_banner">
                        <div class="banner-img">
                            <img src="{{ asset($campaign->banner) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end -->

    <!-- short-desctiption section start -->
    <section class="short-des2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="short-des-2">
                        {!! $campaign->short_description !!}
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- short-desctiption section end -->

    <!-- desctiption section start -->
    <section class="description-section2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <div class="description-inner2">
                        <div class="description-title2">
                            <h2>{{ $campaign->description_title }}</h2>
                        </div>
                        <div class="campaign-description check-double">
                            {!! $campaign->description !!}
                        </div>
                    </div>
                    <div class="ord_btn mt-5">
                        <a href="#order_form" class="order_btn2">অর্ডার করতে চাই</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- desctiption section end -->

    <!-- desctiption section start -->
    <section class="whychoose-section2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="whychoose-inner-2">
                        <div class="whychoose-title-2">
                            <h2>আমাদের প্রোডাক্ট কেন কিনবেন?</h2>
                        </div>
                        <div class="whychoose-2 check-double">
                            {!! $campaign->why_chooseus !!}
                        </div>
                    </div>
                    <div class="ord_btn my-5">
                        <a href="#order_form" class="order_btn2">অর্ডার করতে চাই</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- desctiption section end -->

    <!-- review section start -->
    @if ($campaign->images)
        <section class="review-section-2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="rev_inn-2">
                            <div class="rev_title2">
                                <h2>আমাদের কাস্টমারের রিভিউ?</h2>
                            </div>
                            <div class="review_slider owl-carousel">
                                @foreach ($campaign->images as $key => $value)
                                    <div class="review_item">
                                        <img src="{{ asset($value->image) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- review section end -->

    <!-- offer price form end -->
    <section class="price-section-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="offer_price-2">
                        <div class="offer_title-2">
                            <h2>অফারটি সীমিত সময়ের জন্য, তাই অফার শেষ হওয়ার আগেই অর্ডারটি কনফার্ম করুন </h2>
                        </div>
                        <div class="product-price-2">
                            <h2>
                                @if ($old_price)
                                    <p class="old_price"> আগের দাম : <del> {{ $old_price }}</del> টাকা</p>
                                @endif
                                <p>বর্তমান দাম {{ $new_price }} টাকা</p>
                            </h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="form_sec">
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
                                                        <label for="phone">Mobile Number -  মোবাইল নাম্বার <span class="requere_text">*</span></label>
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
                                                @if ($productcolors->count() > 0)
                                                            <div class="pro-color" style="width: 100%;">
                                                                <div class="color_inner">
                                                                    <p>Color -</p>
                                                                    <div class="size-container">
                                                                        <div class="selector">
                                                                            @foreach ($productcolors as $key => $procolor)
                                                                                <div class="selector-item color-item"
                                                                                    data-id="{{ $key }}">
                                                                                    <input type="radio"
                                                                                        id="fc-option{{ $procolor->color }}"
                                                                                        value="{{ $procolor->color }}"
                                                                                        name="product_color"
                                                                                        class="selector-item_radio emptyalert stock_color stock_check"
                                                                                        required
                                                                                        data-color="{{ $procolor->color }}" />
                                                                                    <label
                                                                                        for="fc-option{{ $procolor->color }}"
                                                                                        class="selector-item_label">{{ $procolor->color }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($productsizes->count() > 0)
                                                            <div class="pro-size" style="width: 100%;">
                                                                <div class="size_inner">
                                                                    <p>Size - <span class="attibute-name"></span></p>
                                                                    <div class="size-container">
                                                                        <div class="selector">
                                                                            @foreach ($productsizes as $prosize)
                                                                                <div class="selector-item">
                                                                                    <input type="radio"
                                                                                        id="f-option{{ $prosize->size }}"
                                                                                        value="{{ $prosize->size }}"
                                                                                        name="product_size"
                                                                                        class="selector-item_radio emptyalert stock_size stock_check"
                                                                                        data-size="{{ $prosize->size }}"
                                                                                        required />
                                                                                    <label
                                                                                        for="f-option{{ $prosize->size }}"
                                                                                        class="selector-item_label">{{ $prosize->size }}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
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
                                                            <p class="item__delete"><a class="cart_remove" data-id="{{ $value->rowId }}"></a></p>
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
                                                        <input name="area" id="area" class="areas" type="radio" value="{{ $select_charge->id}}" checked />
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
                                                <button class="order_places" type="submit"><i class="fa-solid fa-lock"></i> অর্ডারটি কনফর্ম করুন</button>
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

    <script src="{{ asset('public/frontEnd/campaign/js') }}/jquery-2.1.4.min.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/all.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/bootstrap.min.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/owl.carousel.min.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/select2.min.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/script.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    <!-- bootstrap js -->
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                margin: 15,
                loop: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                items: 1,
            });
            $('.owl-nav').remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

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
                        alert('Something Went Wrong !');
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
    <script>
        $(".cart_increment").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('cart.increment_camp') }}",
                    success: function(data) {
                        if (data) {
                            $(".cartlist").html(data);
                        }
                    },
                });
            }
        });

        $(".cart_decrement").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('cart.decrement_camp') }}",
                    success: function(data) {
                        if (data) {
                            $(".cartlist").html(data);
                        }
                    },
                });
            }
        });
        $(".stock_check").on("click", function() {
            var color = $(".stock_color:checked").data('color');
            var size = $(".stock_size:checked").data('size');
            var id = {{ $campaign->product_id }};
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        color: color,
                        size: size
                    },
                    url: "{{ route('campaign.stock_check') }}",
                    dataType: "json",
                    success: function(status) {
                        if (status == true) {
                            $('.confirm_order').prop('disabled', false);
                            return cart_content();
                        } else {
                            $('.confirm_order').prop('disabled', true);
                            toastr.error("Please select another color or size");
                        }
                        console.log(status);
                        // return cart_content();
                    }
                });
            }
        });

        function cart_content() {
            $.ajax({
                type: "GET",
                url: "{{ route('cart.content_camp') }}",
                success: function(data) {
                    if (data) {
                        $(".cartlist").html(data);
                    } else {
                        $(".cartlist").html(data);
                    }
                },
            });
        }
    </script>
    <script>
        $('.review_slider').owlCarousel({
            dots: false,
            arrow: false,
            autoplay: true,
            loop: true,
            margin: 10,
            smartSpeed: 1000,
            mouseDrag: true,
            touchDrag: true,
            items: 6,
            responsiveClass: true,
            responsive: {
                300: {
                    items: 1,
                },
                480: {
                    items: 2,
                },
                768: {
                    items: 5,
                },
                1170: {
                    items: 5,
                },
            }
        });
    </script>
</body>

</html>
