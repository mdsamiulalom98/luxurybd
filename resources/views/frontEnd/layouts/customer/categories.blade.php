@extends('frontEnd.layouts.master')
@section('title', 'Customer Categories')
@section('content')
    <section class="customer-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 d-none d-sm-block">
                    <div class="customer-sidebar">
                        @include('frontEnd.layouts.customer.sidebar')
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="customer-content">
                        <h5 class="account-title">My Categories</h5>
                        <div class="customer-content-inner">
                            <form action="{{ route('customer.category_update') }}" method="POST" class="row"
                                data-parsley-validate="">
                                @csrf

                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label for="category1" class="form-label">Category One *</label>
                                        <select id="category1"
                                            class="form-control category-select form-select select2 category1 @error('category1') is-invalid @enderror"
                                            name="category1" value="{{ old('category1') }}" required>
                                            <option value="">Select...</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($customer->category1 == $category->id) selected @endif>
                                                    {{ $category->name }}</option>
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
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label for="category2" class="form-label">Category Two *</label>
                                        <select id="category2"
                                            class="form-control category-select form-select category2 select2 @error('category2') is-invalid @enderror"
                                            name="category2" value="{{ old('category2') }}" required>
                                            <option value="">Select...</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($customer->category2 == $category->id) selected @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach

                                        </select>
                                        @error('category2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label for="category3" class="form-label">Category Three *</label>
                                        <select id="category3"
                                            class="form-control category-select form-select category3 select2 @error('category3') is-invalid @enderror"
                                            name="category3" value="{{ old('category3') }}" required>
                                            <option value="">Select...</option>

                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($customer->category3 == $category->id) selected @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->

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

@push('script')
    <script>
        $(document).ready(function() {
            $('.category-select').on('change', function() {
                let selectedValues = [];

                // Gather all selected values
                $('.category-select').each(function() {
                    let val = $(this).val();
                    if (val) selectedValues.push(val);
                });

                // Enable all options first
                $('.category-select option').prop('disabled', false);

                // Disable selected options in other selects
                $('.category-select').each(function() {
                    let currentSelect = $(this);
                    selectedValues.forEach(function(val) {
                        if (val !== currentSelect.val()) {
                            currentSelect.find('option[value="' + val + '"]').prop(
                                'disabled', true);
                        }
                    });
                });
            });
        });
    </script>
@endpush
