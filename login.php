<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Login to NerdLink!";
$date = "2015-09-27";
$filename = "index.php";
$banner = "NerdLink";
$description = "The homepage for NerdLink.";

include ("header.php");
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
	
	$disabledMessage = $_SESSION['disabledMessage'];
	unset($_SESSION['disabledMessage']);
	session_destroy();
	session_start();
    $_SESSION['disabledMessage'] = $disabledMessage;
    pageRedirect("Acceptable_use_policy.php");
		
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
				
			    $_SESSION['disabledMessage'] = "Your account has been disabled.";
				
				pageRedirect("index.php");
				
			}
			else 
			{
				pageRedirect("dashboard.php");

			}
        //header("Location: dashboard.php");
        //ob_flush();

    }else if ($record == 0){

        print '<script type="text/javascript">';
        print 'alert("Invalid login/password! Please try again!")';
        print '</script>';
    }
}
?>

    <body id="page-top">

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
                <!--ELLEN: Place logo image here-->
                <a class="navbar-brand page-scroll" href="#page-top"><img src="img/nllogo.png" style="height:40px; position=fixed; margin-top: -10px"/></a>
            </div>



            <!-- /.navbar-collapse -->
        </div>

        <!-- /.container-fluid -->
    </nav>




    <!--LOGIN BOX CODE-->

            <div class="loginmodal-container">
                <h2>Login to Your Account</h2><br/>
				<?php echo "<h4>".$disabledMessage."</h4>"; ?>
                <?php echo "<h4>".$message."</h4>"; ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <p><input type="text" name="login" value="<?php echo $login; ?>" placeholder="Username"/></p>
                    <p><input type="password" name="pass" placeholder="Password"/></p>
					<div class="login-help">
						<a href="user-password-request.php">Forgot Password</a>
					</div><br />
                    <p><input type="submit" name="signin" class="login loginmodal-submit" value="Sign In"/></p>
                </form>
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