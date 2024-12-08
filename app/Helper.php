<?php
namespace App;

use App\Models\CigaratteCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Helper{

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
