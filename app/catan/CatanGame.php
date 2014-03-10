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
  private $model;
  
  /**
   *
   * @var CatanBoard board's model
   */
  private $board;
  private $playerList = array();
  private $cardList = array();
  
  
  public function __construct(Game $game) 
  {
      if($game instanceof Game)
      {
        $this->model=$game;
      }     
  }
  
  public function generate(array $users)
  {
      $game = Game::create(); // new game instance
      
      //dodanie hosta gry
      $player = new Player($user->id);
      $player=$game->players()->save($player);  
      
  }
  
  public function addPlayer($user)
  {
    if ($game instanceof Game)
    {
      $player = new Player($user->id);
      $player=$game->players()->save($player);
    }
  }
  
  
  public function gameStart() 
  {
      //generacja planszy
      $board = CatanBoard::generate();
      $board = $game->board()->save($board);
      
      //generacja zestawu kart do gry  
      $CardTypeList = array('knight', 'yearOfPleanty', 'roadBuilding', 'victoryPoint', 'monopoly');
      $card;
      for($i=0;$i<14;$i++) {
          $card = new Card();
          $card->type=$CardTypeList[rand(0,4)];
          $card = $game->cards()->save($card);
          }
  }
  
  
  public function endMove()
  {
      //jesli doszedl do konca nowa tura
      if($this->model->current_player==4)
      {
          $this->model->turn_number++;
          $this->model->current_player=1;
      }else //inaczej następny gracz
        {
          $this->model->current_player++;
        }
        $this->model->is_changed=true;
        $this->model->save();
  }
  
  
  public function throwDice()
  {
      $dice=rand(1,6)+rand(1,6);
      
      
  }
  
  public function shop()
  {
      
  }
  
  public function build()
  {
      
  }
  
  public function playCard()
  {
      
  }
  

  
  
}
