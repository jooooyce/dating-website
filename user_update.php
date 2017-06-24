<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
November 10, 2015
WEDE3201
*/

$title = "Update Your Information";
$date = "2015-09-27";
$filename = "user_update.php";
$banner = "Update Your Information";
$description = "This page allows users to update your user information";

include ("header.php");
include ("secure-navbar.php");

$message = "";

if(isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['user_id'];
    $record = pg_execute($conn, "user_query", array($userId));
    $records = pg_num_rows($record);

    if ($records == 1) {
        $user = pg_fetch_assoc($record, 0);
        $dob=explode("-",$user['birth_date']);
        $birthday = $dob[2];
        $birthmonth = $dob[1];
        $birthyear = $dob[0];
        $email = $user['email_address'];
        $confirmemail = $user['confirm_email'];
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
    }

    else {
        $birthday = "";
        $birthmonth = "";
        $birthyear = "";
        $email = "";
        $confirmemail = "";
    }
} else {
    pageRedirect("index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $birthday = trim($_POST["birth_day"]);
    $birthmonth = trim($_POST["birth_month"]);
    $birthyear = trim($_POST["birth_year"]);
    $email = trim($_POST["email_address"]);
    $confirmemail = trim($_POST["confirm_email"]);
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $fullbirthdate = $birthyear . "-" . $birthmonth . "-" . $birthday;

    // If first name text box was blank, or length is incorrect, display error message
    if (!isset($firstName) || $firstName == "") {
        $message .= "You must enter a first name" . "<br/>";
    } else if (strlen($firstName) > MAXIMUM_FIRST_NAME_LENGTH) {
        $message .= "A first name must not exceed " . MAXIMUM_FIRST_NAME_LENGTH . " characters" . "<br/>";
        $firstName = "";
    }

    // If last name text box was blank, or length is incorrect, display error message
    if (!isset($lastName) || $lastName == "") {
        $message .= "You must enter a last name" . "<br/>";
    } else if (strlen($lastName) > MAXIMUM_LAST_NAME_LENGTH) {
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

    // If error is an empty string, save user profile information
    if ($message == "") {
            pg_execute($conn, "user_update", array($userId, $firstName, $lastName, $fullbirthdate, $email));
        $_SESSION['success_message'] = 'You have successfully updated your profile!';
    }
}

?>

<body id="page-top">
<div class="container body-container" role="main">
    <h2 align="center">Update User Information</h2>
    <p><?php echo $message ?></p>
    <div class="row">
        <div class="col-md-11 col-xs-10" style="padding-top: 20px; width 100%; margin: 0 auto;">
            <form method = "post" action= <?php echo $_SERVER['PHP_SELF']; ?>>
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
                    </div><br/>
                    <div style="padding-top: 5px;">
                        <h4>Email</h4>
                        <input class="em-box" type="text" name="email_address" placeholder="e.g. example@nerdlink.com" value="<?php echo $email; ?>"/>
                        <input class="em-box" type="text" name="confirm_email" placeholder="Confirm Email" value="<?php echo $confirmemail; ?>"/>
                    </div>
                    <input type="submit" name="Register" class="login loginmodal-submit" value="Update"/>
            </form>
        </div>
     </div>
</div>

<?php include ("footer.php");?>