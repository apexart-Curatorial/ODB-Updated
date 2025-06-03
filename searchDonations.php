<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";
			include "loginCheck.php";
			include "header.php";
			$page = isset($_GET["page"])? $_GET["page"]: 0; //paginator?
			
			
			$d=new DBX();
			//$count=$d->Count();
			
			//subs=$d->LoadSubmissionLIST($page,10);
			
			
			
			
?>
	<form action='resultsDonations.php' method="GET" >
<?php
		
			
?>
<center>
<h4>Donation Search</h4>
<table width='800'>
   <tr><td>
   	<blockquote>
		<br/><br/><br/><br/>Enter Date 1: <br/>
		<input type="text" value="2000-10-02" name="date1" style="width:100px;" /> 
		

		
		<br/><br/>Enter Date 2: <br/>
		<input type="text" value="2011-12-23" name="date2" style="width:100px;" /> 
	
		<br/><br/>
		<i>Enter same dates if you want a particular day. Enter a year 1979 or 2222 to get all records from all dates. </i>
		<hr/><br/>
		
		
		Enter Lower Amount: <br/>
		<input type="text" value="0" name="amount1" style="width:100px;" /> 
		

		
		<br/><br/>Enter Upper Amount: <br/>
		<input type="text" value="100000000" name="amount2" style="width:100px;" /> 
		
		<hr/>
		<br/><br/>Enter Comment: <br/>
		<input type="text" value="" name="comment" style="width:200px;" /> 
	
		<br/><br/>
		<i>Leave Empty if don't care</i>
		<hr/>
		Searches between Date 1 and Date 2, with amounts between Lower and Upper<br/><br/> 	
		<input type="submit" value="SEARCH" name="searchStarted" />
		</blockquote>
		<br/><br/>
		
		</form>
	</td>
	
<tr>
	<br/><br/><b>Search Mailing Lists only</b><br/><br/><br/>
		<center>
		<span style="width:200px; text-align:left;">
		<form action='results.php' method="GET" >
				<?php					//for($k=0;$k<14;$k++)//14 statuses
					foreach ($d->statCols as $key=>$value)
					{
						
						echo '<input type="checkbox" value="1" name="'.$value.'" title="Statuses">'.$d->statNames[$key].'<br>';
					}
				?>
		<br/><br/>
		
		
		<? if (($_SESSION['accessLevel'])>=3){ ?>
		Select Mailing List Type: <br/>
		<select size="1" name="listtype" style="width:180px;" >
		<option value="invitation" selected="true">invitation</option>
		<option value="foreign">foreign</option>
		<option value="domestic">domestic</option>
		<option value="dontcare">all lists</option>
    	</select><br/><br/>
		<input type="checkbox" value="1" name="save2CSV"/>Save to CSV<br/><br/>
		<? } ?>
		
		</form>
		</span>
	</table>
	
	
	<br/><br/><br/>	
<?php include("footer.php"); 

?>		
			