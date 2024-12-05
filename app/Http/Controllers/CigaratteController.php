<?php

namespace App\Http\Controllers;

use App\Models\Cigaratte;
use App\Models\CigaratteCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CigaratteController extends Controller
{
    public function index(){
        $cigarattes = DB::table('cigarattes')->get(['id','user_id','token']);
        return view('admin.cigaratte.index',compact('cigarattes'));
    }
    public function add(Request $request){
        $users = DB::table('users')->get(['id']);
        if($request->getMethod()=="GET"){
            return view('admin.cigaratte.add',compact('users'));
        }else{
            $cigaratte = new Cigaratte();
            $cigaratte->user_id = $request->user_id;
            $cigaratte->token = $request->token;
            $cigaratte->save();
            return redirect()->back();
        }
    }
    public function edit(Request $request ,$id){
        $cigaratte = Cigaratte::where('id',$id)->first();
        $users = DB::table('users')->get(['id']);
        if($request->getMethod()=="GET"){
            return view('admin.cigaratte.edit',compact('cigaratte','users'));
        }else{
            $cigaratte->user_id = $request->user_id;
            $cigaratte->token = $request->token;
            $cigaratte->save();
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
