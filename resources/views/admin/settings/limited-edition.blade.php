@extends('admin.layouts.admin-app')

@section('content')
    <style>
        .settings-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 32px 16px 50px;
            min-height: 100vh;
        }

        .settings-card {
            width: 100%;
            max-width: 1000px;
            background: #ffffff;
            padding: 28px;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .settings-title h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .settings-title p {
            color: #4b5563;
            margin-bottom: 26px;
        }

        .section-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 18px;
            background: #f9fafb;
        }

        .section-card h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }

        .section-help {
            margin-bottom: 16px;
            color: #6b7280;
            font-size: 13px;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-group label {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 11px 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            background: #fff;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #facc15;
            outline: none;
            box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #facc15, #eab308);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            color: #111;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(to right, #eab308, #ca8a04);
        }

        @media (max-width: 768px) {
            .field-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="settings-wrapper">
        <div class="settings-card">
            <div class="settings-title">
                <h2>Limited Edition Settings</h2>
                <p>Manage both the home section and dedicated Limited Edition page content from one place.</p>
            </div>

            <form method="POST" action="{{ route('admin.limited-edition-settings.update') }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div style="margin-bottom:16px;padding:12px;border-radius:8px;background:#fef2f2;color:#b91c1c;">
                        <strong>Please fix the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="section-card">
                    <h4>Home Limited Edition Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="limited_edition[title]" value="{{ old('limited_edition.title', $data['limited_edition']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Section Subtitle</label>
                            <input type="text" name="limited_edition[subtitle]" value="{{ old('limited_edition.subtitle', $data['limited_edition']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Button Text</label>
                            <input type="text" name="limited_edition[view_all_text]" value="{{ old('limited_edition.view_all_text', $data['limited_edition']['view_all_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Button Link</label>
                            <input type="text" name="limited_edition[view_all_link]" value="{{ old('limited_edition.view_all_link', $data['limited_edition']['view_all_link'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Badge Text</label>
                            <input type="text" name="limited_edition[badge_text]" value="{{ old('limited_edition.badge_text', $data['limited_edition']['badge_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>How Many Products to Show</label>
                            <input type="number" min="1" name="limited_edition[product_limit]" value="{{ old('limited_edition.product_limit', $data['limited_edition']['product_limit'] ?? 4) }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Limited Edition Page</h4>
                    <div class="section-help">Controls content shown on the dedicated Limited Edition page.</div>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Page Title</label>
                            <input type="text" name="limited_edition_page[page_title]" value="{{ old('limited_edition_page.page_title', $data['limited_edition_page']['page_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Hero Badge</label>
                            <input type="text" name="limited_edition_page[hero_badge]" value="{{ old('limited_edition_page.hero_badge', $data['limited_edition_page']['hero_badge'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Hero Title</label>
                            <input type="text" name="limited_edition_page[hero_title]" value="{{ old('limited_edition_page.hero_title', $data['limited_edition_page']['hero_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Current Hero Image</label>
                            <input type="hidden" name="limited_edition_page[hero_image_url]" value="{{ old('limited_edition_page.hero_image_url', $data['limited_edition_page']['hero_image_url'] ?? '') }}">
                            @if(!empty($data['limited_edition_page']['hero_image_url']))
                                <img src="{{ $data['limited_edition_page']['hero_image_url'] }}" alt="Limited Edition Hero"
                                     style="width: 100%; max-height: 180px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                            @else
                                <div style="padding:10px 12px;border:1px dashed #d1d5db;border-radius:8px;color:#6b7280;font-size:13px;">No hero image uploaded yet.</div>
                            @endif
                        </div>
                        <div class="field-group">
                            <label>Upload Hero Image</label>
                            <input type="file" name="limited_edition_page[hero_image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Hero Description</label>
                            <textarea name="limited_edition_page[hero_description]" class="form-control">{{ old('limited_edition_page.hero_description', $data['limited_edition_page']['hero_description'] ?? '') }}</textarea>
                        </div>
                        <div class="field-group">
                            <label>Feature 1</label>
                            <input type="text" name="limited_edition_page[feature_1]" value="{{ old('limited_edition_page.feature_1', $data['limited_edition_page']['feature_1'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Feature 2</label>
                            <input type="text" name="limited_edition_page[feature_2]" value="{{ old('limited_edition_page.feature_2', $data['limited_edition_page']['feature_2'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Feature 3</label>
                            <input type="text" name="limited_edition_page[feature_3]" value="{{ old('limited_edition_page.feature_3', $data['limited_edition_page']['feature_3'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Products Section Title</label>
                            <input type="text" name="limited_edition_page[products_title]" value="{{ old('limited_edition_page.products_title', $data['limited_edition_page']['products_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Products Section Subtitle</label>
                            <input type="text" name="limited_edition_page[products_subtitle]" value="{{ old('limited_edition_page.products_subtitle', $data['limited_edition_page']['products_subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Empty Title</label>
                            <input type="text" name="limited_edition_page[empty_title]" value="{{ old('limited_edition_page.empty_title', $data['limited_edition_page']['empty_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Empty Description</label>
                            <input type="text" name="limited_edition_page[empty_text]" value="{{ old('limited_edition_page.empty_text', $data['limited_edition_page']['empty_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Browse Button Text</label>
                            <input type="text" name="limited_edition_page[browse_text]" value="{{ old('limited_edition_page.browse_text', $data['limited_edition_page']['browse_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Browse Button Link</label>
                            <input type="text" name="limited_edition_page[browse_link]" value="{{ old('limited_edition_page.browse_link', $data['limited_edition_page']['browse_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Save Limited Edition Settings</button>
            </form>
        </div>
    </div>
@endsection
