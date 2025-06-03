<?php
			error_reporting(E_ALL);
			session_start();
			

			include "header.php";
			
			if (!isset($_SESSION["messageURL"])) $messageURL="index.php";
			else $messageURL=$_SESSION["messageURL"];
			
			if (!isset($_SESSION["messageURLtext"])) $messageURLtext="home";
			else $messageURLtext=$_SESSION["messageURLtext"];
			
			if (!isset($_SESSION["message"])) $message="Success";
			else $message=$_SESSION["message"];
			
			echo "<center>";
			echo $message;
			echo "<br/><a href='".$messageURL."'>$messageURLtext</a>";
			unset($_SESSION["messageURL"], $_SESSION["messageURLtext"], $_SESSION["messageURL"]);
			
?>




<?php include("footer.php") ?>