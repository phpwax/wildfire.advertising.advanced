<?
class WildfireAdvertAdvanced extends WaxModel{
  public $ad_types = array(''=>'-- Select --', 'mpu'=>'MPU', 'leaderboard'=>'Leaderboard', 'sky'=>'Sky');

  public function setup(){
    if($types = Config::get("adverts/types")) $this->ad_types = $types;

    $this->define("title", "CharField", array('required'=>true,'scaffold'=>true));
    $this->define("type", "CharField", array('widget'=>'SelectInput', 'choices'=>$this->ad_types,'scaffold'=>true));
    $this->define("link", "CharField", array('required'=>true));
    $this->define("impressions", "IntegerField", array('editable'=>false,'scaffold'=>true));
    $this->define("clicks", "IntegerField", array('editable'=>false,'scaffold'=>true));

    $this->define("media", "ManyToManyField", array('target_model'=>"WildfireMedia", "eager_loading"=>true, "join_model_class"=>"WildfireOrderedTagJoin", "join_order"=>"join_order", 'group'=>'media', 'module'=>"media"));
  }

  public function before_insert(){
    if(!$this->title) $this->title = "Enter your title here";
  }

  public function preview(){
    return $this->media[0]->preview();
  }

  public function render($width){
    return $this->media[0]->render($width);
  }
}?>