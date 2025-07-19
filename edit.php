<?php
			error_reporting(E_ALL);
			require_once 'DBX.php';
			session_start();
			include "loginCheck.php";
			if (!isset($_SESSION['accessLevel']) || ($_SESSION['accessLevel'])==1)
			{
				header("Location: search.php");
				die();
			}
				
		

			$d = new DBX();
			$record = [];
			//$count=$d->Count();
			if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
			    $record = $d->getPersonByID($_GET['id']);
			    if (!$record) {
			        die("Record not found.");
			    }
			} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
			    if (!empty($_POST['id'])) {
			        $d->updateSubmission($_POST);
			        header("Location: results.php");
			        exit();
			    } else {
			        die("Error: Missing ID for update.");
			    }
			} else {
			    die("Invalid request.");
			}

			require_once "header.php";
			if (isset($_REQUEST["stuffISsubmitted"])) 
			{
				if ($_REQUEST["person"]==0) //if NEW PERSON and stuffISsubmitted just create the person and then die.
				{
					$s=$d->CreateSubmission($_REQUEST);
					if ($s==true)
					{
							echo "Person created!<br/><br/><a href='index.php'>home</a><br/><br/><i>Please don't use the BACK button on your browser.<i/>";
							die();
					}
					
					echo "<font color='red'>Person with this name already exists!</font><br/>Check the box and click UPDATE if you still want to create the person";
					?>
					<br/><a href="results.php?searchString=<?=$_REQUEST["firstname"]?>&theType=firstname&searchString2=<?=$_REQUEST["lastname"]?>&theType2=lastname&searchStarted=SEARCH" target="_blank">click to see</a>
					<?php					$s=$_REQUEST;
					//die();
				}
				else//UPDATE
				{
				
				$s=$d->LoadSubmission($_REQUEST["person"]);//UPDATING not all keys are preset in the POST, get the missing fields
				//print_r($s);
				
				foreach ($_REQUEST as $key=>$value)// overwrite the keys that were set in the form
				{
					$s[$key]=$_REQUEST[$key];
				}
				//print_r($_REQUEST);
				foreach ($d->statCols as $value)// now we need to reset the checkboxes , because checkboxes=0 are missing from POST and therefore dont get unset from 1 to 0 
				{
					if (!isset($_REQUEST[$value]))$s[$value]=0;// if checkbox not set means that we want to unsubscribe from that checkbox
				}
				
				$d->UpdateSubmission($s);
				echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><center><font color='green'>Update Successful!</font><br/><br/>";?>
				
				<a href="<? if (isset($_SESSION['lastSearch'])) echo $_SESSION['lastSearch']; else echo '#'; ?>">Back to Last Search</a>
				<?php				die();
				//$s=$_REQUEST;
				}
			}	
			else 
				if (isset($_GET["person"])) $s=$d->LoadSubmission($_GET["person"]);
				else $s=null;	
			//print_r($s);
?>
<center>	
	<h4>Add/Edit People Records.</h4>
	<form method="POST" action="edit.php">
<?php
			$j=0;
		//`firstname`, `lastname`, `company`, `address`, `city`,  `state`, `zip`, `country`, `phone`, `fax`, `email`, `comments`,  `creditLine`, `invitation`,`domestic`, `foreign`, `press`, `nn`, `feedback`,  `member`, `foundation`, `consulate`,  `donor`, `inKindDonor`,  `potDonor`, `edu`, `funder` 
if (!empty($record['id'])) {
    echo "<input type=\"hidden\" name=\"id\" value=\"" . htmlspecialchars($record['id']) . "\">";
}
				echo '<table width="800">';
				echo "<tr><td width='5%' rowspan='2'>";
				
				
				echo (isset($s["id"])?$s["id"]:"");
				
				echo "&nbsp;</td><td width='20%' rowspan='2'>";
				//unset($s["firstname"]);
				echo "First Name<br/><input type=\"text\" name=\"firstname\" value=\"" . htmlspecialchars($record['firstname'] ?? '') . "\"><br>";
				
				echo "<br/><br/>";
				echo "Last Name<br/><input type=\"text\" name=\"lastname\" value=\"" . htmlspecialchars($record['lastname'] ?? '') . "\"><br>";
				
				echo "<br/><br/>";
				echo "Title<br/><input type=\"text\" name=\"title\" value=\"" . htmlspecialchars($record['title'] ?? '') . "\"><br>";
				
				echo "<br/><br/>";
				echo "Company<br/><input type=\"text\" name=\"company\" value=\"" . htmlspecialchars($record['company'] ?? '') . "\"><br>";
				
				echo "<br/><br/>";
				echo "Phone<br/><input type=\"text\" name=\"phone\" value=\"" . htmlspecialchars($record['phone'] ?? '') . "\"><br>";
				
				echo "<br/><br/>";
				echo "Fax<br/><input type=\"text\" name=\"fax\" value=\"" . htmlspecialchars($record['fax'] ?? '') . "\"><br>";
				
				
				
				echo "</td><td rowspan='2' style='text-align:right;' width='30%'>";
				echo "Address&nbsp;&nbsp;<br/><input type=\"text\" name=\"address\" value=\"" . htmlspecialchars($record['address'] ?? '') . "\"><br>";
				echo "City&nbsp;&nbsp;<br/><input type=\"text\" name=\"city\" value=\"" . htmlspecialchars($record['city'] ?? '') . "\"><br>";
				echo "State&nbsp;&nbsp;<br/><input type=\"text\" name=\"state\" value=\"" . htmlspecialchars($record['state'] ?? '') . "\"><br>";
				echo "Zip&nbsp;&nbsp;<br/><input type=\"text\" name=\"zip\" value=\"" . htmlspecialchars($record['zip'] ?? '') . "\"><br>";
				echo "Country&nbsp;&nbsp;<br/><input type=\"text\" name=\"country\" value=\"" . htmlspecialchars($record['country'] ?? '') . "\"><br>";
				echo "<br/><br/>";
				echo "Email&nbsp;&nbsp;<br/><input type=\"text\" name=\"email\" value=\"" . htmlspecialchars($record['email'] ?? '') . "\"><br>";
				echo "<br/>Alternative contact&nbsp;&nbsp;<br/><input type=\"text\" name=\"alt\" value=\"" . htmlspecialchars($record['alt'] ?? '') . "\"><br>";

				
				//echo (isset($s["address"])?$s["address"]:"")."<br/>".(isset($s["city"])?$s["city"]:"").", ".(isset($s["state"])?$s["state"]:"")."<br/>".(isset($s["zip"])?$s["zip"]:"")." ".(isset($s["country"])?$s["country"]:"");
				
				
				
				
				
				
				echo "</td><td rowspan='1' width='20%'>";

				//echo "Comments<br/><input type='text' value='".(isset($s["comments"])?$s["comments"]:"")."' name='comments'/>";
				echo "Comments<br/><textarea cols='20' rows='9' wrap='ON' name='comments' >". htmlspecialchars($record['comments'] ?? '') ."</textarea>";
				
				echo "&nbsp</td><td width='15%' rowspan='2'>";
				
				
				//prints all the checkboxes depending if they have status=1 (checked) or status=0 (unchecked)
				for($k=0;$k<count($d->statCols);$k++)// less or equal than length of the array
				{
					
					echo '<input type="checkbox" value="1" '.
					(isset($s[$d->statCols[$k]])? $s[$d->statCols[$k]]==1? "checked='true'" : "" :"").
					' name="'.$d->statCols[$k].
					'" title="Statuses">&nbsp;'.
					$d->statNames[$k].'<br>';
				}
				
				echo "</td></tr><tr>";/////////////////////////////////////////////////////////////NEW ROW

				
				
				
				
				
				echo "<td>";
				echo "Credit&nbsp;Line<br/><input type='text' value='". htmlspecialchars($record['creditLine'] ?? '') ."' name='creditLine'/>";
				
				//echo "</td></tr><tr><td colspan='5'>&nbsp;";

				echo "&nbsp</td></tr>";
				echo "</table><br/><br/>";
				echo '<input type="checkbox" name="updateANYWAY" />&nbsp;Create Person Regardless if another exists with same name<br/><br/>';
				
		
			
			?>
			
			
			
			<input type="hidden" value="<?=(isset($_GET["person"])?$_GET["person"]:0)?>" name="person" />
			<input type="submit" value="UPDATE" name="stuffISsubmitted" onclick="return confirm('Are you sure ?')"  />
			<br/>

		</form>
		
<a href="<? if (isset($_SESSION['lastSearch'])) echo $_SESSION['lastSearch']; else echo '#'; ?>">Back to Last Search</a><br/><br/><br/>
<?php if (isset($_GET["person"])) echo "<a href='addDonation.php?person=".$_GET["person"]."' title='Add Donations'>Add Donations</a><br/><br/>";
include("donationView.php");



include("footer.php"); 

?>

			
			
			