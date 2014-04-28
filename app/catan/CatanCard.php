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

  public function play($data = array())
  {
    $player = $this->model->player;
    if ($this->model->type == 'yearofplenty' && array_sum($data['offer']) != 2)
    {
      throw new Exception('Co za dużo, to nie zdrowo...');
    }
    if ($player->has_played_card == 1)
    {
      throw new Exception('Zagrano już kartę w tej turze.');
    }
    if ($this->model->type == 'victorypoint')
    {
      throw new Exception('Nie można zagrać tej karty!');
    }
    if ($this->model->is_used)
    {
      throw new Exception('Kartę już zagrano wcześniej.');
    }
    $this->model->is_used = 1;
    $this->model->save();
    $player->has_played_card = 1;
    $player->save();
    switch ($this->model->type)
    {
      case 'knight':
        // move thief
        $knights = $player->cards()->used()->where('type','knight')->count();
        if($knights > 2)
        {
          $opponents = $this->model->board->game->getOpponents()->get();
          $flag = true;
          foreach ($opponents as $opponent)
          {
            if($opponent->cards()->used()->where('type','knight')->count() >= $knights)
            {
              $flag = false;
            }
          }
          if($flag)
          {
            $this->model->board->game->getOpponents()->update(array('has_biggest_army'=>0));
            $player->has_biggest_army = 1;
            $player->save();
          }
        }
        break;
      case 'monopoly':
        $resource = $data['resource'];
        $opponents = $this->model->board->game->getOpponents()->get();
        $profit = 0;
        foreach ($opponents as $opponent)
        {
          $profit += $opponent->{$resource};
          $opponent->{$resource} = 0;
          $opponent->save();
        }
        $player->addResource($resource,$profit);
        $player->save();
        break;
      case 'yearofplenty':
        foreach ($data['offer'] as $resource => $quantity)
        {
          $player->addResource($resource,$quantity);
        }
        $player->save();
        break;
      case 'roadbuilding':
        $data['road1']->buy(Player::findByGameByUser($this->model->board->game->id, Auth::user()->id), TRUE);
        $data['road2']->buy(Player::findByGameByUser($this->model->board->game->id, Auth::user()->id), TRUE);
        break;
      default:
        break;
    }
    return true;
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
