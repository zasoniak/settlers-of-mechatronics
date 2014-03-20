<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <?php echo HTML::style('css/colors.css'); ?>
    <title>Settlers of Mechatronics</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $.getJSON("<?php echo URL::to('ajax/board'); ?>",{game_id:<?php echo Request::segment(2); ?>})
              .done(function(data){
                  $.each(data.tiles, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .append($("<span>").html(item.prob))
                            .appendTo("#board");
                  });
                  $.each(data.settlements, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
                  $.each(data.roads, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
              });
      loadJSON();
      $("#build_button").click(function(){
        $("#slide1").slideToggle('300');
        $("#slide2").slideUp('300');
        $(".trade").slideUp('300');
        $(".road.active").hide('800');
        $(".settle.active").hide('800');
        $(".res_card p").removeClass("trading");
      });
      $("#build_settle").click(function(){
        $(".road.active").hide('800');
        $(".settle.active").toggle('400');
      });
      $("#build_road").click(function(){
        $(".settle.active").hide('800');
        $(".road.active").toggle('400');
      });
      $("#buy_card_button").click(function(){
        $("#slide2").slideToggle('300');
        $("#slide1").slideUp('300');
        $(".trade").slideUp('300');
        $(".res_card p").removeClass("trading");
      });
      $("#trade_button").click(function(){
        $(".res_card p").toggleClass("trading");
        $(".res_card p").removeClass("stop");
        $(".trade").slideToggle(300);
        $(".stats").slideToggle('300');
        $("#offers").slideToggle('300');
        $("#slide1").slideUp('300');
        $("#slide2").slideUp('300');
        $(".road.active").hide('800');
        $(".settle.active").hide('800');
      });
      $("#endturn").click(function(){
        loadJSON();
      });
      $(document).on("click",".settle.active",function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"settlement", id:$(this).attr("settle") })
                .done(function(data){
                  loadJSON();
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      $(document).on("click",".road.active",function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"road", id:$(this).attr("road") })
                .done(function(data){
                  loadJSON();
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      $("#loadjson").click(function(){
        loadJSON();
      });
      function loadJSON() {
    $.getJSON("<?php echo URL::to("game/".$game->model->id."/update"); ?>")
                .done(function(data){
                  $("#board").find(".road").remove();
                  $("#board").find(".settle").remove();
                  $.each(data.board.settlements, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
                  $.each(data.board.roads, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
                  $.each(data.opponents, function(index,item){
                    $("[player="+index+"]").find("td").last().html(item.resources);
                  });
                  $.each(data.player.resources, function(index,item){
                    var card = $(".res_card."+index);
                    if(item == 0)
                    {
                      card.addClass("greyscale");
                      card.find("p").html("");
                    }
                    else
                    {
                      card.removeClass("greyscale");
                      card.find("p").html(item);
                    }
                  });
                  $("#die1").html(data.dice[0]);
                  $("#die2").html(data.dice[1]);
                })
                .error(function(data){
                  alert(data.responseText);
                });
      };
    });
    
    </script>
  </head>
  <body>
    <aside>
      <?php foreach($game->getOpponents() as $player): ?>
      <div class="usercard" player="<?php echo $player->model->id; ?>">
        <figure><?php echo HTML::image('img/'.$player->model->user->image, 'morda', array('class'=>$player->model->color)); ?></figure>
        <figcaption><?php echo $player->model->user->nickname; ?></figcaption>
        <div class="stats">
        <table>
          <tr>
            <th>S</th>
            <td></td>
          </tr>
          <tr>
            <th>R</th>
            <td><?php echo $player->model->countResources(); ?></td>
          </tr>
        </table>
        </div>
      </div>
      <div class="panel" id="offers">
        <div class="offer" id="player1">
          <table>
          <tr>
            <th><div class="wood"></div></th>
            <td>-2</td>
          </tr>
          <tr>
            <th><div class="stone"></div></th>
            <td>+1</td>
          </tr>
        </table>
        </div>
        <div class="offer" id="player2">
          
        </div>
        <div class="offer" id="player3">
          
        </div>
      </div>
      <?php endforeach; ?>
      <div class="panel">
        <?php
          $resources['wood']=$game->model->players()->where('user_id',Auth::user()->id)->first()->wood;
          $resources['stone']=$game->model->players()->where('user_id',Auth::user()->id)->first()->stone;
          $resources['sheep']=$game->model->players()->where('user_id',Auth::user()->id)->first()->sheep;
          $resources['clay']=$game->model->players()->where('user_id',Auth::user()->id)->first()->clay;
          $resources['wheat']=$game->model->players()->where('user_id',Auth::user()->id)->first()->wheat;
        ?>
        <?php foreach($resources as $type=>$count): ?>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale <?php echo $type; ?>">
            <p class="stop"></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php 
      if(!$game->isBoard() && $game->getHost()->model->user->id == Auth::user()->id)
      {
        echo HTML::link("game/".$game->model->id."/start", 'rozpocznij grę');
      }
      ?>
      <?php echo Session::get('message'); ?>
      <?php if($game->isBoard()) : ?>
      <a id="loadjson">Pobierz JSON</a>
      Graczy: <?php echo $game->model->players()->count(); ?>
      Tura: <?php echo $game->model->turn_number; ?>
      Obecny gracz: <?php echo $game->model->players()->where('turn_order',$game->model->current_player)->first()->user->nickname;?>  
      <?php endif; ?>
      <div class="panel">
        <div class="button">
          <a href="#" id="build_button"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
        </div>
        <div class="button">
          <a href="#" id="trade_button"><?php echo HTML::image('img/exchange_icon.png', 'exchange'); ?></a>
        </div>
        <div class="button">
          <a href="#" id="buy_card_button"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
        </div>
        <div class="button">
          <a href="<?php echo $game->model->id ?>/next" class="endturn"><?php echo HTML::image('img/hourglass_icon.png', 'hourglass'); ?></a>
        </div>
      </div>
      <div class="panel" id="slide1">
        <div class="button">
          <a href="#" id="build_settle"><?php echo HTML::image('img/icon_house.png', 'hammer'); ?></a>
        </div>
        <div class="button">
          <a href="#" id="build_city"><?php echo HTML::image('img/icon_city.png', 'exchange'); ?></a>
        </div>
        <div class="button">
          <a href="#" id="build_road"><?php echo HTML::image('img/icon_road.png', 'cards'); ?></a>
        </div>
      </div>
      <div class="panel" id="slide2">
        A tu się będzie kupowało karcioszki!</br>
        Stasiu, jebnij tu jakieś takie obrazki z kartami. Na razie wrzucam zdjęcie znanej japońskiej korporacji :P
        <?php echo HTML::image('img/sony.jpg');?>
      </div>
    </aside>
    <div id="whole">
      <div id="board"></div>
    </div>
  </body>
</html>
