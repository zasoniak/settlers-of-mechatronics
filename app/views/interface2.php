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
        <div class="hex ocean" tile="22" style="left: 180px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="28" style="left: 300px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="33" style="left: 420px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="37" style="left: 540px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="15" style="left: 120px; top: 103px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="21" style="left: 240px; top: 103px;"><span>11</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="27" style="left: 360px; top: 103px;"><span>10</span><div class="face1"></div><div class="face2"></div></div><div class="hex desert" tile="32" style="left: 480px; top: 103px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="36" style="left: 600px; top: 103px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="9" style="left: 60px; top: 206px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="14" style="left: 180px; top: 206px;"><span>9</span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="20" style="left: 300px; top: 206px;"><span>5</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="26" style="left: 420px; top: 206px;"><span>2</span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="31" style="left: 540px; top: 206px;"><span>11</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="35" style="left: 660px; top: 206px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="4" style="left: 0px; top: 309px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="8" style="left: 120px; top: 309px;"><span>6</span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="13" style="left: 240px; top: 309px;"><span>3</span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="19" style="left: 360px; top: 309px;"><span>9</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="25" style="left: 480px; top: 309px;"><span>10</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="30" style="left: 600px; top: 309px;"><span>4</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="34" style="left: 720px; top: 309px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="3" style="left: 60px; top: 412px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="7" style="left: 180px; top: 412px;"><span>6</span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="12" style="left: 300px; top: 412px;"><span>4</span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="18" style="left: 420px; top: 412px;"><span>8</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="24" style="left: 540px; top: 412px;"><span>8</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="29" style="left: 660px; top: 412px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="2" style="left: 120px; top: 515px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="6" style="left: 240px; top: 515px;"><span>5</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="11" style="left: 360px; top: 515px;"><span>12</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="17" style="left: 480px; top: 515px;"><span>3</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="23" style="left: 600px; top: 515px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="1" style="left: 180px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="5" style="left: 300px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="10" style="left: 420px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="16" style="left: 540px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div>
        </div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
