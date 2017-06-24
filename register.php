<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Register NerdLink Account";
$date = "2015-09-27";
$filename = "index.php";
$banner = "NerdLink";
$description = "The registration page for NerdLink.";

include ("header.php"); ?>

<?php
$results = "";
$message = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $login = "";
    $birthday = "";
    $birthmonth = "";
    $birthyear = "";
    $email = "";
    $confirmemail = "";
    $pass = "";
    $confirmpass = "";
    $firstName = "";
    $lastName = "";

}else if($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["user_id"]);
    $birthday = trim($_POST["birth_day"]);
    $birthmonth = trim($_POST["birth_month"]);
    $birthyear = trim($_POST["birth_year"]);
    $fullbirthdate = $birthyear . "/" . $birthmonth . "/" . $birthday;
    $email = trim($_POST["email_address"]);
    $confirmemail = trim($_POST["confirm_email"]);
    $pass = trim($_POST["password"]);
    $confirmpass = trim($_POST["confirm_password"]);
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $today = date("Y-m-d", time());
    $conn = db_connect();
    $usertype = INCOMPLETE_CLIENT;
    $sql = "SELECT user_id, first_name, last_name, birth_date, email_address, password FROM users WHERE user_id = '" . $login . "'";
    $results = pg_query($conn, $sql);

    // If user already exists in the database, display error message
    if (pg_num_rows($results) == 1) { // Not zero means something was found
        $message .= "The user ID " . $login . " already exists in the database" . "<br/>";
        $login = "";
    }

    // If username text box was blank, or length is incorrect, display error message
    if (!isset($login) || $login == "") {
        $message .= "You must enter a login" . "<br/>";
    } else if (strlen($login) < MINIMUM_LOGIN_LENGTH) {
        $message .= "A user ID must be at least " . MINIMUM_LOGIN_LENGTH . " characters" . "<br/>";
        $login = "";
    } else if (strlen($login) > MAXIMUM_LOGIN_LENGTH) {
        $message .= "A user ID must not exceed " . MAXIMUM_LOGIN_LENGTH . " characters" . "<br/>";
        $login = "";
    }

    // If first name text box was blank, or length is incorrect, display error message
    if (!isset($firstName) || $firstName == "") {
        $message .= "You must enter a first name" . "<br/>";
    } else if (strlen($login) > MAXIMUM_FIRST_NAME_LENGTH) {
        $message .= "A first name must not exceed " . MAXIMUM_FIRST_NAME_LENGTH . " characters" . "<br/>";
        $firstName = "";
    }

    // If last name text box was blank, or length is incorrect, display error message
    if (!isset($lastName) || $lastName == "") {
        $message .= "You must enter a last name" . "<br/>";
    } else if (strlen($login) > MAXIMUM_LAST_NAME_LENGTH) {
        $message .= "A last name must not exceed " . MAXIMUM_LAST_NAME_LENGTH . " characters" . "<br/>";
        $lastName = "";
    }
    // If birth day text box was blank, is not numeric, or length is incorrect, display error message
    if (!isset($birthday) || $birthday == "") {
        $message .= "You must enter a birth day" . "<br/>";
    } else if (!is_numeric($birthday)) {
        $message .= "Birth day must be a number" . "<br/>";
        $birthday = "";
    } else if (strlen($birthday) < MINIMUM_DAY_MONTH_LENGTH) {
        $message .= "A birth day must be at least " . MINIMUM_DAY_MONTH_LENGTH . " character." . "<br/>";
        $birthday .= "";
    } else if (strlen($birthday) > MAXIMUM_DAY_MONTH_LENGTH) {
        $message .= "A birth day must not exceed " . MAXIMUM_DAY_MONTH_LENGTH . " characters. " . "<br/>";
        $birthday .= "";
    }

    // If birth month text box was blank, is not numeric, or length is incorrect, display error message
    if (!isset($birthmonth) || $birthmonth == "") {
        $message .= "You must enter a birth month" . "<br/>";
    } else if (!is_numeric($birthmonth)) {
        $message .= "Birth month must be a number";
        $birthmonth = "";
    } else if (strlen($birthmonth) < MINIMUM_DAY_MONTH_LENGTH) {
        $message .= "A birth month must be at least " . MINIMUM_DAY_MONTH_LENGTH . " character." . "<br/>";
        $birthmonth .= "";
    } else if (strlen($birthmonth) > MAXIMUM_DAY_MONTH_LENGTH) {
        $message .= "A birth month must not exceed " . MAXIMUM_DAY_MONTH_LENGTH . " characters. " . "<br/>";
        $birthmonth .= "";
    }

    // If birth year text box was blank, is not numeric, or length is incorrect, display error message
    if (!isset($birthyear) || $birthyear == "") {
        $message .= "You must enter a birth year" . "<br/>";
    } else if (!is_numeric($birthyear)) {
        $message .= "Birth year must be a number" . "<br/>";
        $birthyear = "";
    } else if (strlen($birthyear) < MAXIMUM_YEAR_LENGTH) {
        $message .= "A birth month must be at least " . MAXIMUM_YEAR_LENGTH . " characters." . "<br/>";
        $birthyear .= "";
    }

    // If date is invalid, display error message
    if (checkdate ((int)$birthmonth,(int)$birthday,(int)$birthyear) == FALSE) {
        $message .= "You must enter a valid date" . "<br/>";
        $birthday = "";
        $birthmonth = "";
        $birthyear = "";
    }

    // If user is under the age of 18, display error message
    if (calculateAge($fullbirthdate) < MINIMUM_AGE) {
        $message .= "You must be over the age of " . MINIMUM_AGE . " to register! <br/>";
        $birthday = "";
        $birthmonth = "";
        $birthyear = "";
    }

    // If e-mail address is invalid, or length is incorrect, display error message
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $message .= "Your email address is not valid" . "<br/>";
        $email = "";
    } else if (strlen($email) > MAXIMUM_EMAIL_LENGTH) {
        $message .= "Your email address must not exceed 255 characters" . "<br/>";
    }else if (strcmp($email, $confirmemail) !== 0) {
        $message .= "Your e-mail addresses do not match" . "<br/>";
        $email = "";
        $confirmemail = "";
    }

    // If password text box was blank, or length is incorrect, or they do not match, display error message
    if (!isset($pass) || $pass == "") {
        $message .= "You must enter a password" . "<br/>";
    } else if (strlen($pass) < MINIMUM_PASSWORD_LENGTH) {
        $message .= "A password must be at least "  . MINIMUM_PASSWORD_LENGTH . " characters <br/>";
        $pass .= "";
    } else if (strlen($pass) > MAXIMUM_PASSWORD_LENGTH) {
        $message .= "A password must not exceed " . MAXIMUM_PASSWORD_LENGTH . " characters <br/>";
        $pass .= "";
    } else if (strcmp($pass, $confirmpass) !== 0) {
        $message .= "Your passwords do not match" . "<br/>";
        $pass = "";
        $confirmpass = "";
    }

    // If error is an empty string, register user to database
    if ($message == "") {
        $passmd5 = md5($pass);
        pg_execute($conn, "user_insert", array($login, $firstName, $lastName, $fullbirthdate, $email, $passmd5, $today, $today, $usertype));
        header("Location: login.php");
        ob_flush();
    }
}

?>

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

        <!-- Register box -->
        <div class="loginmodal-container" style="max-width: 450px;">
            <h2>Register Your Account</h2><br/>
            <h2><?php echo $message; ?></h2><br/>
            <div class="register-box">
                <form method = "post" action= <?php echo $_SERVER['PHP_SELF']; ?>>
                    <div>
                        <h4>Username</h4>
                        <input class="" type="text" name="user_id" placeholder="Username" value="<?php echo $login; ?>"/>
                    </div>
                    <div style="padding-top: 5px;">
                        <h4>First Name</h4>
                        <input class="em-box" type="text" name="first_name" placeholder="First Name" value="<?php echo $firstName; ?>"/>
                        <h4>Last Name</h4>
                        <input class="em-box" type="text" name="last_name" placeholder="Last Name" value="<?php echo $lastName; ?>"/>
                    <div>
                        <h4>Birthdate</h4>
                        <input class="date-box" type="text" name="birth_day" placeholder="DD" maxlength="2" autocomplete="off" value="<?php echo $birthday; ?>"/>
                        <input class="date-box2" type="text" name="birth_month" placeholder="MM" maxlength="2" autocomplete="off" value="<?php echo $birthmonth; ?>"/>
                        <input class="date-box2" type="text" name="birth_year" placeholder="YYYY" maxlength="4" autocomplete="off" value="<?php echo $birthyear; ?>"/>
                    </div>
                    <div style="padding-top: 5px;">
                        <h4>Email</h4>
                        <input class="em-box" type="text" name="email_address" placeholder="e.g. example@nerdlink.com" value="<?php echo $email; ?>"/>
                        <input class="em-box" type="text" name="confirm_email" placeholder="Confirm Email" value="<?php echo $confirmemail; ?>"/>
                        <h4>Password</h4>
                        <input class="em-box" type="password" name="password" placeholder="Password" value="<?php echo $pass; ?>"/>
                        <input class="em-box" type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirmpass; ?>"/>
                    </div>
                    <input type="submit" name="Register" class="login loginmodal-submit" value="Register"/>
                </form>
            </div>
        </div>

<?php include ("footer.php"); ?>