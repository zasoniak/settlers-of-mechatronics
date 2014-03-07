<?php

/**
 * Description of CatanBoard
 *
 * @author Konrad Kowalewski
 */
class CatanBoard
{
  /**
   * 
   * @var Board eloquent model
   */
  public $model;
  
  private $fieldList = array();
  private $portList = array();
  private $roadList = array();
  private $settlementList = array();
  private $activeThief;
  
  /**
   * tutaj będzie fajny konstruktor wyciągający z bazy danych obiekty należące
   */
  
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
            $board->tiles()->save($tile);
            // tu można dodać następującą linijkę
            // array_push($this->tilesList, new CatanTile($tile));
            // tylko nie wiem po co, skoro w tym requescie głównie dodajemy do bazy, nie musimy na tym działać
          }
        }
      }
    }
    
    // generowanie portów
    /*
    $portLocations = array();
    $portTypes = array('wood', 'stone', 'clay','sheep','wheat','default','default','default','default');
    shuffle($portTypes);
        $port = new Port();
    $port->type = array_shift($portCollection);
    $tile1 = Tile::findByCoords($board->id, array(1,1,-2));
    $port->tile1 = $tile1->id;
    $tile2 = Tile::findByCoords($board->id, array(1,1,-3));  
    $port->tile2 = $tile2->id;
    $port=$port->save($port);
        
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(0,2,-2));
    $port->tile2 = Tile::findByCoords($board->id, array(-1,3,-2));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(-2,2,0));
    $port->tile2 = Tile::findByCoords($board->id, array(-2,3,-1));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(-2,1,1));
    $port->tile2 = Tile::findByCoords($board->id, array(-3,2,1));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(-2,0,2));
    $port->tile2 = Tile::findByCoords($board->id, array(-3,0,3));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(-1,-1,2));
    $port->tile2 = Tile::findByCoords($board->id, array(-1,-2,3));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(1,-2,1));
    $port->tile2 = Tile::findByCoords($board->id, array(1,-3,2));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(2,-2,0));
    $port->tile2 = Tile::findByCoords($board->id, array(3,-3,0));
    $port->save($port);
    
        $port = new Port();
    $port->type = array_shift($portCollection);
    $port->tile1 = Tile::findByCoords($board->id, array(2,0,-2));
    $port->tile2 = Tile::findByCoords($board->id, array(3,-1,-2));
    $port->save($port);
    */
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
}
