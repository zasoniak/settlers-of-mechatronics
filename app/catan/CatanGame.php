<?php

/**
 * Description of Game
 *
 * @author konrad
 */
class CatanGame
{
  /**
   * 
   * @var Game game's model
   */
  private $game;
  
  /**
   *
   * @var CatanBoard board's model
   */
  private $board;
  private $playerList = array();
  private $cardList = array();

  public function __construct($user_id) {
      $this->game = Game::create(); // new game instance
      $board = new CatanBoard();
  }
}
