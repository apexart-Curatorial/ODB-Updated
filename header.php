<?php
if (!isset($ptitle)) $ptitle="apexart";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML lang=en-US><HEAD><TITLE><?=$ptitle?></TITLE>

<meta name="Description" content="" />
<meta name="Keywords" content="" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="admin@bulbish.com" />
<meta name="Robots" content="index,follow" />

<link href="cfr.css" rel="stylesheet" type="text/css" />


</HEAD>
<BODY>


<?php 
?>



<span class="hhhg" style="float:left;">
<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>apexart</i><br/><br/>
</span>



<span class="loginInfo partnerLink">
<?php
	if (isset($_SESSION["uname"]))
	{  	
		$msg = "Logged in as <b>".$_SESSION['uname']."</b><br/>Access Level ".$_SESSION['accessLevel'];
	}
	else $msg="Not Logged In.";
	
	echo $msg;
	
	?>

	
	<?php
?>
</span>

<?php include "links.php";
?>



<br/><br/><br/><br/>

<div class="contextbox">

