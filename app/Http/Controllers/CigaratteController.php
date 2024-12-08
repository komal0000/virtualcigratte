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

    function getRandToken($game_id)
    {
        $randToken = mt_rand(111111, 999999);
        while (DB::table('cigarattes')->where('cigaratte_collection_id', $game_id)->where('token', $randToken)->exists()) {
            $randToken = mt_rand(111111, 999999);
        }
        return $randToken;
    }
    public function index()
    {
        $cigarattes = DB::table('cigarattes')->get(['id', 'user_id', 'token']);
        return view('admin.cigaratte.index', compact('cigarattes'));
    }
    public function add(Request $request)
    {
        if ($request->getMethod() == "GET") {

            $users = DB::table('users')->get(['id']);
            return view('admin.cigaratte.add', compact('users'));
        } else {
            $game = Helper::getCurrentGame();
            $cigaratte = new Cigaratte();
            $cigaratte->user_id = $request->user_id;
            $cigaratte->cigaratte_collection_id = $game->id;
            $cigaratte->token = $this->getRandToken($game->id);
            $cigaratte->save();
            Cache::forget('cigarattes');
            Cache::forget('cigarattes_' .  $cigaratte->user_id);
            return redirect()->back();
        }
    }
    public function Cindex()
    {
        $CigaratteCollections = DB::table('cigaratte_collections')->get(['id', 'date', 'win_token']);
        return view('admin.game.index', compact('CigaratteCollections'));
    }
    public function Cadd(Request $request)
    {
        if ($request->getMethod() == "GET") {
            return view('admin.game.add');
        } else {
            $today = Carbon::today()->toDateString();
            $existingCollection = CigaratteCollection::whereDate('date', $today)->first();

            if ($existingCollection) {
                return redirect()->back()->with('error', 'A token has already been generated today.');
            } else {
                $random_token = $this->getRandToken(1);
                $CigaratteCollection = new CigaratteCollection();
                $CigaratteCollection->date = Carbon::now();
                $CigaratteCollection->win_token = $random_token;
                $CigaratteCollection->save();
                 Helper::delCache();
                return redirect()->back();
            }
        }
    }
    public function Cedit(Request $request,$id){
        $winner = CigaratteCollection::where('id',$id)->first();
        if ($request->getMethod() == "GET") {
            return view('admin.game.edit',compact('winner'));
        } else {
          $winner ->win_token = $request->win_token;
          $winner->save();

          Helper::delCache();
          return redirect()->back();
        }
    }
    public function winner($win_id)
    {
        $win_token = DB::table('cigaratte_collections')->where('id', $win_id)->value('win_token');
        $winner = DB::table('cigarattes')
            ->join('users', 'cigarattes.user_id', '=', 'users.id')
            ->where('cigarattes.token', $win_token)
            ->select('cigarattes.user_id', 'users.id as user_id', 'cigarattes.token')
            ->first();

        if ($winner) {
            return view('admin.game.winner', compact('winner'));
        } else {
            return view('admin.game.winner', ['winner' => null]);
        }
    }

    public function publish($id){
        $cigaratte_collection = CigaratteCollection::where('id',$id)->first();
        $cigaratte_collection->published_at = true;
        $cigaratte_collection->save();
        return redirect()->back();
    }

}
