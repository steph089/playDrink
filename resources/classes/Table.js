//Table javaScript class
//handles all aspects of dispalying cards in the table div
//such as loading an initial state of cards and adding additional cards (on at a time)

function Table(game_id) {
	this.add_card = add_card;
	
	$.post(
		'resources/ajax/load_table.php',
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

function add_card(card_string) {
	var num = card_string.substring(0,card_string.length - 1);				
	$("#cardContainer"+num).append("<div id='card'>" + card_string + "</div>");
}