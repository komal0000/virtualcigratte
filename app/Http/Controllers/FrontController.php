<?php

namespace App\Http\Controllers;

use App\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){
        return view('front.index');
    }

    public function info(){
        $user_id=Auth::id();
        Cache::remember('cigarattes_'.$user_id,3600,function()use($user_id){
            return  DB::table('cigarattes')
            ->where('cigaratte_collection_id',Helper::getCurrentGame()->id)
            ->where('user_id',$user_id)
            ->get(['token']);
        });

    }

    public function count(){
        return response(
            Cache::remember('cigarattes',3600,function(){
                return  DB::table('cigarattes')
                ->where('cigaratte_collection_id',Helper::getCurrentGame()->id)
                ->count();
            })
        );
    }

}
