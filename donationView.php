<?php	if (isset($_GET["person"]))
	{
		$result=$d->LoadDonationLIST($_GET["person"]);
		echo '<table width="450">';
		if (!mysql_num_rows($result)) echo "</br>NO DONATIONS<br/>"; 
		else
		{
			echo "Donations:<br/><tr>";

				echo "<td width='20%'>";
				echo "ID";
				echo "&nbsp;</td>";
				
				echo "<td width='20%'>";
				echo "Date";
				echo "&nbsp;</td>";
				
				echo "<td width='20%'>";
				echo "Amount";
				echo "&nbsp;</td>";
				
				
				echo "<td width='40%'>";
				echo "Payment Method";
				echo "&nbsp;</td>";
				
				//echo "<td width='20%'>";
				//echo "Year";
				//echo "&nbsp;</td>";
				
				
				echo "</tr>";
		}
		while ($s = mysql_fetch_assoc($result)) 
		{
				// id  date  ammount  paymentMethod  donorID  position 
				echo "<tr>";

				echo "<td width='20%'>";
				echo $s["id"];
				echo "&nbsp;</td>";
				
				echo "<td width='20%'>";
				echo date("m.d.Y",$s["unixDate"]);//$s["date"]; //
				echo "&nbsp;</td>";
				
				echo "<td width='20%'>";
				echo $s["ammount"];
				echo "&nbsp;</td>";
				
				
				echo "<td width='40%'>";
				echo $s["paymentMethod"];
				echo "&nbsp;</td>";
				
				//echo "<td width='20%'>";
				//echo $s["position"];
				//echo "&nbsp;</td>";
				
				
				echo "</tr>";
		}
		echo "</table>";
	
	}
	?>