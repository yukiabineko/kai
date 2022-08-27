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
  /**
   * 時間の抽出
   */
  public function time_extraction(){
    //開始時間
    $first_hour = (int)date('H', strtotime($this->start));
    //開始分
    $first_min = (int)date('i', strtotime($this->start));
    //終了時間
    $last_hour = (int)date('H', strtotime($this->finish));
    //終了分
    $last_min = (int)date('i', strtotime($this->finish));

    $hours = [];
    $mins = [];


    
    for($i = $first_hour; $i <= $last_hour; $i++){
      array_push($hours, $i);
    }
    //最初に選択時間に合わせる(開始分)
    if($first_hour == $last_hour){
      for($i = $first_min; $i<= $last_min; $i+= 15){
        array_push($mins, $i);
      }
    }
    elseif($first_hour != $last_hour){
      for($i = $first_min; $i<= 45; $i+= 15){
        array_push($mins, $i);
      }
    }
    
    
    
    return [
      $hours,
      $mins
    ];

  }
  
}
