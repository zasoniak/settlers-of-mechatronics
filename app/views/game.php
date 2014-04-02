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
          <div class="icon"></div>
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
            <p><span></span><span></span></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div id="dev_cards" class="panel">
        <?php
        /*
        $cards = array('victorypoint','knight','monopoly','roadbuilding','yearofplenty');
        foreach($cards as $card): ?>
        <div class="development_card">
          <div class="dev_card greyscale <?php echo $card; ?>" card="<?php echo $card; ?>">
            <p><span></span></p>
          </div>
        </div>
        <?php endforeach; */?>
      </div>
      <?php echo Session::get('message'); ?>
      <div class="panel" player="<?php echo Player::findByGameByUser($game->model->id, Auth::user()->id)->id; ?>">
        <div class="button">
          <a id="build_button" class="main"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
          <a id="build_settle" class="inside"><?php echo HTML::image('img/icon_house.png', 'hammer'); ?></a>
          <a id="build_city" class="inside"><?php echo HTML::image('img/icon_city.png', 'exchange'); ?></a>
          <a id="build_road" class="inside"><?php echo HTML::image('img/icon_road.png', 'cards'); ?></a>
          <a id="buy_card_button" class="inside"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
        </div>
        <div class="button">
          <a id="trade_button" class="main"><?php echo HTML::image('img/exchange_icon.png', 'exchange'); ?></a>
          <a id="trade_button_accept" class="inside"><?php echo HTML::image('img/accept.png', 'accept'); ?></a>
          <a id="trade_button_reject" class="inside"><?php echo HTML::image('img/reject.png', 'reject'); ?></a>
          <a id="trade_button_withbank" class="inside"><?php echo HTML::image('img/withbank.png', 'withbank'); ?></a>
        </div>
        <div class="button">
          <a id="buy_card_button"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
        </div>
        <div class="button">
          <a id="endturn_button" class="main"><?php echo HTML::image('img/hourglass_icon.png', 'hourglass'); ?></a>
        </div>
      </div>
      </div>
      <div class="panel">
        <a id="loadjson">Pobierz JSON</a>
        <button id="trade_submit">Handuj z tym</button> 
      </div>
    </aside>
    <div id="whole">
      <div id="board">
        <div id="dice">
          Kostki<br>
          <span id="die1"></span>
          <span>+</span>
          <span id="die2"></span>
        </div>
        <div id="turn">
          Tura<br>
          <span><?php echo $game->model->turn_number; ?></span>
        </div>
      </div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
