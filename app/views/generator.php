<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php
      $board = CatanBoard::generate();
      $game = CatanGame::generate(User::find(1));
    ?>
  </body>
</html>
