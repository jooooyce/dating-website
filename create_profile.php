<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Create Your Profile";
$date = "2015-09-27";
$filename = "create_profile.php";
$banner = "Create Your NerdLink Profile";
$description = "This page allows users to create a profile.";

include ("header.php");
include ("secure-navbar.php");

$message = "";
$createProfile = "Create Profile";

if(isset($_SESSION['user']))
			{
				$userId = $_SESSION['user']['user_id'];
                $record = pg_execute($conn, "profile_query", array($userId));
                $records = pg_num_rows($record);
                $profileMessage ="";
                if (isset($_SESSION['profileMessage']))
                {
                    $profileMessage = "<h4>" . $_SESSION['profileMessage'] . "</h4>";
                    unset($_SESSION['profileMessage']);
                }

                if ($records == 1)
                {
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
                    $createProfile = "Update Profile";
                }
                else
                {
                    $gender = -1;
                    $genderSought = -1;
                    $seeking = -1;
                    $minimumAge = "";
                    $maximumAge = "";
                    $status = -1;
                    $city = -1;
                    $height = "";
                    $bodyType = -1;
                    $hairColour = -1;
                    $education = -1;
                    $smokes = -1;
                    $drinks = -1;
                    $drugs = -1;
                    $children = -1;
                    $description = "";
                    $headLine = "";
                    $matchDescription = "";
                    $interests = "";
                }


                if($_SERVER["REQUEST_METHOD"] == "POST") {

                    $gender = ((isset($_POST["gender"]))? trim($_POST["gender"]) : -1);
                    $seeking = ((isset($_POST["seeking"]))?trim($_POST["seeking"]) : -1);
                    $minimumAge = trim($_POST["minimum_age"]);
                    $maximumAge = trim($_POST["maximum_age"]);
                    $status = trim($_POST["status"]);
                    $height = trim($_POST["height"]);
                    $bodyType = trim($_POST["body_type"]);
                    $hairColour = trim($_POST["hair"]);
                    $education = trim($_POST["education"]);
                    $smokes = trim($_POST["smokes"]);
                    $drinks = trim($_POST["drinks"]);
                    $drugs = trim($_POST["drugs"]);
                    $children = trim($_POST["children"]);
                    $description = trim($_POST["self_description"]);
                    $headLine = trim($_POST["headline"]);
                    $matchDescription = trim($_POST["match_description"]);
                    $interests = trim($_POST["interests"]);
                    $usertype = CLIENT;
                    
                    if (isset($_POST["gender_sought"]))
                    {
                        $genderSought = trim($_POST["gender_sought"]);
                    }

                    if (isset($_POST["city"]))
                    {
                        $city = trim($_POST["city"]);
                    }

                    // If headline text box was blank display error message
                    if (!isset($description) || $description == "") {
                        $message .= "You must enter a headline" . "<br/>";
                    }
                    // If self summary text box was blank display error message
                    if (!isset($headLine) || $headLine == "") {
                        $message .= "You must enter a self summary" . "<br/>";
                    }
                    // If match summary text box was blank display error message
                    if (!isset($matchDescription) || $matchDescription == "") {
                        $message .= "You must enter a match summary" . "<br/>";
                    }
                    
                    // If user does not select a gender, display an error message
                    if (!isset($gender)){
                        $message .= "You must select a gender" . "<br/>";
                    }

                    // If user does not select a gender sought, display an error message
                    if (!isset($genderSought)){
                        $message .= "You must select a gender sought" . "<br/>";
                    }

                    // If age text box was blank, or length is incorrect, display error message
                    if (!isset($minimumAge) || $minimumAge == "") {
                        $message .= "You must enter a minimum age" . "<br/>";
                    }
                    else
                    {
                        $tempMaxAge = ($minimumAge > $maximumAge)?$minimumAge:$maximumAge;
                        $minimumAge = ($minimumAge < $maximumAge)?$minimumAge:$maximumAge;
                        $maximumAge = $tempMaxAge;
                    }

                    // If user does not enter a maximum age, display an error message
                    if (!isset($maximumAge) || $maximumAge =="") {
                        $message .= "You must enter a maximum age" . "<br/>";
                    }

                    // If height text box was blank, or length is incorrect, display error message
                    if (!isset($height) || $height == "") {
                        $message .= "You must enter your height" . "<br/>";
                    }

                    // If user does not select a city, display error message
                    if (!isset($city) || $city == "-1") {
                        $message .= "You must select a city" . "<br/>";
                    }

                    // If error is an empty string, save user profile information
                    if ($message == "") {
                        if ($records == 0) {
                            pg_execute($conn, "profile_insert", array($userId, $gender, $genderSought, $seeking, $minimumAge,
                                $maximumAge, $status, $city, $height, $bodyType, $hairColour, $education, $smokes, $drinks,
                                $drugs, $children, $description, $headLine, $matchDescription, $interests));
                            pg_execute($conn, "client_update", array($usertype, $userId));
                            $_SESSION['user']['user_type'] = $usertype;
                        } elseif ($records == 1) {
                            pg_execute($conn, "profile_update", array($userId, $gender, $genderSought, $seeking, $minimumAge,
                                $maximumAge, $status, $city, $height, $bodyType, $hairColour, $education, $smokes, $drinks,
                                $drugs, $children, $description, $headLine, $matchDescription, $interests));
                        }
                        $_SESSION['success_message'] = 'You have successfully updated your user information!';
                        header("Location: dashboard.php");
                        ob_flush();
                    }
                }
			}else{
				$_SESSION['message'] = "You must log in to access your profile.";
				pageRedirect("index.php");
			}

?>



<div class="container body-container" role="main">
    <div class="row">
        <div class="col-md-11 col-xs-10" style="padding-top: 20px; width 100%; margin: 0 auto;">
            <!-- <div class="" style="padding-top: 20px; width 100%; margin: 0 auto;"> -->
            <div class="row">

                <!--Profile Image and Stars-->
                <div class="col-xs-12 col-sm-4 text-center col-md-4">
                    <div class="img-circle hor">
                        <img src="img/placeholder.jpg" alt=""/>
                    </div>
                    <form class="list-inline ratings text-center" enctype="multipart/form-data" method="post" name="upform" action="">
                        <p>Add Profile Photo:
                        <input name="upfile" type="file" style="padding-left: 20px; padding-bottom: 10px"/>
<!--                        <input type="submit" value="upload">-->
                        <input type="submit" value="upload" class="btn btn-success btn-block"/></p>
                    </form>
                </div>

                <!--Bio-->
                <form method = "post" action= "<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="col-xs-12 col-sm-8 col-md-6">
                        <h2> <?php echo $createProfile; ?> </h2>
                        <p><?php echo $message; ?></p>
                        <?php echo $profileMessage; ?>
                            <h3>Bio</h3>
                            <hr class="stats"/>
                            <br/>Headline:
                            <textarea class="form-control" name="headline" placeholder="" style="height: 125px;" rows="10" cols="30"><?php echo $headLine; ?></textarea>
                            <br/>Self-Summary:
                            <textarea class="form-control" name="self_description" placeholder="" style="height: 125px;" rows="10" cols="30"><?php echo $description ?></textarea>
                            <br/>Match Summary:
                            <textarea class="form-control" name="match_description" placeholder="" style="height: 125px;" rows="10" cols="30"><?php echo $matchDescription; ?></textarea>
                            <br/>Interests:
                            <textarea class="form-control" name="interests" placeholder="" style="height: 125px;" rows="10" cols="30"><?php echo $interests; ?></textarea>
                            <br/>
                            <input type="submit" value="Submit" class="btn btn-success btn-block"/>
                    </div>

                    <!--Stats-->
                    <div class="col-md-2">
<!--                        <div style="margin-top: 100px;">-->
                        <h2><br/></h2>
                            <h3>Statistics</h3>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Gender:<br/></strong>
                                <?php buildRadioButton("gender", $gender, true); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Looking For:<br/></strong>
                                 <?php buildRadioButton("gender_sought", $genderSought, true); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Seeking:<br/></strong>
                                <?php buildRadioButton("seeking", $seeking); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Desired Age Range</strong>
                                <input class="em-box" type="text" name="minimum_age" placeholder="eg. 18" style="width: 50px" value="<?php echo $minimumAge ?>"/> -
                                <input class="em-box" type="text" name="maximum_age" placeholder="eg. 50" style="width: 50px" value="<?php echo $maximumAge ?>"/>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Relationship Status:</strong>
                                <?php buildDropDown("status", $status); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>City:<br/></strong>
                            <?php buildDropDown("city", $city, true); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Height:<br/></strong>
                                <input class="em-box" type="text" name="height" placeholder="eg. 182" style="width: 127px" value="<?php echo $height?>"/>cm
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Body Type:<br/></strong>
                                <?php buildDropDown("body_type", $bodyType); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Hair Colour:<br/></strong>
                            <?php buildDropDown("hair", $hairColour); ?>
                            </p>
                            <hr class="stats"/>
                            <p style="font-size: small"><strong>Education:<br/></strong>
                            <?php buildDropDown("education", $education); ?>
                            </p>
                        <hr class="stats"/>
                        <p style="font-size: small"><strong>Smokes:<br/></strong>
                            <?php buildDropDown("smokes", $smokes); ?>
                        </p>
                        <hr class="stats"/>
                        <p style="font-size: small"><strong>Drinks:<br/></strong>
                            <?php buildDropDown("drinks", $drinks); ?>
                        </p>
                        <hr class="stats"/>
                        <p style="font-size: small"><strong>Drugs:<br/></strong>
                            <?php buildDropDown("drugs", $drugs); ?>
                        </p>
                        <hr class="stats"/>
                        <p style="font-size: small"><strong>Children:</strong>
                            <?php buildDropDown("children", $children); ?>
                        </p>
                        <hr class="stats"/>
<!--                        </div>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<p><br/><br/></p>

<?php include("footer.php");?>

