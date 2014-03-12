<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/homescreen.css'); ?>
    <title>Settlers of Mechatronics</title>
  </head>
  <body>
    <div id="logo" class="centered">
      <div class="flattop">pioneers</div>
      <div class="flattop">of</div>
      <div class="flattop">mechatronics</div>
      <div class="flattop"><?php echo HTML::image('img/WM3.png', 'mchtr'); ?></div>
    </div>
    <nav class="centered">
      <?php foreach($games as $game): ?>
      <?php echo HTML::link("game/$game->id/join", "gra nr $game->id"); ?>
      <p>
        graczy: <?php echo $game->players()->count(); ?><br />
        utworzono: <?php echo $game->created_at->diffForHumans(); ?>
      </p>
      <?php endforeach; ?>
      <?php echo HTML::link('/', 'wróć'); ?>
    </nav>
  </body>
</html>
