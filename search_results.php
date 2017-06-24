<?php

$title = "NerdLink";
$date = "2015-09-27";
$filename = "dashboard.php";
$banner = "Welcome to NerdLink";
$description = "1";

include ("header.php");
include ("secure-navbar.php");
global $conn;
//Verifie session
if(isset($_SESSION['user']))
{
    $userId = $_SESSION['user']['user_id'];
    $record = pg_execute($conn, "user_query", array($userId));
    $records = pg_num_rows($record);



    if ($records == 1)  //that user exists
    {
        $user = pg_fetch_assoc($record, 0);
        $userType = $user['user_type'];
        if ($userType != CLIENT && $userType != INCOMPLETE_CLIENT && $userType != ADMIN)  //That user is a client or incomplete client
        {
            pageRedirect("index.php");
        }
    }
    else    //if user does not exist
    {
        pageRedirect("index.php");
    }
    
    if (!isset($_SESSION['profileUserNames']))  //make sure profile_search has set profileUserNames
    {
        pageRedirect("profile_search.php");
    }
    $users = $_SESSION['profileUserNames'];     //Get user name array from session
    //Table starts here
    $tableOutput = "<table cellpadding=\"25\" border=\"0\" style=\"width:70%;margin-left:auto;margin-right:auto\">\n";
    $numberOfUsers = max(array_map("count", $users));
    $totalPages = (integer) ceil($numberOfUsers / 10);
    //Current page validation not really a partof table here since current page is used for table
    if (!isset($_GET['page']) || $_GET['page'] != (string)((integer)$_GET['page']) || $_GET['page'] < 1)
        $currentPage = 1;
    elseif ($_GET['page'] > $totalPages)
        $currentPage = $totalPages;
    else
        $currentPage = $_GET['page'];
    //Continuing on table    
    $startIndex = ($currentPage - 1) * 10;  //start index is current page - 1 * 10 so page 1 would be 0 - 9 page 2 would be 10-19
    $endIndex = $currentPage * 10;  //end index is 10 after start
    if ($endIndex > $numberOfUsers) //less then 10 users left in array
        $endIndex = $numberOfUsers; //Set to total users
    //Loop to generate table based on users passed from search
    for( $i = $startIndex; $i < $endIndex; $i++)
    {
        $result1 = pg_execute($conn, "user_query", array($users[0][$i]));
        $result2 = pg_execute($conn, "profile_query", array($users[0][$i]));
        $currentUser = pg_fetch_assoc($result1, 0);
        $currentProfile = pg_fetch_assoc($result2, 0);
        $gender = $currentProfile['gender'];
        $city = $currentProfile['city'];
        $tableOutput .= "\t\t<tr>";
        $tableOutput .= "\t\t\t<td>" . $users[0][$i] . "</td>\n";    //Generates table output this is where you will add information
        $tableOutput .= "\t\t\t<td>" . calculateAge($currentUser['birth_date']) . ", " . getProperty('gender', $gender) . "</td>\n";
        $tableOutput .= "\t\t\t<td>" . getProperty('city', $city) . "</td>\n";
        $tableOutput .= "\t\t<td><a href=\"display_profile.php?profileUserName=" . $users[0][$i] . "\">View Profile</a></td>";
        $tableOutput .= "</tr>\n";
    }
    $tableOutput .= "</table>\n";   //Closes table
    //Nav bar starts here DON"T touch ELLEN if you dunno this part
    $navigateOutput = "";   //in case no nav bar
    if($totalPages > 1)     //Need at least 2 pages to see nav bar
    {
        if ($currentPage != 1)
        {
            $navigateOutput = "<a href=\"search_results.php?page=1\"> &lt;&lt; </a>\n";
            $navigateOutput .= "<a href=\"search_results.php?page=" . ($currentPage - 1) . "\"> &lt; </a>\n";
        }
        for($i = 1; $i <= $totalPages; $i++)
        {
            $navigateOutput .= "<a href=\"search_results.php?page=" . $i . "\"> " . $i . " </a>\n";
        }
        if ($currentPage != $totalPages)
        {
            $navigateOutput .= "<a href=\"search_results.php?page=" . ($currentPage + 1) . "\"> &gt; </a>\n";
            $navigateOutput .= "<a href=\"search_results.php?page=" . $totalPages . "\"> &gt;&gt; </a>\n";
        }
    }
    else
        $totalPages = 1;
}
else
{
    pageRedirect("index.php");
}




?>

    <style type="text/css">
        table tr:nth-child(odd) td{
            background-color: #ffffff;
        }
        table tr:nth-child(even) td{
            background-color: #ebbaab;
        }
    </style>

<div class="container body-container" role="main">
    <section class="no-padding" id="portfolio">
    <div class="col-lg-12 text-center">
        <br/>
        <h2 class="section-heading">Search Results</h2>
        <hr class="primary"/>
        <h4>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></h4>
        <br/>
        <?php echo $tableOutput; 
            echo "<br/>" . $navigateOutput; ?>
        
    </div>

<?php //echo $numberOfUsers;
include("footer.php");?>