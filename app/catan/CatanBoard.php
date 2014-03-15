<?php

/**
 * Description of CatanBoard
 *
 * @author Konrad Kowalewski
 */
class CatanBoard implements DrawableInterface
{
  /**
   * 
   * @var Board eloquent model
   */
  public $model;
  
  public $tileMap = array(array(array()));
  private $portList = array();
  public $roadList = array();
  public $settlementList = array();
  
  /**
   * wyciąga z bazy danych obiekty należące do planszy
   */
  public function __construct(Board $board = NULL)
  {
    if ($board instanceof Board)
    {
      $this->model = $board;
      foreach ($board->tiles as $tile)
      {
        $this->tileMap[$tile->x][$tile->y][$tile->z] = new CatanTile($tile);
      }
      foreach ($board->settlements as $settle)
      {
        $this->settlementList[$settle->id] = new CatanSettlement($settle);
      }
      foreach ($board->roads as $road)
      {
        $this->roadList[$road->id] = new CatanRoad($road);
      }
      foreach ($board->ports as $port)
      {
        array_push($this->portList, new CatanPort($port));
      }
    }
  }
  
  /**
   * tworzy nową planszę i dodaje ją do bazy, po czym zwraca GameBoard
   */
  public static function generate(Game $game)
  {
    $board = new Board;
    $board = $game->board()->save($board);
    // generowanie pól
    $probabilities = array(2,3,3,4,4,5,5,6,6,8,8,9,9,10,10,11,11,12);
    $types = array('wood','wood','wood','wood','stone','stone','stone','clay','clay','clay','sheep','sheep','sheep','sheep','wheat','wheat','wheat','wheat','desert');
    shuffle($probabilities);
    shuffle($types);
    for ($x = -30; $x < 31; $x+=10)
    {
      for ($y = -30; $y < 31; $y+=10)
      {
        for ($z = -30; $z < 31; $z+=10)
        {
          if ($x+$y+$z == 0)
          {
            $tile = new Tile();
            $tile->x = $x;
            $tile->y = $y;
            $tile->z = $z;
            if (abs($x) < 30 && abs($y) < 30 && abs($z) < 30)
            {
              $tile->type = array_pop($types);
              if ($tile->type != 'desert')
              {
                $tile->probability = array_pop($probabilities);
              }
            }
            $tile = $board->tiles()->save($tile);
//            array_push($this->tileList, new CatanTile($tile));
          }
        }
      }
    }
    //zapisanie złodzieja
    $tile = $board->tiles()->where('type', 'desert')->first();
    echo $tile->id;
    echo $tile->type;
    $board->thief_location=$tile->id;
    $board->save();
    // generowanie portów
    $portLocations = array(
        array(-10,-15,25),
        array(0,25,-25),
        array(10,-25,15),
        array(25,-10,-15),
        array(-25,0,25),
        array(15,10,-25),
        array(-15,25,-10),
        array(25,-25,0),
        array(-25,15,10)
    );
    $portTypes = array('wood', 'stone', 'clay','sheep','wheat','default','default','default','default');
    shuffle($portTypes);
    foreach ($portLocations as $location)
    {
      $port = new Port();
      $port->type = array_pop($portTypes);
      $port->x = $location[0];
      $port->y = $location[1];
      $port->z = $location[2];
      $board->ports()->save($port);
    }
    // generowanie możliwych osad
    for ($x = -25; $x < 30; $x+=10)
    {
      for ($y = -25; $y < 30; $y+=10)
      {
        for ($z = -25; $z < 30; $z+=10)
        {
          if ($x+$y+$z == 5 || $x+$y+$z == -5)
          {
            $settle = new Settlement();
            $settle->x = $x;
            $settle->y = $y;
            $settle->z = $z;
            $board->settlements()->save($settle);
          } 
        }
      }
    }
    // generowanie dróg
    for ($x = -20; $x < 21; $x+=10)
    {
      for ($y = -25; $y < 26; $y+=10)
      {
        for ($z = -25; $z < 26; $z+=10)
        {
          if($x+$y+$z == 0)
          {
            $road = new Road();
            $road->x = $x;
            $road->y = $y;
            $road->z = $z;
            $board->roads()->save($road);
          }
        }
      }
    }
    for ($z = -20; $z < 21; $z+=10)
    {
      for ($y = -25; $y < 26; $y+=10)
      {
        for ($x = -25; $x < 26; $x+=10)
        {
          if($x+$y+$z == 0)
          {
            $road = new Road();
            $road->x = $x;
            $road->y = $y;
            $road->z = $z;
            $board->roads()->save($road);
          }
        }
      }
    }
    for ($y = -20; $y < 21; $y+=10)
    {
      for ($x = -25; $x < 26; $x+=10)
      {
        for ($z = -25; $z < 26; $z+=10)
        {
          if($x+$y+$z == 0)
          {
            $road = new Road();
            $road->x = $x;
            $road->y = $y;
            $road->z = $z;
            $board->roads()->save($road);
          }
        }
      }
    }
    /*
      //generacja zestawu kart do gry  
      $CardTypeList = array('knight', 'yearOfPleanty', 'roadBuilding', 'victoryPoint', 'monopoly');
      for($i=0;$i<14;$i++) {
          $card = new Card();
          $card->type=$CardTypeList[rand(0,4)];
          $card = $board->cards()->save($card);
          }
    
    */
    return new self($board);
  }
  
  public function __toString()
  {
    $return = '<div id="board">';
    for ($z = -30; $z < 31; $z+=10)
    {
      for ($x = -30; $x < 31; $x+=10)
      {
        $y = 0-$x-$z;
        if(isset($this->tileMap[$x][$y][$z]))
        {
          $return .= $this->tileMap[$x][$y][$z];
        }
      }
    }
    foreach($this->roadList as $road)
    {
      $return .= $road;
    }
    foreach($this->settlementList as $settle)
    {
      $return .= $settle;
    }
    foreach($this->portList as $port)
    {
      $return .= $port;
    }
    $return .= "</div>";
    return $return;
  }
}
