<?php
  require 'baseController.php';
  require './model/shop.php';
  require './model/orders.php';

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
    /********************************************************************************************************************************************************* */
    /**
     * 登録処理
     */
    public function create(array $params){

     if($this->csrf($params['csrf-token'])){
        //電話番号、メールアドレスの存在のバリデーションのチェックエラーを含んでいた場合は元のページに戻る
        $vallidation_error = $this->vallidation($params['tel'], $params['email']);
        
        if( !empty($vallidation_error['tel_error']) || !empty($vallidation_error['mail_error']) ){
          $_SESSION['vallidation'] = $vallidation_error;
          $_SESSION['input'] = $params;
          header('location: ./shop?action=new');
        }
        else{
          //入力保持のためのセッションの削除
          unset($_SESSION['input']);
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
    }
    /************************************************************************************************************************************************* */
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
    /************************************************************************************************************************************************************** */
    /**
     * 編集処理
     */
    public function update(int $id, array $params){
      //電話番号、メールアドレスの存在のバリデーションのチェックエラーを含んでいた場合は元のページに戻る
      $vallidation_error = $this->vallidation($params['tel'], $params['email']);
      $shop = new shop();
      $shop->find( $id );
      $current_tel = $shop->tel;
      $current_mail = $shop->email;
      //変更されてないカラムパラメータはエラーから除外
      if( $params['tel'] == $current_tel ) { unset($vallidation_error['tel_error']); }
      if( $params['email'] == $current_mail ) { unset($vallidation_error['mail_error']); }

     

      if($this->csrf($params['csrf-token'])){
         //バリデーションの処理はcreateと同じだが、編集処理の場合は元の電話番号とメールアドレスは除外する。
        if( ( !empty($vallidation_error['tel_error']) && $params['tel'] != $current_tel) 
        ||( !empty($vallidation_error['mail_error']) && $params['email'] != $current_mail) ){
          $_SESSION['vallidation'] = $vallidation_error;
          $_SESSION['input'] = $params;
          header('location: ./shop?action=edit&id='.$shop->id);
        }
        else{
          //入力保持のためのセッションの削除
          unset($_SESSION['input']);
          if($shop->update($id, $this->set_parameter($params))){
            $_SESSION["flash"] = "編集しました。";
            header("location: ./shop?action=show&id=$shop->id");
          }
        
        }
      }
    }
  /************************************************************************************************************************************************************************* */    
    /**
     * 店舗さん専用ページ
     */
    public function show(int $id){
      $token = $this->tokenCreate();
      $_SESSION['token'] = $token;
      $shopModel = new shop();
      $shop = $shopModel->find($id);       //=>店舗情報インスタンス

      
      $items = $shop->hasMany('item');     //=>関連商品
      $ordersModel = new orders();
      $orders = $ordersModel->records($shop->id);  //=>オーダーレコード


      if(!isset($_SESSION['auth_id']) || $shop->id != $_SESSION['auth_id']){
         header('location: ./auth?action=new');
      }
      $this->view('show', [
        'shop' => $shop,
        'token' => $token,
        'items' => $items,
        'orders' => $orders,
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
    //バリデーション
    public function vallidation(string $telparam, string $mailparam) :array{
      $error_messages = [];
      $shop = new shop();
      $telrecord = $shop->find_by("tel", $telparam);
      isset($telrecord)? $error_messages["tel_error"] ="その電話番号はすでに存在します。"  : "";

      $mailrecord = $shop->find_by("email", $mailparam );
      isset($mailrecord)? $error_messages["mail_error"] ="そのメールアドレスはすでに存在します。" : "";

      return $error_messages;
    }
  }