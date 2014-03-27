<?php
/**
 *
 * @author Sony
 */
interface PurchasableInterface {
  public function buy(Player $player);
  public function cost();
}
