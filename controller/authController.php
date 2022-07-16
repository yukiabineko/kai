<?php
  require 'baseController.php';
  require './model/shop.php';

  class authController extends baseController{

  /****************************表示*****************************************************************/
    public function new(){
      $this->view('new',[
        'token' => $this->tokenCreate(),  //csrf対策のためトークンを作成(セッションに格納)
      ]);
    }
  /*************************ログイン処理*************************************************************/
    public function create(array $params){
      if($this->csrf($params['csrf-token'])){
        $shop = new  shop();
        $record = $shop->find_by('email', $params['email']);
      
        //パスワードのチェック問題なければセッションidを格納し、ログイン状態を保持
        if(password_verify($params['password'], $record->password)){
          $this->session_store($record->id);
          $sessinId = $_SESSION['auth_id'];
          header("location: ./shop?action=show&id=$sessinId");
        }
        //ログイン失敗
        else{
          header('location: ./auth?action=new');
        }
      }
    }
  }