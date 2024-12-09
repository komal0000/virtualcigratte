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
    public function index()
    {
        $count = Helper::getCurrentCount();
        $imageCount= Helper::getQrImage()->count();

        if($imageCount== 0){
            $imageURL= Helper::getQrImage();
            return view('front.index', compact('count','imageURL'));
        }else{
            $imageURL= Helper::getQrImage()->random();
            return view('front.index', compact('count','imageURL'));
        }
    }

    public function info()
    {
        $user_id = Auth::id();
        $data=Cache::remember('cigarattes_' . $user_id, 3600, function () use ($user_id) {
            $tokens=DB::table('cigarattes')
            ->where('cigaratte_collection_id', Helper::getCurrentGame()->id)
            ->where('user_id', $user_id)
            ->pluck('token')->toArray();
            return  implode(",", $tokens);
        });

        return response($data);
    }

    public function count()
    {
        return response(
            Helper::getCurrentCount()
        );
    }
    public function win_token() {
        $game = Helper::getCurrentGame();
        $winningtoken = DB::table('cigaratte_collections')
            ->where('id', $game->id)
            ->first(['id', 'win_token', 'is_published']);
        if ($winningtoken && $winningtoken->is_published) {
            return response($winningtoken->win_token);
        } else {
            return response('the winning token have not been published yet..');
        }
    }


}
