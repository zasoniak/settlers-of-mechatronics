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
        $.post("<?php echo URL::to("ajax/color"); ?>",{ color:$(this).attr("class"),game_id:<?php echo Request::segment(2);?> })
                .error(function(data){
                  alert(data.responseText);
                })
                .done(function(data){
                  window.location.reload();
                });
      });
    });
    </script>
  </head>
  <body>
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
    <div class="centered players">
      <?php foreach ($game->model->players as $player): ?>
      <div class="usercard" player="<?php echo $player->id; ?>">
        <figure><?php echo HTML::image('img/'.$player->user->image, 'morda', array('class'=>$player->color)); ?></figure>
      </div>
      <?php endforeach; ?>
    </div>
    <nav class="centered">
      <?php
      if(Player::findByGameByUser(Request::segment(2),Auth::user()->id)->color)
      {
        if($game->getHost()->model->user->id == Auth::user()->id)
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
