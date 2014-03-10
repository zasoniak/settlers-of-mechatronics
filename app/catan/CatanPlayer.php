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
}
