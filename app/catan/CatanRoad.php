<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie dróg i autostrad :P
 *
 * @author Sony
 */
class CatanRoad implements DrawableInterface
{
  /**
   *
   * @var Road road's Eloquent model
   */
  public $model;
  
  public function __construct(Road $road)
  {
    if($road instanceof Road)
    {
      $this->model = $road;
    }
  }
  
  public function __toString()
  {
    return '<div class="road"></div>';
  }
}
