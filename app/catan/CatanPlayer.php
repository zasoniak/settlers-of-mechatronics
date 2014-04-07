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
  
  public function getScore()
  {
    return 0;
  }
  
  public function toJSON($hidden = true, $profile = false)
  {
    if($profile)
    {
      return array(
          'photo' => 'img/sony.jpg',
          'nick' => $this->model->nickname,
          'color' => $this->model->color,
          'id' => $this->model->id
      );
    }
    if($hidden)
    {
      return array(
          'resources' => $this->model->countResources()
      );
    }
    $tradereceived = $this->model->tradeReceived;
    if(!is_null($tradereceived))
    {
      $tradereceived = $tradereceived->toArray();
    }
    $cards=array();
    foreach($this->model->cards as $card)
    {
      $catancard = new CatanCard($card);
      $cards[] = $catancard->toJSON();
    }
    return array(
        'resources' => $this->model->getResources(),
        'cards' => $cards,
        'trades_hosted' => $this->model->tradesReturned()->get()->toArray(),
        'trade_received' => $tradereceived,
        'id' => $this->model->id
    );
  }
}
