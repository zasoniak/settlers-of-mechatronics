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
      <span id="showGamesList">Gry</span>
      <div id="GamesList">
      <?php foreach($games as $game): ?>
        <span>Gra nr: <?php echo $game->id; ?> </span>
      <div class="admin">
        graczy: <?php echo $game->players()->count(); ?><br />
        utworzono: <?php echo $game->created_at->diffForHumans(); ?><br />
        skończona: <?php echo $game->is_finnished; ?>
      <?php echo HTML::link("game/$game->id/delete", "usuń"); ?>
      </div>
      <?php endforeach; ?>
      </div>
      <span id="showUsersList">Gracze</span>
      <div id="UsersList">
      <?php foreach($users as $user): ?>
      <div class="admin">
        <div>
        <?php echo HTML::image('img/'.$user->image, 'morda'); ?>
        </div>
        <div>
          <p class="nick"><?php echo $user->nickname;?></p><br>
          gier granych: <?php echo $user->games_played;?> <br>
          gier ukończonych: <?php echo $user->games_completed;?><br>
          gier wygranych: <?php echo $user->games_won;?><br>
        <?php echo HTML::link("user/$user->id/delete", "usuń"); ?>
        </div> 
      </div>
      <?php endforeach; ?>
      </div>
      <?php echo HTML::link('/', 'wróć'); ?>
    </nav>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
