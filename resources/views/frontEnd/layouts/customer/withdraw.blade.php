@extends('frontEnd.layouts.master')
@section('title', 'Customer Withdraws')
@section('content')
    <section class="customer-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 d-none d-sm-block">
                    <div class="customer-sidebar">
                        @include('frontEnd.layouts.customer.sidebar')
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="customer-content">
                        <h5 class="account-title">Make a Withdraw </h5>
                        <div class="customer-content-inner">
                            <form action="{{ route('customer.withdraw_store') }}" method="POST" class="row"
                                enctype="multipart/form-data" data-parsley-validate="">
                            {{--
                            payment_method	message	status
                             --}}
                                @csrf
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="amount" class="form-label">Amount *</label>
                                        <input type="number" id="amount"
                                            class="form-control @error('amount') is-invalid @enderror" name="amount"
                                            value="{{ old('amount') }}" required>
                                        @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Payment Method *</label>
                                        <select id="payment_method"
                                            class="form-control select2 form-select @error('payment_method') is-invalid @enderror"
                                            name="payment_method" value="{{ old('payment_method') }}" required>
                                            <option value="">Select...</option>
                                            <option value="bkash">bKash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="rocket">Rocket</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="account_number" class="form-label">Account Number *</label>
                                        <input type="number" id="account_number"
                                            class="form-control @error('account_number') is-invalid @enderror" name="account_number"
                                            value="{{ old('account_number') }}" required>
                                        @error('account_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->

                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="message" class="form-label">Message *</label>
                                        <input type="text" id="message"
                                            class="form-control @error('message') is-invalid @enderror" name="message"
                                            value="{{ old('message') }}" required>
                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->


                                <div class="col-sm-12">

                                </div>
                                <!-- col-end -->
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <button type="submit" class="submit-btn">Update</button>
                                    </div>
                                </div>
                                <!-- col-end -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
