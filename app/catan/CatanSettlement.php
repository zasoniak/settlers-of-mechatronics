<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie osad i miast
 *
 * @author Sony
 */
class CatanSettlement implements DrawableInterface
{
  /**
   *
   * @var Settlement settlement's Eloquent model
   */
  public $model;
  
  public function __construct(Settlement $settlement)
  {
    if($settlement instanceof Settlement)
    {
      $this->model = $settlement;
    }
  }
  
  public function __toString()
  {
    return '<div class="settle"></div>';
  }
}
