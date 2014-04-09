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
      <form id="trade_form">
        <input type="hidden" name="game_id" value="<?php echo Request::segment(2); ?>" id="game_id" />
        <?php foreach($game->getOpponents() as $player): ?>
        <input type="checkbox" id="player_<?php echo $player->model->id; ?>" name="player_<?php echo $player->model->id; ?>" />
        <?php endforeach; ?>
        <?php $resources = array('wood','stone','sheep','clay','wheat'); ?>
        <?php foreach($resources as $type): ?>
        <input type="text" name="trade_<?php echo $type ?>" res="<?php echo $type; ?>" value="0" />
        <?php endforeach; ?>
      </form>
      <?php $you = new CatanPlayer(Player::findByGameByUser($game->model->id, Auth::user()->id)); ?>
      <div class="usercard your"><div>
          <figure>
            <p class="<?php echo $you->model->color; ?>" id="res_number"><img src="http://localhost/catan/public/img/resource.png"><?php echo $player->model->countResources(); ?></p>
            <p class="<?php echo $you->model->color; ?>" id="cards_number"><img src="http://localhost/catan/public/img/icon_card.png"><?php echo $player->model->countCards(); ?></p>
            <label for="player_<?php echo $you->model->id; ?>">
              <?php echo HTML::image('img/'.$you->model->user->image, 'morda', array('class'=>$you->model->color)); ?>
            </label>
          </figure>
          <figcaption><?php echo $you->model->user->nickname; ?></figcaption>
          <div class="icon"></div>
          </div></div>
      <div class="ring" player="<?php echo $you->model->id; ?>">
        <div id="button_develop_outside" class="button"><div>
          <a id="build_button" class="main <?php echo $you->model->color; ?>"><span>rozwój</span></a>
          <a id="build_settle" class="inside <?php echo $you->model->color; ?>"><span>osada</span></a>
          <a id="build_town" class="inside <?php echo $you->model->color; ?>"><span>miasto</span></a>
          <a id="build_road" class="inside <?php echo $you->model->color; ?>"><span>droga</span></a>
          <a id="buy_card_button" class="inside <?php echo $you->model->color; ?>"><span>karta</span></a>
        </div></div>
        <div id="button_trade_outside" class="button"><div>
          <a id="trade_button" class="main <?php echo $you->model->color; ?>"><span>handel</span></a>
<!--          <a id="trade_button_send" class="inside <?php echo $you->model->color; ?>"><span>wyślij</span></a>
          <a id="trade_button_cancel" class="inside <?php echo $you->model->color; ?>"><span>anuluj</span></a>-->
          <a id="trade_button_accept" class="inside <?php echo $you->model->color; ?>"><span></span></a>
          <a id="trade_button_reject" class="inside <?php echo $you->model->color; ?>"><span></span></a>
        </div></div>
        <div class="button"><div>
          <a id="endturn_button" class="main <?php echo $you->model->color; ?>"><span>koniec</span></a>
        </div></div>
      </div>
      <div class="ring">
        <?php foreach($resources as $type): ?>
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale <?php echo $type." ".$you->model->color; ?>" res="<?php echo $type; ?>">
            <p class="<?php echo $you->model->color; ?>"><span></span><span></span></p>
          </div>
        </div></div>
        <?php endforeach; ?>
      </div>
      <div id="dev_cards" class="ring">
      </div>
      <div id="opponents" class="ring grey">
        <?php foreach($game->getOpponents() as $player): ?>
        <div class="usercard" player="<?php echo $player->model->id; ?>"><div>
          <figure>
            <p class="<?php echo $player->model->color; ?>" id="res_number"><img src="http://localhost/catan/public/img/resource.png"><?php echo $player->model->countResources(); ?></p>
            <p class="<?php echo $player->model->color; ?>" id="cards_number"><img src="http://localhost/catan/public/img/icon_card.png"><?php echo $player->model->countCards(); ?></p>
            <label for="player_<?php echo $player->model->id; ?>">
              <?php echo HTML::image('img/'.$player->model->user->image, 'morda', array('class'=>$player->model->color)); ?>
            </label>
          </figure>
          <figcaption><?php echo $player->model->user->nickname; ?></figcaption>
          <div class="icon"></div>
          </div></div>
        <?php endforeach; ?>
      </div>
      <?php echo Session::get('message'); ?>
    </aside>
    <div id="whole">
      <div id="board">
        <div class="boardcorner" id="dice">
          Kostki<br>
          <span id="die1">?</span>
          <span>+</span>
          <span id="die2">?</span>
        </div>
        <div class="boardcorner" id="turn">
          Tura<br>
          <span>5</span>
        </div>
      </div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
