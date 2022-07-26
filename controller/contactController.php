<?php
require 'baseController.php';

class contactController extends baseController
{

  public function new()
  {
    $token = $this->tokenCreate();
    $_SESSION['token'] = $token;

    $this->view('new', [
      'token' => $token,
    ]);
    //=< トップページのview呼び出し
  }
}