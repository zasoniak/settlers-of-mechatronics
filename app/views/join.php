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
        var color = $(this).attr("class")
        $.post("ajax/color",{ color:color,game_id:<?php echo Request::segment(2);?> })
                .error(function(data){
                  alert(data.responseText);
                })
                .done(function(data){
                  window.location.reload();
                });
      });
      $("li").find("img").parent().addClass("busy");
      $(document).on("click","nav a",function(event){
        $(this).hide();
        $("#load").show();
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
    <div class="centered message"><?php echo Session::get('message'); ?></div>
    <p class="centered">
      Za chwilę dołączysz do gry. Wybierz kolor, jakim będziesz się w tej grze posługiwać:
    </p>
    <div class="centered colors">
      <?php
        $colors=array("red","orange","yellow","green","blue","violet");
        foreach ($colors as $color):?>
        <li class="<?php echo $color;?>">
          <?php if(array_key_exists($color, $players))
          {
            echo HTML::image('img/'.$players[$color]->user->image, 'morda');
          }
          ?>
        </li>
        <?php endforeach; ?>
    </div>
    <div class="centered" id="load">
      <div class="ring" id="loading">
        <span>Ładowanie...</span>
        <div>
          <div class="ring"></div>
            
        </div>
      </div>
    </div>
    <nav class="centered">
      <?php
      if(Player::findByGameByUser(Request::segment(2),Auth::user()->id)->color)
      {
        if(($game->getHost()->model->user->id == Auth::user()->id)&&($game->model->players()->count() > 1))
        {
          echo HTML::link("game/".$game->model->id."/start", 'rozpocznij grę');
        }
        else
        {
          if($game->isBoard())
          {
            echo HTML::link("game/".$game->model->id, 'dołącz do gry');
          }
        }
      }
      ?>
    </nav>
  </body>
</html>
