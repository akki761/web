<?php include("./inc/header.inc.php");?>
<?php
if(isset($_GET['u'])){
$username= mysqli_real_escape_string($conn,$_GET['u']);
if(ctype_alnum($username)){
	//check user exists
        $check=mysqli_query($conn,"SELECT username,first_name FROM users WHERRE username='$username'");
	      
	if(mysqli_num_rows($check)==1){
		$get=mysqli_fetch_assoc($check);
		$username=$GET['username'];
		$firstname=$GET['first_name'];
	}
	else{
		echo "<meta http-equiv=\"refersh\"content=\"0; url=http://localhost/social_net/home.php\">";
		exit();
	}
}
}
?>

<div class="postForm">
<textarea id="post" name="post" rows="5" cols="60">

</textarea>
 
 <input type="submit" name="send" onclick="javascript:send_posts()" value="Post" style="background-color: #DCE5EE; float: right;border: 1px solid #666">
  
</div>
<div class="ProfilePosts">
       <?php
        $getposts=mysqli_query($conn,"SELECT * FROM posts WHERRE user_posted_to='$username' ORDER BY id DESC LIMIT 10");
if(mysqli_connect_error()){
	die("Connected failed: .$conn->connect_error");
while($row = mysqli_fetch_assoc($getposts)){
  $id=$row['id'];
  $body=$row['body'];
$date_added=$row['date_added'];
$added_by=$row['added_by'];
$user_posted_to=$row['user_posted_to'];  
echo "<div class='posted_by'><a href='$added_by'>$added_by</a> - $date_added - </div>$nbsp;$nbsp;$body<";
}
?>
</div>
<img src="" height="250" width="200" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile" />
<br>
<div class="textHeader"><?php echo $username; ?>'s Profile</div>
<div class="profileLeftSideContent">Some content about this persons profile ...</div>
<div class="textHeader"><?php echo $username; ?>'s Friends</div>
<div class="profileLeftSideContent">
<img src="#" height="50" width="40">&nbsp;&nbsp; 
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
<img src="#" height="50" width="40">&nbsp;&nbsp;
</div>
</div>