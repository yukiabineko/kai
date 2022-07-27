<?php
require 'baseController.php';

class contactController extends baseController
{
  /**
   * 表示
   */
  public function new()
  {
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('new', [
      'token' => $token,
    ]);
    //=< トップページのview呼び出し
  }

  /**
   * メール送信
   *
   * 
   */
  public function  create(array $params){
    if ($this->csrf($params['csrf-token'])){
      $to = "abineko@yukiabineko.sakura.ne.jp";
      $subject = $params['subject'];
      $message = $params['content'];
      $headers = "From:yuki1980426@gmail.com";
      if(mb_send_mail($to, $subject, $message, $headers)){
        echo 'success';
      }
      else{
        echo 'not';
      }
      /*$_SESSION['flash'] = "送信しました。";
      header('location: ./contact?action=new');*/
    }
  }
  
}