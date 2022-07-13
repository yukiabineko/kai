<?php

class Model{
  public $table;
  public $columns = ['id'=>null];              //=>カラム名によるメンバー変数名
  protected $pdo = null;
  
  /**
   * データベースのカラムをメンバー変数にするため__set, __get呼び出し
   */
  public function __set($name, $value){$this->columns[$name] = $value;}
  public function __get($name)
  {
    if(isset($this->columns[$name])){
      return $this->columns[$name];
    }
    else{
      return null;
    }
  }
  public function __construct()
  {
    $this->table = get_class($this);    //モデルクラス名
    $sql = "CREATE TABLE IF NOT EXISTS $this->table(id INT PRIMARY KEY AUTO_INCREMENT,";
    
    require_once "./database/$this->table.php";
    require_once "./key.php";
    $count = 1;
    foreach($columns as $column){
      $column_name = $column['column'];
      $column_type = $column['type'];

      $this->__set($column_name, null);   //クラスメンバー変数にカラムを追加
      //テーブル作成SQL文を格納
      $sql .= "$column_name $column_type ";
      count($columns) > $count? $sql.= "," : "";
      $count ++;
    }
    $sql .= ")";
    //pdoクラス作成しテーブルを作成する。
    $db_info = "mysql:host=$host_name;dbname=$db_name;charset=utf8";
    $this->pdo = new PDO($db_info, $user_name, $db_password);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo->exec($sql);
  }
  public function __destruct()
  {
    $this->pdo = null;
  }
  /********************************************************************** */
  /**
   * テーブルのレコード作成
   */
  public function create(array $params = null){
    //sql文作成
    $sql = "INSERT INTO shop(";
    $count = 1;
    foreach($this->columns as $key => $value){
      $count != 1? $sql.= $key : "";
      (count($this->columns) > $count) && $count > 1? $sql.= "," : "";
      $count ++;
    }
    $sql .=")VALUES(";
    for($i=2; $i<$count; $i++){   //idカラムは除くため$i=2からスタート
      $sql .= "?";
      count($this->columns) > $i? $sql.=",":"";
    }
    $sql.=")";
    echo $sql;
    /************************INSERT*******************************************/
    
    try{
      $smt = $this->pdo->prepare($sql);
      $column_number = 1;
      foreach($params as $key=>$value){
        $smt->bindValue($column_number, $value, gettype($value)=="integer"? PDO::PARAM_INT : PDO::PARAM_STR);
        $column_number++;
      }
      $smt->execute();

    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
}