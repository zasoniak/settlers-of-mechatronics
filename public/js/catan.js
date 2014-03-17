$(document).ready(function(){
      $("#build_button").click(function(){
        $("#slide1").slideToggle('300');
        $("#slide2").slideUp('300');
        $(".trade").slideUp('300');
        $("#road.active").hide('800');
        $("#settle.active").hide('800');
      });
      $("#build_settle").click(function(){
        $("#road.active").hide('800');
        $("#settle.active").toggle('400');
      });
      $("#build_road").click(function(){
        $("#settle.active").hide('800');
        $("#road.active").toggle('400');
      });
      $("#buy_card_button").click(function(){
        $("#slide2").slideToggle('300');
        $("#slide1").slideUp('300');
        $(".trade").slideUp('300');
      });
      $("#trade_button").click(function(){
        $(".trade").slideToggle();
        $("#slide1").slideUp('300');
        $("#slide2").slideUp('300');
        
      });
      $(".settle.active").click(function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"settlement", id:$(this).attr("settle") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      $(".road.active").click(function(event){
        $.post("<?php echo URL::to("game/".$game->model->id."/build"); ?>",{ item:"road", id:$(this).attr("road") })
                .done(function(data){
                  $(event.target).removeClass("active").addClass("red");
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      $("#loadjson").click(function(){
        $.getJSON("<?php echo URL::to("game/".$game->model->id."/update"); ?>")
                .done(function(data){
                  $.each(data.board.tiles, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .append($("<span>").html(item.prob))
                            .appendTo("#board");
                  });
                  $.each(data.board.settlements, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
                  $.each(data.board.roads, function(index,item){
                    $("<div>")
                            .addClass(item.classes)
                            .css(item.styles)
                            .attr(item.attr)
                            .appendTo("#board");
                  });
                  $.each(data.opponents, function(index,item){
                    $("[player="+index+"]").find("td").last().html(item.resources);
                  });
                  $.each(data.player.resources, function(index,item){
                    $(".res_card."+index).find("span").html(item);
                  });
                })
                .error(function(data){
                  alert(data.responseText);
                });
      });
      
    });
    function loadJSON()
    {
      
    }
      

