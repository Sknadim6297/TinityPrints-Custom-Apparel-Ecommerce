<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimitedEditionSettingController extends Controller
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

        return view('admin.settings.limited-edition', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'limited_edition' => 'nullable|array',
            'limited_edition_page' => 'nullable|array',
            'limited_edition_page.hero_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $settings = HomeSetting::first() ?? new HomeSetting();
        $payload = HomeSetting::mergedData($settings->data ?? []);

        $payload['limited_edition'] = array_replace($payload['limited_edition'], $this->sanitizeAssoc(
            $request->input('limited_edition', []),
            ['title', 'subtitle', 'view_all_text', 'view_all_link', 'badge_text']
        ));
        $payload['limited_edition']['product_limit'] = max(1, (int) $request->input('limited_edition.product_limit', $payload['limited_edition']['product_limit']));

        $payload['limited_edition_page'] = array_replace($payload['limited_edition_page'], $this->sanitizeAssoc(
            $request->input('limited_edition_page', []),
            [
                'page_title',
                'hero_badge',
                'hero_title',
                'hero_image_url',
                'hero_description',
                'feature_1',
                'feature_2',
                'feature_3',
                'products_title',
                'products_subtitle',
                'empty_title',
                'empty_text',
                'browse_text',
                'browse_link',
            ]
        ));

        $payload['limited_edition_page']['hero_image_url'] = $this->sanitizeValue(
            $request->input('limited_edition_page.hero_image_url', $payload['limited_edition_page']['hero_image_url'] ?? '')
        );

        $heroImageFile = $request->file('limited_edition_page.hero_image_file');
        if ($heroImageFile) {
            $storedPath = $heroImageFile->store('home-settings/limited-edition', 'public');
            $payload['limited_edition_page']['hero_image_url'] = Storage::url($storedPath);
        }

        $settings->data = $payload;
        $settings->save();

        return back()->with('success', 'Limited Edition settings updated successfully.');
    }

    private function sanitizeAssoc(array $input, array $fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->sanitizeValue($input[$field] ?? '');
        }

        return $data;
    }

    private function sanitizeValue(mixed $value): string
    {
        if (is_array($value)) {
            return '';
        }

        return trim((string) $value);
    }
}
