<?
class CMSAdminAdvertisingController extends AdminComponent{

  public $module_name = "advertising";
  public $model_class = 'WildfireAdvertAdvanced';
  public $display_name = "Advertising";
  public $dashboard = false;
  public $file_tags = array('media');

  public function events(){
    WaxEvent::add("cms.model.columns", function(){
      $obj = WaxEvent::data();
      $obj->scaffold_columns['preview'] = true;
    });
    parent::events();
  }
}?>