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
      <div id="player" class="panel">
        <div class="usercard"></div>
        <div class="usercard" player="2">
          <figure>
            <p class="yellow" id="res_number"><img src="http://localhost/catan/public/img/resource.png">3</p>
            <p class="yellow" id="cards_number"><img src="http://localhost/catan/public/img/cards_icon.png">1</p>
            <label for="player_1"><img src="http://localhost/catan/public/img/konrad.jpg" class="yellow"></label>
          </figure>
          <figcaption>Fellglen</figcaption>
          <div class="icon"></div>
        </div>
        <div class="usercard">
          <div class="dev_card knight yellow"></div>
          <div class="dev_card yearofplenty yellow"></div>
          <div class="dev_card knight yellow"></div>
        </div>
      </div>
      <div class="panel" player="1">
        <div class="button">
          <a id="build_button" class="main yellow"><span>rozwój</span></a>
          <a id="build_settle" class="inside yellow"><span>osada</span></a>
          <a id="build_town" class="inside yellow"><span>miasto</span></a>
          <a id="build_road" class="inside yellow"><span>droga</span></a>
          <a id="buy_card_button" class="inside yellow">karta</a>
        </div>
        <div class="button">
          <a id="trade_button" class="main yellow"><span>handel</span></a>
          <a id="trade_button_accept" class="inside yellow"><span>wyślij</span></a>
          <a id="trade_button_reject" class="inside yellow"><span>anuluj</span></a>
        </div>
        <div class="button">
          <a id="endturn_button" class="main yellow"><span>koniec</span></a>
        </div>
      </div>
      <div class="panel">
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card wood yellow" res="wood">
            <p class="yellow"><span>2</span><span>2</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale stone yellow" res="stone">
            <p class="yellow"><span></span><span></span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card sheep yellow" res="sheep">
            <p class="yellow"><span>3</span><span>3</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card clay yellow" res="clay">
            <p class="yellow"><span>1</span><span>1</span></p>
          </div>
        </div>
        <div class="resource">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale wheat yellow" res="wheat">
            <p class="yellow"><span></span><span></span></p>
          </div>
        </div>
      </div>
      <p class="panel">Sony przehandlował Twoją starą za 3 snopki zboża.</p>
      <div id="opponents" class="panel">
        <div class="usercard" player="2">
          <figure>
            <p class="red" id="res_number"><img src="http://localhost/catan/public/img/resource.png">3</p>
            <p class="red" id="cards_number"><img src="http://localhost/catan/public/img/cards_icon.png">1</p>
            <label for="player_2"><img src="http://localhost/catan/public/img/mroova.jpg" class="red"></label>
          </figure>
          <figcaption>mroova</figcaption>
          <div class="icon"></div>
        </div>
        <div class="usercard" player="3">
          <figure>
            <p class="green" id="res_number"><img src="http://localhost/catan/public/img/resource.png">2</p>
            <p class="green" id="cards_number"><img src="http://localhost/catan/public/img/cards_icon.png">1</p>
            <label for="player_3"><img src="http://localhost/catan/public/img/sony.jpg" class="green"></label>
          </figure>
          <figcaption>Sony</figcaption>
          <div class="icon"></div>
        </div>
        <div class="usercard">
          <figure>
            <label><img src="http://localhost/catan/public/img/avatar.png" class="grey" alt="morda"></label>
          </figure>
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
    </aside>
    <div id="whole">
      <div id="board">
        <div class="boardcorner" id="dice">
          Kostki<br>
          <span id="die1">3</span>
          <span>+</span>
          <span id="die2">4</span>
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
