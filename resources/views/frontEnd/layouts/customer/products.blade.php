@extends('frontEnd.layouts.master')
@section('title', 'Customer Products')
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
                        <h5 class="account-title">My Products</h5>
                        <div class="customer-content-inner">
                            <div class="product-item-wrapper">
                                @foreach ($products as $key => $value)
                                    <div class="product_item wist_item">
                                        @include('frontEnd.layouts.partials.product')
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="custom_paginate">
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
