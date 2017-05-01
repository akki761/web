		<?php include("./inc/header.inc.php"); ?>
		
	    <?php
		$reg =@$_POST['reg'];
		$fn="";
		$ln="";
		$un="";
		$em="";
		$em2="";
		$pswd="";
		$d="";
		$u_check="";
		//registration form
		$fn=strip_tags(@$_POST['fname']);
		$ln=strip_tags(@$_POST['lname']);
		$un=strip_tags(@$_POST['username']);
		$em=strip_tags(@$_POST['email']);
		$em2=strip_tags(@$_POST['email2']);
		$pswd=strip_tags(@$_POST['password']);
		$pswd2=strip_tags(@$_POST['password2']);
	   	$d=date("d-m-y");
	     if($reg){
			 if($em==$em2){
				 $u_check=mysqli_query($conn,"SELECT username FROM users WHERE username='$un'");
               
			   $check=mysqli_num_rows($u_check);
                         //check whether email already exist or not 
			  $e_check=mysqli_query($conn,"SELECT email FROM users WHERE email='$em'");
			   //count the number of rows returned
			   $email_check=mysqli_num_rows($e_check);
			   if($check==0){
                          if($email_check == 0)
						  {
			   if($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2){

			   if($pswd==$pswd2){
               if(strlen($un)>25||strlen($fn)>25||strlen($ln)>25){
                    echo "The maximum limit for username/first name/last name is 25 characters!";				   
			   }
         			   
			else
			{				
		 
		 if(strlen($pswd)>30||strlen($pswd)<5){
			 echo "Your password must be between 5 and 30 characters long..";
		 }
		 else
		 {
			 $pswd=md5($pswd);
			 $pswd2=md5($pswd2);
			 $query=mysqli_query($conn,"INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$d','0','Write something about yourself.','','','no')");
			 die("<h2>Welcome to sociokiet</h2><a href='home.php'>Login </a>to your account to get started ...");
		 }
			   }
			   }
		 else{
			 echo "Your passwords don't match!";
		 }
			   }
			   else{
				   echo "Please fill in all of the fields";
			   }
			 }
			 else{
				 echo "Sorry,but it looks like someone has already used that email!";
			 }
			   }
			 else{
				 echo "Username already taken..";
			 }
		 }
		 else{
			 echo"Your email don't match";
		 }
		 
		 }
		 ?>
		 <?php
		 //User Login Code
		 
		 if(isset($_POST["user_login"])&& isset($_POST["password_login"])){
			 $user_login=preg_replace('#[^A-Za-z0-9]#i','',$_POST["user_login"]);
		 $password_login=preg_replace('#[^A-Za-z0-9]#i','',$_POST["password_login"]);
		 $password_login_md5=md5($password_login);
		 $sql=mysqli_query($conn,"SELECT id FROM users WHERE username='$user_login' AND password='$password_login_md5' AND closed='no' LIMIT 1");
		 
		 $usercount=mysqli_num_rows($sql);
		 
		 if($usercount==1){
			 while($row = mysqli_fetch_array($sql)){
				 $id=$row["id"];
		 }
		 $_SESSION["user_login"]=$user_login;
		 header("location: home1.php");
		 exit();
		 }
		 else{
			 echo "That information is incorrect, <a href='home.php'>try again</a>";
			 exit();
		 }
		 }
		 ?>
		
		<table id="tab">
		   <tr>
		   <td width="60%" valign="top">
		   <h2>Already a Member? Sign in Below!</h2>
		          <form action="home.php" method="POST">
		            <input type="text" name="user_login" size="25" placeholder="Username"/>
							    <br><br>
					<input type="password" name="password_login" size="44" placeholder="Password" id="change"/>
							    <br><br>
						     <input type="submit" name="login" value="Login">			 
		   </form>
		   </td>
		        <td width="40%" valign="top">
				<h2>Sign Up Below</h2>
				<form action="#" method="POST">
				      <input type="text" name="fname" size="25" placeholder="Firstname"/>
                            <br>		<br>		       
					   <input type="text" name="lname" size="25" placeholder="Lastname"/>
						  <br><br>
						  <input type="text" name="username" size="25" placeholder="Username"/>
						    <br><br>
							<input type="email" name="email" size="44" placeholder="Email Address" id="change"/>
							  <br><br>
							  <input type="email" name="email2" size="44" placeholder="Confirm Email Address" id="change"/>
							  <br><br>
							  <input type="password" name="password" size="44" width="50"placeholder="Password" id="change"/>
							    <br><br>
					<input type="password" name="password2" size="44" placeholder="Confirm Password" id="change"/>
							    <br><br>
						    <input type="submit" name="reg" value="Sign Up"/>
				</form>
				</td>
		     </tr>
		</table>
		
   <?php include("./inc/footer.inc.php"); ?>
   