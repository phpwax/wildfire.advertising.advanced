<?php
class WaxModelWeightedJoin extends WaxModelOrderedJoin {
  public function setup() {
    parent::setup();
    $this->define("weight", "IntegerField");
  }

  public static function weighted_random($recordset, $num = 1){
    // basic shuffle so the list has less sequence for $num > 1
    if($num > 1) shuffle($recordset->rowset);

    $cnt = count($recordset->rowset);
    if($num >= $cnt) return $recordset;

    $total_weight = 0;
    foreach($recordset->rowset as $row) $total_weight += $row['weight'];

    // pick a random number between 0 and the total weight
    $rnd = mt_rand(0, $total_weight - 1);

    // keep removing the weight from the random number to find the first item
    // when there's no random number left, start returning items
    for($j = $i = 0; $j < $num; $i = ($i + 1) % $cnt){
      if(($rnd -= $recordset->rowset[$i]['weight']) <= 0){
        $ret[] = $recordset->rowset[$i];
        if(++$j >= $num) break;
      }
    }

    $recordset->rowset = $ret;
    return $recordset;
  }
}?>
