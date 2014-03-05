<?php

/**
 * Description of Board
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
    $probabilities = array(2,3,3,4,4,5,5,6,6,8,8,9,9,10,10,11,11,12);
    $types = array('wood','wood','wood','wood','stone','stone','stone','clay','clay','clay','sheep','sheep','sheep','sheep','wheat','wheat','wheat','wheat','desert');
    shuffle($probabilities);
    shuffle($types);
    for ($x = -3; $x < 4; $x++)
    {
      for ($y = -3; $y < 4; $y++)
      {
        for ($z = -3; $z < 4; $z++)
        {
          if ($x+$y+$z == 0)
          {
            $tile = new Tile();
            $tile->x = $x;
            $tile->y = $y;
            $tile->z = $z;
            if (abs($x) < 3 && abs($y) < 3 && abs($z) < 3)
            {
              $tile->type = array_shift($types);
              if ($tile->type != 'desert')
              {
                $tile->probability = array_shift($probabilities);
              }
            }
            $tile = $board->tiles()->save($tile);
            // tu można dodać następującą linijkę
            // array_push($this->tilesList, new CatanTile($tile));
            // tylko nie wiem po co, skoro w tym requescie głównie dodajemy do bazy, nie musimy na tym działać
          }
        }
      }
    }
    $instance = new self();
    $instance->model = $board;
    return $instance;
  }
  
  /**
   * creating ports and locating them
   */
  private function generatePorts()  {
      //default port collection available on board
      $portCollection = array('wood', 'stone', 'clay','sheep','wheat','default','default','default','default');
      
      while($portCollection!=NULL)
      {
          array_push($this->portList, new CatanPort(array_rand($portCollection)));
      }
  }
}
