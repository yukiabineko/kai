<?php
  require 'baseController.php';
  require './model/shop.php';

  class shopController extends baseController{
    /**
     * 新規登録画面
     */
    public function new(){
      $this->view('new',[
      'token' => $this->tokenCreate(),  //csrf対策のためトークンを作成(セッションに格納)
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
          header("location: ./shop?action=show&id=$shop->id");
        }
      }
    }

    /**
    *店舗情報編集ページ
     */
    public function edit(int $id){
      $model = new shop();
      $shop = $model->find($id);
    
      $this->view('edit', [
        'shop' => $shop,
        'token' =>$this->tokenCreate(),  //csrf対策のためトークンを作成(セッションに格納)
      ]);
    }
    /**
     * 編集処理
     */
    public function update(int $id, array $params){
      if($this->csrf($params['csrf-token'])){
        $shop = new shop();
        if($shop->update($id, $this->set_parameter($params))){
          header("location: ./shop?action=show&id=$shop->id");
        }
      }
      
    }

    /**
     * 店舗さん専用ページ
     */
    public function show(int $id){
      $shopModel = new shop();
      $shop = $shopModel->find($id);
      
      $this->view('show', [
        'shop' => $shop
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