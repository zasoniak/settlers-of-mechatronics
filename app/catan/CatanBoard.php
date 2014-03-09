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
  private $roadList = array();
  private $settlementList = array();
  private $activeThief;
  
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
      foreach ($board->settlements as $i=>$settle)
      {
        $this->settlementList[$i] = new CatanSettlement($settle);
      }
    }
  }
  
  /**
   * tworzy nową planszę i dodaje ją do bazy, po czym na zwraca GameBoard
   */
  public static function generate()
  {
    $board = Board::create(array()); // zapisuje nową instancję boarda do bazy i zwraca
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
    // generowanie portów
    $portLocations = array(
        array(15,10,-25),
        array(-5,25,-20),
        array(-20,25,-5),
        array(-25,15,10),
        array(-25,0,25),
        array(-10,-15,25),
        array(10,-25,15),
        array(25,-25,0),
        array(25,-5,-20)
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
    for($x=-2;$x<=2;$x++){
        for($y=-2;$y<=2;$y++) {
            for($z=-2;$z<=2;$z++) {
        	
     * if(($x+$y+$z)==0)
        	{
                    //sprawdzic jak to bedzie by wygenerować algorytm ktory nie bedzie powtarzal miejsc wspolnych dla sasiednich tile'i????
                    
                    //sprawdza wszystkie krawędzie danego tile'a
                    {
                        $road;
                        if(!Road::findByTiles(array(Tile::findByCoords($board->id, array($x,$y,$z))->id,Tile::findByCoords($board->id, array($x+1,$y-1,$z))->id))) {
                            $road = new Road();
                            $road->player_id=0;
                            $road->tile1_id=Tile::findByCoords($board->id, array($x,$y,$z))->id;
                            $road->tile2_id=Tile::findByCoords($board->id, array($x+1,$y-1,$z))->id;
                            $road->save();
                        }
                        if(!Road::find(tile::find(x,y,z),tile::find(x+1,y-1,z)))
        	Road::create(tile::find(x,y,z),tile::find(x+1,y-1,z))

	       	if(!Road::find(tile::find(x,y,z),tile::find(x+1,y,z-1)))
        	Road::create(tile::find(x,y,z),tile::find(x+1,y,z-1))

       		if(!Road::find(tile::find(x,y,z),tile::find(x,y+1,z-1)))
        	Road::create(tile::find(x,y,z),tile::find(x,y+1,z-1))

       		if(!Road::find(tile::find(x,y,z),tile::find(x-1,y+1,z)))
        	Road::create(tile::find(x,y,z),tile::find(x-1,y+1,z))

        	if(!Road::find(tile::find(x,y,z),tile::find(x-1,y,z+1)))
        	Road::create(tile::find(x,y,z),tile::find(x-1,y,z+1))

        	if(!Road::find(tile::find(x,y,z),tile::find(x,y-1,z+1)))
        	Road::create(tile::find(x,y,z),tile::find(x,y-1,z+1))

                             
                    }
                    {
                        //sprawdzić jak dodawać bez powtórzeń
                        $settlement;
                        if(!Settlement::findByTiles(array($board->id, array(Tile::findByCoords(array($x,$y,$z))->id, Tile::findByCoords($board->id, array($x+1,$y-1,$z))->id, Tile::findByCoords($board->id, array($x+1,$y,$z-1))->id))));
                         $settlement=new Settlement();
                         $settlement->player_id=0;
                         $settlement->tile1_id=Tile::findByCoords($board->id, array($x,$y,$z))->id;
                         $settlement->tile2_id=Tile::findByCoords($board->id, array($x+1,$y-1,$z))->id;
                         $settlement->tile3_id=Tile::findByCoords($board->id, array($x+1,$y,$z-1))->id;
                         $settlement=$settlement->save($settlement);
                         
        	if(!Settlement::find(tile::find(x,y,z),tile::find(x+1,y-1,z),tile::find(x+1,y,z-1)))
        	Settlement::create(tile::find(x,y,z),tile::find(x+1,y-1,z),tile::find(x+1,y,z-1))

	        if(!Settlement::find(tile::find(x,y,z),tile::find(x+1,y,z-1),tile::find(x,y+1,z-1)))
	        	Settlement::create(tile::find(x,y,z),tile::find(x+1,y,z-1),tile::find(x,y+1,z-1))

	        if(!Settlement::find(tile::find(x,y,z),tile::find(x-1,y+1,z),tile::find(x,y+1,z-1)))
	        	Settlement::create(tile::find(x,y,z),tile::find(x-1,y+1,z),tile::find(x,y+1,z-1))

	        if(!ettlement::find(tile::find(x,y,z),tile::find(x-1,y+1,z),tile::find(x-1,y,z+1)))
	        	Settlement::create(tile::find(x,y,z),tile::find(x-1,y+1,z),tile::find(x-1,y,z+1))

	        if(!Settlement::find(tile::find(x,y,z),tile::find(x,y-1,z+1),tile::find(x-1,y,z+1)))
	        	Settlement::create(tile::find(x,y,z),tile::find(x,y-1,z+1),tile::find(x-1,y,z+1))

	        if(!Settlement::find(tile::find(x,y,z),tile::find(x,y-1,z+1),tile::find(x+1,y-1,z)))
	        	Settlement::create(tile::find(x,y,z),tile::find(x,y-1,z+1),tile::find(x+1,y-1,z))           
                    }
                    
                }
            }
        }
    }
    */
    $instance = new self();
    $instance->model = $board;
    return $instance;
  }
  
  public function __toString()
  {
    $return = '<div id="whole"><div id="board">';
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
    for ($i = 0; $i < 54; $i+=1)
    {
      if(isset($this->settlementList[$i]))
      {
        $return .= $this->settlementList[$i];
      }
    }
    $return .= '</div></div>';
    return $return;
  }
}
