<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrControlller extends Controller
{
    public function index(Request $request){
        if($request->getMethod()=="GET"){
            return view('admin.qr.index');
        }else{

        }
    }
}
