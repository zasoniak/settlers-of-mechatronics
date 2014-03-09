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

  public function __construct() {

  }
  
  public function generate(array $users)
  {
      $game = Game::create(); // new game instance
      
      //generacja planszy
      $board = CatanBoard::generate();
      
      //dodanie graczy do gry
      foreach($users as $user) {
      $player = new Player($user->id);
      $player->wood=0;
      $player->stone=0;
      $player->sheep=0;
      $player->clay=0;
      $player->wheat=0;
      $player=$game->player()->save($player);  
      }
      
      //generacja zestawu kart do gry  
      $CardTypeList = array('knight', 'yearOfPleanty', 'roadBuilding', 'victoryPoint', 'monopoly');
      $card;
      for($i=0;$i<14;$i++) {
          $card = new Card();
          $card->type=$CardTypeList[rand(0,4)];
          $card->is_used=false;
          $card->player_id=NULL;
          $card = $game->card()->save($card);
      }
  }
  
}
