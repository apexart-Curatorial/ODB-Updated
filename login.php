<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";

			
			$d=new DBX();
			//$d->__construct();
			
			if (isset($_POST["xxcv"]))
			{
				$row=$d->login($_POST["xxcv"],$_POST["xxcy"]);
				$loc="message.php";
				if (isset($row))
				{
					$_SESSION["message"]="Thank you for logging in!";
					$loc="search.php";
				}
				else 
				{
					$_SESSION["message"]="Login Failed";
					$_SESSION["messageURLtext"]="Try Again";
					$_SESSION["messageURL"]="login.php";
				}	
				header("Location: ".$loc);
			}

			include "header.php";			

?>
			<br/><br/><br/><br/><br/><br/><br/>
		<center>
		<form action='<?=$_SERVER['PHP_SELF']?>' method="post">
		User Name:<br/>
		<input type="text" name="xxcv" tabindex="0"><br/>
		Password:<br/>
		<input type="password" name="xxcy"><br/>
		<input type="submit" value="Log In"><br/>
		</form>
		</center>




<?php include("footer.php") ?>