jQuery(function($){
  var weight_inputs = $(".media_join_weight");
  weight_inputs.each(function(){
    var t = $(this),
        input = t.find("input");

    t.children().hide(); //hide actual input

    function set_input(t){
      t.data("input").val(t.slider("value"));
    }

    function calc_sliders(e,ui){
      var t = $(this);
      set_input(t);
      var start = t.data("start");
      var diff = start - ui.value;
      var tot = 100 - start;
      sliders.not(t).each(function(i){
        var t = $(this);
        var start = t.data("start");
        var ratio;
        if(!tot) ratio = 0.5; //division by zero hook to handle the case when this slider started on 100%, so all others are 0
        else ratio = start / tot;
        t.slider("value", start + (diff * ratio));
        set_input(t);
      });

      //adjust for rounding errors on stop
      if(e.type == "slidestop"){
        var checker = 100;
        sliders.each(function(i){
          checker -= $(this).slider("value");
        });
        var t = sliders.eq(Math.floor(Math.random() * sliders.length));
        t.slider("value", t.slider("value") + checker);
        set_input(t);
      }
    }

    $("<div class='weight_sliders'>").appendTo(t).slider({
      "max":100,
      "value":input.val(),
      "start":function(e,ui){
        //record all the values at the start of a slide
        zero_count = 0;
        sliders.each(function(){
          var t = $(this);
          t.data("start", t.slider("value"));
        });
      },
      "slide":calc_sliders,
      "stop":calc_sliders
    }).data("input", input);
  });
  var sliders = $(".weight_sliders");
});