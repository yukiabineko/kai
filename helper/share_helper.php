<?php
//買い物カゴ重複防止のためすでにカートに追加されているか確認する
 function search_target_id(int $id, array $item_array) :bool{
   $status = false;
   foreach($item_array as $item){
    $id == $item['item_id'] ? $status = true : "";
   }
   return $status;
 }
