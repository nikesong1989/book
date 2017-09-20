<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;
use App\Models\M3Result;

class phponeController extends Controller
{
    public function index()
    {
        return view ('index');
    }

    public function send(Request $request)
    {
        $m3_result = new M3Result;
        $phone = $request->input('phone', '');
        $sendTemplateSMS = new SendTemplateSMS;
        $code = '';
        $charset = '1234567890';
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 60), 1);
        dd($m3_result);
//        return $m3_result->toJson();
    }


    public function ajaxsvr(Request $request)
    {
        $phone=input('phone' , '');
        if($phone) {
            return $phone;
        }
    }
}