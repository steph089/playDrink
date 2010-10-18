var table;

$(function() {
	$("#players").sortable({
		stop: function(event, ui)
		{
			var game_id = $("#game_id").val();
			var player_order = new Array($(".player").size());
			var i = 0;
			$(".player").each(function() {
				player_order[i] = $(this).attr('player_id');
				i++;
			});
			$.post(
				'resources/ajax/reorder_players.php',
				{
					'game_id':game_id,
					'new_order':player_order.join()
				},
				function(data)
				{

				},
			'json');
		}
	});
	$("#new_player_name").hide();

	

	//gets size of window to make font bigger
	//$("#stats").html(document.documentElement.clientHeight + " by " + document.documentElement.clientWidth);
	//$("body").css('font-size','150%');

	table = new Table($("#game_id").val());	

	$(document).bind('keydown', 'f2',
		function (evt){
			if($("#new_player_name").val() == '') {
				show_hide_new_player_name();
			}
			return false;
		}
	);

	$("#new_player_name").keypress(function(e) {
		//alert(e.which);
		if(e.which == 13) {
			var game_id = $("#game_id").val();
			var new_name = $("#new_player_name").val();
			if(new_name != '') {
				$.post(
					'resources/ajax/add_player.php',
					{
						'name': new_name,
						'game_id':game_id
					},
					function(data)
					{
						$("#no_players").remove();
						$("#players").append(data.li);
						$("#new_player_name").val('');
						change_status(data.status);
					},
				'json');

			}
			else {
				show_hide_new_player_name();
				$("#guess_box").focus();
			}
		}
	});

	$("#guess_box").keypress(function(e) {
		//alert(e.which);
		if(e.which == 13) {
			$.post(
				'resources/ajax/parse_guess.php',
				{
					'game_id'	: $("#game_id").val(),
					'guess'		: $(this).val()
				},
				function(data) {
					if($("#guess_num").val() == 2 || data.end_turn)
					{						
						table.add_card(data.card_string);
					}

					if(data.end_turn)
					{
						if(data.drinkers_id != undefined)
						{
							//alert("adding " + data.drinkers_drinks + " drinks to " + data.drinkers_id);
							var cur_drinks = $("li[player_id=" + data.drinkers_id + "]").children(".player_drinks").html();							
							$("li[player_id=" + data.drinkers_id + "] > .player_drinks").html(parseInt(cur_drinks) + data.drinkers_drinks);
						}
						
						if(data.new_dealer_id != undefined)
						{
							$(".dealer").removeClass('dealer');
							$("li[player_id=" + data.new_dealer_id + "]").addClass('dealer');
						}

						if(data.new_player_id != undefined)
						{
							$(".cur_player").removeClass('cur_player');
							$("li[player_id=" + data.new_player_id + "]").addClass('cur_player');
						}

						$("#gets").html(data.gets);
					}

					$("#geuss_num").val(data.guess);
					change_status(data.status);
				},
				'json');
			$(this).val('');
		}
	});

  $("#game_status").click(function ()
  {
    $.get('resources/ajax/game_status.php?game_id=' + $("#game_id").val(),
      function (data)
      {
        change_status(data.status);
      });
  });

});


function change_status(statusText) {
	$(".new_status").removeClass('new_status');
	$("#status").prepend("<div class='new_status'>" + statusText + "</div>");
	$(".new_status").hide().fadeIn('slow');
}

function show_hide_new_player_name() {
	if($("#new_player_name").css('display') == 'none') {
		$("#new_player_name").show().focus();
	}
	else {
		$("#new_player_name").hide().val('');
		//$("#show_hide_new_player_name").focus();
	}
}
