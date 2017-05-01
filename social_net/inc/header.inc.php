<?php 
include( "./inc/connect.inc.php"); 

session_start();
if(!isset($_SESSION["user_login"])){
	$user="";
}
else
{
	$user=$_SESSION["user_login"];
}
		$get_unread_query=mysqli_query($conn,"SELECT opened FROM pvt_messages WHERE user_to='$user'&&opened='no'");
		$get_unread=mysqli_fetch_assoc($get_unread_query);  
		$unread_numrows=mysqli_num_rows($get_unread_query);
				$unread_numrows="(".$unread_numrows.")";
				?>
<!doctype html>
<html lang="en">
   <head>
   <title>CONNECT</title>
   
   <link rel="stylesheet" href="css/blue.css" media="screen">
   <link rel="stylesheet" href="css/mystyle.css" media="screen">
   <script src="bootstrap.min.css"></script>
   <script src="http://ajax.googlepis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
   <script src="js/jquery.color.js"></script>
   <script src="js/script.js"></script>
   <script src="js/placeholder-js.js" type="text/javascipt"></script>
   <script src="js/main.js" type="text/javascript"></script>
   
   </head>
   								   
   <body style="background-color: #F3F6F9">
   <div class="headers">
   <div id="wrap">
      <div class="logo">
	     <img src="./img/logo.jpg"> 
			</div>
			 
        </div>
		<div id="wrapper">
	  <div class="mashmenu">
      <div id="menuWrapper">
	     					<?php
					if(!$user){
						
                    echo "";
					
					}
					else{
						echo '
						<div id="menu">
                              <a href="home1.php">Home</a>
							  <a href="'.$user.'">Profile</a>
                            
                        
                              <a href="account_settings.php">Account Setting</a>
                                       
									   
									   
                              <a href="my_messages.php">My Messages ' . $unread_numrows . '</a>
                                       
									   
                              <a href="logout.php">Logout</a>
                                 </div>      
					<div class="search_box">
			       <form action="search.php method="GET" id="search">
				       <input type="text" name="search" size="60" placeholder="Find">
					   <input type=button name="searchn" value="Search">
			         </form>
			</div>';
					}
                                ?>  
              