<?php
require 'baseController.php';

class infoController extends baseController
{

  public function index()
  {
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('index', [
      'token' => $token,
    ]);
    //=< トップページのview呼び出し
  }
}
