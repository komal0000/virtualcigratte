<?php
namespace App;

use App\Models\CigaratteCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Helper{

    public static function getQrImage(){
        return Cache::rememberForever('qrs',function(){
            $folderPath = public_path('uploads/qr_images');

            if (File::exists($folderPath)) {
                // Get all files in the folder
                $files = File::files($folderPath);

                // Filter the files to include only images
                $imageFiles = collect($files)->filter(function ($file) {
                    return in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'bmp']);
                });

                return $imageFiles->map(function($imageFile){
                    return  url('uploads/qr_images/' . $imageFile->getFilename());

                });
            } else {
                return collect([]);
            }
        });
    }

    public static function getCurrentCount(){
        return Cache::remember('cigarattes',3600,function(){
            return  DB::table('cigarattes')
            ->where('cigaratte_collection_id',Helper::getCurrentGame()->id)
            ->count();
        });
    }
    public static function getCurrentGame(){
        $date=Carbon::today();
        $dateSTR=$date->format('Y_m_d');
        return Cache::rememberForever('game_'.$dateSTR, function ()use($date) {
            $game=DB::table('cigaratte_collections')->where('date',$date)->first();
            if($game==null){
                $game=new CigaratteCollection();
                $game->date=$date;
                $game->save();
            }
            return $game;
        });
    }
    public static function delCache(){
        $date = Carbon::today();
        $dateSTR = $date->format('Y_m_d');
        return Cache::forget('game_'.$dateSTR);
    }
}
