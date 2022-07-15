<?php

class Model{
  public $table;
  public $id;
  protected $pdo = null;
  
  
  /*****************データベースのカラムをメンバー変数にするため__set, __get呼び出し********************/

  public function __set($name, $value){$this->$name = $value;}
  public function __get($name)
  {
    if(isset($this->$name)){
      return $this->$name;
    }
    else{
      return null;
    }
  }
  /***********************************コンストラクタ******************************************************************** */
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
  /*******************************デストラクタ******************************************************************************** */
  public function __destruct()
  {
    $this->pdo = null;
  }
  /**********************テーブルのレコード作成************************************************ */

  public function create(array $params = null){
    //sql文作成
    $count = 0;
    $sql = "INSERT INTO $this->table(";
    foreach($params as $key => $value){
      $sql.= $key;
      count($params) > ($count +1)? $sql.="," : "";
      $count ++;
    }
    $sql .=")VALUES(";
    for($i=1; $i<= $count; $i++){   
      $sql .= "?";
      count($params) > $i? $sql.=",":"";
    }
    $sql.=")";
    /**
     * INSERT
     */
    
    try{
      $smt = $this->pdo->prepare($sql);
      $column_number = 1;
      echo $sql.'<br>';
    
      foreach($params as $key=>$value){
        $smt->bindValue($column_number, $value, gettype($value)=="integer"? PDO::PARAM_INT : PDO::PARAM_STR);
        $column_number++;
      }
      $smt->execute();
      //作成したレコードを呼び出し
      $this->last();
      return true;

    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
  /***************************************レコードの編集*************************************************************************************/
  public function update(int $id,array $params){

    //$sql文の作成
    $sql = "UPDATE $this->table SET ";
    $count = 0;
    foreach($params as $key => $value){
      $sql .= "$key=?";
      count($params) > ($count + 1 )? $sql.= "," : "";
      $count ++;
    }
    $sql .= " WHERE id=?";
    echo $sql;
    /***
     * update処理
     */
    try {
      $smt = $this->pdo->prepare($sql);
      $column_number = 1;

      foreach ($params as $key => $value) {
        $smt->bindValue($column_number, $value, gettype($value) == "integer" ? PDO::PARAM_INT : PDO::PARAM_STR);
        $column_number++;
      }
      $smt->execute();
      //作成したレコードを呼び出し
      $this->last();
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit();
    }
    
  }
  /****************************************IDによるレコード検索**************************************************************************** */
  public function find(int $id){
    $sql = "SELECT * FROM $this->table WHERE id=?";
    try{
     $smt = $this->pdo->prepare($sql);
     $smt->bindValue(1, (int)$id, PDO::PARAM_INT);
     $smt->execute();
     

     $result = $smt->fetch(PDO::FETCH_ASSOC);
     $this->id = $result['id'];
     foreach($result as $key=>$value){
      $this->$key = $value;
     }
     return $this;
    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
  /***********************************最後のレコード取り出し************************************************************* */
  public function last(){
    $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT 1";
    try{
     $smt = $this->pdo->query($sql);
     $result = $smt->fetch(PDO::FETCH_ASSOC);
     foreach($result as $key=>$value){
      $this->$key = $value;
     }
     return $this;
    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
}