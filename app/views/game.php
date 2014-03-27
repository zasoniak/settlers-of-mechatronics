<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <?php echo HTML::style('css/colors.css'); ?>
    <title>Settlers of Mechatronics</title>
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
            <div class="reject"></div>
            <div class="empty"></div>
            <div class="accept"></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <form id="trade_form">
        <input type="hidden" name="game_id" value="<?php echo Request::segment(2); ?>" id="game_id" />
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
            <p class="stop"><span></span></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="panel">
        <?php
        $cards = array('victorypoint','knight','monopoly','roadbuilding','yearofplenty');
        foreach($cards as $card): ?>
        <div class="development_card">
          <div class="dev_card greyscale <?php echo $card; ?>" card="<?php echo $card; ?>">
            <p><span></span></p>
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
          <a id="build_button" class="main"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
          <a id="build_settle" class="inside"><?php echo HTML::image('img/icon_house.png', 'hammer'); ?></a>
          <a id="build_city" class="inside"><?php echo HTML::image('img/icon_city.png', 'exchange'); ?></a>
          <a id="build_road" class="inside"><?php echo HTML::image('img/icon_road.png', 'cards'); ?></a>
          <a id="buy_card_button" class="inside"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
          hope is lost...
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
      <div class="panel">
        <div class="dice" id="die1"></div>
        <div class="dice" id="die2"></div>
      </div>
    </aside>
    <div id="whole">
      <div id="board"></div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
