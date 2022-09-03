<?php
require 'baseController.php';

class emptyController extends baseController{
  
  public function index(){
    $this->view('404',[
      'token' => $this->tokenCreate(),  //csrf対策のためトークンを作成(セッションに格納)
    ]);
  }
}