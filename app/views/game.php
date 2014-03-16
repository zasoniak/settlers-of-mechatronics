<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <title>Settlers of Mechatronics</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $(".build").click(function(){
        $(".slide1").slideToggle('300');
        $(".slide2").slideUp('300');
      });
      $(".buy_card").click(function(){
        $(".slide2").slideToggle('300');
        $(".slide1").slideUp('300');
      });
      $(".build_settle").click(function(){
        $(".road.active").hide('800');
        $(".settle.active").toggle('400');
      });
      $(".build_road").click(function(){
        $(".settle.active").hide('800');
        $(".road.active").toggle('400');
      });
      $(".settle").click(function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"settlement", id:$(this).attr("settle") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                });
      });
      $(".road").click(function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"road", id:$(this).attr("road") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                });
      });
      $("#loadjson").click(function(){
        $.getJSON("<?php echo URL::to("game/".$game->model->id."/update"); ?>")
                .done(function(data){
                  $.each(data.tiles, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .append($("<span>").html(item.prob))
                            .appendTo("#jsontarget");
                  });
                  $.each(data.settlements, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#jsontarget");
                  });
                });
      });
    });
    </script>
  </head>
  <body>
    <aside>
      <?php foreach($game->getOpponents() as $player): ?>
      <div class="usercard" player="<?php echo $player->model->id; ?>">
        <figure><?php echo HTML::image('img/WM3.png', 'morda'); ?></figure>
        <table>
          <caption><?php echo $player->model->user->nickname; ?></caption>
          <tbody>
            <tr>
              <th>S</th>
              <td></td>
            </tr>
            <tr>
              <th>R</th>
              <td><?php echo $player->model->countResources(); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>
      Graczy: <?php echo $game->model->players()->count(); ?>
      <nav>
        <div>
          <a href="#" class="build"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
        </div>
        <div>
          <a href="#" class="trade"><?php echo HTML::image('img/exchange_icon.png', 'exchange'); ?></a>
        </div>
        <div>
          <a href="#" class="buy_card"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
        </div>
        <div>
          <a href="<?php echo $game->model->id ?>/next" class="endturn"><?php echo HTML::image('img/hourglass_icon.png', 'hourglass'); ?></a>
        </div>
      </nav>
      <nav class="slide1">
        <div>
          <a href="#" class="build_settle"><?php echo HTML::image('img/icon_house.png', 'hammer'); ?></a>
        </div>
        <div>
          <a href="#" class="build_city"><?php echo HTML::image('img/icon_city.png', 'exchange'); ?></a>
        </div>
        <div>
          <a href="#" class="build_road"><?php echo HTML::image('img/icon_road.png', 'cards'); ?></a>
        </div>
      </nav>
      <nav class="slide2">
        A tu się będzie kupowało karcioszki!</br>
        Stasiu, jebnij tu jakieś takie obrazki z kartami. Na razie wrzucam zdjęcie znanej japońskiej korporacji :P
        <?php echo HTML::image('img/sony.jpg');?>
      </nav>
      <?php 
      if(!$game->isBoard() && $game->getHost()->model->user->id == Auth::user()->id)
      {
        echo HTML::link("game/".$game->model->id."/start", 'rozpocznij grę');
      }
      ?>
      <?php echo Session::get('message'); ?>
      <a href="#" id="loadjson">Pobierz JSON</a>
      Tura: <?php echo $game->model->turn_number; ?>
      Obecny gracz: <?php echo $game->model->players()->where('turn_order',$game->model->current_player)->first()->user->nickname;?>  
      <nav>
        <?php
          $resources['wood']=$game->model->players()->where('user_id',Auth::user()->id)->first()->wood;
          $resources['stone']=$game->model->players()->where('user_id',Auth::user()->id)->first()->stone;
          $resources['sheep']=$game->model->players()->where('user_id',Auth::user()->id)->first()->sheep;
          $resources['clay']=$game->model->players()->where('user_id',Auth::user()->id)->first()->clay;
          $resources['wheat']=$game->model->players()->where('user_id',Auth::user()->id)->first()->wheat;
          foreach($resources as $type=>$count): ?>
        <div class="res_card <?php echo $type; ?>">
          <span>
            <?php echo $count; ?>
          </span>
        </div>
        <?php endforeach; ?>
      </nav>
    </aside>
    <div id="whole">
      <?php echo $game->renderBoard(); ?>
      <div id="jsontarget"></div>
    </div>
  </body>
</html>
