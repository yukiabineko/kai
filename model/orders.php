<?php
require_once 'model.php';

class orders extends Model{

  public function records(int $shop_id){
    $sql = "select orders.id, orders.name,item.name AS item_name,item.price,orders.order_count,orders.receiving,orders.tel,orders.email,orders.status from shop inner join item on shop.id=item.shop_id inner join orders on item.id=orders.item_id where shop.id=?";
    try{
      $smt = $this->pdo->prepare($sql);
      $smt->bindValue(1,(int)$shop_id, PDO::PARAM_INT);
      $smt->execute();
      $records = $smt->fetchAll(PDO::FETCH_ASSOC);
      return $records;
    }
    catch(PDOException $e){
      echo $e->getMessage();
      die();
    }
    
  }
}