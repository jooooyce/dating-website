<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
October 28, 2015
WEDE3201
*/

$title = "Request Password";
$date = "2015-11-10";
$filename = "user-password-request.php";
$banner = "NerdLink";
$description = "The user password requests page for NerdLink.";

include ("header.php");
include ("secure-navbar.php");

?>






<div class="container body-container" role="main">
    <div class="jumbotron">


<?php
		
		echo '<p style="color: #262626" align="center">' .'<strong>'. "Find Your Account" .'</strong>' .'</p>';

?>
	
<?php 

$conn = db_connect();
$user_id = '';
$email = '';


	if($_SERVER['REQUEST_METHOD'] == "POST"){
		//get form data
		$user_id = isset($_POST['user_id'])?trim($_POST['user_id']):"";
		if($user_id == "")
		{
			$message = "Please enter your username!";
		}else{
		
			$email = trim($_POST['email_address']);
			if(strlen($email) == 0)
			{
				$message = "Please enter your email!";
				
			}else if(strlen($email)>MAXIMUM_EMAIL_LENGTH)
			{
				$message = "Your email address is too long, Please re-enter.";
				
			}else if(filter_var($email,FILTER_VALIDATE_EMAIL) == false)
			{
				$message = $email . " is not a valid email, please re-enter.";
				$email = "";
			}else{
			
				$result = pg_execute($conn, "email_query", array($user_id, $email));
		
				if(pg_num_rows($result) == 1){
						
						$pass = rand();
						$pass = md5($pass);
						$pass = substr($pass,0,8);
						
						pg_execute($conn, "user_password_update", array(md5($pass), $user_id));	
						$result = pg_execute($conn, "email_query", array($user_id, $email));
						$user = pg_fetch_assoc($result, 0);
						$mail_to = $email;
						$mail_subject = "Group09 Password Request";
						$mail_body = "Hello ".$user['first_name'] ." ". $user['last_name'] .". ". '<br />' ."A email has been sent to your email address ". '<u>'.$email.'</u>' ." at ". date("Y-m-d H:i:s") .". ".'<br />'. "Your password has been reset. New password is below.".'<br />';
						$mail_body .= "New Password: $pass";
 
						//if(mail($mail_to,$mail_subject,$mail_body)){
						//	  $message = "Email\"$mail_subject\" to $mail_to was accepted for sending.";
						//}else{
						//	$message = "Email\"$mail_subject\" to $mail_to was not accepted for sending.";
						//}
 
 
							$message = $mail_body;
							$_SESSION['message']=$message;
							header("Location: login.php");	
							ob_flush();
				}
				else{
					$message = "The username/email address combination was not found in our system.";
				}
			}
		}
	}

?>	
	</div>
	
<?php echo $message; ?>

<form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<center><table border="0"  cellpadding="10" >
<tr>
	<td><strong>User Name: </strong></td>
	<td><input type="text" name="user_id" value="" size="20" /></td>
</tr> 
<tr>
	<td><strong>Email Address: </strong></td>
	<td><input type="text" name="email_address" value="<?php echo $email; ?>" size="20" /></td>
</tr>
</table><br />
<table border="0" cellspacing="15" >
<tr>
	<td><input type="submit" name="submit" value = "Submit" /></td>
	<td><input type="reset" value = "Clear" /></td>
</tr>
</table>
    </center>



</form>

</div>


<?php include ("footer.php") ?>


	
