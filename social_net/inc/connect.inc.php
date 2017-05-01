<?php

$conn=mysqli_connect("localhost","root","","sociokiet");
if(mysqli_connect_error()){
	die("Connected failed: .$conn->connect_error");
}
mysqli_select_db($conn,"sociokiet");
 ?>