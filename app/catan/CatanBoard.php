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
  
  private $filedList = array();
  private $portList = array();
  private $roadList = array();
  private $settelmentList = array();
  private $activeThief;
  
  public function __construct() {
      //dodaje nowy board do bazy
  }
}
