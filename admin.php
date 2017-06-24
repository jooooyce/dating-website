<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Welcome Back!";
$date = "2015-11-05";
$filename = "dashboard.php";
$banner = "Welcome Back to NerdLink!";
$description = "This page serves as the dashboard once a admin correctly logs in.";
include ("header.php");
include ("secure-navbar.php");
include_once("includes/db.php");
?>

<?php
		
	if(isset($_SESSION['user']))
	{
		$userId = $_SESSION['user']['user_id'];
		$record = pg_execute($conn, "user_query", array($userId));
		$records = pg_num_rows($record);


		if ($records == 1)
		{
			$user = pg_fetch_assoc($record, 0);
			$userType = $user['user_type'];
			if ($userType != ADMIN)
			{
				pageRedirect("dashboard.php");
			}
		}
		
		else
		{
			pageRedirect("index.php");
		}
		
		if(isset($_POST['disableReported']))
		{
			$reported = $_POST['reported'];
			$reporter = $_POST['reporter'];
			pg_execute($conn, "client_update", array(DISABLED_CLIENT, $reported));
			//pg_execute($conn, "close_report", array($reporter, $reported));
            pg_execute($conn, "handle_user_report", array($reported));
		}
		
		if(isset($_POST['disableReporter']))
		{
			$reported = $_POST['reported'];
			$reporter = $_POST['reporter'];
			pg_execute($conn, "client_update", array(DISABLED_CLIENT, $reporter));
			//pg_execute($conn, "close_report", array($reporter, $reported));
            pg_execute($conn, "handle_user_report", array($reported));
            pg_execute($conn, "handle_user_reporter", array($reporter));
		}
		
		if(isset($_POST['closeReport']))
		{
			$reported = $_POST['reported'];
			$reporter = $_POST['reporter'];
			//pg_execute($conn, "close_report", array($reporter, $reported));
            pg_execute($conn, "handle_user_report", array($reported));
		}
		
		$firstName = $_SESSION['user']['first_name'];
		$lastName = $_SESSION['user']['last_name'];
		$lastAccess = $_SESSION['user']['last_access'];
				
		$greeting = '<p>' . "Welcome back, ".$firstName." ".$lastName."! You last visited on ".$lastAccess . '</p>';
		
		$accountStatus = OPEN;
		$reportedUsers = pg_execute($conn, "find_reports", array($accountStatus));   
		
		$tableOutput = "<table cellpadding=\"25\" border=\"0\" style=\"width:70%;margin-left:auto;margin-right:auto\">\n";
		$tableOutput .= "<tr><th>Reported User</th><th>Reported By</th><th>Report Date/Time</th><th>Disable Reported</th><th>Disable Reporter</th><th>Close Report</th></tr>\n";
		$numberOfReports = pg_num_rows($reportedUsers);
		$totalPages = (integer) ceil($numberOfReports / 10);
		
		if (!isset($_GET['page']) || $_GET['page'] != (string)((integer)$_GET['page']) || $_GET['page'] < 1)
			$currentPage = 1;
		
		elseif ($_GET['page'] > $totalPages)
			$currentPage = $totalPages;
		else
			$currentPage = $_GET['page'];
		
		$startIndex = ($currentPage - 1) * 10;  
		$endIndex = $currentPage * 10;
		
		if ($endIndex > $numberOfReports) 
			$endIndex = $numberOfReports; 
				
		for( $i = $startIndex; $i < $endIndex; $i++)
		{
			$reportedUser = pg_fetch_result($reportedUsers, $i, "user_reported");
			$reportedBy = pg_fetch_result($reportedUsers, $i, "user_id");
			$reportTime = pg_fetch_result($reportedUsers, $i, "time");
			
			$tableOutput .= "\t\t<tr style=\"height:35px;\">";
			$tableOutput .= "\t\t<td><a href=\"display_profile.php?profileUserName=" . $reportedUser . "\">" . $reportedUser . "</a></td>";
			$tableOutput .= "\t\t<td><a href=\"display_profile.php?profileUserName=" . $reportedBy . "\">" . $reportedBy . "</a></td>";
			$tableOutput .= "\t\t\t<td>" . $reportTime . "</td>\n";
			
			$tableOutput .= "\t\t\t<td><form id='disable1-" . $i . "' enctype='multipart/form-data' method='post' action='". $_SERVER['PHP_SELF'] . "'>";
			$tableOutput .= "<div><input type='hidden' name='reported' value='" . $reportedUser . "' />";
			$tableOutput .= "<input type='hidden' name='reporter' value='" . $reportedBy . "' />";
			$tableOutput .= "<input type='submit' name='disableReported' value='Disable Reported' class='btn btn-primary btn-xs'/></div></form></td>";
			
			$tableOutput .= "\t\t\t<td><form id='disable2-" . $i . "' enctype='multipart/form-data' method='post' action='". $_SERVER['PHP_SELF'] . "'>";
			$tableOutput .= "<div><input type='hidden' name='reported' value='" . $reportedUser . "' />";
			$tableOutput .= "<input type='hidden' name='reporter' value='" . $reportedBy . "' />";
			$tableOutput .= "<input type='submit' name='disableReporter' value='Disable Reporter' class='btn btn-primary btn-xs'/></div></form></td>";
			
			$tableOutput .= "\t\t\t<td><form id='close" . $i . "' enctype='multipart/form-data' method='post' action='". $_SERVER['PHP_SELF'] . "'>";
			$tableOutput .= "<div><input type='hidden' name='reported' value='" . $reportedUser . "' />";
			$tableOutput .= "<input type='hidden' name='reporter' value='" . $reportedBy . "' />";
			$tableOutput .= "<input type='submit' name='closeReport' value='Close Report' class='btn btn-primary btn-xs'/></div></form></td>";
			$tableOutput .= "</tr>\n";
		}
		
		$tableOutput .= "</table>\n";  
		
		
		$navigateOutput = "";   
		if($totalPages > 1)     
		{
			if ($currentPage != 1)
			{
				$navigateOutput = "<a href=\"admin.php?page=1\"> &lt;&lt; </a>\n";
				$navigateOutput .= "<a href=\"admin.php?page=" . ($currentPage - 1) . "\"> &lt; </a>\n";
			}
			for($i = 1; $i <= $totalPages; $i++)
			{
				$navigateOutput .= "<a href=\"admin.php?page=" . $i . "\"> " . $i . " </a>\n";
			}
			if ($currentPage != $totalPages)
			{
				$navigateOutput .= "<a href=\"admin.php?page=" . ($currentPage + 1) . "\"> &gt; </a>\n";
				$navigateOutput .= "<a href=\"admin.php?page=" . $totalPages . "\"> &gt;&gt; </a>\n";
			}
		}
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
		<div class="col-lg-12 text-center"><br/>
			<h2 class="section-heading">Admin Dashboard</h2>
			<hr class="primary"/>
			<br/><br/><?php echo $greeting; ?>
			<br/><br/><h3 class="section-heading">Open User Reports</h3>
			<hr class="primary"/>
			<h4>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></h4>
			<br/>
			<?php 
				echo $tableOutput; 
				echo "<br/>" . $navigateOutput; 
			?>
        </div>
	</section>
</div>

<p><br/><br/></p>

<?php include("footer.php");?>