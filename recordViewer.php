<?php
header("Content-type: text/plain");
error_reporting(E_ALL);
$row = 1;
$bas = file_get_contents ("aadb.tab");
$lines = explode("\r", $bas);

$dbhost = 'localhost'; $dbuser = 'root'; $dbpass = ''; $dbname = 'heather';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname, $conn) or die ('Error selecting DB');







//       http://localhost:8080/heatherData/getDonations.php
foreach ($lines as $data)
{
    if (strlen($data)<5) continue;
    $fields = explode("\t", $data);


    	if ($row==230) print_r($fields);
	    for ($i=0;$i++;$i<9)// no more than 9 donations
	    {
		    /*



		    */


		    /*
		    $mystring = $fields[17];
		    //echo "mystring is $mystring</br>";//, 'domestic' strpos is ".strpos($mystring, "domestic")."<br/>";
			$stat["invitation"] = (strpos($mystring, "invitation")!==false)? 1: 0;
			$stat["domestic"] = (strpos($mystring, "domestic")!==false)? 1: 0;
			$stat["foreign"] = (strpos($mystring, "foreign")!==false)? 1: 0;
			$stat["press"] = (strpos($mystring, "press")!==false)? 1: 0;
			$stat["nn"] = (strpos($mystring, "n & n")!==false)? 1: 0;
			$stat["feedback"] = (strpos($mystring, "feedback")!==false)? 1: 0;
			$stat["member"] = (strpos($mystring, "member")!==false)? 1: 0;
			$stat["foundation"] = (strpos($mystring, "foundation")!==false)? 1: 0;
			$stat["consulate"] = (strpos($mystring, "consulate")!==false)? 1: 0;
			$stat["donor"] = (strpos($mystring, "donor")!==false)? 1: 0;
			$stat["inKindDonor"] = (strpos($mystring, "in-kind donor")!==false)? 1: 0;
			$stat["potDonor"] = (strpos($mystring, "pot. donor")!==false)? 1: 0;
			$stat["edu"] = (strpos($mystring, "edu")!==false)? 1: 0;
			$stat["funder"] = (strpos($mystring, "funder")!==false)? 1: 0;

		    //print_r($stat);
		    echo "X";

		    //27 records altogether
		    $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`) VALUES('%s','%s','%s',%d)",	
							    mysql_real_escape_string($fields[0]),
							    mysql_real_escape_string($fields[1]),
							    mysql_real_escape_string($fields[2]),
							    $row
							);


				$result = mysql_query($query, $conn); 
				checkError($result,$query);
				*/
		}
		$row++;//increment user count
    
}




echo "All records saved.";


  function checkError($result,$query)
  {
	if (!$result) {
		    $message  = '<br>Invalid query: ' . mysql_error() . "<br>";
		    $message .= 'Whole query: ' . $query;
		    die($message);
	}
  }

?> 