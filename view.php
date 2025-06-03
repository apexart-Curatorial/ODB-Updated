<?php
			error_reporting(E_ALL);
			session_start();
			include "DBX.php";
			
			
			
			
			
			$d=new DBX();
			$count=$d->Count();
			//$d->__construct();

			//$d->Register("jack7","jack","kells","jackk","jack@gmail.com","pic.jpg",0);
			//$d->createSubmission("first sub","hello hello\n\nhello description", 1);
			//$d->createComment("first sub","hello hello\n\nhello description", 1, 1);
			//$d->changeSubStatus(1,1);
			//$d->changeCommentStatus(1,1);
			
			if (!$_GET["sub"]) header("Location: index.php");
			
			
			if (isset($_POST["title"]) && isset($_SESSION['userID']))
			{
				$d->createComment($_POST["title"],$_POST["comment"], $_SESSION['userID'], $_GET["sub"]);
			}
			
			
			
			
			$s=$d->LoadSubmission($_GET["sub"]);
			$ptitle="BULBISH.COM Photography. ".$s->title;
			include "header.php";
			
			//$text=nl2br(print_r($sub,true));
			//echo $text;
			
				echo '<table >';
				echo "<tr><td>&nbsp;";
				echo "<a href='view.php?sub=".$s->id."'>".$s->title."</a>";
				echo "</td><td>&nbsp;";
				echo "Submitted by: ".$s->author;
				echo "</td><td>&nbsp;";
				//echo $s->authorID;
				echo "</td><td>&nbsp;";
				echo $s->date;
				echo "</td><td>&nbsp;";
				echo $s->rating;
				echo "</td></tr><tr><td colspan='5'>&nbsp;";
				//echo $s->id;
				echo $s->description;
				echo "</td></tr><tr><td colspan='5'>&nbsp;";
				//echo $s->comments;
				
				//echo $s->pictures[0];
				echo "</td></tr>";
				echo "</table><br/><br/><br/>";
				echo '<a href="index.php">Back to main page (see more photo collections)</a><br/>';
				
				
				$j=0;
				if ($s->pictures)
					foreach ($s->pictures as $p)
					{ echo "<img src='".$p."' alt='".htmlentities($s->title)."'></img>"."</br></br>";
					if ($j==3 || $j==7) {
					?>
					<span >
						<script type="text/javascript"><!--
						google_ad_client = "pub-9698899319360964";
						/* 728x90, created 1/22/09 */
						google_ad_slot = "4059248049";
						google_ad_width = 728;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
					</span><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
					<?php						} $j++;
					}
				//print_r ($s->comments);
				echo '<br><br><br><span style="background: yellow"><a href="index.php">Back to main page (see more photo collections)</a></span>';
				echo "<hr><br>COMMENTS:<br><hr>";
				if ($s->comments) 
					foreach ($s->comments as $c)
					{
						echo "<i>Posted By ".$c->author."</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$c->date.")<br/><br/>";
						echo "<b>".$c->title."</b><br/><br/>";
						echo $c->description."<br>________________________________________<br>";

					//echo $c->author=$author;
					//$c->authorID=$authorID;
					//echo $c->date=$date;
					//$c->submissionID=$submissionID;
					//$c->id=$id;	
				}
			if (isset($_SESSION['userID'])){
			?>
			<form action='<?=$_SERVER['PHP_SELF']?>?sub=<?=$_GET["sub"]?>' method="post">
			    Title:<br/>
				<input type="text" name="title" style="width: 380px;"><br/>
				Comment:<br/>
				<textarea cols="45" rows="14" name="comment" ></textarea><br/><br/>
				<input type="submit" value="Add Comment"><br/>
				<input type="hidden" value="<?=$s->id?>"><br/>
			</form>

			<br/><br/>
			
			
			<br/><br/>



			<?php 
			} else echo "<a href='login.php'>Login</a> to post comments.<br/></br/>";
			echo $count; 
include("footer.php") ?>