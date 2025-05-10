@extends('frontEnd.layouts.master')
@section('title','Contact')
@section('content')

 <section class="middle-contact-section">
    <h1 class="contact-header">Contact <span>Info</span></h1>
    <p class="subheading">Have questions? Feel free to reach out via email or phone. We’d love to hear from you!</p>
    
    <div class="middle-contact-cards">
      <!-- Visit Outlet -->
      <div class="item-card">
        <div class="contact-icon">
          <i class="fas fa-store"></i>
        </div>
        <h2 class="card-title">Visit <span>Outlet</span></h2>
        <p class="card-text">
          {{ $contact->address }}
        </p>
        <a href="#" class="contact-page-btn">VISIT SHOP</a>
      </div>

      <!-- WhatsApp -->
      <div class="item-card">
        <div class="contact-icon">
          <i class="fab fa-whatsapp"></i>
        </div>
        <h2 class="card-title">Whats<span>App</span></h2>
        <p class="card-text">
          Have a quick question or need to report an issue?<br> 
          Send us a message on WhatsApp:<br>
          <strong>WhatsApp:</strong> +880 1977-391330
        </p>
        <a href="https://api.whatsapp.com/send?phone={{ $contact->whatsapp }}" target="_blank" class="contact-page-btn">CONTACT US</a>
      </div>

      <!-- Call Us -->
      <div class="item-card">
        <div class="contact-icon">
          <i class="fas fa-phone-alt"></i>
        </div>
        <h2 class="card-title">Call <span>Us</span></h2>
        <p class="card-text">
          Directly for immediate assistance:<br>
          <strong>Main Line:</strong> +8809617–100900
        </p>
        <a href="tel:{{ $contact->hotline }}" class="contact-page-btn">CALL NOW</a>
      </div>
    </div>
  </section>

<section class="contact-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12"></div>
            <div class="col-sm-10">
                <div class="contact-form">
                    <h5 class="account-title">অথবা</h5>
                    <form action="{{route('contact.mail_send')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name">সম্পূর্ণ নাম *</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="phone">মোবাইল নাম্বার *</label>
                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required />
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="email">ইমেইল *</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="subject">বিষয় *</label>
                                <input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{old('subject')}}" required />
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="message">মেসেজ লিখুন *</label>
                                <textarea type="text" id="message" class="form-control @error('message') is-invalid @enderror" name="message" value="{{old('message')}}" required></textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <button type="submit" class="submit-btn">মেসেজ পাঠান</button>
                            </div>
                        </div>
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