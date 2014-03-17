<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php

      $game = new CatanGame(Game::find(9));
      $game->endMove();
      $game->throwDice();
    ?>
  </body>
</html>
