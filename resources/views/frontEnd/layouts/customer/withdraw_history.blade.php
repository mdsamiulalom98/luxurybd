@extends('frontEnd.layouts.master')
@section('title', 'Customer Deposits')
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
                        <h5 class="account-title d-flex justify-content-between align-items-center">My Deposits <a
                                href="{{ route('customer.withdraw_create') }}" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus"></i> Add</a></h5>
                        <div class="customer-content-inner">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Account Number</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawhistory as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                                <td>৳{{ $value->amount }}</td>
                                                <td>{{ $value->payment_method }}</td>
                                                <td>{{ $value->account_number }}</td>
                                                <td>{{ $value->message }}</td>
                                                <td>{{ $value->status }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
