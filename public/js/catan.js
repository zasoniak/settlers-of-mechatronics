$(document).ready(function() {
  var game = $("#game_id").val();
  var color;
  // LOAD BOARD   LOAD BOARD   LOAD BOARD   LOAD BOARD   LOAD BOARD   LOAD BOARD   
  $.getJSON("ajax/board", {game_id: game})
          .done(function(data) {
            $.each(data.tiles, function(index, item) {
              $("<div>")
                      .hide()
                      .addClass(item.classes)
                      .css(item.styles)
                      .attr(item.attr)
                      .append($("<span>").html(item.prob))
                      .append($("<div class=\"face1\"></div>"))
                      .append($("<div class=\"face2\"></div>"))
                      .appendTo("#board")
                      .delay(50 * index)
                      .fadeIn('120');
            });
            $("[tile=\"" + data.thief + "\"]").append($("<div id=\"thief\"></div>"));
            $.each(data.ports, function(index, item) {
              $("<div>")
                      .hide()
                      .addClass(item.classes)
                      .css(item.styles)
                      .appendTo("#board")
                      .delay('720')
                      .fadeIn('120');
            });
          });
  loadJSON(game);
  function hideDevelop() {
    $(".settle.active").hide(300);
    $(".road.active").hide(300);
    $(".settle").removeClass("upgrade");
    $("#button_develop_outside").removeClass("clicked"); 
  }
  function showTrade() {
    $(".trade").slideDown(300);
    $(".usercard figure").addClass("clickable");
    $(".res_card p").addClass("trading");
    $(".res_card p span:last-of-type").show(300);
    $("#button_trade_outside").addClass("clicked");    
  }
  function hideTrade() {
    $(".trade").slideUp(300);
    $(".usercard figure").removeClass("clickable");
    $(".usercard ").removeClass("withoffer");
    $(".res_card p").removeClass("trading");
    $(".res_card p span:last-of-type").hide(300);
    $("#button_trade_outside").removeClass("clicked");
  }
  function hideButtons() {
    $(".main").removeClass("clicked");
  }
  // BUILD    BUILD    BUILD    BUILD    BUILD    BUILD    BUILD    
  $("#build_button:not(.active)").click(function() {
    hideTrade();
    $(this).parent().parent().toggleClass("clicked");
  });
      $("#build_settle").click(function() {
        $(".road.active").hide('300');
        $(".settle.active").toggle('300');
      });
      
      $("#build_road").click(function() {
        $(".settle.active").hide('300');
        $(".road.active").toggle('300');
      });
      
      $("#build_town").click(function() {
        $(".settle."+color+":not(.town)").toggleClass("upgrade");
      });
      
      $(document).on("click", ".settle.active", function(event) {
        $.post("ajax/build", {game_id: game, item: "settlement", id: $(this).attr("settle")})
                .done(function(data) {
                  hideDevelop();
                  loadJSON(game);
                })
                .error(function(data) {
                  alert(data.responseText);
                });
      });
      
      $(document).on("click", ".settle.upgrade", function(event) {
        $.post("ajax/build", {game_id: game, item: "town", id: $(this).attr("settle")})
                .done(function(data) {
                  hideDevelop;
                  loadJSON(game);
                })
                .error(function(data) {
                  alert(data.responseText);
                });
      });
      
      $(document).on("click", ".road.active", function(event) {
        $.post("ajax/build", {game_id: game, item: "road", id: $(this).attr("road")})
                .done(function(data) {
                  hideDevelop
                  loadJSON(game);
                })
                .error(function(data) {
                  alert(data.responseText);
                });
      });
      
  // CARDS    CARDS    CARDS    CARDS    CARDS    CARDS    CARDS   
  $("#buy_card_button").click(function() {
    $.post("ajax/build", {game_id: game, item: "card", id: null})
        .done(function(data) {
          loadJSON(game);
        })
        .error(function(data) {
          alert(data.responseText);
        });
  });
  // purchasing card   purchasing card   purchasing card   
  $(document).on("click", ".knight", function(event){
    var r  = confirm("Czy na pewno chcesz zagrać tę kartę?");
    if(r)
    {
      $.post("ajax/playcard", {game_id: game, id: $(this).attr("card")})
            .done(function(data) {
              alert("Zagrano :)");
            })
            .error(function(data) {
              alert(data.responseText);
            });
    }
  });
  
  // monopoly card   monopoly card   monopoly card 
  var card_id;
  $(document).on("click", ".monopoly", function(){
    $(".resource").addClass("for_monopoly");
    card_id = $(this).attr("card");
  });
  $(document).on("click", ".for_monopoly .res_card", function(){
    $.post("ajax/playcard", {game_id: game, res: $(this).attr("res"), id: card_id})
        .done(function(data) {
          alert("Zagrano :) Zgrniasz wszystko!");
          loadJSON(game);
        })
        .error(function(data) {
          alert(data.responseText);
        });
    $(".resource").removeClass("for_monopoly");
  });
  // year of plenty card   year of plenty card   year of plenty card
  $(document).on("click", ".yearofplenty", function(){
    showTrade();
    $(".usercard figure").removeClass("clickable");
    card_id = $(this).attr("card");
  });
  $(document).on("click", "#trade_button_yearofplenty", function(){
    $.post("ajax/playcard", jQuery.param(jQuery.merge($("#trade_form").serializeArray(),[{name:"id",value:card_id}])))
        .done(function(data) {
          alert("Zagrano :) Masz wymarzone dwa surowce!");
          loadJSON(game);
        })
        .error(function(data) {
          alert(data.responseText);
        });
    hideTrade();
  });
  // TRADE     TRADE     TRADE     TRADE     TRADE     TRADE     TRADE    
  function clearform() {
    document.getElementById("trade_form").reset();
    fromform(false);
  }
  function fromform(resource) {
    if(resource==false)
    {
      var res_array = ["wood","sheep","stone","wheat","clay"];
    }
    else
    {
      var res_array = [resource];
    }
    $.each(res_array, function(index, res){
      var q = $("#trade_form").find("[res=\"" + res + "\"]").val();
      var res_box = $(".res_card." + res).parent();
      var spanres = res_box.find(" p span").first().html();
      var spandiff = res_box.find(" p span").last();
      spandiff.html(parseInt(+spanres)+parseInt(q));
      if(q>0)
        {
          res_box.find(".up").html("+"+q).css("font-size","25px");
        }
        else
        {
          if(q<0)
          {
            res_box.find(".down").html(q).css("font-size","25px");
          }
          else
          {
            res_box.find(".up").empty().html("+").css("font-size","30px");
            res_box.find(".down").empty().html("-").css("font-size","30px");
          }
        }
    });
  }
  $(document).on("click", "#trade_button:not(.clicked)", function(event) {
    hideDevelop();
    showTrade();   
  });
  $(document).on("click", ".button.clicked", function(event) {
    hideTrade();
    hideDevelop();
  });
    $(document).on("click", "figure.clickable", function(event) {
      var usercard = $(this).parent().parent();
      usercard.toggleClass("trading");
    });
    
    $(".trade.up").click(function() {
      var res = $(this).parent().find(".res_card").attr("res");
      var spanoffer = $("#trade_form").find("[res=" + res + "]").val();
      var q = (+spanoffer) + 1; 
      $("#trade_form").find("[res=" + res + "]").val(q);
      fromform(res);
    });
    
    $(".trade:not(.greyscale).down").click(function() {
      var res = $(this).parent().find(".res_card").attr("res");
      var spanoffer = $("#trade_form").find("[res=" + res + "]").val();
      var q = (+spanoffer) - 1; 
      $("#trade_form").find("[res=" + res + "]").val(q);
      fromform(res);
    });
    
    $(document).on("click", "#trade_button_accept.send", function(event) {
      $.post("ajax/trade", $("#trade_form").serialize())
              .done(function(data) {
                loadJSON(game);
                $("#trade_button_outside").removeClass("clicked");
                alert("Wysłano");
                clearform();
              })
              .error(function(data) {
                alert(data.responseText);
              });
    });
    
    $(document).on("click", "#trade_button_accept.accept", function(event) {
      $.post("ajax/tradeaccept", $("#trade_form").serialize())
              .done(function(data) {
                loadJSON(game);
                alert("Zaakceptowano :D");
                clearform();
              })
              .error(function(data) {
                alert(data.responseText);
              });
    });
    
    $(document).on("click", "#trade_button_accept.confirm", function(event) {
      $.post("ajax/tradeconfirm", $("#trade_form").serialize())
              .done(function(data) {
                loadJSON(game);
                alert("Potwierdzono");
                clearform();
              })
              .error(function(data) {
                alert(data.responseText);
              });
    });
    
    $(document).on("click", "#trade_button_reject.cancel", function(event) {
     clearform();
    });
    
    $(document).on("click", "#trade_button_reject.reject", function(event) {
      $.post("ajax/tradereject", $("#trade_form").serialize())
              .done(function(data) {
                loadJSON(game);
                clearform();
              })
              .error(function(data) {
                alert(data.responseText);
              });
    });
    
    $(document).on("click", "#trade_button_reject.delete", function(event) {
      $.post("ajax/tradedelete", $("#trade_form").serialize())
              .done(function(data) {
                loadJSON(game);
                clearform();
              })
              .error(function(data) {
                alert(data.responseText);
              });
    });
  // ENDTURN   ENDTURN   ENDTURN   ENDTURN   ENDTURN   ENDTURN   ENDTURN   
  $("#endturn_button").click(function() {
    $(".usercard figure").toggleClass("clickable");
    $.post("ajax/next", {game_id: game})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  var current;
  var player;
  $("#loadjson").click(function() {
    loadJSON(game);
  });
  setInterval(function() {
    if (current != player)
    {
      loadJSON(game);
    }
  }, 3000);  
  // LOAD JSON   LOAD JSON   LOAD JSON   LOAD JSON   LOAD JSON   LOAD JSON   
  function loadJSON(game) {
    $.getJSON("ajax/update", {game_id: game})
      .done(function(data) {
        $("#board").find(".road").remove();
        $("#board").find(".settle").remove();
        // settlements   settlements   settlements   
        $.each(data.board.settlements, function(index, item, i) {
          $("<div>")
                  .addClass(item.classes)
                  .css(item.styles)
                  .attr(item.attr)
                  .appendTo("#board")
        });
        // roads   roads   roads   roads
        $.each(data.board.roads, function(index, item) {
          $("<div>")
                  .addClass(item.classes)
                  .css(item.styles)
                  .attr(item.attr)
                  .appendTo("#board");
        });
        $.each(data.opponents, function(index, item) {
          $("[player=" + index + "]").find("p.res_number span").html(item.resources);
        });
        // resources   resources   resources   resources   
        $.each(data.player.resources, function(index, item) {
          var card = $(".res_card." + index);
          if (item == 0)
          {
            card.addClass("greyscale");
            card.find("p span").html(item);
          }
          else
          {
            card.removeClass("greyscale");
            card.find("p span").html(item);
          }
        });
        // dev cards   dev cards   dev cards   dev cards   
        $("#dev_cards").html("");
        $.each(data.player.cards, function(index, item) {
          $("<div>")
                  .addClass(item.classes)
                  .appendTo("#dev_cards")
                  .append($("<div>").addClass($(".your div figure p").attr("class")))
                  .attr(item.attr);
        });
        // trades hosted   trades hosted   trades hosted
          $("#trade_button_accept").addClass("send").removeClass("accept").removeClass("confirm").find("span").html("Wyślij");
          $("#trade_button_reject").addClass("cancel").removeClass("reject").removeClass("delete").find("span").html("Anuluj");
        
        if (data.player.trades_hosted.length){
          $("#trade_button_accept").addClass("confirm").removeClass("accept").removeClass("send").find("span").html("Potwierdź");
          $("#trade_button_reject").addClass("delete").removeClass("reject").removeClass("cancel").find("span").html("Rezygnuj");
        }
        
        // trade received   trade received   trade received   
        if (data.player.trade_received)
        {
          $("#button_trade_outside").addClass("withtrade clicked");
          $(".res_card p").addClass("trading");
          $(".trade").slideDown('300');
          $("#trade_button_accept").addClass("accept").removeClass("confirm").removeClass("send").find("span").html("Akceptuj");
          $("#trade_button_reject").addClass("reject").removeClass("delete").removeClass("cancel").find("span").html("Odrzuć");
          var trade = data.player.trade_received;
          var usercard = $("[player=" + trade.host_id + "]");
          $("#trade_form").find("[name=player_" + trade.host_id + "]").prop('checked', true);
          usercard.addClass("withoffer");
          $("#trade_form").find("[res=\"wood\"]").val(trade.wood);
          $("#trade_form").find("[res=\"stone\"]").val(trade.stone);
          $("#trade_form").find("[res=\"sheep\"]").val(trade.sheep);
          $("#trade_form").find("[res=\"clay\"]").val(trade.clay);
          $("#trade_form").find("[res=\"wheat\"]").val(trade.wheat);
          fromform(false);
        }
        $("#die1").html(data.dice[0]);
        $("#die2").html(data.dice[1]);
        $("#turn span").html(data.turn);
        $("[player]").removeClass("current");
        $("[player='" + data.current + "']").addClass("current");
        current = data.current;
        player = data.player.id;
        color = data.player.color;
        $("#thief").remove();
        $("[tile=\"" + data.thief + "\"]").append($("<div id=\"thief\"></div>"));
        $(".usercard.current").parent().addClass("current");
      })
      .error(function(data) {
      });
  }
  ;
});

// TEXTSELECT    TEXTSELECT    TEXTSELECT    TEXTSELECT    TEXTSELECT    
function disableText(e) {
  return false;
}
function reEnable() {
  return true;
}
document.onselectstart = new Function("return false");

if (window.sidebar) {
  document.onmousedown = disableText;
  document.onclick = reEnable;
}
