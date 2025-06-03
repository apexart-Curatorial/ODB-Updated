<?php
		
		$test=false; //true or false
		// if set to true script only sends email to heather@kouris.info, otherwise to ALL jurors
		$from="mike@bulbish.com";	//return email address
				//email subject

		if ($test) $query3="SELECT * FROM emails WHERE email='crazybike99@yahoo.com'";
			else 
		$query3="SELECT * FROM emails ORDER by rand() LIMIT 0,50";


		$dbhost = 'bulbish.dot5hostingmysql.com'; $dbuser = 'bulbish'; $dbpass = 'shittt'; $dbname = 'bulbish';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
		mysql_select_db($dbname, $conn) or die ('Error selecting DB');
		
		$result3 = mysql_query($query3, $conn);  //run database query
		
		if (!$result3) {//if returns nothings
		    echo 'Could not run query: ' . mysql_error();
		    echo("<br><p><font color='red'>NO MESSAGES SENT!</font></p>");
		    exit;
		}
		
		while ($row3 = mysql_fetch_assoc($result3))// take each row from query
		{
	
				$to = $row3["email"];
				$subject = "hi ".$row3["firstname"];	
				//$headers = 'From: '.$from. "\r\n" .
				$headers = 'From: '.$from. "\n".
			    'Reply-To:'.$from. "\n".
			    'MIME-Version: 1.0'."\n".
			    'Content-Type: text/html; charset=us-ascii'."\n".
			    'X-Mailer: PHP/' . phpversion();
			
			
			
					
				//$body=" \n\n check out these awesome hurricane pictures from space! <br/><br/> <a href='http://bulbish.com/view.php?sub=8'>here</a><br/><br/>\n\n\n";
				
				$body="hi ".$row3["firstname"].", this is mike, do you remember me?<br/><br/><br/><br/>--------------<br/><br/> <a href='http://www.bulbish.com/angel-falls-in-canaima-national-park-in-venezuela.html'>My Photography site</a><br/><br/>\n\n\n";
					
			
				
				if (mail($to, $subject, $body, $headers)) //send mail
				{
				  echo("Message successfully sent to ".$row3["email"]."<br/>");
				} 
				else 
				{
				  echo("Message delivery to ".$row3["email"]." failed.</br/>");
				}
				flush();
		
		}
		
		
		
		
		
		
		
		
		if (mail("crazybike99@yahoo.com", $subject, $body, $headers)) //send mail
				{
				  echo("Message successfully sent to crazybike99@yahoo.com<br/>");
				} 
				else 
				{
				  echo("Message delivery to bucketbulbish@gmail.com failed.</br/>");
				}
				
		if (mail("bucketbulbish@gmail.com", $subject, $body, $headers)) //send mail
				{
				  echo("Message successfully sent to bucketbulbish@gmail.com <br/>");
				} 
				else 
				{
				  echo("Message delivery to bucketbulbish@gmail.com failed.</br/>");
				}
				
				
				
				
		echo("<br><p><font color='green'>ALL MESSAGES SENT!</font></p>");



?>

