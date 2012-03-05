<?
class WildfireAdvancedAdvertisingController extends ApplicationController{


  public function method_missing(){
    $link = "/";
    $model = new WildfireAdvertAdvanced;
    if( ($hash = Request::param("id")) && ($found = $model->filter("hash", $hash)->first()) ){
      $link = $found->link;
      $found = $found->update_attributes(array('clicks'=>$found->clicks+1));
    }
    $this->redirect_to($link, "http://", 301);
  }

}?>