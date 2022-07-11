<?php


class baseController{

  public function __construct()
  {
    
  }
  public function view($actionName, $params = null): void{
     $class =  get_class($this);
     $controllerName = explode('Controller', $class)[0];
     include('./view/layout_view.php');
  }
}