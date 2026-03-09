<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function edit()
    {
        $settings = ContactSetting::first();
        return view('admin.settings.contact', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = ContactSetting::first() ?? new ContactSetting();

        $settings->mobile_phone = $request->mobile_phone;
        $settings->hotline_phone = $request->hotline_phone;
        $settings->email_primary = $request->email_primary;
        $settings->email_secondary = $request->email_secondary;
        $settings->address = $request->address;
        $settings->save();

        return back()->with('success', 'Contact settings updated successfully.');
    }
}
