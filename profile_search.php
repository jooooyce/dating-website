 <?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Search For A Match";
$date = "2015-10-29";
$filename = "profile_search.php";
$banner = "Search For Your Nerd";
$description = "This page allows users to select search criteria for a match.";
$cityValue = 3;
include ("header.php");
include ("secure-navbar.php");

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
    if (!isset($_GET['selectedCity']))
    {
        pageRedirect("city_select.php");
    }
    $cityValue = $_GET['selectedCity'];
    $cities = citySelected($cityValue);
	setcookie("city", $cityValue, time()+ EXPIRE_DATE);
    $nameOfInputs = array("gender_sought", "minimum_age", "maximum_age", "seeking", "status", "body_type", "hair", "education","smokes", "drinks", "drugs", "children");
    $searchValue = array();
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        for ($i = 0; $i < NUMBER_OF_FIELDS; $i++)
        {
            $searchValue[$i] = getCookie($nameOfInputs[$i]); 
        }
        if ($searchValue[0] == 0)
            $searchValue[0] = -1;
        /*$status = getCookie("status");
        $seeking = getCookie("seeking");
        $body = getCookie("body");
        $hair = getCookie("hair");
        $education = getCookie("education");
        $smokes = getCookie("smokes");
        $drinks = getCookie("drinks");
        $drugs = getCookie("drugs");
        $children = getCookie("children");
        $minimumAge = getCookie("minimumAge");
        $maximumAge = getCookie("maximumAge");
        $genderSought = getCookie("genderSought");*/
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $message = "";
        /*$searchValue[0] = (isset($_POST["gender_sought"]))? $_POST["gender_sought"] : 0;
        $searchValue[1] = (isset($_POST["minimum_age"]))? $_POST["minimum_age"] : "";
        $searchValue[2] = (isset($_POST["maximum_age"]))? $_POST["maximum_age"] : "";
        $searchValue[3] = (isset($_POST["status"]))? sumCheckBox(($_POST["status"])) : 0;
        $searchValue[4] = (isset($_POST["seeking"]))? sumCheckBox($_POST["seeking"]) : 0;
        $searchValue[5] = (isset($_POST["body_type"]))? sumCheckBox($_POST["body_type"]) : 0;
        $searchValue[6] = (isset($_POST["hair"]))? sumCheckBox($_POST["hair"]) : 0;
        $searchValue[7] = (isset($_POST["education"]))? sumCheckBox($_POST["education"]) : 0;
        $searchValue[8] = (isset($_POST["smokes"]))? sumCheckBox($_POST["smokes"]) : 0;
        $searchValue[9] = (isset($_POST["drinks"]))? sumCheckBox($_POST["drinks"]) : 0;
        $searchValue[10] = (isset($_POST["drugs"]))? sumCheckBox($_POST["drugs"]) : 0;
        $test = $searchValue[11] = (isset($_POST["children"]))? sumCheckBox($_POST["children"]) : 0;*/
        
        
        $searchValue[0] = (isset($_POST["gender_sought"]))? $_POST["gender_sought"] : 0;
        $searchValue[1] = (int)(isset($_POST["minimum_age"]))? trim($_POST["minimum_age"]) : 0;
        $searchValue[2] = (int)(isset($_POST["maximum_age"]))? trim($_POST["maximum_age"]) : 0;
        if ($searchValue[1] != ((string)((integer)$searchValue[1])))
        {
            $message .= $searchValue[1] . " is not a whole number. Please enter a whole number. <br/>";
        }
        if ($searchValue[2] != ((string)((integer)$searchValue[2])))
        {
            $message .= $searchValue[2] . " is not a whole number. Please enter a whole number. <br/>";
        }
        if ($searchValue[1] > $searchValue[2])
        {
            $temp = $searchValue[1];
            $searchValue[1] = $searchValue[2];
            $searchValue[2] = $temp;
        }
        for ($i = 0; $i < NUMBER_OF_FIELDS; $i++)
        {
            if ($i > 2)
            {
                $searchValue[$i] = (isset($_POST[$nameOfInputs[$i]]))? sumCheckBox(($_POST[$nameOfInputs[$i]])) : 0;
            }
            //$searchValue[] = (isset($_POST[$cookieValue]))? $_POST[$cookieValue] : 0;
            setcookie($nameOfInputs[$i], $searchValue[$i], time()+ EXPIRE_DATE);
        }
        /*setcookie("status", $status, time()+ EXPIRE_DATE);
        setcookie("seeking", $seeking, time()+ EXPIRE_DATE);
        setcookie("body", $body, time()+ EXPIRE_DATE);
        setcookie("hair", $hair, time()+ EXPIRE_DATE);
        setcookie("education", $education, time()+ EXPIRE_DATE);
        setcookie("smokes", $smokes, time()+ EXPIRE_DATE);
        setcookie("drinks", $drinks, time()+ EXPIRE_DATE);
        setcookie("drugs", $drugs, time()+ EXPIRE_DATE);
        setcookie("children", $children, time()+ EXPIRE_DATE);
        setcookie("minimumAge", $minimumAge, time()+ EXPIRE_DATE);
        setcookie("maximumAge", $maximumAge, time()+ EXPIRE_DATE);
        setcookie("genderSought", $genderSought, time()+ EXPIRE_DATE);*/
        if ($message == "")
        {
            $searchSql = buildSqlStatement($userId, $searchValue, $nameOfInputs, $cityValue);
            $searchResult = pg_query($conn, $searchSql);
            $searchRows = pg_num_rows($searchResult);
            
            if ($searchRows == 1)
            {   
                $profile = pg_fetch_assoc($searchResult, 0);
                $profileUserName = $profile['user_id'];
                $link = "display_profile.php?profileUserName=" . $profileUserName;
                pageRedirect($link);
                //$message .= "Record found.<br/>";
            }
            elseif ($searchRows > 1)
            {
                $users = pg_fetch_all_columns($searchResult, 0);
                //$users = array_column($users, 'user_id');
                $_SESSION['profileUserNames'] = array($users);
                pageRedirect("search_results.php");
                //$message .= $searchRows . " records found.<br/>";
            }
            else
            {
                $message .= "No profiles matching search criteria were found. You might want to consider expanding your search.<br/>";
            }
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
<p><a href="./city_select.php">City Selected</a> >> <?php echo $cities; ?></p>
<h2 align="center">Search for Your Perfect Nerd</h2>
<hr class="primary"/>
<?php   if (isset($_SESSION['searchMessage']))
        {
            echo "<p align=\"center\">" . $_SESSION['searchMessage'] . "</p>";
            unset($_SESSION['searchMessage']);
        } ?>
<form method = "post" action= "<?php echo $_SERVER['PHP_SELF'] . "?selectedCity=" . $cityValue; ?>">
<div>
<table border="0" style="width:70%;margin-left:auto;margin-right:auto;">
    <tr>
        <td valign="top"><strong>Looking For:</strong></td>
        <td valign="top"><strong>Age Range:</strong></td>
        <td valign="top"><strong>Looking For:</strong></td>
    </tr>
    <tr>
        <td valign="top"><?php buildRadioButton("gender_sought", $searchValue[0]); ?></br></td>
        <td valign="top"><input class="em-box" type="text" name="minimum_age" placeholder="eg. 18" style="width: 50px" value="<?php echo $searchValue[1] ?>"/> -
            <input class="em-box" type="text" name="maximum_age" placeholder="eg. 50" style="width: 50px" value="<?php echo $searchValue[2] ?>"/></br>
        </td>
        <td valign="top"><?php buildCheckBox("seeking",$searchValue[3]); ?></br></td>
    </tr>
    <tr>
        <td valign="top"><strong>Relationship Status:</strong></br><?php buildCheckBox("status", $searchValue[4]); ?><br/></td>
        <td valign="top"><strong>Body Type:</strong></br><?php buildCheckBox("body_type", $searchValue[5]); ?><br/></td>
        <td valign="top"><strong>Hair Colour:</strong></br><?php buildCheckBox("hair", $searchValue[6]); ?><br/></td>
    </tr>
    <tr>
        <td><strong>Education:</strong></td>
        <td><strong>Smokes:</strong></td>
        <td><strong>Drinks:</strong></td>
    </tr>
    <tr>
        <td valign="top"><?php buildCheckBox("education", $searchValue[7]); ?></br></td>
        <td valign="top"><?php buildCheckBox("smokes", $searchValue[8]); ?></br></td>
        <td valign="top"><?php buildCheckBox("drinks", $searchValue[9]); ?></br></td>
    </tr>
    <tr>
        <td><strong>Drugs:</strong></td>
        <td><strong>Children:</strong></td>
        <td><strong></strong></td>
    </tr>
    <tr>
        <td valign="top"><?php buildCheckBox("drugs", $searchValue[10]); ?></br></td>
        <td valign="top"><?php buildCheckBox("children", $searchValue[11]); ?></br></td>
        <td valign="top"></br></td>
    </tr>
    <tr>
        <td colspan="3"><input type="submit" value="Search" class="btn btn-success btn-block"/></td>
    </tr>
</table>
</div>
</form>
</div>
<?php include("footer.php");?>