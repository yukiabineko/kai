<?php
require 'baseController.php';
require './model/item.php';

class orderController extends baseController
{

  public function show(int $item_id)
  {
    $model = new item();
    $item = $model->find($item_id);
    $images = $item->image_array();
    $shop = $item->belogsTo('shop');
    


    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('show', [
      'token' => $token,
      'item' => $item,
      'shop' => $shop,
      'images' => $images,
    ]);
    //=< トップページのview呼び出し
  }
}
