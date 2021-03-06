<?php

namespace App\Http\Controllers\Service;

use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Models\M3Result;
use App\Entity\TempEmail;
use App\Entity\Member;

class ValidateController extends Controller
{
  public function create(Request $request)
  {
    $validateCode = new ValidateCode;
    $request->session()->put('validate_code', $validateCode->getCode());
    return $validateCode->doimg();
  }

  public function sendSMS(Request $request)
  {


    $phone = $request->input('phone', '');

    if($phone == '') {
        return  $message = '手机号不能为空';
    }
    if(strlen($phone) != 11 || $phone[0] != '1') {
        return  $message = '手机格式不正确';
    }

    $sendTemplateSMS = new SendTemplateSMS();
    $code = '';
    $charset = '1234567890';
    $_len = strlen($charset) - 1;
    for ($i = 0;$i < 6;++$i) {
        $code .= $charset[mt_rand(0, $_len)];
    }
      $rel = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 2), 1);

    if($rel != null ) {
      $tempPhone = TempPhone::where('phone', $phone)->first();
      if($tempPhone == null) {
        $tempPhone = new TempPhone;
      }
      $tempPhone->phone = $phone;
      $tempPhone->code = $code;
      $tempPhone->deadline = date('Y-m-d H-i-s', time() + 2*60);
      $tempPhone->save();
    }

      return $message='发送成功!';
  }

  public function validateEmail(Request $request)
  {
    $member_id = $request->input('member_id', '');
    $code = $request->input('code', '');
    if($member_id == '' || $code == '') {
      return '验证异常';
    }

    $tempEmail = TempEmail::where('member_id', $member_id)->first();
    if($tempEmail == null) {
      return '验证异常';
    }

    if($tempEmail->code == $code) {
      if(time() > strtotime($tempEmail->deadline)) {
        return '该链接已失效';
      }

      $member = Member::find($member_id);
      $member->active = 1;
      $member->save();

      return redirect('/login');
    } else {
      return '该链接已失效';
    }
  }
}
