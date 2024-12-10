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

use function Laravel\Prompts\error;

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
    public function index(Request $request)
    {
        if ($request->getMethod() == "GET") {
            return view('admin.cigaratte.index');
        } else {
            $date = $request->date;
            $userList = DB::table('cigarattes')
                ->join('cigaratte_collections', 'cigarattes.cigaratte_collection_id', '=', 'cigaratte_collections.id')
                ->where('cigaratte_collections.date', $date)
                ->get(["token","user_id"]);
            if ($userList->isNotEmpty()) {
                return response()->json([
                    'success' => true,
                    'users' => $userList
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found for the selected date.'
                ]);
            }
        }
    }

    public function userToken(Request $request)
    {
        if ($request->getMethod() == "GET") {
            return view('admin.cigaratte.add');
        } else {
            if (!DB::table('users')->where('id', $request->user_id)->exists()) {
                return response()->json(['success' => false, 'message' => "User Doesn't Exist"]);
            }
            $game = Helper::getCurrentGame();
            if (DB::table('cigarattes')->where('cigaratte_collection_id', $game->id)->where('user_id', $request->user_id)->exists()) {
                return response()->json(['success' => false, 'message' => 'User already has a Token']);
            } else {
                $cigaratte = new Cigaratte();
                $cigaratte->user_id = $request->user_id;
                $cigaratte->cigaratte_collection_id = $game->id;
                $cigaratte->token = $this->getRandToken($game->id);
                $cigaratte->save();
                Cache::forget('cigarattes');
                Cache::forget('cigarattes_' . $cigaratte->user_id);
                return response()->json(['success' => true, 'message' => 'Token generated successfully']);
            }
        }
    }


    public function Cindex()
    {
        // $game = Helper::getCurrentGame();
        $CigaratteCollections = DB::table('cigaratte_collections')->get(['id', 'date', 'win_token','is_published']);
        return view('admin.game.index', compact('CigaratteCollections'));
    }
    public function generatetoken()
    {
        $game = Helper::getCurrentGame();
        $cigarattes = DB::table('cigarattes')->get(['user_id', 'token']);
        $token = $this->getRandToken($game->id);
        if ($game->win_token == null) {
            DB::table('cigaratte_collections')
                ->where('id', $game->id)
                ->update(['win_token' => $token]);
            foreach ($cigarattes as $cigaratte) {
                if ($cigaratte->token === $token) {
                    DB::table('cigaratte_collections')
                        ->where('id', $game->id)
                        ->update(['winner_user_id' => $cigaratte->user_id]);
                    break;
                }
            }
            Helper::clearCurrentGame($game->date);
            return redirect()->back()->with('success', 'Token generated successfully.');
        } else {
            return redirect()->back()->with('error', 'Token already generated.');
        }
    }

    public function Cedit(Request $request, $id)
    {
        $winner = CigaratteCollection::where('id', $id)->first();
        if ($request->getMethod() == "GET") {
            return view('admin.game.edit', compact('winner'));
        } else {
         $cigarattes = DB::table('cigarattes')->get(['user_id', 'token']);
            $winner->win_token = $request->win_token;
            $winner->save();
            foreach ($cigarattes as $cigaratte) {
                if ($cigaratte->token === $winner->win_token) {
                    DB::table('cigaratte_collections')
                        ->where('id', $winner->id)
                        ->update(['winner_user_id' => $cigaratte->user_id]);
                    break;
                }
            }
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

    public function publish($id)
    {
        $cigaratte_collection = CigaratteCollection::where('id', $id)->first();
        $cigaratte_collection->is_published = true;
        $cigaratte_collection->save();
        return redirect()->back();
    }
}
