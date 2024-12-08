<?php
namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class QrController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $QRimages = Helper::getQrImage();
            return view('admin.qr.index',compact('QRimages'));
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
                $file = $request->file('qr_image');
                $folderPath = 'uploads/qr_images';
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($folderPath), $fileName);
                $fileUrl = asset("$folderPath/$fileName");
                Cache::forget('qrs');
                return back()->with('success', 'QR image uploaded successfully!')->with('fileUrl', $fileUrl);
            } else {
                return back()->with('error', 'Failed to upload QR image.');
            }
        }
    }
    public function delete($image)
    {
        $imagePath = public_path('uploads/qr_images/' . $image);

        if (File::exists($imagePath)) {
            File::delete($imagePath); // Delete the image from the server
            return response()->json(['success' => 'Image deleted successfully.']);
        }
        return response()->json(['error' => 'Image not found.'], 404);
    }
}
