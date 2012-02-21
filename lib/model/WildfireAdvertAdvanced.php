<?
class WildfireAdvertAdvanced extends WaxModel{
  public $ad_types = array(''=>'-- Select --', 'mpu'=>'MPU', 'leaderboard'=>'Leaderboard', 'sky'=>'Sky');

  public function setup(){
    if($types = Config::get("adverts/types")) $this->ad_types = $types;

    $this->define("title", "CharField", array('required'=>true,'scaffold'=>true));
    $this->define("type", "CharField", array('widget'=>'SelectInput', 'choices'=>$this->ad_types,'scaffold'=>true));
    $this->define("link", "CharField", array('required'=>true,'scaffold'=>true));
    $this->define("impressions", "IntegerField", array('editable'=>false,'scaffold'=>true));
    $this->define("clicks", "IntegerField", array('editable'=>false,'scaffold'=>true));

    $this->define("media", "ManyToManyField", array('target_model'=>"WildfireMedia", "eager_loading"=>true, "join_model_class"=>"WildfireOrderedTagJoin", "join_order"=>"join_order", 'group'=>'media'));
  }

  public function before_insert(){
    if(!$this->title) $this->title = "Enter your title here";
  }

  //copied directly out of WildfireContent
  //this will need updating when the framework can handle manipulating join columns
  public function file_meta_set($fileid, $tag, $order=0, $title=''){
    $model = new WaxModel;
    if($this->table < "wildfire_media") $model->table = $this->table."_wildfire_media";
    else $model->table = "wildfire_media_".$this->table;
    
    $col = $this->table."_".$this->primary_key;
    if(!$order) $order = 0;
    if(($found = $model->filter($col, $this->primval)->filter("wildfire_media_id", $fileid)->all()) && $found->count()){
      foreach($found as $r){
        $sql = "UPDATE `".$model->table."` SET `join_order`=$order, `tag`='$tag', `title`='$title' WHERE `id`=$r->primval";
        $model->query($sql);
      }
    }else{
      $sql = "INSERT INTO `".$model->table."` (`wildfire_media_id`, `$col`, `join_order`, `tag`, `title`) VALUES ('$fileid', '$this->primval', '$order', '$tag', '$title')";
      $model->query($sql);
    }
  }
  public function file_meta_get($fileid=false, $tag=false){
    $model = new WaxModel;
    if($this->table < "wildfire_media") $model->table = $this->table."_wildfire_media";
    else $model->table = "wildfire_media_".$this->table;
    $col = $this->table."_".$this->primary_key;
    if($fileid) return $model->filter($col, $this->primval)->filter("wildfire_media_id", $fileid)->order('join_order ASC')->first();
    elseif($tag=="all") return $model->filter($col, $this->primval)->order('join_order ASC')->all();    
    elseif($tag) return $model->filter($col, $this->primval)->filter("tag", $tag)->order('join_order ASC')->all();
    else return false;
  }
}?>