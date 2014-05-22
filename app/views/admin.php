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
      <div class="flattop">Admin</div>
      <div class="flattop">mode</div>
      <div class="flattop">enabled</div>
      <div class="flattop"><?php echo HTML::image('img/WM3.png', 'mchtr'); ?></div>
    </div>
    <div class="centered message"><?php echo Session::get('message'); ?></div>
    <nav class="centered">
      <p>Gry: </p>
      <?php foreach($games as $game): ?>
      <?php echo HTML::link("game/$game->id/join", "gra nr $game->id"); ?>
      <p>
        graczy: <?php echo $game->players()->count(); ?><br />
        utworzono: <?php echo $game->created_at->diffForHumans(); ?><br />
        skończona: <?php echo $game->is_finnished; ?>
      </p>
      <?php endforeach; ?>
      
      <p>Gracze:</p>
      <?php foreach($users as $user): ?>
      <p>
        Nick: <?php echo $user->nickname; ?>
      </p>
      <?php endforeach; ?>
      <?php echo HTML::link('/', 'wróć'); ?>
    </nav>
  </body>
</html>
