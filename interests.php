<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
December 6, 2015
WEDE3201
*/

$title = "NerdLink";
$date = "2015-12-06";
$filename = "interests.php";
$banner = "NerdLink";
$description = "The interests page for NerdLik.";

include ("header.php");
include ("secure-navbar.php");
global $conn;

if (!isset($_SESSION['user']))
    pageRedirect("index.php");
elseif($_SESSION['user']['user_type'] == ADMIN)
    pageRedirect("admin.php");
elseif($_SESSION['user']['user_type'] != CLIENT)
    pageRedirect("create_profile.php");
    
    
if (isset($_POST['like']))
{
    pg_execute($conn, "remove_interest", array($_SESSION['user']['user_id'], $_POST['like']));
}
elseif (isset($_POST['likedBy']))
{
    pg_execute($conn, "remove_interest", array($_POST['likedBy'], $_SESSION['user']['user_id']));
}

$interestIn = "<table border=\"0\" style=\"width:100%\">\n\t\t<tr><th colspan=\"4\">People You Like</th></tr>";
$interested = "<table border=\"0\" style=\"width:100%\">\n\t\t<tr><th colspan=\"4\">People That Like You</th></tr>";

$interestIn .= "\n\t\t\t<tr><th>User</th><th>Time Liked</th><th></th><th>Mutual Like</th></tr>";
$interested .= "\n\t\t\t<tr><th>User</th><th>Time Liked</th><th></th><th>Mutual Like</th></tr>";


$interestResults = pg_execute($conn, "my_interests", array($_SESSION['user']['user_id']));
$interestedResults = pg_execute($conn, "interested_in_me", array($_SESSION['user']['user_id']));
$interestRows = pg_num_rows($interestResults);
$interestedRows = pg_num_rows($interestedResults);
$interestArray = pg_fetch_all($interestResults);
$interestedArray = pg_fetch_all($interestedResults);


for( $i = 0; $i < $interestRows; $i++)
{
    $interestIn .= "\n\t\t<tr>";
    $interestIn .= "\n\t\t\t<td style=\"text-align:center;\">" . "<a href=\"display_profile.php?profileUserName=" . $interestArray[$i]['user_interest'] ."\">" . $interestArray[$i]['user_interest'] . "</a></td>";
    $interestIn .= "\n\t\t\t<td style=\"text-align:center;\">" . $interestArray[$i]['time'] ."</td>";
    $interestIn .= "\n\t\t\t<td style=\"text-align:center;\"><button name=\"like\" class=\"btn btn-primary btn-block\" type=\"submit\" value=\"" . $interestArray[$i]['user_interest'] . "\">Remove Like</button></td>";
    $mutualResult = pg_execute($conn, "interst_exist", array($interestArray[$i]['user_interest'], $_SESSION['user']['user_id']));
    if (pg_num_rows($mutualResult) == 1)
        $interestIn .= "\n\t\t\t<td style=\"text-align:center;\">Yes</td>";
    $interestIn .= "\n\t\t</tr>";
}

for( $i = 0; $i < $interestedRows; $i++)
{
    $interested .= "\n\t\t<tr>";
    $interested .= "\n\t\t\t<td style=\"text-align:center;\">" . "<a href=\"display_profile.php?profileUserName=" . $interestedArray[$i]['user_id'] ."\">" . $interestedArray[$i]['user_id'] . "</a></td>";
    $interested .= "\n\t\t\t<td style=\"text-align:center;\">" . $interestedArray[$i]['time'] ."</td>";
    $interested .= "\n\t\t\t<td style=\"text-align:center;\"><button name=\"likedBy\" class=\"btn btn-primary btn-block\" type=\"submit\" value=\"" . $interestedArray[$i]['user_id'] . "\">Remove Like</button></td>";
    $mutualResult = pg_execute($conn, "interst_exist", array($_SESSION['user']['user_id'], $interestedArray[$i]['user_id']));
    if (pg_num_rows($mutualResult) == 1)
        $interested .= "\n\t\t\t<td style=\"text-align:center;\">Yes</td>";
    $interested .= "\n\t\t</tr>";
}

$interestIn .= "\n\t</table>\n";
$interested .= "\n\t</table>\n";

?>
<div class="container body-container" role="main">
    <center>
    <h2>Your Likes</h2>
    <br/>
    <form method = "post" action= "<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="col-xs-12 col-sm-8 col-md-6">
            <?php echo $interestIn; ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-6">
            <?php echo $interested; ?>
        </div> 
    </form>
    
    </center>
    <p>
    <br/>
    <br/>
    </p>
</div>

<?php include ("footer.php");