@extends('frontEnd.layouts.master')
@section('title', 'Customer Account')
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
                        <h5 class="account-title">My Order</h5>
                        <div class="customer-level-buttons">
                            <a href="{{ route('customer.members', ['level' => 1]) }}" class="{{ request()->get('level') == 1 ? 'active' : '' }}">Level 1</a>
                            <a href="{{ route('customer.members', ['level' => 2]) }}" class="{{ request()->get('level') == 2 ? 'active' : '' }}">Level 2</a>
                            <a href="{{ route('customer.members', ['level' => 3]) }}" class="{{ request()->get('level') == 3 ? 'active' : '' }}">Level 3</a>
                            <a href="{{ route('customer.members', ['level' => 4]) }}" class="{{ request()->get('level') == 4 ? 'active' : '' }}">Level 4</a>
                            <a href="{{ route('customer.members', ['level' => 5]) }}" class="{{ request()->get('level') == 5 ? 'active' : '' }}">Level 5</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
