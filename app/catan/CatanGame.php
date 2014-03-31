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
    $game = Game::create(array()); // new database game record
    $instance = new self($game);
    //dodanie hosta gry
    $instance->addPlayer($user,true);
    return $instance;
  }

  public function start() 
  {
    //generacja planszy
    $board = CatanBoard::generate($this->model);
    $order=1;
    foreach($this->model->players as $player)
    {
      $player->turn_order=$order;
      $order++;
      $player->save();
    } 
  }
  
  public function endMove()
  {
    $this->isWinner();
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
    $this->throwDice();
  }
  
  public function endMoveZero()
  {
    $playersQuantity = $this->model->players()->count();
    $player = $this->model->currentPlayer();
    if($player->countSettles() == 1 && $this->model->current_player < $playersQuantity)
    {
      $this->model->current_player++;
    }
    if ($player->countSettles() == 2)
    {
      if($this->model->current_player == 1)
      {
        $this->model->turn_number = 1;
        $this->throwDice();
      }
      else
      {
        $this->model->current_player--;
      }
    }
    $this->model->save();
    /*
    //$playersQuantity=4;
     //jesli doszedl do konca nowa tura
    if($this->model->current_player==$playersQuantity)
    {
    	if($turn==1)
    	{
            $this->model->current_player--;
    	}
        else
        {
            $this->model->turn_number++;
        }
    }
    else //inaczej następny gracz
    { 
      //tura 1 -> 4...3...2...1
      if($this->model->turn_number==1)
      {
      	//o ile nie doszło z powrotem do pierwszego gracza
      	if($this->model->current_player!=1)
      	{
      		$this->model->current_player--;
      	}
      	else
      	{
      		$this->model->turn_number++;
                $this->throwDice();
      	}
      }
      else   //tura 0 -> 1...2..3...4
      {
          $this->model->current_player++;
      }
      	
    }
    $this->model->is_changed=1;
    $this->model->save();
     * 
     */
  }
  
 public function throwDice()
  {
    $this->model->dice1 = mt_rand(1, 6);
    $this->model->dice2 = mt_rand(1, 6);
    $this->model->save();
    $dice=$this->model->dice1+$this->model->dice2;
    
    if($dice==7)
    {
      $this->model->active_thief=1;
      $this->model->save();
      foreach($this->model->players as $player)
      {
          $player->stealHalf();
      }
      //send request for a player to move thief
    }
    
    else
    {
      foreach($this->board->model->findDicedTiles($dice) as $tile)
      {          
        if($this->model->thief_location != $tile->id)
        {
          foreach($tile->nearestSettles() as $settle)
          {
            if ($settle->player_id != NULL)
            {
              $player = $settle->player;
              if ($settle->is_town)
              {
                $player->addResource($tile->type, 2);
              }
              $player->addResource($tile->type, 1);
              $player->save();
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
  
  public function buyItem($itemname,$id)
  {
    $buyer = $this->model->players()->where('user_id', Auth::user()->id)->first();
    if($itemname == 'card')
    {
      $item = new CatanCard($this->board->model->availableCard());
    }
    elseif ($itemname == 'town')
    {
      $item = $this->board->settlementList[(int)$id];
      if($item->upgrade($buyer))
      {
        return true;
      }
      return false;
    }
    else
    {
      $item = $this->board->{$itemname.'List'}[(int)$id];
    }
    if($item->buy($buyer))
    {
      return true;
    }
    return false;
  }
  
  public function settleItem($itemname,$id)
  {
    $buyer = $this->model->players()->where('user_id', Auth::user()->id)->first();
    if($itemname == 'settlement')
    {
      if($buyer->countSettles() > $buyer->countRoads())
      {
        throw new Exception('Nie ma aż tyle za darmo...');
      }
      $item = $this->board->settlementList[(int)$id];
      $item->buy($buyer,true);
      $roads = $item->model->nearestRoads();
      $return = array();
      foreach ($roads as $road)
      {
        if(!is_null($road))
        { 
          array_push($return, $this->board->roadList[$road->id]->toJSON());
        }
      }
      return $return;
    }
    if ($itemname == 'road')
    {
      if($buyer->countSettles() <= $buyer->countRoads())
      {
        throw new Exception('Coś kombinujesz...');
      }
      $item = $this->board->roadList[(int)$id];
      $item->buy($buyer,true);
      $this->endMoveZero();
      return null;
    }
    throw new Exception('Coś musiałeś przeskrobać.');
  }
  
  public function toJSON()
  {
    $opponents = array();
    foreach ($this->getOpponents() as $player)
    {
      $opponents[$player->model->id] = $player->toJSON();
    }
    return array(
        'turn' => $this->model->turn_number,
        'player' => $this->playerList[Player::findByGameByUser($this->model->id, Auth::user()->id)->id]->toJSON(false),
        'opponents' => $opponents,
        'dice' => array($this->model->dice1,$this->model->dice2),
        'board' => $this->board->toJSON()
    );
  }
  public function isWinner()
  {
    $player = Player::findByGameByUser($this->model->id, Auth::user()->id);
    if($player->getScore() >= 10)
    {
      $winner=$player->user;
      $winner->games_won+=1;
      $winner->save();
      $this->endGame();
    }
  }
  
  public function endGame()
  {
    foreach($this->model->players as $player)
    {
      $user = $player->user;
      $user->games_completed += 1;
      $user->save();
    }
  }
    
  public function tradeRequest($offer, $clients = NULL)
  {
    // TODO należy sprawdzić, czy host ma tyle hajsiwa
    $player = Player::findByGameByUser($this->model->id, Auth::user()->id);
    if (count($clients) == 0)
    {
      return $this->tradeBank($player,$offer);
    }
    else
    {
      foreach ($clients as $client)
      {
        $trade = Trade::makeOffer($offer);
        $trade->host_id = $player->id;
        $trade->client_id = $client;
        $trade->save();
      }
    }
    return true;
  }
  
  public function tradeBank($player, $offers)
  {
      //odczytujemy settlementy przy portach i sprawdzamy ktore naleza do gracza
      $bonuses=array();
      foreach($this->board->model->ports as $port)
      {
          $settles=$port->nearestSettlements();
          foreach($settles as $settle)
          {
              if(!is_null($settle) && !is_null($settle->player_id) && $settle->player_id == $player->id)
              {
                array_push($bonuses, $port->type);
              }
          }
      }
      //sprawdzamy oferte, jesli mamy ten bonus liczymy korzystniej
      $givenResources=0;
      $gainedResources=0;
      if(array_search('default',$bonuses)!==false)
      {
          foreach($offers as $resource => $quantity)
          {
              if($quantity<0)
              {
                if(array_search($resource, $bonuses))
                {
                    $givenResources+= $quantity/2;
                } else {
                    $givenResources+= $quantity/3;
                }
              } else {
                  $gainedResources+=$quantity;
              } 
          }
      }
      else
      {
          foreach($offers as $resource => $quantity)
          {
              if($quantity<0)
              {
                if(array_search($resource, $bonuses) !== false)
                {
                    $givenResources+= $quantity/2;
                } else {
                    $givenResources+= $quantity/4;
                }
              } else {
                  $gainedResources+=$quantity;
              }
            
          }
      }
      if($gainedResources+$givenResources!=0)
      {
          throw new Exception('zła ilość surowców');
      }
      
    foreach($offers as $resource => $quantity)
    {
         $player->addResource($resource,(int)$quantity);
    }
    $player->save();
    return true;
  }
}
