<?php

namespace App\Tool\SMS;

use App\Models\M3Result;

class SendTemplateSMS
{
  //主帐号
  private $accountSid='8aaf07085e2d97fd015e3b06a949049b';

  //主帐号Token
  private $accountToken='817fb9714d254eb394ee69ef49254a4d';

  //应用Id
  private $appId='8aaf07085e2d97fd015e3b06acc804a2';

  //请求地址，格式如下，不需要写https://
  private $serverIP='sandboxapp.cloopen.com';

  //请求端口
  private $serverPort='8883';

  //REST版本号
  private $softVersion='2013-12-26';

  /**
    * 发送模板短信
    * @param to 手机号码集合,用英文逗号分开
    * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
    * @param $tempId 模板Id
    */
  public function sendTemplateSMS($to,$datas,$tempId)
  {
       $m3_result = new M3Result;

       // 初始化REST SDK
       $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
       $rest->setAccount($this->accountSid,$this->accountToken);   //设置账号和TOken
       $rest->setAppId($this->appId);                               //设置应用 ID

       // 发送模板短信
       $result = $rest->sendTemplateSMS($to,$datas,$tempId);        //发送


//      返回发送结果及状态
       if($result == NULL ) {
           $m3_result->status = 3;
           $m3_result->message = 'result error!';
       }
       if($result->statusCode != 0) {
           $m3_result->status = $result->statusCode;
           $m3_result->message = $result->statusMsg;
       }else{
           $m3_result->status = 0;
           $m3_result->message = '发送成功';
       }
       return $m3_result;
  }
}


