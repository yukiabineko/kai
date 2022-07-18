<?php
session_start();

if(empty($_SERVER['REQUEST_URI'])) {
  exit;
}
//urlを/で分解し配列化
$array_parse_uri = explode('/', $_SERVER['REQUEST_URI']);
//上で作成した配列の最後の要素取り出し
$last_uri = end($array_parse_uri);
//上で取り出した最後の文字列からさらにクエリパラメーターを除外
$call = substr($last_uri, 0, strcspn($last_uri,'?'));


//クエリパラメーターを$_SERVER['QUERY_STRING']から取得加工クエリパラメーターを準備
$querys = !empty( $_SERVER['QUERY_STRING'])? get_query($_SERVER['QUERY_STRING']) : null;

//関連コントローラー読み込み
if(file_exists('./controller/' . $call . 'Controller.php')){
  $class = $call . 'Controller';
  include('./controller/' . $call . 'Controller.php');
  $obj   = new $class();
  if( $_SERVER["REQUEST_METHOD"] != "POST" && isset($querys['action']) ){
    switch ($querys['action']) {
      case 'new':
        $response = $obj->new();
        break;
      case 'index':
        $response = $obj->index();
        break;
      case 'show':
        $response = $obj->show($querys['id']);
        break;
      case 'edit':
        $response = $obj->edit($querys['id']);
        break;
    
      default:
        $response = $obj->index();
        break;
    }
    // コントローラーから戻された内容をレスポンスとして戻す。
    echo $response;
    exit;
  
  }
  else if(  $_SERVER["REQUEST_METHOD"] != "POST" && !isset($querys['action'])){
    $response = $obj->index();
  }
  else if(  $_SERVER["REQUEST_METHOD"] == "POST" && isset($querys['action'])){
    switch ($querys['action']) {
      case 'create':
        $response = $obj->create($_POST);
        break;
      case 'update':
        $response = $obj->update($querys['id'], $_POST);
        break;
      case 'delete':
        $response = $obj->delete($querys['id'], $_POST);
        break;
     
      default:
        break;
    }
  }
  
}

else{
  $class = "emptyController";
  include('./controller/emptyController.php');
  $obj = new $class();
  $response = $obj->index();
  echo $response;
  exit;

}



/**
 * クエリパラメーターの加工関数
 */
function get_query(string $params = null){
  //&で分解し配列化
  if(isset( $params )){
    $querys = explode('&',$params);
    $query_data = [];
    if( isset( $querys )){
      foreach($querys as $query){
        //配列化されたデータを=で分解し加工
        $query_array = explode("=", $query);
         isset($query_array) ? $query_data[$query_array[0]] = $query_array[1] : null;
      }
    return $query_data;
    }
   return null;
  }
  else{
    return null;
  }
  
}