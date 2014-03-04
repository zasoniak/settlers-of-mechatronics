<?php

/**
 * Description of Player
 *
 * @author Konrad Kowalewski
 */
class Player
{
  /**
   *
   * @var User user's model
   */
  public $user;
  
  public function __construct($id)
  {
    $this->user = User::find($id);
  }
}
