<?php
require 'baseController.php';
require './model/item.php';

class itemController extends baseController{

/********************商品登録ページ******************************************** */
  public function new(){
    //未ログインの場合リダイレクト
    if(!isset($_SESSION['auth_id'])){
      header('location: ./auth?action=new');
    }
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
        $_SESSION['flash'] = "商品を登録しました。";
        header('location: ./shop?action=show&id='.$_SESSION['auth_id']);
      }
      
    }
  }
  /********************商品編集ページ******************************************** */
  public function edit(int $id)
  {
    //未ログインの場合リダイレクト
    if (!isset($_SESSION['auth_id'])) {
      header('location: ./auth?action=new');
    }
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;
    $model = new item();
    $item = $model->find($id);

    //画像のパス配列化
    $images = explode(',',$item->images);
    

    $this->view('edit', [
      'token' => $token,  //csrf対策のためトークンを作成(セッションに格納)
      'item' => $item,
      'images'=> $images,
    ]);
  }
/**********************編集処理****************************************************** */
public function update(int $id, array $params){

  if( $this->csrf($params['csrf-token'])){
    $model = new item();
    $item = $model->find($id);
    
    $send_data = $this->parameter_processing($params, $id, $item->images);
   
     if ($item->update($id,$send_data)) {
        $this->updateImage($item);
        $_SESSION['flash'] = "商品を編集しました。";
        header('location: ./shop?action=show&id=' . $_SESSION['auth_id']);
      }

  }
}
/***************************商品個別表示******************************************************** */
public function show(int $id){
   //未ログインの場合リダイレクト
    if (!isset($_SESSION['auth_id'])) {
      header('location: ./auth?action=new');
    }
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;
    $model = new item();
    $item = $model->find($id);
    $shop = $item->belogsTo('shop');

    //画像のパス配列化
    $images = explode(',', $item->images);


    $this->view('show', [
      'token' => $token,  //csrf対策のためトークンを作成(セッションに格納)
      'item' => $item,
      'images' => $images,
      'shop' => $shop,
    ]);

}
/*****************************削除処理**************************************************************** */
public function delete(int $id){
  
}

/***********************************protected******************************************************************************* */
/********************モデルのデータ送信のためにポストデータの最適化****************************************************************** */

  protected function parameter_processing(array $params, int $item_id, string $item_images=null): array {
    $shop_id = $_SESSION['auth_id'];
    $images = "";
    $files = $_FILES['file']['name'];
   

    if($_GET['action'] == 'create'){
      //post送信された画像数から
      $id = 1;
      for($i= 0; $i< count($files); $i++){
        !empty($files[$i])? $images.= "./shops/item$item_id/img$id.jpg" : "";
        ($i != count($files) -1) && !empty($files[$i]) && !empty($files[$i + 1]) ? $images.= ",": "";
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
    elseif($_GET['action'] == 'update'){
      //print_r($params);
      //echo '<br>';
      //print_r($_FILES);
      //echo '<br>';
      //echo 'すでにある画像パス:'.$item_images;
      //echo '<br>';

      $images = $item_images;
      $images_array = explode(',', $item_images);
      $targetFile = explode("./shops/item$item_id/", end($images_array))[1];
      //echo $targetFile;
      //echo '<br>';
      $targetID = preg_replace('/[^1-3]/', '', $targetFile);
      //echo '登録済み画像番号:'.$targetID;
      //echo '<br>';

      //$targetIDをもとに追加画像ある場合はパスに追加
      $add_files = isset($_FILES['file']['name'])? $_FILES['file']['name'] : null;
      //print_r($add_files);
      //echo '<br>';

      //パス文字列に追加
      for($i = 0; $i < count($add_files); $i++){
         !empty($add_files[$i])? $targetID ++ : "";
         !empty($add_files[$i])? $images.= ",./shops/item$item_id/img$targetID.jpg": "";
      }
      echo "画像パス:".$images;
     

      $newData = array();
      !empty($_FILES['thumbnail']["name"]) ?  $newData['thumbnail'] = "./shops/item$item_id/thumbnail.jpg" : "";
      $newData['name'] = $params['name'];
      $newData['price'] = $params['price'];
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
/***************************************画像編集時のメゾット**************************************************************************************************************** */
protected function updateImage(item $item){
  $uploadFiles = $_FILES['upload-file']['name'];
  $imgPaths = $item->images;
  //echo '<br>';
  $images = explode(',',$imgPaths);
  //print_r($images);
  //echo '<br>';

  !empty($_FILES['thumbnail']['name'])? move_uploaded_file($_FILES['thumbnail']['tmp_name'], "./shops/item$item->id/thumbnail.jpg") : "";
  
  //まずアップデート処理
  foreach($uploadFiles as $id => $file){
    //echo $file;
    //echo '<br>';
    move_uploaded_file($_FILES['upload-file']['tmp_name'][$id], $images[$id] );
    
  }
  echo '<br>';
  //画像ファイルのナンバー
  $targetID = count($_FILES['upload-file']['name']); 
  echo $targetID;
  echo '<br>';
  //print_r($_FILES);
  foreach($_FILES['file']['name'] as $key => $file){
    !empty( $file)? $targetID++ : "";
    //echo 'ターゲット:'.$targetID;
    !empty( $file)? move_uploaded_file($_FILES['file']['tmp_name'][$key],"./shops/item$item->id/img$targetID.jpg") : '' ;   
  }
 
}

 
}

