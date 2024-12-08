<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class QrController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('admin.qr.index');
        } elseif ($request->isMethod('POST')) {
            // Validate the file upload
            $request->validate([
                'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image type and size
            ]);

            // Check if the file is uploaded
            if ($request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
                // Get the uploaded file
                $file = $request->file('qr_image');

                // Define the folder where the file should be saved
                $folderPath = 'uploads/qr_images';

                // Generate a unique file name
                $fileName = time() . '.' . $file->getClientOriginalExtension();

                // Save the file to the specified folder in the `public` directory
                $file->move(public_path($folderPath), $fileName);

                // Construct the URL for the saved file
                $fileUrl = asset("$folderPath/$fileName");
                Cache::forget('qrs');
                // Return success response or redirect
                return back()->with('success', 'QR image uploaded successfully!')->with('fileUrl', $fileUrl);
            } else {
                return back()->with('error', 'Failed to upload QR image.');
            }
        }
    }
    public function showimage()
    {
        $folderPath = public_path('uploads/qr_images');
        $images = File::files($folderPath);
        if (count($images) > 0) {
            $randomImage = $images[array_rand($images)];
            $imageUrl = asset('uploads/qr_images/' . $randomImage->getFilename());
            return view('front.index', compact('imageUrl'));
        } else {
            return view('random_image')->with('error', 'No images found in the folder.');
        }
    }
}
