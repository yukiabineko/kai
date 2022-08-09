<?php

require_once 'model.php';

class item extends Model
{
  //開始日時の加工

  public function start_processing(){
    return date('n/d G:i', strtotime($this->start));
  }
  //終了日時の加工

  public function end_processing()
  {
    return date('n/d G:i', strtotime($this->finish));
  }
  /**
   * レコード数からページ算出
   */

  public function pages(){
    $page_count =  count($this->all());
    $page_array = [];
    for($i = 1; $i <= ceil($page_count / 8); $i++ ){
      array_push($page_array, $i);
    }
    return $page_array;
  }

  //imageレコードを分割
  public function image_array(){
    return explode(',', $this->images);
  }
  
}
