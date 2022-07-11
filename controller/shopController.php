<?php
  require 'baseController.php';

  class shopController extends baseController{

    public function new(){
       $this->view('new');
    }
  }