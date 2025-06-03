<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";
			include "loginCheck.php";
			include "header.php";

			$d=new DBX();
			//$count=$d->Count();
			if (isset($_REQUEST["stuffISsubmitted"])) 
			{

				$d->createDonation($_REQUEST);
				echo "<font color='green'>Donation Created.</font><br/><br/>"; //die(); 
		
			}	
			// id  date  ammount  paymentMethod  donorID  position 
?>
	<h4>Add a Donation.</h4> <br/>
	<form action='<?=$_SERVER['PHP_SELF']?>' method="GET" >
			Date:<br/>
 			<input type="text" name="date" value="" />&nbsp;&nbsp;&nbsp;<i><?=date("Y-m-d");?></i><br/><br/>
			Amount:  <br/>
			<input type="text" name="ammount" value="" /><i>&nbsp;&nbsp;&nbsp;100</i><br/><br/>
			Payment Method: <br/>
			<input type="text" name="paymentMethod" value="" />&nbsp;&nbsp;&nbsp;Mastercard<i></i><br/><br/>
			<input type="hidden" name="position" value="10" /> <!-- &nbsp;&nbsp;&nbsp;<i><?=$d->donationPosition?></i><br/><br/> -->
			<input type="hidden" value="<?=(isset($_GET["person"])?$_GET["person"]:0)?>" name="donorID" />
			<input type="hidden" value="<?=(isset($_GET["person"])?$_GET["person"]:0)?>" name="person" />
			<input type="submit" value="Create Donation for person <?=$_GET["person"]?>" name="stuffISsubmitted" onclick="return confirm('Are you sure you want to add the donation?')" />
			<br/>

		</form>
	<a href="<?=$_SESSION['lastSearch']?>">Back to Last Search</a><br/><br/><br/>
<?php
include("donationView.php");
include("footer.php"); 

?>

			
			
			