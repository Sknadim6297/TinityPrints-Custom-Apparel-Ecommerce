@extends('frontend.layout.app')

@section('title', 'Profile')

@section('content')
<section class="page-title-area" data-background="{{ asset('frontend/assets/img/bg/page-title-bg.html') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-wrapper text-center">
                    <h1 class="page-title mb-10">Profile</h1>
                    <div class="breadcrumb-menu">
                        <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                                <li class="trail-item trail-end"><span>Profile</span></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success mb-30">Profile updated successfully.</div>
                @endif
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success mb-30">Password updated successfully.</div>
                @endif

                <div class="bg-white rounded-lg p-30 mb-30">
                    <h3 class="mb-10">Profile Information</h3>
                    <p class="text-muted mb-20">Update your name and email address.</p>

                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-20">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @if ($errors->get('name'))
                                <div class="text-danger mt-5">{{ $errors->get('name')[0] }}</div>
                            @endif
                        </div>

                        <div class="mb-20">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @if ($errors->get('email'))
                                <div class="text-danger mt-5">{{ $errors->get('email')[0] }}</div>
                            @endif

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-10">
                                    <p class="text-muted mb-10">Your email address is unverified.</p>
                                    <button form="send-verification" type="submit" class="border-btn">Resend verification email</button>
                                    @if (session('status') === 'verification-link-sent')
                                        <div class="text-success mt-10">A new verification link has been sent.</div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="border-btn">Save Changes</button>
                    </form>
                </div>

                <div class="bg-white rounded-lg p-30 mb-30">
                    <h3 class="mb-10">Update Password</h3>
                    <p class="text-muted mb-20">Use a strong password to keep your account secure.</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-20">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password">
                            @if ($errors->updatePassword->get('current_password'))
                                <div class="text-danger mt-5">{{ $errors->updatePassword->get('current_password')[0] }}</div>
                            @endif
                        </div>

                        <div class="mb-20">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password" name="password" class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->get('password'))
                                <div class="text-danger mt-5">{{ $errors->updatePassword->get('password')[0] }}</div>
                            @endif
                        </div>

                        <div class="mb-20">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->get('password_confirmation'))
                                <div class="text-danger mt-5">{{ $errors->updatePassword->get('password_confirmation')[0] }}</div>
                            @endif
                        </div>

                        <button type="submit" class="border-btn">Update Password</button>
                    </form>
                </div>

                <div class="bg-white rounded-lg p-30">
                    <h3 class="mb-10">Delete Account</h3>
                    <p class="text-muted mb-20">This action is permanent. Please confirm your password to delete your account.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                        @csrf
                        @method('delete')

                        <div class="mb-20">
                            <label for="delete_password" class="form-label">Password</label>
                            <input id="delete_password" type="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password">
                            @if ($errors->userDeletion->get('password'))
                                <div class="text-danger mt-5">{{ $errors->userDeletion->get('password')[0] }}</div>
                            @endif
                        </div>

                        <button type="submit" class="border-btn">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
