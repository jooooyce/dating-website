<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Welcome to NerdLink!";
$date = "2015-09-27";
$filename = "index.php";
$banner = "NerdLink";
$description = "The homepage for NerdLink.";

include ("header.php");
include ("secure-navbar.php");
?>

<?php
	$error = "";
	$message = "";
	$disabledMessage ="";
	if(isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	if(isset($_SESSION['disabledMessage']))
	{
        unset($_SESSION['disabledMessage']);
        session_destroy();
        session_start();
        $_SESSION['disabledMessage'] = "Your account has been disabled.";
        pageRedirect("acceptable_use_policy.php");
        $disabledMessage ="<script language=\"javascript\"> alert(\"" . $_SESSION['disabledMessage'] . "\")</script>";
		
	}
	
	
	if($_SERVER["REQUEST_METHOD"] == "GET"){
	
			/* this is cookie area */
		if(isset($_COOKIE['login'])){
				$login = $_COOKIE['login'];
			}; 
			/* this is cookie area */
	$login = "";
	$pass = "";

	}else if($_SERVER["REQUEST_METHOD"] == "POST"){
		$login = $_POST["login"];
		$pass = $_POST["pass"];
		$pass = md5($pass);
		$conn = db_connect();

		$result = pg_execute($conn, "login_query", array($login, $pass));
		$record = pg_num_rows($result);
		if ($record == 1){
			pg_execute($conn, "update_date", array($login, $pass));
			setcookie("login", $login, time()+ EXPIRE_DATE);
			
			/*session area*/	
			$user = pg_fetch_assoc($result,0);
			if(isset($_SESSION['user']))
				unset($_SESSION['user']);
				
			$_SESSION['user'] = $user;

			/*session area*/
			
			$userType = $_SESSION['user']['user_type'];
			if ($userType == DISABLED_CLIENT)
			{
				
			    $_SESSION['disabledMessage'] = "<script language=\"javascript\"> alert(\"Your account has been disabled.\")</script>";
				
				pageRedirect("index.php");
				
			}
			else 
			{
				pageRedirect("dashboard.php");

			}
					
		}else if ($record == 0){
			
		print '<script type="text/javascript">'; 
		print 'alert("Invalid login/password! Please try again!")';
		print '</script>';
		}
        header("Location: login.php");
        ob_flush();
	}
?>



<header>
    <div class="header-content">
	
        <div class="header-content-inner">
		
            <h1>Welcome to NerdLink!</h1>
            <hr/><h2><?php echo $message; ?></h2>
            <p>NerdLink is the largest online dating website for nerds and geeks. Whether you're looking for friendship,
                love, or something more, NerdLink will help link you up!
            </p>
            <a href="register.php" class="btn btn-primary btn-xl page-scroll">REGISTER NOW</a>
        </div>
    </div>
</header>


<section id="information">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-sign-in wow bounceIn info1"></i>
                    <h3>Signing up is easy (and free!).</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-newspaper-o wow bounceIn info2" data-wow-delay=".1s"></i>
                    <h3>Create your profile in a few simple steps.</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-diamond wow bounceIn info3" data-wow-delay=".2s"></i>
                    <h3>Connect with people with similar interests.</h3>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-heart wow bounceIn info4" data-wow-delay=".3s"></i>
                    <h3>Find your perfect match!</h3>
                </div>
            </div>
        </div>
    </div>
</section>


<!--LOGIN BOX CODE-->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h2>Login to Your Account</h2><br/>
            <form action="./login.php" method="post">
                <p><input type="text" name="login" value="<?php echo $login; ?>" placeholder="Username"/></p>
                <p><input type="password" name="pass" placeholder="Password"/></p>
				<div class="login-help">
					<a href="user-password-request.php">Forgot Password</a>
				</div><br />
                <p><input type="submit" name="signin" class="login loginmodal-submit" value="Sign In"/></p>
            </form>

        </div>
    </div>
</div>

<!--REGISTER BOX CODE-->
<!--<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="loginmodal-container" style="max-width: 450px;">-->
<!--            <h2>Almost there! <br/>Just a little more to go.</h2><br/>-->
<!--            <div class="register-box">-->
<!--                <form>-->
<!--                    <div>-->
<!--                        <h4>Username</h4>-->
<!--                        <input class="" type="text" name="user_name" placeholder="Username"/>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <h4>Birthdate</h4>-->
<!--                        <input class="date-box" type="text" name="Day" placeholder="DD" maxlength="2" autocomplete="off"/>-->
<!--                        <input class="date-box2" type="text" name="Month" placeholder="MM" maxlength="2" autocomplete="off"/>-->
<!--                        <input class="date-box2" type="text" name="Year" placeholder="YYYY" maxlength="4" autocomplete="off"/>-->
<!--                    </div>-->
<!--                    <div style="padding-top: 50px;">-->
<!--                        <h4>Country <span style="padding-left: 122px"> Postal Code</span></h4>-->
<!--                        <input class="add-box" type="text" name="Country" placeholder="Canada"/>-->
<!--                        <input class="add-box" type="text" name="Postal" placeholder="e.g. L0L 0L0"/>-->
<!--                    </div>-->
<!--                    <div style="padding-top: 5px;">-->
<!--                        <h4>Email</h4>-->
<!--                        <input class="em-box" type="text" name="Email" placeholder="e.g. example@nerdlink.com"/>-->
<!--                        <input class="em-box" type="text" name="Confirm" placeholder="Confirm Email"/>-->
<!--                        <h4>Password</h4>-->
<!--                        <input class="em-box" type="text" name="Password" placeholder="Password"/>-->
<!--                        <input class="em-box" type="text" name="ConfirmPass" placeholder="Confirm Password"/>-->
<!--                    </div>-->
<!--                    <input type="submit" name="Register" class="login loginmodal-submit" value="Register"/>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div> -->

<!--FORGOT PASSWORD CODE-->
<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h2>Too Bad!</h2><br/>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.fittext.js"></script>
<script src="js/wow.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/creative.js"></script>


<?php include ("footer.php") ?>