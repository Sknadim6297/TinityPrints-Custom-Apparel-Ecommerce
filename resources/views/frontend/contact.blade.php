@extends('frontend.layout.app')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1>Contact Us</h1>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" name="message" rows="5" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
        <div class="col-md-4">
            <h3>Get in Touch</h3>
            <div class="card">
                <div class="card-body">
                    <p><strong>Address:</strong><br>123 Fashion Street<br>Style City, SC 12345</p>
                    <p><strong>Phone:</strong><br>+1 (555) 123-4567</p>
                    <p><strong>Email:</strong><br>info@tinnity.com</p>
                    <p><strong>Business Hours:</strong><br>
                    Monday - Friday: 9:00 AM - 6:00 PM<br>
                    Saturday: 10:00 AM - 4:00 PM<br>
                    Sunday: Closed</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection