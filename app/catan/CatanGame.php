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
   * @var Game game's eloquent model
   */
  public $model;
  
  /**
   *
   * @var CatanBoard board's catan class
   */
  public $board = NULL;
  private $playerList = array();

  public function __construct(Game $game) {
    $this->model = $game;
    // dodanie CatanPlayers do listy
    foreach ($this->model->players as $player)
    {
      array_push($this->playerList, new CatanPlayer($player));
    }
    // warunkowe dodanie CatanBoard
    if($this->model->board()->count())
    {
      $this->board = new CatanBoard($this->model->board);
    }
  }
  
  public function addPlayer(User $user, $host = false)
  {
    foreach($this->playerList as $player)
    {
      if($player->model->user->id == Auth::user()->id)
      {
        return false;
      }
    }
    if($this->model->players()->count() > 3)
    {
      return false;
    }
    $player = new Player();
    $player->user_id = $user->id;
    if($host)
    {
      $player->is_host = 1;
    }
    $this->model->players()->save($player);
    return true;
  }
  
  public static function generate(User $user)
  {
    $game = Game::create(array()); // new game instance
    $instance = new self($game);
    $instance->model = $game;
    //dodanie hosta gry
    $instance->addPlayer($user,true);
    return $instance;
  }

  public function start() 
  {
      //generacja planszy
      $board = CatanBoard::generate($this->model);
      $order=1;
      foreach($this->model->players()->get() as $player)
      {
          $player->turn_order=$order;
          $order++;
          $player->save();
      }
      
            
  }
  
  public function endMove()
  {
      //liczy ilosc graczy w danej grze
      if($this->turnCheck())
      {
            $playersQuantity=$this->model->players()->count();
            //$playersQuantity=4;
             //jesli doszedl do konca nowa tura
            if($this->model->current_player==$playersQuantity)
            {
              $this->model->turn_number++;
              $this->model->current_player=1;
            }
            else //inaczej następny gracz
            {
              $this->model->current_player++;
            }
            $this->model->is_changed=1;
            $this->model->save();
      }
  }
  
 public function throwDice()
  {
      if($this->turnCheck())
      {
            $dice=mt_rand(1,6)+mt_rand(1,6);
            $tiles=Tile::findByProb($this->model->id, $dice);
            $settlements=array();

            if($dice==7)
            {
                $this->model->active_thief=1;
                $this->model->save();
                foreach($this->model->players()->get() as $player)
                {
                    echo $player;
                    $player->stealHalf();
                }
                //send request for a player to move thief
            }
            else
            {
                foreach($tiles as $tile)
                {
                  if($this->model->thief_location!=$tile->id)
                    array_push($settlements, $tile->nearestSettlement);
                }
                foreach($settlements as $settle)
                {
                    echo $settle;
                    //find owner of $settle and ->addResource($tile->type,$settle->is_town);
                }
            }
      }
  }
  
  public function getPlayers()
  {
    $return = array();
    foreach ($this->model->players as $player)
    {
      array_push($return, new CatanPlayer($player));
    }
    return $return;
  }
  
  public function getOpponents()
  {
    $players = $this->getPlayers();
    $return = array();
    foreach($players as $player)
    {
      if($player->model->user->id != Auth::user()->id)
      {
        array_push($return, $player);
      }
    }
    return $return;
  }
  
  public function getHost()
  {
    foreach ($this->playerList as $player)
    {
      if($player->model->is_host)
      {
        return $player;
      }
    }
  }
  
  public function isBoard()
  {
    if(is_null($this->board))
    {
      return false;
    }
    return true;
  }
  
  public function renderBoard()
  {
    if (is_null($this->board))
    {
      return '';
    }
    return (string)$this->board;
  }
  
  public function buyItem(PurchasableInterface $item)
  {   
    if($this->turnCheck())
    {
      $buyer = $this->model->players()->where('user_id', Auth::user()->id)->first();
      if($item->buy($buyer))
      {
        return true;
      }
      throw new Exception('Nie wyszedl buy()');
    }
    throw new Exception('Nie wyszedl turnCheck()');
  }
  
  private function turnCheck()
  {
    $player = Player::where('turn_order',$this->model->current_player)->first();
    if($player->user_id == Auth::user()->id) {
      return true;   
    }
    return false;
  }
}
