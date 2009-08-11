class Card {
	private $_rank;
	private $_suit;
	
	function __construct($initString) {
		if(length($initString) == 2) {
			$_rank = substr($initString,0,1);	
		}
	}
}