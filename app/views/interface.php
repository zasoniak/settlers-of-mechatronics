<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <?php echo HTML::script('js/jquery-1.10.2.js'); ?>
    <?php echo HTML::script('http://code.jquery.com/ui/1.10.1/jquery-ui.js'); ?>
    <title>Settlers of Mechatronics</title>
  </head>
  <body>
    <div class="container" id="board">
      <ol class="even">
        <li class='hex hidden'></li>
        <li class='hex forest'></li>
        <li class='hex mountain'></li>
        <li class='hex plain'></li>
      </ol>
      <ol class="odd">
        <li class='hex hidden'></li>
        <li class='hex clay'></li>
        <li class='hex forest'></li>
        <li class='hex mountain'></li>
        <li class='hex wheat'></li>
      </ol>
      <ol class="even">
        <li class='hex mountain'></li>
        <li class='hex plain'></li>
        <li class='hex clay'></li>
        <li class='hex wheat'></li>
        <li class='hex plain'></li>
      </ol>
      <ol class="odd">
        <li class='hex hidden'></li>
        <li class='hex clay'></li>
        <li class='hex desert'></li>
        <li class='hex plain'></li>
        <li class='hex forest'></li>
      </ol>
      <ol class="even">
        <li class='hex hidden'></li>
        <li class='hex forest'></li>
        <li class='hex wheat'></li>
        <li class='hex clay'></li>
      </ol>
    </div>
    <aside>
      <div class="user_card" id="user1">
        <figure><?php echo HTML::image('img/konrad.jpg', 'morda1'); ?></figure>
        <ul>
          <li>surowce: 3</li>
          <li>karty rozwoju: 2</li>
          <li>karty rycerz: 1</li>
        </ul>
      </div>
      <div class="user_card" id="user2">
        <figure><?php echo HTML::image('img/mroova.jpg', 'morda2'); ?></figure>
        <ul>
          <li>surowce: 5</li>
          <li>karty rozwoju: 2</li>
          <li>karty rycerz: 1</li>
        </ul>
      </div>
      <div class="user_card" id="user3">
        <figure><?php echo HTML::image('img/sony.jpg', 'morda3'); ?></figure>
        <ul>
          <li>surowce: 5</li>
          <li>karty rozwoju: 2</li>
          <li>karty rycerz: 1</li>
        </ul>
      </div>
      <nav>
        <a href="#" class="main"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
        <a href="#" class="main"><?php echo HTML::image('img/exchange_icon.png', 'exchange'); ?></a>
        <a href="#" class="main"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
      </nav>
    </aside>
  </body>
</html>