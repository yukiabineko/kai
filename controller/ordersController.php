<?php
require 'baseController.php';
require './model/item.php';
require './model/orders.php';

class ordersController extends baseController
{/***********************************注文ページ************************************************************************ */
  public function show(int $item_id)
  {
    require_once './helper/share_helper.php';
    
    $model = new item();
    $item = $model->find($item_id);
     //存在しないgetパラメーターを検知したらリダイレクト
     if(empty($item->id) || (isset($_SESSION['orders']) && search_target_id($item->id , $_SESSION['orders']) == true) ){
      header('location: ./item?action=index');
    }
    $othersItem = $model->where('shop_id', $item->shop_id, 3, $item->id);

    $times = $item->time_extraction();
    $images = $item->image_array();
    $shop = $item->belogsTo('shop');
    
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    //リロード防止用セッション
    $_SESSION['reload'] = mt_rand();

    $this->view('show', [
      'token' => $token,
      'item' => $item,
      'shop' => $shop,
      'images' => $images,
      'times' => json_encode($times, JSON_UNESCAPED_UNICODE),
      'others'=>$othersItem,
    ]);
    //=< トップページのview呼び出し
  }
  /********************************注文確定ページ**************************************************************************************** */
  public function new(){
  
    //前のページのURLが指定の出ない場合でオーダーセッションがない場合は一覧へリダイレクト
   /* $before_url = $_SERVER['HTTP_REFERER'];
    if (strpos($before_url, 'order') == false) {
      header('location: ./item');
    }
    */
    require_once './helper/share_helper.php';
    //同じ商品の追加防止
    if(isset($_SESSION['orders']) && isset($_GET['item_id']) && search_target_id($_GET['item_id'], $_SESSION['orders']) == true ){
      header('location: ./order?action=new');
    }
    
    //オーダーセッションなかったら作成
    if(!isset($_SESSION['orders'])){
      $_SESSION['orders'] = [];
    }
    $id = count($_SESSION['orders']);

    if(!empty($_GET['dtInfo']['input']) && !empty($_GET['stockInfo']['input']) && isset($_SESSION['reload'])){
       unset($_SESSION['reload']);
       $datas = [];
       $datas['id'] = $id;
       
       //xss対策でhtmlタグ変換
       foreach($_GET as $key => $value){
         if($key != "dtInfo" && $key != "stockInfo"){
            $datas[$key] =  htmlspecialchars($value,ENT_QUOTES);
         }
         elseif($key == "dtInfo"){
           $data = [
             'start' => htmlspecialchars($value['start'], ENT_QUOTES),
             'finish' => htmlspecialchars($value['finish'], ENT_QUOTES),
             'input' => htmlspecialchars($value['input'], ENT_QUOTES),
           ];
           $datas[$key] = $data;
         }
         elseif($key == "stockInfo"){
          $data = [
            'limit' => htmlspecialchars($value['limit'], ENT_QUOTES),
            'input' => htmlspecialchars($value['input'], ENT_QUOTES),
          ];
          $datas[$key] = $data;
         }
       }
      array_push($_SESSION['orders'], $datas);
    }
  


    $this->view("new");
  }
/******************************************************************************************************************* */
  //買い物かごの削除
  public function delete(int $id){
    $orders = $_SESSION['orders'];
    $target = $orders[$id];
    $price = $target["price"];
    $num = $target['stockInfo']['input'];


    unset($orders[$id]);
    $_SESSION['orders'] = $orders;
     echo json_encode(['status' =>1, 'price'=>$price, 'num'=>$num, 'id'=> $id],JSON_UNESCAPED_UNICODE);
  }
  /********************************注文処理ページ********************************************************************** */
  public function create(array $params)
  {
   print_r($params);
   $_SESSION['error_message'] = [];
   for($i = 0; $i< count($params['items']); $i++){
    $set_parameter =[];
    $set_parameter['number'] = $params['number'][$i];
    $set_parameter['receiving'] = $params['receiving'][$i];
    $set_parameter['item_id'] = $params['items'][$i];
    $set_parameter['name'] = $params['name'];
    $set_parameter['tel'] = $params['tel'];
    $set_parameter['email'] = $params['email'];

    $target_item = new item();
    $target_item->find($set_parameter['item_id']);
    $stock = $target_item->stock;
   
    //注文数が在庫をオーバーしてしまったらエラーを出す。
    if( (int)$set_parameter['number'] > (int)$stock ){
      array_push($_SESSION['error_message'], "⚠".$target_item->name."の在庫がありません。注文数をご確認ください。");
    }
    else{
      $order = new orders();
      if($order->create($set_parameter)){
        $_SESSION['success'] = "注文受付完了しました。";
        unset($_SESSION['orders']);
        header('location: /item');
      }
    }
   }
   if(!empty($_SESSION['error_message'])){
    header('location: ./orders?action=new');
    exit();
   }
   

 }
}

