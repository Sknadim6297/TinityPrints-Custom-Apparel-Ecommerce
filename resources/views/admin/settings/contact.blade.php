@extends('admin.layouts.admin-app')

@section('content')

<style>
    /* Reuse some styles from about edit for consistency */
    .settings-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .settings-card {
        width: 100%;
        max-width: 600px;
        background: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .settings-title {
        text-align: center;
        margin-bottom: 35px;
    }

    .settings-title h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #111827;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 14px;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #facc15;
        outline: none;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.2);
    }

    textarea.form-control {
        resize: none;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(to right, #facc15, #eab308);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        color: white;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .submit-btn:hover {
        background: linear-gradient(to right, #eab308, #ca8a04);
    }
</style>

<div class="settings-wrapper">
    <div class="settings-card">
        <div class="settings-title">
            <h2>Edit Contact Page Settings</h2>
            <p>Update phone numbers and address shown on contact page.</p>
        </div>

        <form method="POST" action="{{ route('admin.contact-settings.update') }}">
            @csrf

            <div class="form-group">
                <label>Mobile Phone</label>
                <input type="text" name="mobile_phone" value="{{ $settings->mobile_phone ?? '' }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Hotline Phone</label>
                <input type="text" name="hotline_phone" value="{{ $settings->hotline_phone ?? '' }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Primary Email</label>
                <input type="email" name="email_primary" value="{{ $settings->email_primary ?? '' }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Secondary Email</label>
                <input type="email" name="email_secondary" value="{{ $settings->email_secondary ?? '' }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3" class="form-control">{{ $settings->address ?? '' }}</textarea>
            </div>

            <button type="submit" class="submit-btn">Save Changes</button>
        </form>
    </div>
</div>

@endsection
