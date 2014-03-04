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
   * @var User user's model
   */
  public $player;
  
  public function __construct($id)
  {
    $this->player = Player::find($id);
  }
}
