<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Display Profile";
$date = "2015-09-27";
$filename = "display_profile.php";
$banner = "Display Profile";
$description = "This page allows users to view more information about individual users.";

include ("header.php");
include ("secure-navbar.php");

global $conn;
$ownProfile = "";
$likeButton = "";
$reportButton = "";
$disableButton = "";
if(isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['user_id'];
    $searchUserID = isset($_GET['profileUserName'])? $_GET['profileUserName'] : "";
    $record = pg_execute($conn, "profile_query", array($searchUserID));
    $record2 = pg_execute($conn, "user_query", array($searchUserID));
    $records = pg_num_rows($record);
    
    if ($records == 1) {
    $userInfo = pg_fetch_assoc($record2, 0);
    $userType = $_SESSION['user']['user_type'];
    if ($userType == INCOMPLETE_CLIENT)
    {
        $_SESSION['profileMessage'] = "You must make a profile to view another user's profile.";
        pageRedirect("create_profile.php");
    }
    
    
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["like"]))
        {
            if($_POST["like"] == "like")
                pg_execute($conn, "add_interest", array($_SESSION['user']['user_id'], $userInfo['user_id'], date("Y-m-d H:i:s", time())));
            else
                pg_execute($conn, "remove_interest", array($_SESSION['user']['user_id'], $userInfo['user_id']));
        }
        if (isset($_POST["disable"]))
        {
            
            if($_POST["disable"] == "disable")
            {
                
                pg_execute($conn, "client_update", array(DISABLED_CLIENT, $userInfo['user_id']));
                pg_execute($conn, "handle_user_report", array($userInfo['user_id']));
            }
            else
            {
                pg_execute($conn, "client_update", array(CLIENT, $userInfo['user_id']));
            }
            $record2 = pg_execute($conn, "user_query", array($searchUserID));
            $userInfo = pg_fetch_assoc($record2, 0);
        }
        if (isset($_POST["report"]))
        {
            pg_execute($conn, "add_user_report", array($_SESSION['user']['user_id'], $userInfo['user_id'], date("Y-m-d H:i:s", time())));
        }
        
    }
    
    
        if ($userInfo['user_type'] != DISABLED_CLIENT || $_SESSION['user']['user_type'] == ADMIN)
        {
            $lastAccess = $userInfo['last_access'];
            $firstName = $userInfo['first_name'];
            $lastName = $userInfo['last_name'];
            $birthdate = $userInfo['birth_date'];
            $age = calculateAge($birthdate);
            $profile = pg_fetch_assoc($record, 0);
            $gender = $profile['gender'];
            $genderSought = $profile['gender_sought'];
            $seeking = $profile['seeking'];
            $minimumAge = $profile['minimum_age'];
            $maximumAge = $profile['maximum_age'];
            $status = $profile['status'];
            $city = $profile['city'];
            $height = $profile['height'];
            $bodyType = $profile['body_type'];
            $hairColour = $profile['hair'];
            $education = $profile['education'];
            $smokes = $profile['smokes'];
            $drinks = $profile['drinks'];
            $drugs = $profile['drugs'];
            $children = $profile['children'];
            $description = $profile['self_description'];
            $headLine = $profile['headline'];
            $matchDescription = $profile['match_description'];
            $interests = $profile['interests'];
            if ($_SESSION['user']['user_type'] == ADMIN)
            {
                if ($userInfo['user_type'] != DISABLED_CLIENT)
                {
                    $disableButton="<button name=\"disable\" type=\"submit\" class=\"btn btn-primary btn-block\" value=\"disable\">Disable User</button>";
                }
                else
                {
                    $disableButton="<button name=\"disable\" type=\"submit\" class=\"btn btn-primary btn-block\" value=\"enable\">Enable User</button>";
                }
            }
            else
            {
                $likesFound = pg_execute($conn, "interst_exist", array($_SESSION['user']['user_id'], $userInfo['user_id']));
                $likesRows = pg_num_rows($likesFound);
                if ($likesRows == 1)
                    $likeButton="<button name=\"like\" value=\"remove\" type=\"submit\" class=\"btn btn-info btn-block\"><span class=\"fa fa-thumbs-o-up\"></span> Remove Like </button>";
                else
                    $likeButton="<button name=\"like\" value=\"like\" type=\"submit\" class=\"btn btn-info btn-block\"><span class=\"fa fa-thumbs-o-up\"></span> Like </button>";
            }
            $reported = pg_execute($conn, "find_user_reports", array($userInfo['user_id'], $_SESSION['user']['user_id']));
            $hasReported = pg_num_rows($reported);
            if($hasReported == 1)
            {
                $reportButton = "You have already reported this user.";
            }
            else
            {
                $reportButton = "<button name=\"report\"  type=\"submit\" class=\"btn btn-primary btn-block\">Report User</button>";
            }
            if ($_SESSION['user']['user_id'] == $userInfo['user_id'])
                $ownProfile = "<h4>This is what your profile looks like to others.</h4>";
        }
        else
        {
            $_SESSION['message'] = "<b>The profile you wish to view has been disabled.</b>";
            pageRedirect("dashboard.php");
        }
    }
    else
    {
        $searchUserID .= " does not have a profile or does not exist.";
        $lastAccess = "";
        $firstName = "";
        $lastName = "";
        $birthdate = "";
        $age = "";
        $gender = "";
        $genderSought = "";
        $seeking = "";
        $minimumAge = "";
        $maximumAge = "";
        $status = "";
        $city = "";
        $height = "";
        $bodyType = "";
        $hairColour = "";
        $education = "";
        $smokes = "";
        $drinks = "";
        $drugs = "";
        $children = "";
        $description = "";
        $headLine = "";
        $matchDescription = "";
        $interests = "";
        
    }
}
else
{
    pageRedirect("index.php");
}

?>

<form action="<?php echo $_SERVER["PHP_SELF"] . "?profileUserName=" . $searchUserID; ?>" method="post">
    <div class="container body-container" role="main">
        <div class="row">
            <div class="col-md-11 col-xs-10" style="padding-top: 20px; width 100%; margin: 0 auto;">
<!--            <div class="" style="padding-top: 20px; width 100%; margin: 0 auto;">-->
                    <div class="row">
                        <!--Profile Image and Stars-->
                        <div class="col-xs-12 col-sm-4 text-center col-md-4">
                            <div class="img-circle hor">
                                <img src="images/notfound.jpg" alt=""/>
                            </div>
                        </div>

                        <!--Bio-->
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <?php echo $ownProfile; ?>
                            <h2><?php echo $searchUserID ?></h2>
                            <p style="color: #737373; font-size: 11pt;"><i> <?php echo $age ?>, <?php echo ($gender == "")? "" : getProperty('gender',$gender) ?> - <?php echo ($city == "")? "" : getProperty('city', $city) ?></i></p>
                            <h4><?php echo $headLine ?> </h4>
                            <p><strong>Name: </strong> <?php echo $firstName ?> <?php echo $lastName ?> </p>
                            <p><strong>Last Online: </strong> <?php echo htmlentities($lastAccess); ?> </p>
                            <p><strong>Self-Summary: </strong> <?php echo htmlentities($description); ?> </p>
                            <p><strong>Interests: </strong> <?php echo htmlentities($interests); ?> </p>
                            <p><strong>Match Summary: </strong> <?php echo htmlentities($matchDescription); ?> </p>
                            <!--<p><strong>Interests: </strong>
                                <span class="label label-info tags">html5</span>
                                <span class="label label-info tags">css3</span>
                                <span class="label label-info tags">jquery</span>
                                <span class="label label-info tags">bootstrap3</span>
                            </p>-->
                        </div>

                        <!--Stats-->
                        <div class="col-md-2">
                            <?php echo $disableButton; ?>
                            <h3>Statistics</h3>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Looking For: </strong> <?php echo htmlentities(($genderSought == "")? "" : getProperty('gender_sought', $genderSought)); ?> </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Seeking: </strong> <?php echo ($seeking == "")? "" : getProperty ('seeking', $seeking); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Desired Age Range: </strong> <?php echo ($maximumAge == "")? "" : $minimumAge ?>-<?php echo $maximumAge; ?> </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Relationship Status: </strong> <?php echo ($status == "")? "" : getProperty ('status', $status); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Height: </strong> <?php echo ($height == "")? "" : $height; ?> cm</p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Body Type: </strong> <?php echo ($bodyType == "")? "" : getProperty('body_type', $bodyType); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Hair Colour: </strong> <?php echo ($hairColour == "")? "" : getProperty('hair', $hairColour); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Education: </strong> <?php echo ($education == "")? "" : getProperty ('education', $education); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Smokes: </strong> <?php echo ($smokes == "")? "" : getProperty('smokes', $smokes); ?> </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Drinks: </strong> <?php echo ($drinks == "")? "" : getProperty ('drinks', $drinks); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Drugs: </strong> <?php echo ($drugs == "")? "" : getProperty('drugs', $drugs); ?></p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Children: </strong> <?php echo ($children == "")? "" : getProperty('children', $children); ?></p>
                        </div>

                        <!--Buttons-->
                        <div style="margin-left: 60px; padding-bottom: 10px">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <button class="btn btn-success btn-block"><span class="fa fa-envelope"></span> Message </button>
                            </div>
                            <!--/col-->
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <?php echo $likeButton; ?>
                            </div>
                            <!--/col-->
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <?php echo $reportButton; ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <p>
    <br/><br/>
    </p>
    </form>
    <?php include("footer.php");?>
