<?php

//お客様名の文字数でcssの分離
function customer_strlen_check(string $str) :string{
  $count = mb_strlen($str);
  return $count > 8? 'user-long' : 'user';
}
//メールアドレスの文字数でcssの分離
function email_strlen_check(string $str) :string{
  $len = mb_strlen($str);
  return $len > 20 ? "email email-long" : "email";
}