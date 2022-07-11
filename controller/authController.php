<?php
  require 'baseController.php';

  class authController extends baseController{

    public function new(){
      $this->view('new');
    }
  }