<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){
        return view('front.index');
    }

    public function count(){
        return response(
            DB::table('cigarattes')
            ->join('cigaratte_collections','cigaratte_collections.id','=','cigarattes.cigaratte_collection_id')
            ->where('cigaratte_collections.date',Carbon::today())
            ->count()
        );
    }

}
