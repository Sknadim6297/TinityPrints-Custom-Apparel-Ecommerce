@extends('admin.layouts.admin-app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')

<style>
    body {
        background-color: #f3f4f6;
    }

    .about-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .about-card {
        width: 100%;
        max-width: 850px;
        background: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .about-title {
        text-align: center;
        margin-bottom: 35px;
    }

    .about-title h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #111827;
    }

    .about-title p {
        font-size: 14px;
        color: #6b7280;
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

    .image-preview {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        margin-bottom: 10px;
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

    @media (max-width: 768px) {
        .about-card {
            padding: 25px;
        }
    }
</style>

<div class="about-wrapper">

    <div class="about-card">

        <div class="about-title">
            <h2>Edit About Section</h2>
            <p>Update homepage content, images and button settings.</p>
        </div>

        <form method="POST"
              action="{{ route('admin.about.update') }}"
              enctype="multipart/form-data">
            @csrf

            <!-- Section Title -->
            <div class="form-group">
                <label>Section Title</label>
                <input type="text"
                       name="title"
                       value="{{ $about->title ?? '' }}"
                       class="form-control">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label>Description</label>
                <textarea name="description"
                          rows="5"
                          class="form-control">{{ $about->description ?? '' }}</textarea>
            </div>

            <!-- Main Image -->
            <div class="form-group">
                <label>Main Image</label>

                @if(!empty($about->main_image))
                    <img src="{{ Storage::url($about->main_image) }}"
                         class="image-preview">
                @endif

                <input type="file" name="main_image" class="form-control">
            </div>

            <!-- Secondary Image -->
            <div class="form-group">
                <label>Secondary Image</label>

                @if(!empty($about->secondary_image))
                    <img src="{{ Storage::url($about->secondary_image) }}"
                         class="image-preview">
                @endif

                <input type="file" name="secondary_image" class="form-control">
            </div>

            <!-- Button Text -->
            <div class="form-group">
                <label>Button Text</label>
                <input type="text"
                       name="button_text"
                       value="{{ $about->button_text ?? '' }}"
                       class="form-control">
            </div>

            <!-- Button Link -->
            <div class="form-group">
                <label>Button Link</label>
                <input type="text"
                       name="button_link"
                       value="{{ $about->button_link ?? '' }}"
                       class="form-control">
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">
                Save Changes
            </button>

        </form>

    </div>

</div>

<!-- Divider -->
<div style="margin:50px 0 25px 0;">
    <h3 style="font-size:20px; font-weight:600; margin-bottom:15px;">
        Current Saved Data (Frontend Status)
    </h3>
</div>

<div style="
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    border:1px solid #e5e7eb;
    overflow:hidden;
">

    <table style="
        width:100%;
        border-collapse:collapse;
        font-size:14px;
    ">
        <thead style="background:#f9fafb;">
            <tr>
                <th style="padding:14px; text-align:left; border-bottom:1px solid #e5e7eb;">
                    Field
                </th>
                <th style="padding:14px; text-align:left; border-bottom:1px solid #e5e7eb;">
                    Value
                </th>
                <th style="padding:14px; text-align:center; border-bottom:1px solid #e5e7eb;">
                    Status
                </th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">Title</td>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">
                    {{ $about->title ?? '—' }}
                </td>
                <td style="text-align:center; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->title))
                        <span style="color:#16a34a; font-weight:600;">✔ Showing</span>
                    @else
                        <span style="color:#dc2626; font-weight:600;">✖ Missing</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">Description</td>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">
                    {{ $about->description ?? '—' }}
                </td>
                <td style="text-align:center; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->description))
                        <span style="color:#16a34a; font-weight:600;">✔ Showing</span>
                    @else
                        <span style="color:#dc2626; font-weight:600;">✖ Missing</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">Main Image</td>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->main_image))
                        <img src="{{ Storage::url($about->main_image) }}"
                             style="height:70px; border-radius:6px;">
                    @else
                        —
                    @endif
                </td>
                <td style="text-align:center; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->main_image))
                        <span style="color:#16a34a; font-weight:600;">✔ Showing</span>
                    @else
                        <span style="color:#dc2626; font-weight:600;">✖ Missing</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">Secondary Image</td>
                <td style="padding:14px; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->secondary_image))
                        <img src="{{ Storage::url($about->secondary_image) }}"
                             style="height:70px; border-radius:6px;">
                    @else
                        —
                    @endif
                </td>
                <td style="text-align:center; border-bottom:1px solid #f1f1f1;">
                    @if(!empty($about->secondary_image))
                        <span style="color:#16a34a; font-weight:600;">✔ Showing</span>
                    @else
                        <span style="color:#dc2626; font-weight:600;">✖ Missing</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="padding:14px;">Button Text</td>
                <td style="padding:14px;">
                    {{ $about->button_text ?? '—' }}
                </td>
                <td style="text-align:center;">
                    @if(!empty($about->button_text))
                        <span style="color:#16a34a; font-weight:600;">✔ Showing</span>
                    @else
                        <span style="color:#dc2626; font-weight:600;">✖ Missing</span>
                    @endif
                </td>
            </tr>

        </tbody>
    </table>

</div>

@endsection

