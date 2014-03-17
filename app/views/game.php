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
      $("#build_button").click(function(){
        $("#slide1").slideToggle('300');
        $("#slide2").slideUp('300');
        $(".trade").slideUp('300');
        $(".road.active").hide('800');
        $(".settle.active").hide('800');
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
      });
      $("#trade_button").click(function(){
        $(".trade").slideToggle();
        $("#slide1").slideUp('300');
        $("#slide2").slideUp('300');
        
      });
      $(document).on("click",".settle.active",function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"settlement", id:$(this).attr("settle") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                  loadJSON;
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      $(document).on("click",".road.active",function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"road", id:$(this).attr("road") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                  loadJSON;
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
                  $("#board").html("");
                  $.each(data.board.tiles, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .append($("<span>").html(item.prob))
                            .appendTo("#board");
                  });
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
                    $(".res_card."+index).find("span").html(item);
                  });
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
        <figure><?php echo HTML::image('img/sony.jpg', 'morda', array('class'=>$player->model->color)); ?></figure>
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
      <div>
      Graczy: <?php echo $game->model->players()->count(); ?>
      </div>
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
      <?php 
      if(!$game->isBoard() && $game->getHost()->model->user->id == Auth::user()->id)
      {
        echo HTML::link("game/".$game->model->id."/start", 'rozpocznij grę');
      }
      ?>
      <?php echo Session::get('message'); ?>
      <?php if($game->isBoard()) : ?>
      <a id="loadjson">Pobierz JSON</a>
      Tura: <?php echo $game->model->turn_number; ?>
      Obecny gracz: <?php echo $game->model->players()->where('turn_order',$game->model->current_player)->first()->user->nickname;?>  
      <?php endif; ?>
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
          <div class="trade">
            <div class="trade_up"></div>
            <div class="trade_quantity">0</div>
            <div class="trade_down"></div>
          </div>
          <div class="res_card <?php echo $type; ?>">
            <span>
              <?php echo $count; ?>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </aside>
    <div id="whole">
      <div id="board"></div>
    </div>
  </body>
</html>
