<?php
header("Content-type: text/plain");
error_reporting(E_ALL);
$row = 1;
$bas = file_get_contents ("aadb.tab");
$lines = explode("\r", $bas);


$dbhost = 'localhost'; $dbuser = 'root'; $dbpass = ''; $dbname = 'heather';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname, $conn) or die ('Error selecting DB');


set_time_limit(250);




//       http://localhost:8080/heatherData/getDonations.php
foreach ($lines as $data)
{
    if (strlen($data)<5) continue;
    $fields = explode("\t", $data);


    	//if ($row==230) print_r($fields);

		    /*



		    */



		    //27 records altogether//str_to_date('10-oct-2006', "%d-%b-%Y"); 
		    //STR_TO_DATE('04/31/2004', '%m/%d/%Y');

		    //$mysqldate = date( 'Y-m-d H:i:s', strtotime() );
			//$phpdate = strtotime( $mysqldate );
		    if (strlen($fields[46].$fields[47].$fields[48])>2)
		    {
				$query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 9)",	
								    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[46])) ),
								    mysql_real_escape_string($fields[47]),
								    mysql_real_escape_string($fields[48]),
								    $row
								);//9
				$result = mysql_query($query, $conn); 
					checkError($result,$query);
			 }


			if (strlen($fields[44].$fields[43].$fields[45])>2)
		    {
			 $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 8)",		
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[44])) ),
							    mysql_real_escape_string($fields[43]),
							    mysql_real_escape_string($fields[45]),
							    $row
							);//8
			$result = mysql_query($query, $conn); 
				checkError($result,$query);	
			}



		    if (strlen($fields[39].$fields[40].$fields[42])>2)
		    {			
			$query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 7)",	
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[39])) ),
							    mysql_real_escape_string($fields[40]),
							    mysql_real_escape_string($fields[42]),
							    $row
							);//7
			$result = mysql_query($query, $conn); 
				checkError($result,$query);
			}


		    if (strlen($fields[37].$fields[36].$fields[38])>2)
		    {
		    $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 6)",	
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[37])) ),
							    mysql_real_escape_string($fields[36]),
							    mysql_real_escape_string($fields[38]),
							    $row
							);//6
			 $result = mysql_query($query, $conn); 
				checkError($result,$query);
			 }


		    if (strlen($fields[33].$fields[32].$fields[34])>2)
		    {
			 $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 5)",		
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[33])) ),
							    mysql_real_escape_string($fields[32]),
							    mysql_real_escape_string($fields[34]),
							    $row
							);//5
			$result = mysql_query($query, $conn); 
				checkError($result,$query);	
			}


		    if (strlen($fields[28].$fields[29].$fields[30])>2)
		    {			
			$query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 4)",	
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[28])) ),
							    mysql_real_escape_string($fields[29]),
							    mysql_real_escape_string($fields[30]),
							    $row
							);//4			 
			$result = mysql_query($query, $conn); 
				checkError($result,$query);
			}


		    if (strlen($fields[25].$fields[26].$fields[24])>2)
		    {
		    $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 3)",	
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[25])) ),
							    mysql_real_escape_string($fields[26]),
							    mysql_real_escape_string($fields[24]),
							    $row
							);//3
			 $result = mysql_query($query, $conn); 
				checkError($result,$query);
			}



		    if (strlen($fields[23].$fields[22].$fields[21])>2)
		    {

			 $query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 2)",		
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[23])) ),
							    mysql_real_escape_string($fields[22]),
							    mysql_real_escape_string($fields[21]),
							    $row
							);//2
			 $result = mysql_query($query, $conn); 
				checkError($result,$query);   	

			}


		    if (strlen($fields[20].$fields[16].$fields[18])>2)
		    {							
			$query = sprintf("INSERT INTO donations (`date`, `ammount`, `paymentMethod`, `donorID`, `position`) VALUES('%s','%s','%s',%d, 1)",	
							    date( 'Y-m-d H:i:s', strtotime(mysql_real_escape_string($fields[20])) ),
							    mysql_real_escape_string($fields[16]),
							    mysql_real_escape_string($fields[18]),
							    $row
							);//1			 

				$result = mysql_query($query, $conn); 
				checkError($result,$query);
			}

		$row++;//increment user count
    
}




echo "All Donation records saved.";


  function checkError($result,$query)
  {
	if (!$result) {
		    $message  = '<br>Invalid query: ' . mysql_error() . "<br>";
		    $message .= 'Whole query: ' . $query;
		    die($message);
	}
  }

?> 