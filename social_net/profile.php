  <?php include("./inc/header.inc.php");?>
<?php
$username="";
$result="";
if(isset($_GET['u'])){
$username= mysqli_real_escape_string($conn,$_GET['u']);
if(ctype_alnum($username)){
	//check username exists
        $check=mysqli_query($conn,"SELECT username,first_name FROM users WHERE username='$username'");
	      
	if(mysqli_num_rows($check)==1){
		$get=mysqli_fetch_assoc($check);
		$username=$get['username'];
		$firstname=$get['first_name'];
	}
	else{
		echo "<meta http-equiv=\"refersh\"content=\"0; url=http://localhost/social_net/home.php\">";
		exit();
	}
}
}
$post = @$_POST['post'];
if($post!=""){
	$date_added=date("Y-m-d");
	$added_by=$user;
	$user_posted_to=$username;
	
	
	$query=mysqli_query($conn,"INSERT INTO posts VALUES('','$post','$date_added','$added_by','$user_posted_to')");
	if(mysqli_connect_error()){
	die("Connected failed: .$conn->connect_error");}
}
	//Check whether the username has uploaded a profile pic or not
  $check_pic = mysqli_query($conn,"SELECT profile_pic FROM users WHERE username='$username'");
  $get_pic_row = mysqli_fetch_assoc($check_pic);
  $profile_pic_db = $get_pic_row['profile_pic'];
  if ($profile_pic_db == "") {
  $profile_pic = "./img/default_pic.jpg";
  }
  else
  {
  $profile_pic = "./userdata/profile_pics/".$profile_pic_db;
  }
 
  ?>
<div id="status"></div>
<div class="postForm">
<form action="<?php echo $username; ?>" method="POST">
<textarea id="post" name="post" rows="4" cols="60"></textarea>
<input type="submit" name="send" value="Post" style="background-color: #DCE5EE; float: right; border: 1px solid #666; color:#666;height:30px; width: 50px;" />
</form>
 </div>
 
<div class="ProfilePosts">
        <?php
		
     $getposts=mysqli_query($conn,"SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 10");

	while($row = mysqli_fetch_assoc($getposts)){
                         $id=$row['id'];
                       $body=$row['body'];
                   $date_added=$row['date_added'];
                    $added_by=$row['added_by'];
                   $user_posted_to=$row['user_posted_to'];  
                         
						$get_user_info = mysqli_query($conn,"SELECT * FROM users WHERE username='$added_by'");
                                                $get_info = mysqli_fetch_assoc($get_user_info);
                                                $profilepic_info = $get_info['profile_pic'];
                                                if ($profilepic_info == "") {
                                                 $profilepic_info = "./img/default_pic.jpg";
                                                }
                                                else
                                                {
                                                 $profilepic_info = "./userdata/profile_pics/".$profilepic_info;
                                                }


						echo "
                                                <div style='float: left;'>
                                                <img src='$profilepic_info' height='60'>
                                                </div>
						<div class='posted_by'>
						Posted by:
                                                <a href='$added_by'>$added_by</a> on $date_added</div>
                                                <br /><br />
                                                <div  style='max-width: 600px;'>
                                                $body<br /><p /><p />
                                                </div>
                                                <hr />
						";

						
						 
}
if(isset($_POST['send_msg'])){
	header("Location: send_msg.php?u=username");
}
$errormsg="";
if (isset($_POST['addfriend'])) {
     $friend_request = $_POST['addfriend'];
     
     $user_to = $user;
     $user_from = $username;
     
     if ($user_to == $username) {
      $errorMsg = "You can't send a friend request to yourself!<br />";
     }
     else
     {
      $create_request = mysqli_query($conn,"INSERT INTO friend_requests VALUES ('','$user_to','$user_from')");
      $errorMsg = "Your friend Request has been sent!";
     }

  }
  else
  {
   //Do nothing
  }
?>
</div>
<img src="<?php echo $profile_pic; ?>" height="200" width="250" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile">
<br>
<form action="<?php echo $username; ?>" method="POST">
<?php
$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$addAsFriend = "";
$selectFriendsQuery = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$username'");
$friendRow = mysqli_fetch_assoc($selectFriendsQuery);
$friendArray = $friendRow['friend_array'];
if ($friendArray != "") {
   $friendArray = explode(",",$friendArray);
   $countFriends = count($friendArray);
   $friendArray12 = array_slice($friendArray, 0, 12);

$i = 0;
if (in_array($user,$friendArray)) {
 $addAsFriend = '<input type="submit" name="removefriend" value="UnFriend">';
}
else
{
 $addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
}
echo $addAsFriend;
}
else{
	$addAsFriend= '<input type="submit" name="addfriend" value="Add as Friend">';
	echo $addAsFriend;
}
//$user = logged in user
//$username = user who owns profile
if (@$_POST['removefriend']) {
  //Friend array for logged in user
  $add_friend_check = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$user'");
  $get_friend_row = mysqli_fetch_assoc($add_friend_check);
  $friend_array = $get_friend_row['friend_array'];
  $friend_array_explode = explode(",",$friend_array);
  $friend_array_count = count($friend_array_explode);
  
  //Friend array for user who owns profile
  $add_friend_check_username = mysqli_query($conn,"SELECT friend_array FROM users WHERE username='$username'");
  $get_friend_row_username = mysqli_fetch_assoc($add_friend_check_username);
  $friend_array_username = $get_friend_row_username['friend_array'];
  $friend_array_explode_username = explode(",",$friend_array_username);
  $friend_array_count_username = count($friend_array_explode_username);
  
  $usernameComma = ",".$username;
  $usernameComma2 = $username.",";
  
  $userComma = ",".$user;
  $userComma2 = $user.",";
  
  if (strstr($friend_array,$usernameComma)) {
   $friend1 = str_replace("$usernameComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$usernameComma2)) {
   $friend1 = str_replace("$usernameComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$username)) {
   $friend1 = str_replace("$username","",$friend_array);
  }
  //Remove logged in user from other persons array
  if (strstr($friend_array,$userComma)) {
   $friend2 = str_replace("$userComma","",$friend_array);
  }
  else
  if (strstr($friend_array,$userComma2)) {
   $friend2 = str_replace("$userComma2","",$friend_array);
  }
  else
  if (strstr($friend_array,$user)) {
   $friend2 = str_replace("$user","",$friend_array);
  }

  $friend2 = "";

  $removeFriendQuery = mysqli_query($conn,"UPDATE users SET friend_array='$friend1' WHERE username='$user'");
  $removeFriendQuery_username = mysqli_query($conn,"UPDATE users SET friend_array='$friend2' WHERE username='$username'");
  echo "Friend Removed ...";
  header("Location: $username");
}

?>
<?php echo $errormsg; ?>

<input type="submit" name="sendmsg" value="Send Message">
</form>
<div class="textHeader"><?php echo $username; ?>'s Profile</div>
<div class="profileLeftSideContent">
<?php
$about_query=mysqli_query($conn,"SELECT bio FROM users WHERE username='$username'");
$get_result=mysqli_fetch_assoc($about_query);
$about_the_username=$get_result['bio'];
 echo $about_the_username;
?>
</div>
<div class="textHeader"><?php echo $username; ?>'s Friends</div>
<div class="profileLeftSideContent">
<?php
if ($countFriends != 0) {
foreach ($friendArray12 as $key => $value) {
 $i++;
 $getFriendQuery = mysqli_query($conn,"SELECT * FROM users WHERE username='$value' LIMIT 1");
 $getFriendRow = mysqli_fetch_assoc($getFriendQuery);
 $friendUsername = $getFriendRow['username'];
 $friendProfilePic = $getFriendRow['profile_pic'];

 if ($friendProfilePic == "") {
  echo "<a href='$friendUsername'><img src='img/default_pic.jpg' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding-right: 6px;'></a>";
 }
 else
 {
  echo "<a href='$friendUsername'><img src='userdata/profile_pics/$friendProfilePic' alt=\"$friendUsername's Profile\" title=\"$friendUsername's Profile\" height='50' width='40' style='padding-right: 6px;'></a>";
 }
}
}
else
echo $username." has no friends yet.";
?>



</div>