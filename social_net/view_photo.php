<?php
include ("./inc/header.inc.php");?>
<?php
$picture="";
if (isset($_GET['uid'])) {
	$picture = mysqli_real_escape_string($conn,$_GET['uid']);
	if (ctype_alnum($picture)) {
 	//check user exists
	$check = mysqli_query($conn,"SELECT * FROM photos WHERE uid='$picture'");
	if (mysqli_num_rows($check)===1) {
	$get = mysqli_fetch_assoc($check);
	$uid = $get['uid'];
	$username = $get['username'];
    $date_posted=$get['date_posted'];
    $description=$get['description'];	 
 }
	else
	{
	//echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/tutorials/findFriends/index.php\">";
	//exit();
	}
	}
}
?>
<h2>Photos in this Album:</h2><hr /><table>
       <tr>
<?php

$get_photos = mysqli_query($conn,"SELECT * FROM photos WHERE uid='$picture' && removed='no'");
$numrows = mysqli_num_rows($get_photos);
while($row = mysqli_fetch_assoc($get_photos)) {
  $id = $row['id'];
  $uid = $row['uid'];
  $username = $row['username'];
  $date_posted = $row['date_posted'];
  $description = $row['description'];
  $image_url = $row['image_url'];
  $img_id = $row['img_id'];

  $md5_image = md5($image_url);

  if (isset($_POST['remove_photo_' . $md5_image . ''])) {
   $remove_photo = mysqli_query($conn,"UPDATE photos SET removed='yes' WHERE uid='$uid' && img_id='$img_id'");
   header("Location: $uid");
  }

  echo "
  <td>
  <div class='albums'>
  <img src='$image_url' height='170' width='170'><br><br>
  $description
  </div>
  <center>
  <form method='POST' action='$uid'>
  <input type='submit' name='remove_photo_$md5_image' value='Remove Photo'>
  </form>
  </center>
  </td>
  ";
}
?>
</tr>
</table>