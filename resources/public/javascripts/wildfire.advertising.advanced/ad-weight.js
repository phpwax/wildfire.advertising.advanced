jQuery(function($){
  var sliders;

  function set_input(t){
    t.data("input").val(t.slider("value"));
  }

  function fix_rounding_errors(){
    if(sliders.length){
      var checker = 100;
      sliders.each(function(i){
        checker -= $(this).slider("value");
      });
      var t = sliders.eq(Math.floor(Math.random() * sliders.length));
      t.slider("value", t.slider("value") + checker);
      set_input(t);
    }
  }

  function init_sliders(){
    $(".media_join_weight:not(.slider_initiated)").each(function(){
      var t = $(this),
          input = t.find("input");

      // t.children().hide(); //hide actual input

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
        if(e.type == "slidestop") fix_rounding_errors();
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

      t.addClass("slider_initiated");
    });

    sliders = $(".weight_sliders"); //reset slider list
  }

  init_sliders();

  // handle adding or removing ads by proportioning the leftover weights
  jQuery(window).bind("join.added join.removed", function(){
    init_sliders();
    var total = 0;
    sliders = $(".weight_sliders");
    sliders.each(function(){
      total += $(this).slider("value");
    });
    if(total != 100){
      sliders.each(function(){
        var t = $(this),
            v = t.slider("value"),
            diff = 100 - total,
            r;
        if(!total) r = 0.5; //division by zero hook to handle the case when this slider started on 100%, so all others are 0
        else r = v / total;
        t.slider("value", v + (diff * r));
        set_input(t);
      });
      fix_rounding_errors();
    }
  });
});