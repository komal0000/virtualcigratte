<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\CigaratteCollection;
use App\Models\User;
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
        $imageCount = Helper::getQrImage()->count();

        if ($imageCount == 0) {
            $imageURL = Helper::getQrImage();
            return view('front.index', compact('count', 'imageURL'));
        } else {
            $imageURL = Helper::getQrImage()->random();
            return view('front.index', compact('count', 'imageURL'));
        }
    }

    public function info()
    {
        $user_id = Auth::id();
        $data = Cache::remember('cigarattes_' . $user_id, 3600, function () use ($user_id) {
            $tokens = DB::table('cigarattes')
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
    public function win_token(Request $request)
    {
        $user_id = Auth::id();
        $game = Helper::getCurrentGame();
        if ($game->is_published) {
            return response(
                "<h5>Wining Token is : " .
                    $game->win_token .
                    ($user_id == $game->winner_user_id ? "
                            <hr style='margin:8px 0px'>
                            <span>You Are Winner</span>
                            <div>
                            <button onclick='generateCode();' id='cashoutBtn' style='margin:10px 0px;' class='btn btn-primary btn-sm'>Initiate Cashout</button></div>
                            <hr style='margin:8px 0px'>
                            <span id='otpElement'><span>
                            " : "") .
                    "</h5>"
            );
        } else {
            return response('<h5>The winning token have not been published yet..</h5>');
        }
    }
    public function getOTP(Request $request)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $user->otp = $request->randomCode;
        $user->save();
        return response()->json($user->otp);
    }
}
