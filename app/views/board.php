<!DOCTYPE HTML>
<html lang="pl-PL">
  <head>
    <meta charset="UTF-8">
    <?php echo HTML::style('css/reset.css'); ?>
    <?php echo HTML::style('css/gameinterface.css'); ?>
    <?php echo HTML::style('css/hex.css'); ?>
    <title>Settlers of Mechatronics</title>
  </head>
  <body>
    <aside>
      <div class="usercard" id="user1">
        <figure><?php echo HTML::image('img/konrad.jpg', 'morda1'); ?></figure>
        <table>
          <caption>Fellglen</caption>
          <tbody>
            <tr>
              <th>S</th>
              <td>3</td>
            </tr>
            <tr>
              <th>R</th>
              <td>5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="usercard" id="user2">
        <figure><?php echo HTML::image('img/mroova.jpg', 'morda2'); ?></figure>
        <table>
          <caption>Mroova</caption>
          <tbody>
            <tr>
              <th>S</th>
              <td>3</td>
            </tr>
            <tr>
              <th>R</th>
              <td>5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="usercard sony" id="user3">
        <div>zjebałeś</div>
        <figure><?php echo HTML::image('img/sony.jpg', 'morda3'); ?></figure>
        <table>
          <caption>Sony</caption>
          <tbody>
            <tr>
              <th>S</th>
              <td>3</td>
            </tr>
            <tr>
              <th>R</th>
              <td>5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <nav>
        <div>
          <a href="#" class="main"><?php echo HTML::image('img/hammer_icon.png', 'hammer'); ?></a>
        </div>
        <div>
          <a href="#" class="main"><?php echo HTML::image('img/exchange_icon.png', 'exchange'); ?></a>
        </div>
        <div>
          <a href="#" class="main"><?php echo HTML::image('img/cards_icon.png', 'cards'); ?></a>
        </div>
        <div>
          <a href="#" class="main"><?php echo HTML::image('img/hourglass_icon.png', 'hourglass'); ?></a>
        </div>
      </nav>
    </aside>
    <?php echo $board; ?>
  </body>
</html>