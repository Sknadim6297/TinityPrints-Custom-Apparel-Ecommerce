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
            max-width: 1150px;
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

        .item-card {
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            background: #fff;
            padding: 16px;
            margin-bottom: 14px;
        }

        .item-card h5 {
            margin-bottom: 14px;
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .field-grid.single {
            grid-template-columns: 1fr;
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

        .subsection-title {
            margin: 14px 0 10px;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
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
                <h2>Home Page General Settings</h2>
                <p>Use normal input fields below. The client can update each section without touching JSON.</p>
            </div>

            <form method="POST" action="{{ route('admin.home-settings.update') }}" enctype="multipart/form-data">
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
                    <h4>Top Promo Bar</h4>
                    <div class="section-help">
                        Edit the scrolling announcement above the header. Use <code>{discount}</code> where the discount percentage should appear (wrapped in a highlighted span).
                    </div>
                    <div class="field-grid single">
                        <div class="field-group">
                            <label>
                                <input type="hidden" name="promo_bar[enabled]" value="0">
                                <input type="checkbox" name="promo_bar[enabled]" value="1"
                                    {{ old('promo_bar.enabled', $data['promo_bar']['enabled'] ?? true) ? 'checked' : '' }}>
                                Show promo bar on website
                            </label>
                        </div>
                        <div class="field-group">
                            <label>Announcement text</label>
                            <textarea name="promo_bar[text]" class="form-control" rows="3">{{ old('promo_bar.text', $data['promo_bar']['text'] ?? '') }}</textarea>
                        </div>
                        <div class="field-group">
                            <label>Discount percentage</label>
                            <input type="text" name="promo_bar[discount]" class="form-control"
                                value="{{ old('promo_bar.discount', $data['promo_bar']['discount'] ?? '20') }}"
                                placeholder="e.g. 20">
                            <small style="color:#6b7280;">Displayed as <strong>20%</strong> when discount is 20.</small>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Offer Popup</h4>
                    <div class="section-help">Image shown once per browser session when visitors land on the site. Upload a compressed JPG/WebP (recommended under 500 KB) for fast loading.</div>
                    <div class="field-grid single">
                        <div class="field-group">
                            <label>
                                <input type="hidden" name="offer_popup[enabled]" value="0">
                                <input type="checkbox" name="offer_popup[enabled]" value="1"
                                    {{ old('offer_popup.enabled', $data['offer_popup']['enabled'] ?? true) ? 'checked' : '' }}>
                                Show offer popup on website
                            </label>
                        </div>
                        @php $offerPopupImage = old('offer_popup.existing_image_url', $data['offer_popup']['image_url'] ?? ''); @endphp
                        <div class="field-group">
                            <label>Current popup image</label>
                            <input type="hidden" name="offer_popup[existing_image_url]" value="{{ $offerPopupImage }}">
                            @if($offerPopupImage)
                                <img src="{{ $offerPopupImage }}" alt="Offer popup preview" style="max-width:280px;border-radius:8px;border:1px solid #e5e7eb;">
                            @else
                                <p style="color:#6b7280;font-size:13px;">No popup image uploaded yet.</p>
                            @endif
                        </div>
                        <div class="field-group">
                            <label>Upload popup image</label>
                            <input type="file" name="offer_popup[image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Hero Slides</h4>
                    <div class="section-help">Update slide image, text, button text and button link for each hero slide.</div>
                    @foreach (($data['hero_slides'] ?? []) as $index => $slide)
                        <div class="item-card">
                            <h5>Hero Slide {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Current Image</label>
                                    <input type="hidden" name="hero_slides[{{ $index }}][existing_image_url]" value="{{ old("hero_slides.$index.existing_image_url", $slide['image_url'] ?? '') }}">
                                    @if (!empty($slide['image_url']))
                                        <img src="{{ $slide['image_url'] }}" alt="Hero Slide {{ $index + 1 }}"
                                            style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label>Upload New Image (from device)</label>
                                    <input type="file" name="hero_slides[{{ $index }}][image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                </div>
                                <div class="field-group">
                                    <label>Subtitle</label>
                                    <input type="text" name="hero_slides[{{ $index }}][subtitle]" value="{{ old("hero_slides.$index.subtitle", $slide['subtitle'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Title Line 1</label>
                                    <input type="text" name="hero_slides[{{ $index }}][title_line_1]" value="{{ old("hero_slides.$index.title_line_1", $slide['title_line_1'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Title Line 2</label>
                                    <input type="text" name="hero_slides[{{ $index }}][title_line_2]" value="{{ old("hero_slides.$index.title_line_2", $slide['title_line_2'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Button Text</label>
                                    <input type="text" name="hero_slides[{{ $index }}][button_text]" value="{{ old("hero_slides.$index.button_text", $slide['button_text'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Button Link</label>
                                    <input type="text" name="hero_slides[{{ $index }}][button_link]" value="{{ old("hero_slides.$index.button_link", $slide['button_link'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Side Banners</h4>
                    <div class="section-help">Update the two image banners shown below the hero slider.</div>
                    @foreach (($data['side_banners'] ?? []) as $index => $banner)
                        <div class="item-card">
                            <h5>Side Banner {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Current Image</label>
                                    <input type="hidden" name="side_banners[{{ $index }}][existing_image_url]" value="{{ old("side_banners.$index.existing_image_url", $banner['image_url'] ?? '') }}">
                                    @if (!empty($banner['image_url']))
                                        <img src="{{ $banner['image_url'] }}" alt="Side Banner {{ $index + 1 }}"
                                            style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label>Upload New Image (from device)</label>
                                    <input type="file" name="side_banners[{{ $index }}][image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                </div>
                                <div class="field-group">
                                    <label>Title</label>
                                    <input type="text" name="side_banners[{{ $index }}][title]" value="{{ old("side_banners.$index.title", $banner['title'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Subtitle</label>
                                    <input type="text" name="side_banners[{{ $index }}][subtitle]" value="{{ old("side_banners.$index.subtitle", $banner['subtitle'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Button Text</label>
                                    <input type="text" name="side_banners[{{ $index }}][button_text]" value="{{ old("side_banners.$index.button_text", $banner['button_text'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group" style="grid-column: 1 / -1;">
                                    <label>Button Link</label>
                                    <input type="text" name="side_banners[{{ $index }}][button_link]" value="{{ old("side_banners.$index.button_link", $banner['button_link'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Best Seller Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="best_seller[title]" value="{{ old('best_seller.title', $data['best_seller']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Section Subtitle</label>
                            <input type="text" name="best_seller[subtitle]" value="{{ old('best_seller.subtitle', $data['best_seller']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Button Text</label>
                            <input type="text" name="best_seller[view_all_text]" value="{{ old('best_seller.view_all_text', $data['best_seller']['view_all_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Button Link</label>
                            <input type="text" name="best_seller[view_all_link]" value="{{ old('best_seller.view_all_link', $data['best_seller']['view_all_link'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>How Many Products to Show</label>
                            <input type="number" min="1" name="best_seller[product_limit]" value="{{ old('best_seller.product_limit', $data['best_seller']['product_limit'] ?? 8) }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Brand Story Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Current Story Image</label>
                            <input type="hidden" name="brand_story[existing_image_url]" value="{{ old('brand_story.existing_image_url', $data['brand_story']['image_url'] ?? '') }}">
                            @if (!empty($data['brand_story']['image_url']))
                                <img src="{{ $data['brand_story']['image_url'] }}" alt="Brand Story Image"
                                    style="width: 100%; max-height: 180px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                            @endif
                        </div>
                        <div class="field-group">
                            <label>Upload New Story Image (from device)</label>
                            <input type="file" name="brand_story[image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                        </div>
                        <div class="field-group">
                            <label>Main Title</label>
                            <input type="text" name="brand_story[title]" value="{{ old('brand_story.title', $data['brand_story']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Subtitle</label>
                            <input type="text" name="brand_story[subtitle]" value="{{ old('brand_story.subtitle', $data['brand_story']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Description</label>
                            <textarea name="brand_story[description]" class="form-control">{{ old('brand_story.description', $data['brand_story']['description'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="subsection-title">Story Features</div>
                    @foreach (($data['brand_story']['features'] ?? []) as $index => $feature)
                        <div class="item-card">
                            <h5>Story Feature {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Icon Class</label>
                                    <input type="text" name="brand_story[features][{{ $index }}][icon]" value="{{ old("brand_story.features.$index.icon", $feature['icon'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Feature Text</label>
                                    <input type="text" name="brand_story[features][{{ $index }}][text]" value="{{ old("brand_story.features.$index.text", $feature['text'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Collection Reels</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="collection_reels[title]" value="{{ old('collection_reels.title', $data['collection_reels']['title'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                    @foreach (($data['collection_reels']['cards'] ?? []) as $index => $card)
                        <div class="item-card">
                            <h5>Reel Card {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Current Image</label>
                                    <input type="hidden" name="collection_reels[cards][{{ $index }}][existing_image_url]" value="{{ old("collection_reels.cards.$index.existing_image_url", $card['image_url'] ?? '') }}">
                                    @if (!empty($card['image_url']))
                                        <img src="{{ $card['image_url'] }}" alt="Reel Card {{ $index + 1 }}"
                                            style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label>Upload New Image (from device)</label>
                                    <input type="file" name="collection_reels[cards][{{ $index }}][image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                </div>
                                <div class="field-group">
                                    <label>Overlay Text</label>
                                    <input type="text" name="collection_reels[cards][{{ $index }}][text]" value="{{ old("collection_reels.cards.$index.text", $card['text'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group" style="grid-column: 1 / -1;">
                                    <label>Card Link</label>
                                    <input type="text" name="collection_reels[cards][{{ $index }}][link]" value="{{ old("collection_reels.cards.$index.link", $card['link'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Custom Design Section</h4>
                    <div class="subsection-title">Left Side</div>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Left Title</label>
                            <input type="text" name="custom_design[left_title]" value="{{ old('custom_design.left_title', $data['custom_design']['left_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Left Button Text</label>
                            <input type="text" name="custom_design[left_button_text]" value="{{ old('custom_design.left_button_text', $data['custom_design']['left_button_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Left Description</label>
                            <textarea name="custom_design[left_description]" class="form-control">{{ old('custom_design.left_description', $data['custom_design']['left_description'] ?? '') }}</textarea>
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Left Button Link</label>
                            <input type="text" name="custom_design[left_button_link]" value="{{ old('custom_design.left_button_link', $data['custom_design']['left_button_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>

                    <div class="subsection-title">Right Side</div>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Right Title</label>
                            <input type="text" name="custom_design[right_title]" value="{{ old('custom_design.right_title', $data['custom_design']['right_title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Right Button Text</label>
                            <input type="text" name="custom_design[right_button_text]" value="{{ old('custom_design.right_button_text', $data['custom_design']['right_button_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Right Description</label>
                            <textarea name="custom_design[right_description]" class="form-control">{{ old('custom_design.right_description', $data['custom_design']['right_description'] ?? '') }}</textarea>
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>Right Button Link</label>
                            <input type="text" name="custom_design[right_button_link]" value="{{ old('custom_design.right_button_link', $data['custom_design']['right_button_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Why Choose Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="why_choose[title]" value="{{ old('why_choose.title', $data['why_choose']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Section Subtitle</label>
                            <input type="text" name="why_choose[subtitle]" value="{{ old('why_choose.subtitle', $data['why_choose']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                    @foreach (($data['why_choose']['cards'] ?? []) as $index => $card)
                        <div class="item-card">
                            <h5>Why Choose Card {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Icon Class</label>
                                    <input type="text" name="why_choose[cards][{{ $index }}][icon]" value="{{ old("why_choose.cards.$index.icon", $card['icon'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Card Title</label>
                                    <input type="text" name="why_choose[cards][{{ $index }}][title]" value="{{ old("why_choose.cards.$index.title", $card['title'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group" style="grid-column: 1 / -1;">
                                    <label>Card Description</label>
                                    <textarea name="why_choose[cards][{{ $index }}][description]" class="form-control">{{ old("why_choose.cards.$index.description", $card['description'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Blog Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="blog[title]" value="{{ old('blog.title', $data['blog']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Section Subtitle</label>
                            <input type="text" name="blog[subtitle]" value="{{ old('blog.subtitle', $data['blog']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Text</label>
                            <input type="text" name="blog[view_all_text]" value="{{ old('blog.view_all_text', $data['blog']['view_all_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>View All Link</label>
                            <input type="text" name="blog[view_all_link]" value="{{ old('blog.view_all_link', $data['blog']['view_all_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                    @foreach (($data['blog']['posts'] ?? []) as $index => $post)
                        <div class="item-card">
                            <h5>Blog Post {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Date</label>
                                    <input type="text" name="blog[posts][{{ $index }}][date]" value="{{ old("blog.posts.$index.date", $post['date'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Current Image</label>
                                    <input type="hidden" name="blog[posts][{{ $index }}][existing_image_url]" value="{{ old("blog.posts.$index.existing_image_url", $post['image_url'] ?? '') }}">
                                    @if (!empty($post['image_url']))
                                        <img src="{{ $post['image_url'] }}" alt="Blog Post {{ $index + 1 }}"
                                            style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label>Upload New Image (from device)</label>
                                    <input type="file" name="blog[posts][{{ $index }}][image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                </div>
                                <div class="field-group" style="grid-column: 1 / -1;">
                                    <label>Post Title</label>
                                    <input type="text" name="blog[posts][{{ $index }}][title]" value="{{ old("blog.posts.$index.title", $post['title'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group" style="grid-column: 1 / -1;">
                                    <label>Post Description</label>
                                    <textarea name="blog[posts][{{ $index }}][description]" class="form-control">{{ old("blog.posts.$index.description", $post['description'] ?? '') }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label>Read More Text</label>
                                    <input type="text" name="blog[posts][{{ $index }}][link_text]" value="{{ old("blog.posts.$index.link_text", $post['link_text'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Read More Link</label>
                                    <input type="text" name="blog[posts][{{ $index }}][link]" value="{{ old("blog.posts.$index.link", $post['link'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Instagram Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>Section Title</label>
                            <input type="text" name="instagram[title]" value="{{ old('instagram.title', $data['instagram']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Section Subtitle</label>
                            <input type="text" name="instagram[subtitle]" value="{{ old('instagram.subtitle', $data['instagram']['subtitle'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Follow Button Text</label>
                            <input type="text" name="instagram[follow_text]" value="{{ old('instagram.follow_text', $data['instagram']['follow_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Follow Button Link</label>
                            <input type="text" name="instagram[follow_link]" value="{{ old('instagram.follow_link', $data['instagram']['follow_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                    @foreach (($data['instagram']['items'] ?? []) as $index => $item)
                        <div class="item-card">
                            <h5>Instagram Image {{ $index + 1 }}</h5>
                            <div class="field-grid single">
                                <div class="field-group">
                                    <label>Current Image</label>
                                    <input type="hidden" name="instagram[items][{{ $index }}][existing_image_url]" value="{{ old("instagram.items.$index.existing_image_url", $item['image_url'] ?? '') }}">
                                    @if (!empty($item['image_url']))
                                        <img src="{{ $item['image_url'] }}" alt="Instagram Image {{ $index + 1 }}"
                                            style="width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                </div>
                                <div class="field-group">
                                    <label>Upload New Image (from device)</label>
                                    <input type="file" name="instagram[items][{{ $index }}][image_file]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="section-card">
                    <h4>Contact CTA Section</h4>
                    <div class="field-grid">
                        <div class="field-group">
                            <label>CTA Title</label>
                            <input type="text" name="contact_cta[title]" value="{{ old('contact_cta.title', $data['contact_cta']['title'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group" style="grid-column: 1 / -1;">
                            <label>CTA Description</label>
                            <textarea name="contact_cta[description]" class="form-control">{{ old('contact_cta.description', $data['contact_cta']['description'] ?? '') }}</textarea>
                        </div>
                        <div class="field-group">
                            <label>WhatsApp Button Text</label>
                            <input type="text" name="contact_cta[whatsapp_text]" value="{{ old('contact_cta.whatsapp_text', $data['contact_cta']['whatsapp_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>WhatsApp Link</label>
                            <input type="text" name="contact_cta[whatsapp_link]" value="{{ old('contact_cta.whatsapp_link', $data['contact_cta']['whatsapp_link'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Email Button Text</label>
                            <input type="text" name="contact_cta[email_text]" value="{{ old('contact_cta.email_text', $data['contact_cta']['email_text'] ?? '') }}" class="form-control">
                        </div>
                        <div class="field-group">
                            <label>Email Link</label>
                            <input type="text" name="contact_cta[email_link]" value="{{ old('contact_cta.email_link', $data['contact_cta']['email_link'] ?? '') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <h4>Feature Boxes</h4>
                    <div class="section-help">These are the 4 small service boxes shown at the bottom of the home page.</div>
                    @foreach (($data['feature_boxes'] ?? []) as $index => $feature)
                        <div class="item-card">
                            <h5>Feature Box {{ $index + 1 }}</h5>
                            <div class="field-grid">
                                <div class="field-group">
                                    <label>Title</label>
                                    <input type="text" name="feature_boxes[{{ $index }}][title]" value="{{ old("feature_boxes.$index.title", $feature['title'] ?? '') }}" class="form-control">
                                </div>
                                <div class="field-group">
                                    <label>Description</label>
                                    <input type="text" name="feature_boxes[{{ $index }}][description]" value="{{ old("feature_boxes.$index.description", $feature['description'] ?? '') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="submit-btn">Save Home Page Settings</button>
            </form>
        </div>
    </div>
@endsection
