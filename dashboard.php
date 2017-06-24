<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Welcome Back!";
$date = "2015-09-27";
$filename = "dashboard.php";
$banner = "Welcome Back to NerdLink!";
$description = "This page serves as the dashboard once a user correctly logs in.";
//session_start();
include ("header.php");
include ("secure-navbar.php");
include_once("includes/db.php");
?>


<div class="container body-container" role="main">
    <div class="jumbotron">
	
	<!-- trying to show the username here -->
<?php
		
			//if (!isset $_SESSION){
			
			// $user_id = $_POST['user_id'];
			// $pass = $_POST['password'];
			if(isset($_SESSION['user']))
			{
				$userId = $_SESSION['user']['user_id'];
				$record = pg_execute($conn, "user_query", array($userId));
				$records = pg_num_rows($record);
				
				if ($records == 1)
				{
					$user = pg_fetch_assoc($record, 0);
					$userType = $user['user_type'];
					if ($userType == ADMIN)
					{
						pageRedirect("admin.php");
					}
				}
				
				else
				{
					echo $message = "You must log in to access your dashboard";
					header("Location: index.php");
				}
				
				$firstName = $_SESSION['user']['first_name'];
				$lastName = $_SESSION['user']['last_name'];
				$lastAccess = $_SESSION['user']['last_access'];
				
				echo '<p style="color: #262626" align="center">' . "Welcome back, ".$firstName." ".$lastName."! You last visited on ".$lastAccess . '</p>';
			}
			
			else
			{
				echo $message = "You must log in to access your dashboard";
				header("Location: index.php");
			}
			
			if(isset($_SESSION['message']))
			{	
				echo '<p style="color: #262626" align="center">' .$_SESSION['message'].'</p>';
				unset ($_SESSION['message']);
			}
		
?>			
    </div>
</div>
    <?php include ("footer.php");?>


