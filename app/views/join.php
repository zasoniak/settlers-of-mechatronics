<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/homescreen.css'); ?>
    <?php echo HTML::style('css/colors.css'); ?>
    <title>Settlers of Mechatronics</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $("div.colors").find("li").click(function(event){
        $.post("<?php echo URL::to("game/".Request::segment(2)."/join"); ?>",{ color:$(this).attr("class") })
                .error(function(data){
                  alert("coś się nie udało!");
                })
                .done(function(data){
                  window.location.replace("<?php echo URL::to("game/".Request::segment(2)); ?>");
                });
      });
    });
    </script>
  </head>
  <body>
    <div id="logo" class="centered">
      <div class="flattop">pioneers</div>
      <div class="flattop">of</div>
      <div class="flattop">mechatronics</div>
      <div class="flattop"><?php echo HTML::image('img/WM3.png', 'mchtr'); ?></div>
    </div>
    <p class="centered">
      Za chwilę dołączysz do gry. Wybierz kolor, jakim będziesz się w tej grze posługiwać:
    </p>
    <div class="centered colors">
      <ul>
        <li class="red"></li>
        <li class="orange"></li>
        <li class="yellow"></li>
        <li class="green"></li>
        <li class="blue"></li>
        <li class="violet"></li>
      </ul>
    </div>
  </body>
</html>
