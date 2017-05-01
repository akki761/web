<?php include("./inc/connect.inc.php");

session_start();
if(!isset($_SESSION["user_login"])){
	$user="";
}
else
{
	$user=$_SESSION["user_login"];
}
$post = @$_POST['post'];
if($post!=""){
	$date_added=date("Y-m-d");
	$added_by=$user;
	$user_posted_to="test123";
	
	
	$query=msqli_query($conn,"INSERT INTO posts VALUES('','$posts','$date_added','$added_by','$user_posted_to')");
	if(mysqli_connect_error()){
	die("Connected failed: .$conn->connect_error");
}
else
{
	echo "You must enter something in the post..!";
}
?>