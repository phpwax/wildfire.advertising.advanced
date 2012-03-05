<?
class WildfireAdvancedAdvertising extends ApplicationController{


  public function method_missing(){
    $link = "/";
    $model = new WildfireAdvertAdvanced;
    if(($hash = Request::param("id")) ($found = $model->fitler("hash", $hash)->first()) ){
      $link = $found->link;
      $found = $found->update_attributes(array('clicks'=>$found->clicks+1));
    }
    $this->redirect_to($link, 301);
  }

}?>