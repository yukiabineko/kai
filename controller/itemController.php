<?php
require 'baseController.php';

class itemController extends baseController{
  public function new(){
    $this->view('new');
  }
}

