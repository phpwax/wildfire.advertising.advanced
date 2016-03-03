<?
class WildfireAdvertAdvanced extends WaxModel{
  public static $ad_types = array(''=>'-- Select --', 'mpu'=>'MPU', 'leaderboard'=>'Leaderboard', 'sky'=>'Sky');

  public function setup(){
    if($types = Config::get("adverts/types")) $this->ad_types = $types;

    $this->define("title", "CharField", array('required'=>true,'scaffold'=>true));
    $this->define("type", "CharField", array('widget'=>'SelectInput', 'choices'=>WildfireAdvertAdvanced::$ad_types,'scaffold'=>true));
    $this->define("link", "CharField", array('required'=>true));
    $this->define("impressions", "IntegerField", array('editable'=>false,'scaffold'=>true));
    $this->define("clicks", "IntegerField", array('editable'=>false,'scaffold'=>true));
    $this->define("hashtag", "CharField", array('editable'=>false));

    $this->define("media", "ManyToManyField", array('target_model'=>"WildfireMedia", "eager_loading"=>true, "join_model_class"=>"WildfireOrderedTagJoin", "join_order"=>"join_order", 'group'=>'media', 'module'=>"media"));

    $this->define("date_modified", "DateTimeField", array('export'=>true, 'scaffold'=>true, 'editable'=>false));
    $this->define("date_created", "DateTimeField", array('export'=>true, 'scaffold'=>true, 'editable'=>false));
  }

  public function before_save(){
    if(!$this->title) $this->title = "Enter your title here";
    if(!$this->hashtag) $this->hashtag = hash_hmac("sha1", $this->link, time());
    if(!$this->impressions) $this->impressions = 0;
    if(!$this->clicks) $this->clicks = 0;
    if($this->columns['date_created'] && !$this->date_created) $this->date_created = date("Y-m-d H:i:s");
    if($this->columns['date_modified']) $this->date_modified = date("Y-m-d H:i:s");
  }

  public function preview(){
    if($media = $this->media[0]) return $media->preview();
  }

  public function render($width){
    $this->update_attributes(array('impressions'=>$this->impressions+1));
    if($media = $this->media[0]) return $media->render($width);
  }

  public function permalink(){
    return "/a/".$this->hashtag."/";
  }

  public function groups(){
    return WildfireAdvertAdvanced::$ad_types[$this->type];
  }
}?>