<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
November 12, 2015
WEDE3201
*/

$title = "User Logout";
$date = "2015-11-12";
$filename = "user-logout.php";
$banner = "NerdLink";
$description = "The user logout page for Nerdlink.";



include ("header.php");
if (isset($_SESSION['user']))
{
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['message'] = "You have successfully logged out.";
}
pageRedirect("login.php");

include ("footer.php");
?>