function hideErrorMessage(id) {
	$("#"+id).removeClass('errorMessage').addClass('errorMessage_holder').html('1');	
}

function showErrorMessage(id, text) {
	$("#"+id).removeClass('errorMessage_holder').addClass('errorMessage').html(text);	
}

