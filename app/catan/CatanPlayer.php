<?php

/**
 * Description of Player
 *
 * @author Konrad Kowalewski
 */
class CatanPlayer
{
  /**
   *
   * @var Player player's eloquent model
   */
  public $model;
  
  public function __construct(Player $player)
  {
    $this->model = $player;
  }
  
    public function addResource($tile, $isTown)
  {
      if($isTown)
      {
          $this->model->{$type}+=2;
      }else
      {
          $this->model->{$type}+=1;
      }
      $this->model->save();
      
  }
}
