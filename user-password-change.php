<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
October 28, 2015
WEDE3201
*/

$title = "Change Password";
$date = "2015-10-27";
$filename = "user-password-change.php";
$banner = "NerdLink";
$description = "The user password change page for NerdLink.";

include ("header.php");
include ("secure-navbar.php");
 ?>





<div class="container body-container" role="main">
    <div class="jumbotron">
	
<?php
		
			if(isset($_SESSION['user']))
			{
				$user_id = $_SESSION['user']['user_id'];

				if(!empty($_SESSION['message'])){
                    echo '<p style="color: #262626" align="center">' . $_SESSION['message'] . '</p>';
                    unset ($_SESSION['message']);
                }
				echo '<p style="color: #262626" align="center">' . "Welcome, ".$user_id." ! You may change your password below.".'</p>';
			}else{
				$_SESSION['message'] = "You must log in to change your password.";
				header("Location: index.php");
			}
			
?>			



<?php 

$conn = db_connect();

if(isset($_SESSION['user'])){

	if(isset($_POST['submit'])){
		$pass = md5($_POST['pass']);
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];

		$result = pg_execute($conn, "login_query", array($_SESSION['user']['user_id'], ($pass)));
		
		//check whether password exists in database
		if (pg_num_rows($result) != 0){
		
			// check two new passwords
			if($pass2!=$pass1){
				$message = "Your passwords do not match!";
			}else if(strlen($pass1) == 0){
				$message = "You must enter a password!";
			}else if(strlen($pass1) < MINIMUM_PASSWORD_LENGTH) {
				$message = "The password length must be at least ".MINIMUM_PASSWORD_LENGTH." characters!";	
			}else if(strlen($pass1) > MAXIMUM_PASSWORD_LENGTH) {
				$message = "The password length must be less than ".MAXIMUM_PASSWORD_LENGTH." characters!";

			}else{ 
				
					//$sql="UPDATE users SET password = '".md5($pass2)."' WHERE user_id = '".$_SESSION['user']."'";
					//session_destroy();
					pg_execute($conn, "user_password_update", array(md5($pass1), $_SESSION['user']['user_id']));
					$message = "You have successfully updated your password!";
					$_SESSION['message']=$message;					
					header("Location: dashboard.php");	
					ob_flush();
			}
		}else{
			$message = "Current password is incorrect. Please try again!";
		}
		
		}	
	}

?>	
	</div>
	
<?php echo $message; ?>

<form  method="post" action="user-password-change.php">
<center><table border="0"  cellpadding="10" >
<tr>
	<td><strong>Current Password</strong></td>
	<td><input type="password" name="pass" value="" size="20" /></td>
</tr>
<tr>
	<td><strong>New Password</strong></td>
	<td><input type="password" name="pass1" value="" size="20" /></td>
</tr>
<tr>
	<td><strong>Confirm Password</strong></td>
	<td><input type="password" name="pass2" value="" size="20" /></td>
</tr>
</table>
<table border="0" cellspacing="15" >
<tr>
	<td><input type="submit" name="submit" value = "Change Password" /></td>
	
	<td><input type="reset" value = "Clear" /></td>
</tr>
</table>
    </center>



</form>

</div>


<?php include ("footer.php") ?>










