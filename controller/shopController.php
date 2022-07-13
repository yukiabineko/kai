<?php
  require 'baseController.php';
  require './model/shop.php';

  class shopController extends baseController{

    public function new(){
      $model = new shop();
       $model->create(['name'=>'sample', 'email'=>'a@example.com', 'tel'=>"090-1111-2222", "adress"=>'甲府市', 'password'=>'123']);
      $this->view('new');
    }
  }