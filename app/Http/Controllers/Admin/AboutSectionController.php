<?php
namespace App\Http\Controllers\Admin;

use App\Models\AboutSection;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    public function edit()
    {
        $about = AboutSection::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutSection::first() ?? new AboutSection();

        $about->title = $request->title;
        $about->description = $request->description;
        $about->button_text = $request->button_text;
        $about->button_link = $request->button_link;

        if ($request->hasFile('main_image')) {
            $about->main_image = $request->file('main_image')->store('about', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            $about->secondary_image = $request->file('secondary_image')->store('about', 'public');
        }

        $about->save();

        return back()->with('success', 'About Section Updated Successfully');
    }
}