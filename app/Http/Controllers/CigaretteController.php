<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CigaretteController extends Controller
{
    public function index(){
        return view('admin.cigarette.index');
    }
    public function add(Request $request){
        if($request->getMethod()=="GET"){
            return view('admin.cigarette.add');
        }else{

        }
    }
    public function edit(Request $request ,$id){
        if($request->getMethod()=="GET"){
            return view('admin.cigarette.edit');
        }else{

        }
    }
}
