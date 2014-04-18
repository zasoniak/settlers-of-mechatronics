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
    <?php
    if(Auth::guest()) :
      echo Form::open(array('url'=>'login','class'=>'centered'));
      echo Form::email('email', null, array('placeholder'=>'email'));
      echo Form::password('password', array('placeholder'=>'password'));
      echo Form::submit('zaloguj');
      echo Form::close();
    ?>
    <nav class="centered">
      <?php echo HTML::link('signup', 'zarejestruj się'); ?>
    </nav>
    <?php
    endif;
    ?>
    <?php if(Auth::check()): ?>
    <nav class="centered">
      <?php echo HTML::link('game/create', 'utwórz stół'); ?>
      <?php echo HTML::link('game/my', 'twoje rozpoczęte gry'); ?>
      <?php echo HTML::link('game', 'dołącz do gry'); ?>
      <?php echo HTML::link('logout', 'wyloguj się'); ?>
    </nav>
    <?php endif; ?>
  </body>
</html>
