<?php

//時間のセッテイング
function setDateTime(string $start, string $finish): array{
  
  //開始時間
  $first_hour = (int)date('H', strtotime($start));
  //開始分
  $first_min = (int)date('i', strtotime($start));
  //終了時間
  $last_hour = (int)date('H', strtotime($finish));
  //終了分
  $last_min = (int)date('i', strtotime($finish));

  $hours = [];
  $mins = [];


  for ($i = $first_hour; $i <= $last_hour; $i++) {
    array_push($hours, $i);
  }
  //最初に選択時間に合わせる(開始分)
  for ($i = $first_min; $i <= 45; $i += 15) {
    array_push($mins, $i);
  }
  return [
    $hours,
    $mins
  ];
}
//合計金額
function total_price(string $baseprice, string $cout): int{
  return (int)$baseprice * (int)$cout;
}
//合計金額税込
function total_tax_price(string $baseprice, string $count): int{
  return total_price($baseprice, $count) * 1.1;
} 
//メール本文作成
function create_mail_text(array $params){
  $message = "植松サイトご利用ありがとうございます。\n";
  $message.= "【注文内容の確認】\n";
  for($i=0; $i< count($params['number']); $i++){
    $message.= $params['item_names'][$i]."\n";
    $message.= "価格";
    $message.= "受け取り日時:".$params['receiving'][$i]."\n";
    $message.= "注文数:".$params['number'][$i]."\n";
    $message.="合計:".(int)$params['number'][$i] * (int)$params['price'][$i]."\n";
    $message.= "税込:".ceil( (int)$params['number'][$i] * (int)$params['price'][$i]*1.1 )."`\n";
    $message.="------------------------------------------";
  }
  $message.="連絡等はこちらからよろしくお願いいたします\n。";
  $message.= "yukiabineko@live.com\n";
  $message.="************************************************\n";
  $message.="【代表者　植松　勇貴】";

  return $message;
}