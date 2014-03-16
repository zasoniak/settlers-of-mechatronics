<?php

/**
 * Description of Player
 *
 * @author Konrad Kowalewski
 */
class CatanPlayer
{
  /**
   *
   * @var Player player's eloquent model
   */
  public $model;
  
  public function __construct(Player $player)
  {
    $this->model = $player;
  }
  
  public function addResource(Tile $tile, $isTown)
  {
      if($isTown)
      {
          $this->model->{$tile->type}+=2;
      }else
      {
          $this->model->{$tile->type}+=1;
      }
      $this->model->save();
  }
 
  public function stealFromPlayer($player, $playerThief)
  {
      $resourceList = array('wood', 'stone', 'clay','sheep','wheat');
      shuffle($resource);
      $check=0;
      $resource;
      while(!check ||$resource!=NULL)
      {   
          $resource=array_pop($resourceList);     //losuje surowiec
          if($player->{$resource}!=0)             //jeśli go posiada
          {
              $player->{$resource}-=1;            //zabiera 1 graczowi
              $playerThief->{$resource}+=1;      //dodaje 2 graczowi
              $check=1;
          }
      }   
  }
  
  public function toJSON($hidden = true)
  {
    if($hidden)
    {
      return array(
          'resources' => $this->model->countResources()
      );
    }
    return array(
        'resources' => $this->model->getResources()
    );
  }
}
