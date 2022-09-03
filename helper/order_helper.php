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