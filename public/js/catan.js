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
    usercard.find(".offer").slideToggle(150);
    usercard.find(".stats").slideToggle(150);
  });
  $(".trade.up").click(function() {
    var res = $(this).parent().find(".res_card").attr("res");
    var span = $(".offer").find("." + res);
    var q = (+span.html()) + 1;
    span.html(q);
    $("#trade_form").find("[res=" + res + "]").val(q);
  });
  $(".trade.down").click(function() {
    var res = $(this).parent().find(".res_card").attr("res");
    var span = $(".offer").find("." + res);
    var q = (+span.html()) - 1;
    span.html(q);
    $("#trade_form").find("[res=" + res + "]").val(q);
  });
  $("#trade_submit").click(function() {
    $.post("ajax/trade", $("#trade_form").serialize())
            .done(function() {
              alert("jupi!");
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
  $(document).on("click", ".road.active", function(event) {
    $.post("ajax/build", {game_id: game, item: "road", id: $(this).attr("road")})
            .done(function(data) {
              loadJSON(game);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  });
  $("#loadjson").click(function() {
    loadJSON(game);
  });
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
                  card.find("p span").first().html("");
                }
                else
                {
                  card.removeClass("greyscale");
                  card.find("p span").first().html(item);
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
              $.each(data.player.trades_hosted, function(index, item) {
                var div = $("[player=" + item.client_id + "]").find(".offer");
                div.find(".wood").html(item.wood);
                div.find(".stone").html(item.stone);
                div.find(".sheep").html(item.sheep);
                div.find(".clay").html(item.clay);
                div.find(".wheat").html(item.wheat);
              });
              if (data.player.trade_received)
              {
                var trade = data.player.trade_received;
                var usercard = $("[player=" + trade.host_id + "]");
                usercard.addClass("trading");
                usercard.find(".stats").hide(150);
                var div = usercard.find(".offer");
                div.show(150);
                div.find(".wood").html(trade.wood);
                div.find(".stone").html(trade.stone);
                div.find(".sheep").html(trade.sheep);
                div.find(".clay").html(trade.clay);
                div.find(".wheat").html(trade.wheat);
              }
              $("#die1").html(data.dice[0]);
              $("#die2").html(data.dice[1]);
              $("#turn span").html(data.turn);
            })
            .error(function(data) {
              alert(data.responseText);
            });
  }
  ;
});