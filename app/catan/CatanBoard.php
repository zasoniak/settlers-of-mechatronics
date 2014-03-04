<?php

/**
 * Description of Board
 *
 * @author konrad
 */
class Board
{
  /**
   * 
   * @var Board board model
   */
    public $board;
  
  private $fieldList = array();
  private $portList = array();
  private $roadList = array();
  private $settelmentList = array();
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
  
  /**
   * creating fields: 4 wood, 3 stone, 3 clay, 4 sheep, 4 wheat and dessert = 19 fields
   */
  private function generateFields()  {
      $fieldCollection = array('wood','wood','wood','wood','stone','stone','stone','clay','clay','clay','sheep','sheep','sheep','sheep','wheat','wheat','wheat','wheat','dessert');
      
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
