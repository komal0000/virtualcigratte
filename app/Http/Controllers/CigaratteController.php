<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cigaratte;
use App\Models\CigaratteCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CigaratteController extends Controller
{

    function getRandToken($game_id){
        $randToken=mt_rand(111111,999999);
        while (DB::table('cigarattes')->where('cigaratte_collection_id',$game_id)->where('token',$randToken)->exists()) {
            $randToken=mt_rand(111111,999999);
        }
        return $randToken;
    }
    public function index(){
        $cigarattes = DB::table('cigarattes')->get(['id','user_id','token']);
        return view('admin.cigaratte.index',compact('cigarattes'));
    }
    public function add(Request $request){
        if($request->getMethod()=="GET"){
            $users = DB::table('users')->get(['id']);
            return view('admin.cigaratte.add',compact('users'));
        }else{

            $game=Helper::getCurrentGame();

            $cigaratte = new Cigaratte();
            $cigaratte->user_id = $request->user_id;
            $cigaratte->cigaratte_collection_id = $game->id;
            $cigaratte->token = $this->getRandToken($game->id);
            $cigaratte->save();

            Cache::forget('cigarattes');
            return redirect()->back();
        }
    }


    public function Cindex(){
        $CigaratteCollections = DB::table('cigaratte_collections')->get(['id','date','win_token']);
        return view('admin.game.index',compact('CigaratteCollections'));
    }
    public function Cadd(Request $request){
        $cigaratte_tokens = DB::table('cigarattes')->pluck('token')->toArray();

        if($request->getMethod() == "GET"){
            return view('admin.game.add');
        }else{
            if (count($cigaratte_tokens) > 0) {
                $random_token = $cigaratte_tokens[array_rand($cigaratte_tokens)];
                $CigaratteCollection = new CigaratteCollection();
                $CigaratteCollection->date = $request->date;
                $CigaratteCollection->win_token = $random_token;
                $CigaratteCollection->save();
            }
            return redirect()->back();
        }
    }

}
