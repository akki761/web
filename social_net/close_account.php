<?php
include ("./inc/header.inc.php");?>
<?php
//Take the user back
if ($user) {
if (isset($_POST['no'])) {
 header("Location: account_settings.php");
}
if (isset($_POST['yes'])) {
$close_account = mysqli_query($conn,"UPDATE users SET closed='yes' WHERE username='$user'");

session_destroy();

header("Location: home.php");
/*echo '
 <script language="javascript">
      alert("Your Account has been closed!");
        </script>';*/
}
}
else
{
 die ("You must be logged in to view this page!");
}
?>
<script language="javascript">
   function pop(){
      alert("Your Account has been closed!");
   }
        </script>
       
<br />
<center>
<form action="close_account.php" method="POST">
Are you sure you want to close your account?<br>
<input type="submit" name="no" value="No, take me back!">
<input type="submit" name="yes" value="Yes I'm sure" onsubmit="pop();">
</form>
</center>
 