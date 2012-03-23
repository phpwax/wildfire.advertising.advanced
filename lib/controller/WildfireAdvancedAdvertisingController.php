<?
class WildfireAdvancedAdvertisingController extends ApplicationController{


  public function method_missing(){
    $link = "/";
    $model = new WildfireAdvertAdvanced;
    if( ($hash = $this->route_array[1]) && ($found = $model->filter("hashtag", $hash)->first()) ){
      $link = $found->link;
      $found = $found->update_attributes(array('clicks'=>$found->clicks+1));
    }
    $this->redirect_to($link, "http://", 301);
  }

}?>