<?
  CMSApplication::register_module("advertising", array('plugin_name'=>'wildfire.advertising.advanced', 'assets_for_cms'=>true, "display_name"=>"Advertising", "link"=>"/admin/advertising/", 'split'=>true));

  if(!defined("CONTENT_MODEL")){
    $con = new ApplicationController(false, false);
    define("CONTENT_MODEL", $con->cms_content_class);
  }

  WaxEvent::add(CONTENT_MODEL.".setup", function(){
    $model = WaxEvent::data();
    if(!$model->columns['ads']) $model->define("ads", "ManyToManyField", array('target_model'=>'WildfireAdvertAdvanced', "eager_loading"=>true, "join_model_class"=>"WildfireOrderedTagJoin", "join_order"=>"join_order", 'group'=>'advertising', 'module'=>'advertising'));
});
?>