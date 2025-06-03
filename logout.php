<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";

			
			$d=new DBX();
			//$d->__construct();
			$d->Logout();

			$_SESSION["message"]="Logged Out";
			//$_SESSION["messageURLtext"]="y Again";

			header("Location: message.php");

?>