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
  
}
