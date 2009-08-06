<?php

function page_logoHeader() {
	?>
	<div class='header'>
	<img src='images/logo.jpg'>
	<noscript>
		<div class='noscript'>This site requires javascript to function correctly. Honestly, we won't pepper you with pop-ups or install fake anti-virus programs. Hit allow on the NoScript and let's get schwasted.</div>
	</noscript>
	</div>
	<?php
}

function page_sidemenu() {
	echo "<div class='sidemenu'>";
	echo "<ul>";
	echo "<li style='padding-top:0px'><a href='index.html'>home<a></li>";
	if(isset($_SESSION['logged-in'])){
	  echo "<li><a href='stats.php'>stats</a></li>";
	  echo "<li><a href='logout.php'>logout</a></li>";
	}
	else
	{

	  echo "<li><a href='login.php'>login</a></li>";
	}
	echo "</li>";
	echo "</ul>";
	echo "</div>";
}

function page_userBox() {
	echo "<div class='userBox'>	";	
	if(isset($_SESSION['logged-in'])){
		include 'opendb.php';
		$username = $_SESSION['username'];
		$query = "SELECT drinks, turns, correct_guesses, correct_guesses_2 FROM users WHERE username = '$username'";
		$result = mysql_query($query)or die("Userbox Query Failed");
		$row = mysql_fetch_array($result);
	  echo "<span1>".$_SESSION['username']."</span1><BR>";
	  echo "<table><tr><td id='type2'>".$row['drinks']."</td><td>total drinks</td></tr>";
	  echo "<tr><td id='type2'>".number_format(($row['correct_guesses']+$row['correct_guesses_2'])/$row['turns']*100,2)."%</td><td>guess pct</td></tr></table>";
	  echo "<a href='logout.php'>logout</a>";
	}
	else
	{
	    echo "Playing as Guest<BR>login to track your play<br>";
		//page_loginBox();
	}
	echo "</div>";
}

?>