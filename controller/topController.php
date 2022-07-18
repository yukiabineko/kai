<?php
require 'baseController.php';

class topController extends baseController{

  public function index(){
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('index',[
      'token' => $this->$token,
    ]);    
    //=< トップページのview呼び出し
  }
}