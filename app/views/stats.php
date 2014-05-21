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
    <div class="centered message"><?php echo Session::get('message'); ?></div>
    <nav class="centered">
        
        <?php $user=Auth::user();?>
        <p> gracz: <?php echo $user->nickname;?> </p>
        <p> gier granych: <?php echo $user->games_played;?> </p>
        <p> gier ukończonych: <?php echo $user->games_completed;?> </p>
        <p> gier wygranych: <?php echo $user->games_won;?> </p>
        
      <?php foreach($players as $player): ?>
      <?php echo "gra nr ". $player->game->id; ?>
      <p>punkty: <?php echo $player->points; ?><br /></p>
      <p>surowce zebrane: <?php echo $player->resources_collected; ?><br /></p>
      <p>surowce skradzione: <?php echo $player->resources_stolen; ?><br /></p>
      <p>kupione karty rozwoju: <?php echo $player->cards_bought; ?><br /></p>
      <p>zrealizowane transakcje handlowe: <?php echo $player->transactions_made; ?><br /></p>
      <?php endforeach; ?>
      <?php echo HTML::link('/', 'wróć'); ?>
    </nav>
  </body>
</html>
