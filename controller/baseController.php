<?php


class baseController{

  public function __construct()
  {
    
  }
  /***************************対応viewの表示********************************************************************** */
  public function view($actionName, $params = null): void{
    
     $class =  get_class($this);
     $controllerName = explode('Controller', $class)[0];
     //送られてきたモデルのデータ格納
     
     ${ $controllerName } =isset($params[$controllerName])? $params[$controllerName] : "";  //モデルのデータ
     $token = isset($params['token'])? $params['token'] : null;                               //csrfトークン
     
     if($controllerName === "empty"){
      include('./view/404_view.php');
     }
     else{
      include('./view/layout_view.php');
     }
      
  }
  /****************************トークンによるcsrf対策********************************************************************************* */
  public function csrf(string $token) :bool{
    
    if($token == $_SESSION['token']){
      return true;
    }
    else{
      return false;
    }
  }
  public function tokenCreate(): string{
    $tokenByte = openssl_random_pseudo_bytes(16);
    $token = bin2hex($tokenByte);
    $_SESSION['token'] = $token;
    return $token;
  }
  /******************************************セッションの格納**************************************************************************************** */
  public function session_store(int $id):void{
    $class =  get_class($this);
    $controllerName = explode('Controller', $class)[0];
    //セッションの名前
    $sessin_name = $controllerName."_id";
    $_SESSION[$sessin_name] = $id;
  }
  /********************************ログイン状態かチェック***************************************************************************************************************** */
  public function login_check(string $session): bool{
    if(isset($session)){
      return true;
    }
    else{
      return false;
    }
  }
}