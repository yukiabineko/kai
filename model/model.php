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
    
    require "./database/$this->table.php";
    require "./key.php";
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
  /*********************全理コードの取得*********************************************************/
  public function all(string $sort_column = null, string $sort = null){
    $sql = isset($sort_column)?  "SELECT * FROM $this->table ORDER BY $sort_column $sort" : "SELECT * FROM $this->table ";
   
    try{
       $smt = $this->pdo->query($sql);
       $results = $smt->fetchAll(PDO::FETCH_ASSOC);
       $records = [];

       foreach($results as $result){
         $model = new $this->table();
         foreach($result as $key=>$value){
           $model->$key = $value;
         }
        array_push($records, $model);
       }
       return $records;
    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
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
      $smt->bindValue($column_number, (int)$id, PDO::PARAM_INT);
      $smt->execute();
      //作成したレコードを呼び出し
      $this->find($id);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit();
    }
    
  }
  /****************************************削除処理****************************************************************************************/
  public function delete(int $id){
    $sql = "DELETE FROM $this->table WHERE id=?";
    try{
      $smt = $this->pdo->prepare($sql);
      $smt->bindValue(1, (int)$id, PDO::PARAM_INT);
      $smt->execute();
      return true;
    }
    catch(PDOException $e){
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
     if(!empty($result)){
      foreach($result as $key=>$value){
        $this->$key = $value;
       }
       return $this;
     }
     else{
       return null;
     }
    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
  /***************************************特定のカラムから１行検索*************************************************************************** */
  public function find_by(string $column_name, string $param){
    /*$columSql = "SHOW COLUMNS FROM $this->table WHERE Field='$column_name'";
    echo $columSql;
    $columnSmt = $this->pdo->prepare($columSql);
    $columnSmt->execute();
    $columnResult = $columnSmt->fetch(PDO::FETCH_ASSOC);
    echo $columnResult['Type'];*/

    $sql = "SELECT * FROM $this->table WHERE $column_name=?";
    $smt = $this->pdo->prepare($sql);
    $smt->bindValue(1, $param, PDO::PARAM_STR);
    $smt->execute();
    $results = $smt->fetch(PDO::FETCH_ASSOC);
    if(!empty($results)){
      foreach($results as $key=>$value){
        $this->$key = $value;
      }
      return $this;
    }
    else{
      return null;
    }
   
  }
  
  /***********************************最後のレコード取り出し************************************************************* */
  public function last(){
    $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT 1";
    try{
     $smt = $this->pdo->query($sql);
     $result = $smt->fetch(PDO::FETCH_ASSOC);
     if(!empty($result)){
      foreach($result as $key=>$value){
        $this->$key = $value;
       }
       return $this;
     }
     else{
      return null;
     }
    }
    catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }
  /*************************auto_incrementによる次回のID取得************************************************************* */
  public function getID(){
    $sql = "SHOW TABLE STATUS LIKE "."'$this->table'";
    try {
      $smt = $this->pdo->query($sql);
      $result = $smt->fetch(PDO::FETCH_ASSOC);
      return $result['Auto_increment'];
      
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit();
    }
  }
  /****************************レコード数カラム、指定して複数取り出し*********************************************************************************** */
  public function where(string $column_name, string $param, int $limit = null, int $exclusion = null){
   $sql = "SELECT * FROM $this->table WHERE $column_name=?";
   isset($exclusion) ? $sql .= " AND NOT id= ?" : "";
   isset($limit)? $sql.= " LIMIT ?" : "";

   $smt = $this->pdo->prepare($sql);
   $smt->bindValue(1, $param, PDO::PARAM_STR);
   $smt->bindValue(2,$exclusion,PDO::PARAM_STR);
   $smt->bindValue(3, (int)$limit, PDO::PARAM_INT);
   $smt->execute();
   $records = $smt->fetchAll(PDO::FETCH_ASSOC);
  
   $items = [];
   foreach($records as $record){
     $obj = new $this->table();
     foreach($record as $key => $value){
      $obj->$key = $value;
     }
     array_push($items, $obj);
   }
   return $items;
  }
  /***************************リレーション関連********************************************************************************************/
  public function hasMany(string $table_name, string $sort_column = null, string $sort = null){
    require_once "$table_name.php";
    require "./database/$table_name.php";
    //リレーション対象のテーブルの初期設定
    $tb_sql = "CREATE TABLE IF NOT EXISTS $table_name(id INT PRIMARY KEY AUTO_INCREMENT,";
    $count = 1;
    foreach($columns as $column){
      $column_name = $column['column'];
      $column_type = $column['type'];
      $tb_sql .= "$column_name $column_type ";
      count($columns) > $count? $tb_sql.= "," : "";
      $count ++;
    }
    $tb_sql .= ")";
    $this->pdo->exec($tb_sql);
    $sql = "SELECT * FROM $table_name WHERE $this->table" . "_id=?";

    if( isset($sort_column) && isset($sort)){
      $sql.= " ORDER BY $sort_column $sort";
    }
    try {
      $smt = $this->pdo->prepare($sql);
      $smt->bindValue(1, (int)$this->id, PDO::PARAM_INT);
      $smt->execute();


      $results = $smt->fetchAll(PDO::FETCH_ASSOC);
      $records = [];

      //リレーション対象のテーブルのカラムを取
      if(!empty($results)){
        $columns = array_keys($results[0]);
      
        //対応モデルのオブジェクト格納
        foreach($results as $result){
          $model = new $table_name();
          foreach($result as $key=>$value){
            $model->$key = $value;
          }
          array_push($records, $model);
        }
      }
      
      return $records;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit();
    }
  }
  /************************************一対多でリレーション元を取り出す**************************************************************************** */
  public function belogsTo(string $table_name){
    require_once "$table_name.php";
    $sql = "SELECT * FROM $table_name WHERE id=?";
    try {
      $smt = $this->pdo->prepare($sql);
      $smt->bindValue(1, (int)$this->shop_id, PDO::PARAM_INT);
      $smt->execute();
      $result = $smt->fetch(PDO::FETCH_ASSOC);

      //リレーション対象のテーブルのカラムを取
      if(!empty($result)){
        $columns = array_keys($result);
      
        //対応モデルのオブジェクト格納
          $model = new $table_name();
          foreach($result as $key=>$value){
            $model->$key = $value;
          }
          return $model;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit();
    }
    
  }
  /*****************************inner join句 ************************************************************************* */
  public function join(string $target_table, string $target_column =null, string $target_string = null)
  {
    $sql =
      "SELECT $this->table. * FROM $this->table 
     INNER JOIN $target_table ON $this->table.$target_table" . "_id=$target_table.id ";
    if(isset($target_column)){
      $sql.= "WHERE $target_table.$target_column = ?";
    }
    $smt = $this->pdo->prepare($sql);
    $smt->bindValue(1, $target_string, PDO::PARAM_STR);
    $smt->execute();
    $results = $smt->fetchAll(PDO::FETCH_ASSOC);
    $instances = [];
    foreach($results as $result){
      $model = new $this->table();
      foreach($result as $key=>$value){
        $model->$key = $value;
      }
      array_push($instances, $model);
    }
    return $instances;
  }
  /*****************************inner join like句 ************************************************************************* */
  public function joinLike(string $target_table, string $target_column, string $target_string){
    $sql = 
    "SELECT $this->table. * FROM $this->table 
     INNER JOIN $target_table ON $this->table.$target_table"."_id=$target_table.id 
     WHERE $target_table.$target_column LIKE '%$target_string%'";
     
     $smt = $this->pdo->query($sql);
     $results = $smt->fetchAll(PDO::FETCH_ASSOC);
     $records = [];
     foreach($results as $result){
      $model = new $this->table();
      foreach($result as $key => $value){
        $model->$key = $value;
      }
      array_push($records, $model);
     }
     return $records;
  }
  /************************************id複数選択で検索***************************************************************************************************** */
  public function include(array $id_array){
    $sql = "SELECT * FROM $this->table WHERE id in(";
    foreach($id_array as $i => $id){
      $sql.= $i != array_key_last($id_array) ? "$id," : $id;
    }
    $sql.=")";
    try{
      $smt = $this->pdo->query($sql);
      $results = $smt->fetchAll(PDO::FETCH_ASSOC);
      $records = [];
      foreach($results as $result){
        $model = new $this->table();
        foreach($result as $key => $value){
          $model->$key = $value;
        }
        array_push($records, $model);
      }
      return $records;
    }
    catch(PDOException $e){
      echo $e->getMessage();
      die();
    }

  }

}