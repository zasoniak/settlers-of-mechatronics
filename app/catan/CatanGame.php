<?php

/**
 * Description of Game
 *
 * @author Konrad Kowalewski
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
      
      $this->board = new CatanBoard();
      $this->playerList =  CatanPlayer::add($user_id);
      $this->cardList = $this->generateCardList();
  }
  
  private function generateCardList()
  {
      $CardList = array('knight', 'yearOfPleanty', 'roadBuilding', 'monopoly', 'victoryPoint');
      array_push($this->cardList, new CatanCard(array_rand($CardList)));
  }
}
