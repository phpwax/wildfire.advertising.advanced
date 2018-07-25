<?
class CMSAdminAdvertisingController extends AdminMediaController{

  public $module_name = "advertising";
  public $model_class = 'WildfireAdvertAdvanced';
  public $display_name = "Advertising";
  public $dashboard = false;
  public $file_tags = array('media');
  public $uploads = false;
  public $preview_hover = false;
  public $filter_fields=array(
                          'text' => array('columns'=>array('title', 'type'), 'partial'=>'_filters_text', 'fuzzy'=>true)
                        );
}?>