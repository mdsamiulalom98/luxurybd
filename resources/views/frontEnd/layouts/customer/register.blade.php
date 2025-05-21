@extends('frontEnd.layouts.master')
@section('title', 'Customer Register')
@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title"> Register </p>
                        <form action="{{ route('customer.store') }}" method="POST" data-parsley-validate="">
                            @csrf

                            <div class="form-group mb-3 d-flex justify-content-center">
                                <ul class="radio-switch ">
                                    <li class="radio-switch__item">
                                        <input class="radio-switch__input ri5-sr-only" type="radio" name="customer_type"
                                            id="radio-1" value="1" checked>
                                        <label class="radio-switch__label" for="radio-1">Reseller</label>
                                    </li>

                                    <li class="radio-switch__item">
                                        <input class="radio-switch__input ri5-sr-only" type="radio" name="customer_type"
                                            id="radio-2" value="2">
                                        <label class="radio-switch__label" for="radio-2">Whole Seller</label>
                                        <div aria-hidden="true" class="radio-switch__marker"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group mb-3">
                                <label for="referral_id">Referral ID *</label>
                                <input type="text" id="referral_id"
                                    class="form-control @error('referral_id') is-invalid @enderror" name="referral_id"
                                    value="{{ Session::get('referral_id') ?? old('referral_id') }}" placeholder="Referral ID" required>
                                @error('referral_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="form-group mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" placeholder="Enter your full name " required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="form-group mb-3">
                                <label for="phone"> Mobile Number * </label>
                                <input type="number" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" placeholder="Enter your mobile number" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="form-group mb-3">
                                <label for="email"> Email </label>
                                <input type="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" placeholder="Enter your email address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category1">Select Product Category *</label>
                                    <select id="category1"
                                        class="form-control select2 category1 @error('category1') is-invalid @enderror"
                                        name="category1" value="{{ old('category1') }}" required>
                                        <option value="">Select...</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <!-- col-end -->
                            <div class="form-group mb-4">
                                <label for="password"> Password * </label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Choose a password " name="password" value="{{ old('password') }}"
                                    required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- col-end -->
                            <button class="submit-btn mt-4">Submit</button>
                            <div class="register-now no-account">
                                <p> If have an account. <a href="{{ route('customer.login') }}"><i
                                            data-feather="edit-3"></i> Login here </a></p>

                            </div>
                    </div>
                    <!-- col-end -->


                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush
