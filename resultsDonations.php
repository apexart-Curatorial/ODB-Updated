<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";
			include "loginCheck.php";
			
			
		    $d=new DBX();
			$subs=$d->SearchDonations($_REQUEST["date1"], $_REQUEST["date2"], $_REQUEST["amount1"], $_REQUEST["amount2"], $_REQUEST["comment"]);
			
			include "header.php";
			
?>
<center>	
<?php
			
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		///output the GRID
		$j=1;
		while ($s = mysql_fetch_assoc($subs)) 
		{
				
				//$rrr=$d->randomColor();
				echo '<table width="800">';
				echo "<tr>";

				echo "&nbsp</td><td width='5%' title='id'>";
				echo $s["id"];
				
				echo "&nbsp</td><td width='5%' title='donor id'>";
				echo $s["donorID"];
				
				echo "&nbsp</td><td width='30%' title='date'>";
				echo date("m.d.Y",$s["unixDate"]);;
				
				echo "&nbsp</td><td width='30%' title='amount'>";
				echo $s["ammount"];
				
				echo "&nbsp</td><td width='30%' title='paymentMethod'>";
				echo $s["paymentMethod"];
				
				echo "&nbsp</td>";
				
				echo "</tr><tr>";/////////////////////////////////////////NEW ROW
				
				echo "<tr>";

				echo "&nbsp</td><td width='5%' title='id'>";
	
				
				echo "&nbsp</td><td width='5%' title='donor id'>";

				
				echo "&nbsp</td><td width='30%' title='firstname'>";
				echo $s["firstname"];
				
				echo "&nbsp</td><td width='30%' title='lastname'>";
				echo "<a href='edit.php?person=".$s['donorID']."' title='Edit personal information'>".$s['lastname']."</a>";
				
				echo "&nbsp</td><td width='30%' title='paymentMethod'>";
				echo "&nbsp</td>";
				
				echo "<tr>";
				echo "</table>";
				
				if ($j % 10 ==0) echo "<br/><hr/><br/>"; $j++;
				
			}
			
			
	
			
			
			
			?>
			
			



<?php include("footer.php"); 

?>
			
			
			