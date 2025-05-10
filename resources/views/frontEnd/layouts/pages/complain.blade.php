@extends('frontEnd.layouts.master')
@section('title','Customer Complain')
@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="form-content">
                    <p class="auth-title"> Complain </p>
                    <form action="{{route('complain_store')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="phone"> Mobile Number * </label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter your mobile number" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        
                        <div class="form-group mb-3">
                            <label for="question"> Complain Box  </label>
                            <input type="question" id="question" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" placeholder="Enter your complain">
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button class="submit-btn mt-4">Submit</button>
                         
                         
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
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush