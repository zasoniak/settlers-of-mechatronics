<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface_1.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <?php echo HTML::style('css/colors.css'); ?>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <title>Settlers of Mechatronics</title>
  </head>
  <body>
    <aside>
      <div class="usercard your" player="2">
        <figure>
          <p class="blue" id="res_number"><img src="http://localhost/catan/public/img/resource.png">3</p>
          <p class="blue" id="cards_number"><img src="http://localhost/catan/public/img/icon_card.png">1</p>
          <label for="player_1"><img src="http://localhost/catan/public/img/konrad.jpg" class="blue"></label>
        </figure>
        <figcaption>Fellglen</figcaption>
        <div class="icon"></div>
      </div>
      <div class="ring blue">
        <div class="button"><div>
          <a id="build_button" class="main blue"><span>rozwój</span></a>
          <a id="build_settle" class="inside blue"><span>osada</span></a>
          <a id="build_town" class="inside blue"><span>miasto</span></a>
          <a id="build_road" class="inside blue"><span>droga</span></a>
          <a id="buy_card_button" class="inside blue"><span>karta</span></a>
        </div></div>
        <div class="button"><div>
          <a id="trade_button" class="main blue"><span>handel</span></a>
          <a id="trade_button_accept" class="inside blue"><span>wyślij</span></a>
          <a id="trade_button_reject" class="inside blue"><span>anuluj</span></a>
        </div></div>
        <div class="button"><div>
          <a id="endturn_button" class="main blue"><span>koniec</span></a>
        </div></div>
      </div>
      <div class="ring blue">
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card wood blue" res="wood">
            <p class="blue"><span>2</span><span>2</span></p>
          </div>
        </div></div>
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale stone blue" res="stone">
            <p class="blue"><span></span><span></span></p>
          </div>
        </div></div>
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card sheep blue" res="sheep">
            <p class="blue"><span>3</span><span>3</span></p>
          </div>
        </div></div>
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card clay blue" res="clay">
            <p class="blue"><span>1</span><span>1</span></p>
          </div>
        </div></div>
        <div class="resource"><div class="res_in">
          <div class="trade up">+</div>
          <div class="trade down">-</div>
          <div class="res_card greyscale wheat blue" res="wheat">
            <p class="blue"><span></span><span></span></p>
          </div>
        </div></div>
      </div>
      <div class="ring blue">
        <div class="dev_card knight"><div class="blue"></div></div>
        <div class="dev_card yearofplenty"><div class="blue"></div></div>
        <div class="dev_card knight"><div class="blue"></div></div>
        <div class="dev_card roadbuilding"><div class="blue"></div></div>
        <div class="dev_card monopoly"><div class="blue"></div></div>
      </div>
      <p class="panel none">Sony przehandlował Twoją starą za 3 snopki zboża.</p>
      <div id="opponents" class="ring grey">
        <div class="usercard" player="2"><div>
          <figure>
            <p class="red" id="res_number"><img src="http://localhost/catan/public/img/resource.png">3</p>
            <p class="red" id="cards_number"><img src="http://localhost/catan/public/img/icon_card.png">1</p>
            <label for="player_2"><img src="http://localhost/catan/public/img/mroova.jpg" class="red"></label>
          </figure>
          <figcaption>mroova</figcaption>
          <div class="icon"></div>
        </div></div>
        <div class="usercard" player="3"><div>
          <figure>
            <p class="green" id="res_number"><img src="http://localhost/catan/public/img/resource.png">2</p>
            <p class="green" id="cards_number"><img src="http://localhost/catan/public/img/icon_card.png">1</p>
            <label for="player_3"><img src="http://localhost/catan/public/img/sony.jpg" class="green"></label>
          </figure>
          <figcaption>Sony</figcaption>
          <div class="icon"></div>
        </div></div>
        <div class="usercard"><div>
          <figure>
            <label><img src="http://localhost/catan/public/img/avatar.png" class="grey" alt="morda"></label>
          </figure>
          <figcaption></figcaption>
          <div class="icon"></div>
          </div></div>
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
          <span id="die1">6</span>
          <span>+</span>
          <span id="die2">4</span>
        </div>
        <div class="boardcorner" id="turn">
          Tura<br>
          <span>5</span>
        </div>
        <div class="hex ocean" tile="133" style="left: 180px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="139" style="left: 300px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="144" style="left: 420px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="148" style="left: 540px; top: 0px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="126" style="left: 120px; top: 103px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="132" style="left: 240px; top: 103px;"><span>9</span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="138" style="left: 360px; top: 103px;"><span>8</span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="143" style="left: 480px; top: 103px;"><span>3</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="147" style="left: 600px; top: 103px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="120" style="left: 60px; top: 206px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex stone" tile="125" style="left: 180px; top: 206px;"><span>10</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="131" style="left: 300px; top: 206px;"><span>6</span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="137" style="left: 420px; top: 206px;"><span>10</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="142" style="left: 540px; top: 206px;"><span>6</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="146" style="left: 660px; top: 206px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="115" style="left: 0px; top: 309px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="119" style="left: 120px; top: 309px;"><span>11</span><div class="face1"></div><div class="face2"></div></div><div class="hex desert" tile="124" style="left: 240px; top: 309px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="130" style="left: 360px; top: 309px;"><span>11</span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="136" style="left: 480px; top: 309px;"><span>4</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="141" style="left: 600px; top: 309px;"><span>9</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="145" style="left: 720px; top: 309px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="114" style="left: 60px; top: 412px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="118" style="left: 180px; top: 412px;"><span>4</span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="123" style="left: 300px; top: 412px;"><span>12</span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="129" style="left: 420px; top: 412px;"><span>5</span><div class="face1"></div><div class="face2"></div></div><div class="hex clay" tile="135" style="left: 540px; top: 412px;"><span>3</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="140" style="left: 660px; top: 412px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="113" style="left: 120px; top: 515px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex sheep" tile="117" style="left: 240px; top: 515px;"><span>2</span><div class="face1"></div><div class="face2"></div></div><div class="hex wheat" tile="122" style="left: 360px; top: 515px;"><span>5</span><div class="face1"></div><div class="face2"></div></div><div class="hex wood" tile="128" style="left: 480px; top: 515px;"><span>8</span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="134" style="left: 600px; top: 515px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="112" style="left: 180px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="116" style="left: 300px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="121" style="left: 420px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div><div class="hex ocean" tile="127" style="left: 540px; top: 618px;"><span></span><div class="face1"></div><div class="face2"></div></div>
      </div>
    </div>
  </body>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <?php echo HTML::script('js/catan.js'); ?>
</html>
