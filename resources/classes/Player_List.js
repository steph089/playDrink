//Players JS Class

function Player_List(game_id) {
	this.build_player_setup_element = build_player_setup_element;
	this.show_hide_new_player_name = show_hide_new_player_name;
	this.player_check = player_check;
	
	$.post(
		'resources/ajax/load_players.php',
		{ 'game_id':game_id },
		function(data) {
			table_array = data.split(',');
			for(var i = 0; i < table_array.length; i++)
			{
				add_card(table_array[i]);
			}
		}
	);
	
}




function build_player_setup_element(new_name) {
	return "<li class='player'>" + new_name + "</li>";
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

function playerCheck() {
	if($(".player").size() == 0) {
		change_status("add some players (F2)");
	}
}
