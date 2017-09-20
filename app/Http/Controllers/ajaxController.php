<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M3Result;


class ajaxController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('POST')) {
            $phone=$request->input('phone','数据错误!');
            $rel= new M3Result();
            $rel->status=1;
            $rel->message=$phone;
            return $rel->toJson();  //返回JSON数据
        }

        return view ('send');

    }
}