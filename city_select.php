<?php

/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
November 4th, 2015
WEDE3201
*/

$title = "City Selection";
$date = "2015-11-03";
$filename = "profile_city_select.php";
$banner = "Select a city";
$description = "This page serves as a city selection page for the user.";

include ("header.php");
include ("secure-navbar.php");
?>

<?php
	
	$city = NULL;
		
	if(isset($_SESSION['user']))
	{
		$userId = $_SESSION['user']['user_id'];
		$record = pg_execute($conn, "user_query", array($userId));
		$records = pg_num_rows($record);


		if ($records == 1)
		{
			$user = pg_fetch_assoc($record, 0);
			$userType = $user['user_type'];
            
			if ($userType != CLIENT && $userType != INCOMPLETE_CLIENT && $userType != ADMIN)
			{
				pageRedirect("index.php");
			}
		}
		
		else
		{
			pageRedirect("index.php");
		}
		
		if($_SERVER["REQUEST_METHOD"] == "GET")
		{
			$city = getCookie("city");
		}
		
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			$message = "";
			$selectedCity = (isset($_POST["city"]))? sumCheckBox($_POST["city"]) : 0;
			//setcookie("city", $selectedCity, time()+ EXPIRE_DATE);
			//$_SESSION['selectedCity'] = $selectedCity;
			//unset($_SESSION['selectedCity']);
			
			if($selectedCity == 0)
			{
				$message = "You must select a city!";
			}
			
			else 
			{
			$link = "profile_search.php?selectedCity=" . $selectedCity;
			pageRedirect($link);
			}
			
			if ($message != "")
			{
				$_SESSION['searchMessage'] = $message;
			}
		}
	}
	
	else
	{
		pageRedirect("index.php");
	}
?>

<div class="container body-container" role="main">
	<section class="no-padding" id="portfolio">
		<div class="col-lg-12 text-center"><br/>
			<h2 class="section-heading">City Selection</h2>
			<hr class="primary"/>
		
			<?php   
				if (isset($_SESSION['searchMessage']))
				{
					echo "<p align=\"center\">" . $_SESSION['searchMessage'] . "</p>";
					unset($_SESSION['searchMessage']);
				} 
			?>
		
			<script type="text/javascript">
			<!--
				function cityToggleAll()
				{
					var isChecked = document.getElementById("city_toggle").checked;
					var city_checkboxes = document.getElementsByName("city[]");
					for (var i in city_checkboxes)
					{
						city_checkboxes[i].checked = isChecked;
					}		
				}
			//-->
			</script>
			
			<table border="0" style="width:100%">
				<tr>
					<td style="width:16%"></td>
					<td style="width:14%" align="left">
						<form method = "post" action= "<?php echo $_SERVER['PHP_SELF']; ?>">
							<p style="font-size: small"><strong>Select Cities:<br/></strong>
								<input type="checkbox"  id="city_toggle" onclick="cityToggleAll();" name="city[]" value="0"/>Select All<br/>
								<?php buildCheckBox("city", $city); ?><br/>
								<input type="submit" value="Submit" class="btn btn-success btn-block"/>
							</p>
						</form>
					</td>
					<td style="width:15%"></td>
					<td align="center">
						<img src="img/durhamregion.png" width="318" height="439" alt="Durham Region Map" usemap="#durhammap" />
						<map name="durhammap" id="page-map">
							<area shape="poly" coords="46,354,81,355,81,409,47,409" href="profile_search.php?selectedCity=1" alt="Ajax" />
							<area shape="poly" coords="84,18,121,22,137,1,162,10,160,192,82,189" href="profile_search.php?selectedCity=2" alt="Brock" />
							<area shape="poly" coords="160,306,236,305,237,318,316,319,316,433,295,438,244,423,212,419,194,425,160,411" href="profile_search.php?selectedCity=4" alt="Clarington" />
							<area shape="poly" coords="122,301,160,301,160,411,144,414,122,411" href="profile_search.php?selectedCity=8" alt="Oshawa" />
							<area shape="poly" coords="4,299,82,301,81,353,46,353,44,411,29,407,16,413,4,398" href="profile_search.php?selectedCity=16" alt="Pickering" />
							<area shape="poly" coords="85,192,160,195,161,226,188,204,198,210,194,234,237,211,236,303,159,301,83,299" href="profile_search.php?selectedCity=32" alt="Scugog" />
							<area shape="poly" coords="7,142,82,142,82,299,5,297" href="profile_search.php?selectedCity=64" alt="Uxbridge" />
							<area shape="poly" coords="83,301,121,301,121,409,112,413,100,405,82,411" href="profile_search.php?selectedCity=128" alt="Whitby" />
						</map>
					</td>
				</tr>
			</table>
		</div>
	</section>
</div>

<p><br/><br/></p>

<?php include("footer.php");?>