@extends('backEnd.layouts.master')
@section('title', 'Withdraw Manage')

@section('css')
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Withdraw Manage</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive ">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Sender Number & Message</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($show_data as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->customer->name ?? '' }}</td>
                                            <td>{{ $value->amount }}</td>
                                            <td>{{ $value->payment_method }}</td>
                                            <td>{{ $value->account_number }} <br>
                                                {{ $value->message }}</td>
                                            <td>
                                                @if ($value->status == 'accepted')
                                                    <span class="badge bg-soft-success text-success">Accepted</span>
                                                @else
                                                    <span
                                                        class="badge bg-soft-danger text-danger">{{ $value->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="button-list">
                                                    @if ($value->status == 'pending')
                                                        <form method="post"
                                                            action="{{ route('withdraw.status', ['status' => 'accepted']) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}"
                                                                name="hidden_id">
                                                            <button type="button"
                                                                class="btn btn-xs  btn-success waves-effect waves-light change-confirm"><i
                                                                    class="fe-thumbs-up"></i> Accepted</button>
                                                        </form>
                                                        <form method="post"
                                                            action="{{ route('withdraw.status', ['status' => 'cancelled']) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}"
                                                                name="hidden_id">
                                                            <button type="button"
                                                                class="btn btn-xs  btn-danger waves-effect waves-light change-confirm"><i
                                                                    class="fe-thumbs-down"></i> Cancelled</button>
                                                        </form>
                                                    @endif
                                                    @if ($value->status == 'accepted')
                                                        <form method="post"
                                                            action="{{ route('withdraw.status', ['status' => 'returned']) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}"
                                                                name="hidden_id">
                                                            <button type="button"
                                                                class="btn btn-xs  btn-danger waves-effect waves-light change-confirm"><i
                                                                    class="fe-thumbs-down"></i> Returned</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-paginate">
                            {{ $show_data->links('pagination::bootstrap-4') }}
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
@endsection


@section('script')
    <!-- third party js -->
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script
        src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/js/pages/datatables.init.js"></script>
    <!-- third party js ends -->
@endsection
