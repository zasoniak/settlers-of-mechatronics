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
      <?php $opps = $game->getOpponents(); ?>
      <?php foreach($opps as $player): ?>
      <div class="usercard" player="<?php echo $player->model->id; ?>">
        <figure><?php echo HTML::image('img/WM3.png', 'morda'); ?></figure>
        <table>
          <caption><?php echo $player->model->user->nickname; ?></caption>
          <tbody>
            <tr>
              <th>S</th>
              <td><?php echo $player->model->countResources(); ?></td>
            </tr>
            <tr>
              <th>R</th>
              <td>?</td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php endforeach; ?>
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
      <?php 
      if(!$game->isBoard() && $game->getHost()->model->user->id == Auth::user()->id)
      {
        echo HTML::link("game/".$game->model->id."/start", 'rozpocznij grę');
      }
      ?>
      <?php echo Session::get('message'); ?>
      Graczy: <?php echo $game->model->players()->count(); ?>
    </aside>
    <?php echo $game->renderBoard(); ?>
  </body>
</html>
