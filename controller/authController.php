<?php
  require 'baseController.php';
  require './model/shop.php';

  class authController extends baseController{

  /****************************表示*****************************************************************/
    public function new(){
      $token = $this->tokenCreate();
      $_SESSION['token'] = $token;

      $this->view('new',[
        'token' => $token,  //csrf対策のためトークンを作成(セッションに格納)
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
          $_SESSION["flash"] = "ログインしました。";
          header("location: ./shop?action=show&id=$sessinId");
        }
        //ログイン失敗
        else{
          $_SESSION["error-flash"] = "ログインに失敗しました。入力が間違ってます。";
          header('location: ./auth?action=new');
        }
      }
      else{
        echo 'ERROR';
      }
    }
  /*************************ログアウト処理**************************************************************************/
    public function delete(int $id, $params){
      if($this->csrf($params['csrf-token'])){
        unset($_SESSION['auth_id']);
        $shop = new shop();
        $record = $shop->find($id);
        $_SESSION['error-flash'] = $record->name."さんがログアウトしました。";
        header('location: ./auth?action=new');
      }
    }  
  }
