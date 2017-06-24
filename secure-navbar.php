<?php
$userLogin = "<a href=\"#\" data-toggle=\"modal\" data-target=\"#login-modal\" style=\"background-color: #706A79\">Sign In</a>";
$dashboard = "";
$profile = "";
$search = "";
$account = "";
$image = "";
$userUpdate ="";
$userPassword = "";
$disabledUsers = "";
$interests = "";
if ($_SERVER['PHP_SELF'] != "/index.php")
    $userLogin = "<a href=\"login.php\" style=\"background-color: #706A79\">Sign In</a>";
if (isset($_SESSION['user']))
{
    $userLogin = "<a href=\"user-logout.php\"><i class=\"fa fa-sign-out\"></i> SIGN OUT</a>";
    $dashboard = "<a href=\"dashboard.php\"><i class=\"fa fa-home\"></i> DASHBOARD</a>";
    $profile = "<a href=\"create_profile.php\"><i class=\"fa fa-user\"></i> CREATE PROFILE</a>";
    $search = "<a href=\"city_select.php\"><i class=\"fa fa-search\"></i> SEARCH</a>";
    $account = "<a href=\"create_profile.php\"><i class=\"fa fa-user\"></i> UPDATE PROFILE</a>";
	$image = "<a href=\"profile_images.php\"><i class=\"fa fa-user\"></i> UPDATE PHOTOS</a>";
    $userUpdate ="<a href=\"user_update.php\"><i class=\"fa fa-user\"></i> UPDATE USER</a>";
    $userPassword ="<a href=\"user-password-change.php\"><i class=\"fa fa-user\"></i> CHANGE PASSWORD</a>";
    if ($_SESSION['user']['user_type'] == CLIENT)
    {
        $interests = "<a href=\"interests.php\"><i class=\"fa fa-user\"></i> VIEW LIKES</a>";
        $profile = "<a href=\"create_profile.php\"><i class=\"fa fa-user\"></i> UPDATE PROFILE</a>";
    }
    elseif ($_SESSION['user']['user_type'] == ADMIN)
    {
        $dashboard = "<a href=\"admin.php\"><i class=\"fa fa-home\"></i> DASHBOARD</a>";
        $disabledUsers = "<a href=\"disabled_users.php\"><i class=\"fa fa-user\"></i> DISABLED USERS</a>";
        $profile = "";
        $image = "";
    }
}
 
?>

<!--Navbar-->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-home">
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
            <a class="navbar-brand page-scroll" href="dashboard.php"><img src="img/nllogo.png" style="height:40px; position=fixed; margin-top: -10px" alt="NerdLink Logo"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php echo $dashboard; ?>
                </li>
                <li>
                    <?php echo $search; ?>
                </li>
                <li>
                    <?php echo $interests; ?>
                </li>
                <li>
                    <?php echo $profile; ?>
                </li>
                <li>
                    <?php echo $userUpdate; ?>
                </li>
				<li>
					<?php echo $image; ?>
                    <?php echo $disabledUsers; ?>
				</li>
                <li>
                    <?php echo $userPassword; ?>
                </li>
                <li>
                    <?php echo $userLogin; ?>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>