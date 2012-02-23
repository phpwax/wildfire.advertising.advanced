<?php
class WaxModelWeightedJoin extends WaxModelOrderedJoin {
  public function setup() {
    parent::setup();
    $this->define("weight", "IntegerField");
  }
}?>
