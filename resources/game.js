var table;

$(function() {
	$("#players").sortable();
	$("#new_player_name").hide();

	$("#show_hide_new_player_name").click(show_hide_new_player_name);

	//gets size of window to make font bigger
	//$("#stats").html(document.documentElement.clientHeight + " by " + document.documentElement.clientWidth);
	//$("body").css('font-size','150%');

	table = new Table($("#game_id").val());

	playerCheck();

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
			var new_name = $("#new_player_name").val();
			if(new_name != '') {
				var li = build_player_setup_element(new_name);
				$("#no_players").remove();
				$("#players").append(li);
				$("#new_player_name").val('');
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
					'game_id'	:$("#game_id").val(),
					'guess'		:$(this).val(),
					'guess_num'	:$("#guess_num").val(),
				},
				function(data) {
					if($("#guess_num").val() == 2 || data.end_turn)
					{
						$("#guess_num").val('1');
						table.add_card(data.card_string);
					}
					else
					{
						$("#guess_num").val('2');
					}
					change_status(data.status);
				},
				'json');
			$(this).val('');
		}
	});

});


function change_status(statusText) {
	$("#status").hide().html(statusText).fadeIn('slow');
}