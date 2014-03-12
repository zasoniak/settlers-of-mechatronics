<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php

      $game = new CatanGame(Game::find(17));
      $game->endMove();
      $game->throwDice();
      foreach ($game->model->players()->get() as $player)
      {
          echo $player->id;
      }
      $board=$game->model->board()->first();
      $game->buy(24, new CatanSettlement(Settlement::findByCoords($board->id, array(-5,5,5))));

    ?>
  </body>
</html>
