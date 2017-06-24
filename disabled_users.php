<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
November 27, 2015
WEDE3201
*/

$title = "NerdLink";
$date = "2015-11-30";
$filename = "disabled_users.php";
$banner = "Disabled Users";
$description = "This page lists disabled_users that only admin can see .";

include ("header.php");
include ("secure-navbar.php");
global $conn;

if(isset($_SESSION['user']))
{
    $user = $_SESSION['user']['user_id'];
    $result = pg_execute($conn, "user_query", array($user));
	//$result2 = pg_execute($conn, "disabled_user_query", array($user));
    $record = pg_num_rows($result);
	
    if ($record == 1)  //that user exists
    {
        $user = pg_fetch_assoc($result, 0);
        $userType = $user['user_type'];
        if ($userType != ADMIN )  
        {
            pageRedirect("index.php");
        }
    }
    else    //if user does not exist
    {
        pageRedirect("index.php");
    }	
	   
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$enable = $_POST['enable'];
	pg_execute($conn, "disabled_user_update",array(CLIENT, $enable));
	
	}
	$results = pg_execute($conn, "user_query_by_type",array(DISABLED_CLIENT));
	$users = pg_fetch_all($results);  
	
    //Table starts here
    $tableOutput = "<table cellpadding=\"25\" border=\"0\" style=\"width:70%;margin-left:auto;margin-right:auto\">\n";
    $numberOfUsers = count($users);
    $totalPages = (integer) ceil($numberOfUsers / 10);
    //Current page validation not really a partof table here since current page is used for table
    if (!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] < 1)
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
    //print_r($users);
    for( $i = $startIndex; $i < $endIndex; $i++)
    {
		$result2 = pg_execute($conn, "profile_query", array($users[$i]['user_id']));
        $currentProfile = pg_fetch_assoc($result2, 0);
		//print_r($currentProfile);
		
		

		
        $gender = $currentProfile['gender'];
        $city = $currentProfile['city'];
        $tableOutput .= "\t\t<tr>";
        $tableOutput .= "\t\t\t<td>" . $currentProfile['user_id'] . "</td>\n";    //Generates table output this is where you will add information
        
        $tableOutput .= "\t\t<td><a href=\"display_profile.php?profileUserName=" . $currentProfile['user_id'] . "\">View Profile</a></td>";	
        $tableOutput .= "\t\t<td><button name=\"enable\" type=\"submit\" value=\"" . $currentProfile['user_id'] . "\">Enable</button></td>";	
        $tableOutput .= "</tr>\n";
		
    }
    $tableOutput .= "</table>\n";   //Closes table

	$navigateOutput = "";   //in case no nav bar
    if($totalPages > 1)     //Need at least 2 pages to see nav bar
    {
        if ($currentPage != 1)
        {
            $navigateOutput = "<a href=\"disabled_users.php?page=1\"> &lt;&lt; </a>\n";
            $navigateOutput .= "<a href=\"disabled_users.php?page=" . ($currentPage - 1) . "\"> &lt; </a>\n";
        }
        for($i = 1; $i <= $totalPages; $i++)
        {
            $navigateOutput .= "<a href=\"disabled_users.php?page=" . $i . "\"> " . $i . " </a>\n";
        }
        if ($currentPage != $totalPages)
        {
            $navigateOutput .= "<a href=\"disabled_users.php?page=" . ($currentPage + 1) . "\"> &gt; </a>\n";
            $navigateOutput .= "<a href=\"disabled_users.php?page=" . $totalPages . "\"> &gt;&gt; </a>\n";
			
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
        <h2 class="section-heading">Disabled Users List</h2>
        <hr class="primary"/>
        <h4>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></h4>
        <br/>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php echo $tableOutput; 
            echo "<br/>" . $navigateOutput; ?>
        </form>
    </div>

<?php 
include("footer.php");?>

















