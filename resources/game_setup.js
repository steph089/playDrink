$(function() {
	$("#players").sortable();
	$("#newPlayerName").focus();
	
	$("#addPlayerButton").click(function() {
		var errorMessage = '';
		hideErrorMessage('addPlayerErrorMessage');
				
		var newName = $("#newPlayerName").val();
		if(newName == '') {
			errorMessage += "gotta put a name in";
		}
		
		if(errorMessage == '') {
			var li = buildPlayerSetupElement(newName);
			$("#players").append(li);
			$("#newPlayerName").val('');
		}
		else {
			showErrorMessage('addPlayerErrorMessage', errorMessage);
		}	
		
		return false;
	});
});

function buildPlayerSetupElement(newName) {
	return "<li class='player'>" + newName + "</li>"
}