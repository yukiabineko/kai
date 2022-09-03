<?php
  require 'baseController.php';
  require './model/shop.php';

  class shopController extends baseController{
    /**
     * 新規登録画面
     */
    public function new(){
      $token = $this->tokenCreate();
      $_SESSION['token'] = $token;

      $this->view('new',[
      'token' => $token,  //csrf対策のためトークンを作成(セッションに格納)
      ]);
    }

    /**
     * 登録処理
     */
    public function create(array $params){
      if($this->csrf($params['csrf-token'])){
        $params = $this->set_parameter($params);
        $shop = new shop();
        if ($shop->create($params)) {
          $_SESSION['auth_id'] = $shop->id;                  //=>自動ログイン
          $_SESSION['flash'] = '登録しました。';
          if(isset($_SESSION['orders'])){ unset($_SESSION['orders']); }  //買い物かごがあった場合一度削除
          header("location: ./shop?action=show&id=$shop->id");
        }
      }
    }

    /**
    *店舗情報編集ページ
     */
    public function edit(int $id){
      $token = $this->tokenCreate();
      $_SESSION['token'] = $token;

      $model = new shop();
      $shop = $model->find($id);
      
    
      $this->view('edit', [
        'shop' => $shop,
        'token' =>$token,  //csrf対策のためトークンを作成(セッションに格納)
      ]);
    }
    /**
     * 編集処理
     */
    public function update(int $id, array $params){
      echo "<br>";
      echo $_SESSION['token'];
      if($this->csrf($params['csrf-token'])){
        $shop = new shop();
        if($shop->update($id, $this->set_parameter($params))){
          $_SESSION["flash"] = "編集しました。";
          header("location: ./shop?action=show&id=$shop->id");
        }
      } else {
      echo 'ERROR';
    }
      
    }

    /**
     * 店舗さん専用ページ
     */
    public function show(int $id){
      $token = $this->tokenCreate();
      $_SESSION['token'] = $token;
      $shopModel = new shop();
      $shop = $shopModel->find($id);       //=>店舗情報インスタンス

      
      $items = $shop->hasMany('item');     //=>関連商品

      if(!isset($_SESSION['auth_id']) || $shop->id != $_SESSION['auth_id']){
         header('location: ./auth?action=new');
      }
      $this->view('show', [
        'shop' => $shop,
        'token' => $token,
        'items' => $items,
      ]);
     
    }


    /*******************************************補助メソッド************************************************************************* */
    //postされたデータをエスケープまた、パスワードを暗号化
    public function set_parameter(array $posts){
      $params = [];
      foreach($posts as $key=>$value){
        if($key !='password' && $key != 'password_confirmation' && $key != 'csrf-token'){
          $params[$key] = htmlspecialchars($value,ENT_QUOTES, 'UTF-8');
        }
      }
      $params['password'] = password_hash($posts['password'], PASSWORD_DEFAULT);
      return $params;
    }
  }