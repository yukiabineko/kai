<?php
require 'baseController.php';
require './model/item.php';

class itemController extends baseController{

/********************商品登録ページ******************************************** */
  public function new(){
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('new',[
      'token' => $token,  //csrf対策のためトークンを作成(セッションに格納)
    ]);
  }
/**********************登録処理****************************************************** */
  public function create(array $params){

    if( $this->csrf($params['csrf-token'])){
      $item = new item();
      $id =  $item->getID();
      $send_data = $this->parameter_processing($params);     //=>モデルに登録するためデータの加工
      $item->create($send_data);
      
    }
  }
/********************モデルのデータ送信のためにポストデータの最適化****************************************************************** */
  protected function parameter_processing(array $params): array {
    $shop_id = $_SESSION['auth_id'];

    $newData = array();
    $newData['thumbnail'] = !empty($_FILES['thumbnail']["name"])? "./image/shop$shop_id/thumbnail.jpg" : null;
    $newData['name'] = $params['name'];
    $newData['price']= $params['price'];
    $newData['stock'] = $params['stock'];
    $startDate = $params['startDate'];
    $startTime =  $params['startTime'];
    $newData['start'] = "$startDate $startTime";
    $endDate = $params['endDate'];
    $endTime =  $params['endTime'];
    $newData['finish'] = "$endDate $endTime";
    $newData['info'] = $params['info'];
    $newData['shop_id'] = $shop_id;
    return $newData;
  }
/**************************************画像を関連ディレクトリに登録**************************************************************************************** */
}

