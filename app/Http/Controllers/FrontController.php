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
        return view('front.index', compact('count'));
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
        $winningtoken = Helper::getCurrentGame();

        if ($winningtoken) {
            if($winningtoken->published_at == true){
                return response($winningtoken->win_token);
            }
        } else {
            return response('No token found for today');
        }
    }

}
