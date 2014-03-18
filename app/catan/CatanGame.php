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
      $this->playerList[$player->id] = new CatanPlayer($player);
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
  
 public function throwDice()
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
            $player->stealHalf();
        }
        //send request for a player to move thief
    }
    else
    {
        foreach($tiles as $tile)
        {          
          if($this->model->thief_location!=$tile->id)
          {
              $neighbours=array(array(5,-5,-5),array(-5,5,-5),array(-5,-5,5),array(5,5,-5),array(5,-5,5),array(-5,5,5));
              foreach($neighbours as $neighbour)
              {
                  $settle=Settlement::findByCoords($tile->board->id, array($tile->x+$neighbour[0],$tile->y+$neighbour[1],$tile->z+$neighbour[2]));
                  if(!is_null($settle))
                  {
                      if($settle->player_id!=NULL)
                      {
                        if($settle->is_town)
                        {
                            $settle->player()->first()->addResource($tile->type,2);
                        }
                        $settle->player()->first()->addResource($tile->type,1);
                      }
                  }
              }
           }
        }
    }
  }
  
  public function getPlayers()
  {
    return $this->playerList;
  }
  
  public function getOpponents()
  {
    $return = array();
    foreach($this->playerList as $player)
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
    $buyer = $this->model->players()->where('user_id', Auth::user()->id)->first();
    if($item->buy($buyer))
    {
      return true;
    }
    return false;
  }
  
  public function toJSON()
  {
    $opponents = array();
    foreach ($this->getOpponents() as $player)
    {
      $opponents[$player->model->id] = $player->toJSON();
    }
    return array(
        'player' => $this->playerList[Player::findByGameByUser($this->model->id, Auth::user()->id)->id]->toJSON(false),
        'opponents' => $opponents,
        'board' => $this->board->toJSON()
    );
  }
}
