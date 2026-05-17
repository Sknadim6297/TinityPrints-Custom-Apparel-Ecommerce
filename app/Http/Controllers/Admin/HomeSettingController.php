<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSettingController extends Controller
{
    public function edit()
    {
        $settings = HomeSetting::first();

        if (!$settings) {
            $settings = HomeSetting::create([
                'data' => HomeSetting::defaults(),
            ]);
        }

        $data = HomeSetting::mergedData($settings->data);

        return view('admin.settings.home', compact('settings', 'data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'promo_bar' => 'nullable|array',
            'promo_bar.text' => 'nullable|string|max:500',
            'promo_bar.discount' => 'nullable|string|max:20',
            'promo_bar.enabled' => 'nullable|boolean',
            'offer_popup' => 'nullable|array',
            'offer_popup.enabled' => 'nullable|boolean',
            'offer_popup.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'hero_slides' => 'nullable|array',
            'hero_slides.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'side_banners' => 'nullable|array',
            'side_banners.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'best_seller' => 'nullable|array',
            'brand_story' => 'nullable|array',
            'brand_story.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'collection_reels' => 'nullable|array',
            'collection_reels.cards.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'custom_design' => 'nullable|array',
            'why_choose' => 'nullable|array',
            'blog' => 'nullable|array',
            'blog.posts.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'instagram' => 'nullable|array',
            'instagram.items.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'contact_cta' => 'nullable|array',
            'feature_boxes' => 'nullable|array',
        ]);

        $settings = HomeSetting::first();
        $payload = HomeSetting::mergedData($settings?->data ?? []);

        $payload['promo_bar'] = [
            'enabled' => $request->boolean('promo_bar.enabled'),
            'text' => $this->sanitizeValue($request->input('promo_bar.text', $payload['promo_bar']['text'] ?? '')),
            'discount' => $this->sanitizeValue($request->input('promo_bar.discount', $payload['promo_bar']['discount'] ?? '20')),
        ];

        $offerPopupImageUrl = $this->sanitizeValue($request->input('offer_popup.existing_image_url', $payload['offer_popup']['image_url'] ?? ''));
        if ($request->hasFile('offer_popup.image_file')) {
            $storedPath = $request->file('offer_popup.image_file')->store('home-settings/offer-popup', 'public');
            $offerPopupImageUrl = Storage::url($storedPath);
        }
        $payload['offer_popup'] = [
            'enabled' => $request->boolean('offer_popup.enabled'),
            'image_url' => $offerPopupImageUrl,
        ];

        $payload['hero_slides'] = $this->buildSlidesWithUploads(
            $request,
            'hero_slides',
            ['subtitle', 'title_line_1', 'title_line_2', 'button_text', 'button_link'],
            'home-settings/hero'
        );

        $payload['side_banners'] = $this->buildSlidesWithUploads(
            $request,
            'side_banners',
            ['title', 'subtitle', 'button_text', 'button_link'],
            'home-settings/side-banners'
        );

        $payload['best_seller'] = array_replace($payload['best_seller'], $this->sanitizeAssoc(
            $request->input('best_seller', []),
            ['title', 'subtitle', 'view_all_text', 'view_all_link']
        ));
        $payload['best_seller']['product_limit'] = max(1, (int) $request->input('best_seller.product_limit', $payload['best_seller']['product_limit']));

        $payload['brand_story'] = array_replace($payload['brand_story'], $this->sanitizeAssoc(
            $request->input('brand_story', []),
            ['title', 'subtitle', 'description']
        ));
        $payload['brand_story']['image_url'] = $this->sanitizeValue($request->input('brand_story.existing_image_url', ''));
        $brandStoryFile = $request->file('brand_story.image_file');
        if ($brandStoryFile) {
            $storedPath = $brandStoryFile->store('home-settings/brand-story', 'public');
            $payload['brand_story']['image_url'] = Storage::url($storedPath);
        }
        $payload['brand_story']['features'] = $this->sanitizeRepeater(
            $request->input('brand_story.features', []),
            ['icon', 'text']
        );

        $payload['collection_reels'] = array_replace($payload['collection_reels'], $this->sanitizeAssoc(
            $request->input('collection_reels', []),
            ['title']
        ));
        $payload['collection_reels']['cards'] = $this->buildSlidesWithUploads(
            $request,
            'collection_reels.cards',
            ['text', 'link'],
            'home-settings/reels'
        );

        $payload['custom_design'] = array_replace($payload['custom_design'], $this->sanitizeAssoc(
            $request->input('custom_design', []),
            ['left_title', 'left_description', 'left_button_text', 'left_button_link', 'right_title', 'right_description', 'right_button_text', 'right_button_link']
        ));

        $payload['why_choose'] = array_replace($payload['why_choose'], $this->sanitizeAssoc(
            $request->input('why_choose', []),
            ['title', 'subtitle']
        ));
        $payload['why_choose']['cards'] = $this->sanitizeRepeater(
            $request->input('why_choose.cards', []),
            ['icon', 'title', 'description']
        );

        $payload['blog'] = array_replace($payload['blog'], $this->sanitizeAssoc(
            $request->input('blog', []),
            ['title', 'subtitle', 'view_all_text', 'view_all_link']
        ));
        $payload['blog']['posts'] = $this->buildSlidesWithUploads(
            $request,
            'blog.posts',
            ['date', 'title', 'description', 'link_text', 'link'],
            'home-settings/blog'
        );

        $payload['instagram'] = array_replace($payload['instagram'], $this->sanitizeAssoc(
            $request->input('instagram', []),
            ['title', 'subtitle', 'follow_text', 'follow_link']
        ));
        $payload['instagram']['items'] = $this->buildSlidesWithUploads(
            $request,
            'instagram.items',
            [],
            'home-settings/instagram'
        );

        $payload['contact_cta'] = array_replace($payload['contact_cta'], $this->sanitizeAssoc(
            $request->input('contact_cta', []),
            ['title', 'description', 'whatsapp_text', 'whatsapp_link', 'email_text', 'email_link']
        ));

        $payload['feature_boxes'] = $this->sanitizeRepeater(
            $request->input('feature_boxes', []),
            ['title', 'description']
        );

        $settings = $settings ?? new HomeSetting();
        $settings->data = $payload;
        $settings->save();

        return back()->with('success', 'Home page general settings updated successfully.');
    }

    private function sanitizeAssoc(array $input, array $fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->sanitizeValue($input[$field] ?? '');
        }

        return $data;
    }

    private function sanitizeRepeater(array $items, array $fields): array
    {
        return array_map(function ($item) use ($fields) {
            $item = is_array($item) ? $item : [];

            return $this->sanitizeAssoc($item, $fields);
        }, array_values($items));
    }

    private function sanitizeValue(mixed $value): string
    {
        if (is_array($value)) {
            return '';
        }

        return trim((string) $value);
    }

    private function buildSlidesWithUploads(Request $request, string $key, array $fields, string $directory): array
    {
        $items = $request->input($key, []);
        $items = is_array($items) ? array_values($items) : [];

        return array_map(function ($item, $index) use ($request, $fields, $key, $directory) {
            $item = is_array($item) ? $item : [];

            $row = $this->sanitizeAssoc($item, $fields);

            $existingImage = $this->sanitizeValue($item['existing_image_url'] ?? '');
            $row['image_url'] = $existingImage;

            $file = $request->file($key . '.' . $index . '.image_file');
            if ($file) {
                $storedPath = $file->store($directory, 'public');
                $row['image_url'] = Storage::url($storedPath);
            }

            return $row;
        }, $items, array_keys($items));
    }
}
