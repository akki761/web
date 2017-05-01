<?php
include("./inc/header.inc.php");
?>
<?php
if (!isset($_SESSION["user_login"])) {
    echo "<meta http-equiv=\"refersh\"content=\"0; url=http://localhost/social_net/home.php\">";
}
else
{
?>
<div class="newsFeed">
<h2>Newsfeed:</h2>
</div>
<?php
//If the user is logged in
$getposts = mysqli_query($conn,"SELECT * FROM posts WHERE user_posted_to='$user' ORDER BY id DESC LIMIT 10") or die(mysql_error());
while ($row = mysqli_fetch_assoc($getposts)) {
						$id = $row['id'];
						$body = $row['body'];	
						$date_added = $row['date_added'];
						$added_by = $row['added_by'];
						$user_posted_to = $row['user_posted_to'];  

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
                                      //Get Comments
									  $get_comments = mysqli_query($conn,"SELECT * FROM post_comments WHERE post_id='$id' ORDER BY id ASC");
									  $comment=mysqli_fetch_assoc($get_comments);
									  $comment_body=$comment['post_body'];
									  $posted_to=$comment['posted_to'];
									  $posted_by=$comment['posted_by'];
									  $removed=$comment['post_removed'];
                                                ?>

<script language="javascript">
         function toggle<?php echo $id; ?>() {
           var ele = document.getElementById("toggleComment<?php echo $id; ?>");
           var text = document.getElementById("displayComment<?php echo $id; ?>");
           if (ele.style.display == "block") {
              ele.style.display = "none";
           }
           else
           {
             ele.style.display = "block";
           }
         }
</script>

                                               <?php
						echo  "

						<p />
						<div class='newsFeedPost'>
						<div class='newsFeedPostOptions'>
                                                <a href='#' onClick='javascript:toggle$id()'>Show Comments</a>
						</div>
                                                <div style='float: left;'>
                                                <img src='$profilepic_info' height='60'>
                                                </div>
						<div class='posted_by'>$added_by posted this on your profile:</div>
                                                <br /><br />
                                                <div  style='max-width: 600px;'>
                                                $body<br /><p /><p />
                                                </div>
                                                <div id='toggleComment$id' style='display: none;'>
                                                <br />
                                                <iframe src='./comment_frame.php?id=$id' frameborder='0' style='max-height: 150px; width: 100%; min-height: 10px;'></iframe>
                                                </div>
                                                <p />
                                                </div>
						";
}
}
?>