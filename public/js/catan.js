$(document).ready(function() {
  var game = $("#game_id").val();
  $.getJSON("ajax/board", {game_id: game})
          .done(function(data) {
            $.each(data.tiles, function(index, item) {
              $("<div>")
                      .hide()
                      .addClass(item.classes)
                      .css(item.styles)
                      .append($("<span>").html(item.prob))
                      .append($("<div class=\"face1\"></div>"))
                      .append($("<div class=\"face2\"></div>"))
                      .appendTo("#board")
                      .delay(50 * index)
                      .fadeIn(120);
            });
            $.each(data.ports, function(index, item) {
              $("<div>")
                      .hide()
                      .addClass(item.classes)
                      .css(item.styles)
                      .appendTo("#board")
                      .delay(720)
                      .fadeIn(120);
            });
          });
  loadJSON(game);
  $("#build_button").click(function() {
    $(".road.active").hide();
    $(".settle.active").hide();
    $(".trade").slideUp('300');
    $("#slide2").slideUp('300');
    $(".res_card p").removeClass("trading");
    $(this).parent().toggleClass("clicked");
  });
  $("#build_settle").click(function() {
    $(".road.active").hide();
    $(".settle.active").toggle('300');
  });
  $("#build_road").click(function() {
    $(".settle.active").hide();
    $(".road.active").toggle('300');
  });
  $("#buy_card_button").click(function() {
    $.post("ajax/build", {game_id: game, item: "card", id: null})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $("#trade_button").click(function() {
    $(".road.active").hide();
    $(".settle.active").hide();
    $(".res_card p").toggleClass("trading");
    $(".resource").removeClass("on");
    $(".trade").slideToggle('300');
    $(".usercard figure").toggleClass("clickable");
    $("#slide1").slideUp('300');
    $("#slide2").slideUp('300');
    $("#trade_submit").toggle('300');
    $(".res_card p span:last-of-type").toggle();
    $(this).parent().toggleClass("clicked");
  });
  $("#endturn_button").click(function() {
    $.post("ajax/next", {game_id: game})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $(document).on("click", "figure.clickable", function(event) {
    var usercard = $(this).parent().parent();
    usercard.toggleClass("trading");
  });
  $(".trade.up").click(function() {
    var res = $(this).parent().find(".res_card").attr("res");
    var spanoffer = $(".offer").find("." + res);
    var spanres = $(this).parent().find(".res_card p span").first();
    var spandiff = $(this).parent().find(".res_card p span").last();
    var q = (+spanoffer.html()) + 1;
    spanoffer.html(q);
    spandiff.html(+spanres.html() + q);
    if(q>0)
    {
      $(this).html("+"+q).css("font-size","25px");
    }
    else
    {
      if(q<0)
      {
        $(this).next().html(q).css("font-size","25px");
      }
      else
      {
        $(this).empty().html("+").css("font-size","30px");
        $(this).next().empty().html("-").css("font-size","30px");;
      }
    }
    $("#trade_form").find("[res=" + res + "]").val(q);
  });
  $(".trade.down").click(function() {
    var res = $(this).parent().find(".res_card").attr("res");
    var spanoffer = $(".offer").find("." + res);
    var spanres = $(this).parent().find(".res_card p span").first();
    var spandiff = $(this).parent().find(".res_card p span").last();
    var q = (+spanoffer.html()) - 1;
    spanoffer.html(q);
    spandiff.html(+spanres.html() + q);
    if(q>0)
    {
      $(this).prev().html("+"+q).css("font-size","25px");;
    }
    else
    {
      if(q<0)
      {
        $(this).html(q).css("font-size","25px");;
      }
      else
      {
        $(this).prev().empty().html("+").css("font-size","30px");;
        $(this).empty().html("-").css("font-size","30px");;
      }
    }
    $("#trade_form").find("[res=" + res + "]").val(q);
  });
  $("#trade_button_withbank").click(function() {
    $.post("ajax/trade", $("#trade_form").serialize())
            .done(function() {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $(document).on("click", ".settle.active", function(event) {
    $.post("ajax/build", {game_id: game, item: "settlement", id: $(this).attr("settle")})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $(document).on("click", ".settle:not(.active)", function(event) {
    $.post("ajax/build", {game_id: game, item: "town", id: $(this).attr("settle")})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $(document).on("click", ".road.active", function(event) {
    $.post("ajax/build", {game_id: game, item: "road", id: $(this).attr("road")})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $(document).on("click", "#trade_button_accept", function(event) {
    $.post("ajax/tradeaccept", $("#trade_form").serialize())
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
  function loadJSON(game) {
    $.getJSON("ajax/update", {game_id: game})
            .done(function(data) {
              $("#board").find(".road").remove();
              $("#board").find(".settle").remove();
              $.each(data.board.settlements, function(index, item, i) {
                $("<div>")
                        .addClass(item.classes)
                        .css(item.styles)
                        .attr(item.attr)
                        .appendTo("#board")
              });
              $.each(data.board.roads, function(index, item) {
                $("<div>")
                        .addClass(item.classes)
                        .css(item.styles)
                        .attr(item.attr)
                        .appendTo("#board");
              });
              $.each(data.opponents, function(index, item) {
                $("[player=" + index + "]").find("td").last().html(item.resources);
              });
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
              $("#dev_cards").html("");
              $.each(data.player.cards, function(index, item) {
                $("<div>")
                        .addClass("development_card")
                        .appendTo("#dev_cards")
                        .append($("<div>"))
                        .children().first()
                        .addClass(item.classes)
                        .attr(item.attr);
              });

              if (data.player.trade_received)
              {
                var trade = data.player.trade_received;
                var usercard = $("[player=" + trade.host_id + "]");
                $("#trade_form").find("[name=player_" + trade.host_id + "]").prop('checked', true);
                usercard.addClass("withoffer");
                div.find(".wood").html(trade.wood);
                $("#trade_form").find("[res=wood]").val(trade.wood);
                div.find(".stone").html(trade.stone);
                $("#trade_form").find("[res=stone]").val(trade.stone);
                div.find(".sheep").html(trade.sheep);
                $("#trade_form").find("[res=sheep]").val(trade.sheep);
                div.find(".clay").html(trade.clay);
                $("#trade_form").find("[res=clay]").val(trade.clay);
                div.find(".wheat").html(trade.wheat);
                $("#trade_form").find("[res=wheat]").val(trade.wheat);
              }
              $("#die1").html(data.dice[0]);
              $("#die2").html(data.dice[1]);
              $("#turn span").html(data.turn);
              $("[player]").removeClass("current");
              $("[player='" + data.current + "']").addClass("current");
              current = data.current;
              player = data.player.id;
            })
            .error(function(data) {
              alert("Musiało się zrąbać połączenie.");
            });
  }
  ;
});
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
