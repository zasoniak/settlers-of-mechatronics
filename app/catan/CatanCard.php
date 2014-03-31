<?php
/**
 * Description of CatanCard
 *
 * @author Konrad Kowalewski
 */
class CatanCard implements PurchasableInterface
{
  /*
   * @var Card card's Eloquent model
   */
  public $model;
  
  public function __construct(Card $card)
  {
    $this->model = $card;
  }

  public function play()
  {
    $this->model->is_used = 1;
    $this->model->save();
    switch ($this->model->type)
    {
      case 'monopoly':
        break;

      default:
        break;
    }
  }

  public function cost()
  {
      return array('sheep'=>1,'wheat'=>1, 'stone'=>1);
  }

  public function buy(Player $player)
  {
    foreach ($this->cost() as $resource => $quantity)
    {
      if($player->{$resource} < $quantity)
      {
        throw new Exception('Nie stać Cię na to!');
      }
    }
    foreach ($this->cost() as $resource => $quantity)
    {
      $player->{$resource} -= $quantity;
    }
    if(is_null($this->model->player_id))
    {
      $this->model->player_id = $player->id;
    }
    $player->save();
    $this->model->save();
    return true;
  }
  
  public function toJSON()
  {
    return array(
        'classes' => 'dev_card '.$this->model->type,
        'attr' => array('card'=>$this->model->id)
    );
  }
}
