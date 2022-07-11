<?php
require 'baseController.php';

class topController extends baseController{

  public function index(){
    
    $this->view('index');    //=< トップページのview呼び出し
  }
}