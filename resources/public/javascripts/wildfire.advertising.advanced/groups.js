jQuery(function($){
  $("fieldset#advertising").unbind("add-media").bind("add-media", function(e, result){
    var insert = $(result);
    var group = insert.find(".group").attr("data-target-group");
    $(this).find(".existing-ad-"+group).append(insert);
  });
});