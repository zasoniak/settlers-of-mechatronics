<?php

/**
 * Description of Board
 *
 * @author konrad
 */
class CatanBoard
{
  /**
   * 
   * @var Board board model
   */
    public $board;
  
  private $fieldList = array();
  private $portList = array();
  private $roadList = array();
  private $settlementList = array();
  private $activeThief;
  
  /**
   * tutaj będzie bardzo rozbudowany konstruktor 
   * wywołujący elementy zgodnie z zasadami planszy dla catana
   * 
   * trzeba zapewnić logiczną całość i wrzucić wszystko do bazy
   */
  
  public function __construct() {
      $this->board = Board::create();      //dodaje nowy board do bazy
      
      
      $this->generateFields(); //create fields
      $this->generatePorts(); //create ports

  }
  
  public static function generate(){
      $board= new CatanBoard();
      
      $board->generateFields();
      $board->generatePorts();
      
  }
  
  
  
  
  
  /**
   * creating fields: 4 wood, 3 stone, 3 clay, 4 sheep, 4 wheat and dessert = 19 fields
   */
  private function generateFields()  {
      $fieldCollection = array('wood','wood','wood','wood','stone','stone','stone','clay','clay','clay','sheep','sheep','sheep','sheep','wheat','wheat','wheat','wheat','dessert');
      
      for($x=-3;$x<=3;$x++) {
          for($y=-3;$y<=3;$y++) {
              for($z=-3;$z<=3;$z++) {
                  // tu wkleić kod Konrada co do bazy danych :P
              }
          }
      }
      while($fieldCollection!=NULL)
      {
           array_push($this->fieldList, new CatanField(array_rand($fieldCollection))); 
      }

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
