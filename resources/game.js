$(function() {
	$("#players").sortable();
	$("#newPlayerName").hide();

	$("#showHideNewPlayerName").click(showHideNewPlayerName);
	
	//gets size of window to make font bigger
	//$("#stats").html(document.documentElement.clientHeight + " by " + document.documentElement.clientWidth);
	//$("body").css('font-size','150%');
	
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
			var errorMessage = '';			

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

	$("#createGame").click(function() {
		var i=0;
		var players = new Array;
		$("#players > li").each(function() {
			players[i] = $(this).html();
			i++;
		});
		var players = players.join();
		$.post('resources/ajax/createGame.php', {'players': playersString });
	});
});

function buildPlayerSetupElement(newName) {
	return "<li class='player'>" + newName + "</li>"
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
		$("#status").html("Please add at least one player to begin");
	}
}