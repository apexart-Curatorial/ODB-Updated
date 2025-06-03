<?php
error_reporting(E_ALL);
$row = 1;
$bas = file_get_contents ("aadb.tab");
$lines = explode("\r", $bas);


$dbhost = 'localhost'; $dbuser = 'root'; $dbpass = ''; $dbname = 'heather';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname, $conn) or die ('Error selecting DB');



//     http://localhost:8080/heatherData/
foreach ($lines as $data){
    //$num = count($data);
    if (strlen($data)<5) continue;
    $fields = explode("\t", $data);
    //echo "<p> $num fields in line $row: <br /></p>\n";
    //$row++;
    
	/*
	echo "<table style='border: 1px solid gray'><tr>";
	foreach ($fields as $c)
	{
        echo "<td style='border: 1px solid gray'>".$c. "<font color=green> $c </font>&nbsp;</td>\n";
    }
    echo "</tr></table>";
    */
    
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
    $query = sprintf("INSERT INTO people (`firstname`, `lastname`, `company`, `address`, `city`,  `state`, `zip`, `country`, `phone`, `fax`, `email`, `comments`,  `creditLine`, `invitation`,`domestic`, `foreign`, `press`, `nn`, `feedback`,  `member`, `foundation`, `consulate`,  `donor`, `inKindDonor`,  `potDonor`, `edu`, `funder` ) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d)",	
					    mysql_real_escape_string($fields[0]),
					    mysql_real_escape_string($fields[1]),
					    mysql_real_escape_string($fields[2]),
					    mysql_real_escape_string($fields[3]),
					    mysql_real_escape_string($fields[4]),
					    mysql_real_escape_string($fields[5]),//state
					    mysql_real_escape_string($fields[6]),//zip
					    mysql_real_escape_string($fields[7]),//country
					    mysql_real_escape_string($fields[8]),
					    mysql_real_escape_string($fields[9]),//fax
					    mysql_real_escape_string($fields[10]),//email
					    mysql_real_escape_string($fields[15]), //comments
					    mysql_real_escape_string($fields[27]), //creditLine
					    $stat["invitation"],
						$stat["domestic"],
						$stat["foreign"],
						$stat["press"],
						$stat["nn"],
						$stat["feedback"],
						$stat["member"],
						$stat["foundation"],
						$stat["consulate"],
						$stat["donor"],
						$stat["inKindDonor"],
						$stat["potDonor"],
						$stat["edu"],
						$stat["funder"]
					);
	    	
		
		$result = mysql_query($query, $conn); 
		//$newUserID=mysql_insert_id() or die("Error adding a user!");
		checkError($result,$query);
	
    
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