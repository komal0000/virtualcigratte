<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrControlller extends Controller
{
    public function index(Request $request)
{
    if ($request->getMethod() == "GET") {
        return view('admin.qr.index');
    } else {
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
            $file = $request->file('qr_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/qr_images', $fileName);

            // Save the image path
            $imageUrl = Storage::url($filePath); // Get URL

            // Store the image URL in the session or database, so it can be retrieved later
            session(['qr_image_url' => $imageUrl]);

            // You can return it via response or simply redirect back
            return back()->with('success', 'QR image uploaded successfully!');
        } else {
            return back()->with('error', 'Failed to upload image.');
        }
    }
}

public function getQrImageUrl()
{
    $imageUrl = session('qr_image_url', '');
    return response()->json(['image_url' => $imageUrl]);
}

}
