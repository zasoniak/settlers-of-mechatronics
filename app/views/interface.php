<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface_1.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <?php echo HTML::style('css/colors.css'); ?>
    <title>Settlers of Mechatronics</title>
  </head>
  <body>
    <aside>
      <div id="opponents" class="panel">
        <div class="usercard" player="2">
          <label for="player_1">
            <figure><img src="http://localhost/catan/public/img/konrad.jpg" class="yellow"></figure>
          </label>
          <figcaption>Fellglen</figcaption>
          <div class="icon"></div>
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
      </div>
      <div class="panel" player="1">
        <div class="button">
          <a id="build_button" class="main yellow"><span>rozwój</span></a>
          <a id="build_settle" class="inside yellow">osada</a>
          <a id="build_city" class="inside yellow">miasto</a>
          <a id="build_road" class="inside yellow">droga</a>
          <a id="buy_card_button" class="inside yellow">karta</a>
        </div>
        <div class="button">
          <a id="trade_button" class="main yellow"><span>handel</span></a>
          <a id="trade_button_accept" class="inside yellow">wyślij</a>
          <a id="trade_button_reject" class="inside yellow">anuluj</a>
        </div>
        <div class="button">
          <a id="endturn_button" class="main yellow"><span>koniec</span></a>
        </div>
      </div>
      <div class="panel">
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card wood" res="wood">
            <p><span>2</span><span>2</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale stone" res="stone">
            <p><span></span><span></span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card sheep" res="sheep">
            <p><span>3</span><span>3</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card clay" res="clay">
            <p><span>1</span><span>1</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale wheat" res="wheat">
            <p><span></span><span></span></p>
          </div>
        </div>
      </div>
      <div id="opponents" class="panel">
        <div class="usercard" player="2">
          <label for="player_2">
            <figure><img src="http://localhost/catan/public/img/mroova.jpg" class="blue" alt="morda"></figure>
          </label>
          <figcaption>mroova</figcaption>
          <div class="icon"></div>
        </div>
        <div class="usercard" player="3">
          <label for="player_3">
            <figure><img src="http://localhost/catan/public/img/sony.jpg" class="green" alt="morda"></figure>
          </label>
          <figcaption>Sony</figcaption>
          <div class="icon"></div>
        </div>
        <div class="usercard" player="2">
          <label for="player_2">
            <figure><img src="http://localhost/catan/public/img/avatar.png" class="grey" alt="morda"></figure>
          </label>
          <figcaption></figcaption>
          <div class="icon"></div>
        </div>
      </div>
      <form id="trade_form">
        <input type="hidden" name="game_id" value="1" id="game_id" />
        <input type="checkbox" id="player_2" name="player_2" />
        <input type="text" name="trade_wood" res="wood" />
        <input type="text" name="trade_stone" res="stone" />
        <input type="text" name="trade_sheep" res="sheep" />
        <input type="text" name="trade_clay" res="clay" />
        <input type="text" name="trade_wheat" res="wheat" />
      </form>
      <div id="dev_cards" class="panel">
      </div>
    </aside>
    <div id="whole">
      <div id="board">
        <div id="dice">
          Kostki<br>
          <span id="die1">3</span>
          <span>+</span>
          <span id="die2">4</span>
        </div>
        <div id="turn">
          Tura<br>
          <span>5</span>
        </div>
      </div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
