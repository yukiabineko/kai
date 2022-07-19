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
      $send_data = $this->parameter_processing($params, $id);     //=>モデルに登録するためデータの加工
      if($item->create($send_data)){
        $this->set_image($_FILES, $id);
      }
      
    }
  }
/********************モデルのデータ送信のためにポストデータの最適化****************************************************************** */
  protected function parameter_processing(array $params, int $item_id): array {
    $shop_id = $_SESSION['auth_id'];
    $images = "";
    $files = $_FILES['file']['name'];

    //post送信された画像数から
    $id = 1;
    for($i= 0; $i< count($files); $i++){
      !empty($files[$i])? $images.= "./shpps/item$item_id/img$id.jpg" : "";
      $i != count($files) -1 ? $images.= ",": "";
      !empty($files[$i]) ? $id ++ : "";
    }

    $newData = array();
    $newData['thumbnail'] = !empty($_FILES['thumbnail']["name"])? "./shops/item$item_id/thumbnail.jpg" : null;
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
    $newData['images'] = $images;
    return $newData;
  }
/**************************************画像を関連ディレクトリに登録**************************************************************************************** */
 public function set_image(array $files, int $item_id){
  $directory = "./shops/item$item_id";
  
   if(!empty($files['thumbnail']['name'])){
    !file_exists($directory)? mkdir($directory) : "";  //店舗さんの画像ディレクトリなければ作成
    move_uploaded_file($files['thumbnail']['tmp_name'], $directory."/thumbnail.jpg");
   }
   $img_number = 1;
   for($i = 0; $i< 3; $i++ ){
    !empty($files['file']['name'][$i])? move_uploaded_file($files['file']['tmp_name'][$i], $directory."/img$img_number.jpg") : "";
    !empty($files['file']['name'][$i])? $img_number ++ : "";
   }
 }
 
}

