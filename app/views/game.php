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
                            .hide()
                            .addClass(item.classes)
                            .css(item.styles)
                            .append($("<span>").html(item.prob))
                            .append($("<div class=\"face1\"></div>"))
                            .append($("<div class=\"face2\"></div>"))
                            .appendTo("#board")
                            .delay(20*index)
                            .slideDown(200);
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
                  $.each(data.ports, function(index,item){
                    $("<div>")
                            .hide()
                            .addClass(item.classes)
                            .css(item.styles)
                            .appendTo("#board")
                            .delay(720) 
                            .slideDown(200);
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
        $(".road.active").hide();
        $(".settle.active").toggle('300');
      });
      $("#build_road").click(function(){
        $(".settle.active").hide();
        $(".road.active").toggle('300');
      });
      $("#buy_card_button").click(function(){
        $("#slide2").slideToggle('300');
        $("#slide1").slideUp('300');
        $(".trade").slideUp('300');
        $(".res_card p").removeClass("trading");
      });
      $("#trade_button").click(function(){
        $(".road.active").hide();
        $(".settle.active").hide();
        $(".res_card p").toggleClass("trading");
        $(".resource").removeClass("on");
        $(".trade").slideToggle('300');
        $(".usercard figure").toggleClass("clickable");
        $("#slide1").slideUp('300');
        $("#slide2").slideUp('300');
        $("#trade_submit").toggle('300');
      });
      $(document).on("click","figure.clickable",function(event){
        var usercard = $(this).parent().parent();
        usercard.toggleClass("trading");
        usercard.find(".offer").slideToggle(150);
        usercard.find(".stats").slideToggle(150);
      });
      $(".trade.up").click(function(){
        var res = $(this).parent().find(".res_card").attr("res");
        var span = $(".offer").find("."+res);
        var q = (+span.html())+1;
        span.html(q);
        $("#trade_form").find("[res="+res+"]").val(q);
      });
      $(".trade.down").click(function(){
        var res = $(this).parent().find(".res_card").attr("res");
        var span = $(".offer").find("."+res);
        var q = (+span.html())-1;
        span.html(q);
        $("#trade_form").find("[res="+res+"]").val(q);
      });
      $("#trade_submit").click(function(){
        $.post("<?php echo URL::to('ajax/trade') ?>", $("#trade_form").serialize())
                .done(function(){
                  alert("jupi!");
                })
                .error(function(){
                  alert("zjebało się");
                });
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
                  $.each(data.board.settlements, function(index,item,i){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board")
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
                      card.find("p span").first().html("");
                    }
                    else
                    {
                      card.removeClass("greyscale");
                      card.find("p span").first().html(item);
                    }
                  });
                  $.each(data.player.trades_hosted, function(index,item){
                    var div = $("[player="+item.client_id+"]").find(".offer");
                    div.find(".wood").html(item.wood);
                    div.find(".stone").html(item.stone);
                    div.find(".sheep").html(item.sheep);
                    div.find(".clay").html(item.clay);
                    div.find(".wheat").html(item.wheat);
                  });
                  if(data.player.trade_received)
                  {
                    var trade = data.player.trade_received;
                    var usercard = $("[player="+trade.host_id+"]");
                    usercard.addClass("trading");
                    usercard.find(".stats").hide(150);
                    var div = usercard.find(".offer");
                    div.show(150);
                    div.find(".wood").html(trade.wood);
                    div.find(".stone").html(trade.stone);
                    div.find(".sheep").html(trade.sheep);
                    div.find(".clay").html(trade.clay);
                    div.find(".wheat").html(trade.wheat);
                  }
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
      <div id="opponents" class="panel">
        <?php foreach($game->getOpponents() as $player): ?>
        <div class="usercard" player="<?php echo $player->model->id; ?>">
          <label for="player_<?php echo $player->model->id; ?>">
            <figure><?php echo HTML::image('img/'.$player->model->user->image, 'morda', array('class'=>$player->model->color)); ?></figure>
          </label>
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
          <div class="offer">
            <div class="wood">0</div>
            <div class="stone">0</div>
            <div class="sheep">0</div>
            <div class="clay">0</div>
            <div class="wheat">0</div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <form id="trade_form">
        <input type="hidden" name="game" value="<?php echo Request::segment(2); ?>" />
        <?php foreach($game->getOpponents() as $player): ?>
        <input type="checkbox" id="player_<?php echo $player->model->id; ?>" name="player_<?php echo $player->model->id; ?>" />
        <?php endforeach; ?>
        <?php $resources = array('wood','stone','sheep','clay','wheat'); ?>
        <?php foreach($resources as $type): ?>
        <input type="text" name="trade_<?php echo $type ?>" res="<?php echo $type; ?>" />
        <?php endforeach; ?>
      </form>
      <div class="panel">
        <?php foreach($resources as $type): ?>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale <?php echo $type; ?>" res="<?php echo $type; ?>">
            <p class="stop"><span></span><span>0</span></p>
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
      <div class="panel">
        <a id="loadjson">Pobierz JSON</a>
        Tura: <?php echo $game->model->turn_number; ?>
        Obecny gracz: <?php echo $game->model->players()->where('turn_order',$game->model->current_player)->first()->user->nickname;?> 
        <button id="trade_submit">Handuj z tym</button> 
      </div>
    </aside>
    <div id="whole">
      <div id="board"></div>
    </div>
  </body>
</html>
