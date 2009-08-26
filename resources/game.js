var table;

$(function() {
	$("#players").sortable();
	$("#newPlayerName").hide();

	$("#showHideNewPlayerName").click(showHideNewPlayerName);

	//gets size of window to make font bigger
	//$("#stats").html(document.documentElement.clientHeight + " by " + document.documentElement.clientWidth);
	//$("body").css('font-size','150%');

	table = new Table($("#game_id").val());

	playerCheck();

	$(document).bind('keydown', 'f2',
		function (evt){
			if($("#newPlayerName").val() == '') {
				showHideNewPlayerName();
			}
			return false;
		}
	);

	$("#newPlayerName").keypress(function(e) {
		//alert(e.which);
		if(e.which == 13) {
			var newName = $("#newPlayerName").val();
			if(newName != '') {
				var li = buildPlayerSetupElement(newName);
				$("#noPlayers").remove();
				$("#players").append(li);
				$("#newPlayerName").val('');
			}
			else {
				showHideNewPlayerName();
			}
		}
	});

	$("#guessBox").keypress(function(e) {
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
					changeStatus(data.status);
				},
				'json');
			$(this).val('');
		}
	});

});

function buildPlayerSetupElement(newName) {
	return "<li class='player'>" + newName + "</li>";
}

function showHideNewPlayerName() {
	if($("#newPlayerName").css('display') == 'none') {
		$("#newPlayerName").show().focus();
	}
	else {
		$("#newPlayerName").hide().val('');
		$("#showHideNewPlayerName").focus();
	}
}

function playerCheck() {
	if($(".player").size() == 0) {
		changeStatus("add some players (F2)");
	}
}

function changeStatus(statusText) {
	$("#status").html(statusText);
}