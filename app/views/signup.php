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
      <div class="flattop">settlers</div>
      <div class="flattop">of</div>
      <div class="flattop">mechatronics</div>
      <div class="flattop"><?php echo HTML::image('img/WM3.png', 'mchtr'); ?></div>
    </div>
    <?php
    echo Form::open(array('url'=>'signup','class'=>'centered'));
    echo Form::text('nick', null, array('placeholder'=>'nick'));
    echo Form::email('email', null, array('placeholder'=>'email'));
    echo Form::password('password', array('placeholder'=>'password'));
    echo Form::password('password_confirmation', array('placeholder'=>'retype password'));
    foreach ($errors->all() as $error)
    {
      echo "$error<br />";
    }
    echo Form::submit('zarejestruj');
    echo Form::close();
    ?>
  </body>
</html>
