<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";

			
			$d=new DBX();
			//$d->__construct();
			$d->deletePerson($_GET["id"]);

			$_SESSION["message"]="Person #".$_GET["id"]." deleted.<br/><br/>";

			header("Location: message.php");

?>