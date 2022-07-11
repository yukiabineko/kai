<?php
require 'baseController.php';

class emptyController extends baseController{
  
  public function index(){
    $this->view('404');
  }
}