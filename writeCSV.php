<?php 
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";
			$d=new DBX();
			//$result=$d->getAllRegistrations($_GET["query"]);
			if ($_SESSION["CSVexport"]) die ("session not set");
			$result=$_SESSION["CSVexport"];
			$d->writeCSV($_SESSION["CSVexport"]);		

			//header("Location: output.csv");
?> 
