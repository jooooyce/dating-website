<?php

function displayCopyrightInfo()
	{
	  echo "<p>&copy; " . date("Y") . " Ellen Coombs, William Beniuk, Andrew Daigneault, Yina Qin</p>";
	}
	
function calculateAge($dob="1970-01-01")
{ 
        $dob=explode("-",$dob);
        $curMonth = date("m");
        $curDay = date("j");
        $curYear = date("Y");
        $age = $curYear - $dob[0]; 
        if($curMonth<$dob[1] || ($curMonth==$dob[1] && $curDay<$dob[2])) 
                $age--; 
        return $age; 
}
//Redirects page based on a string
function pageRedirect($page)
{
    header("Location: " . $page);
    ob_flush();
}


/*
	this function should be passed a integer power of 2, and any 
	decimal number,	it will return true (1) if the power of 2 is 
	contain as part of the decimal argument
*/
function isBitSet($power, $decimal) {
	if((pow(2,$power)) & ($decimal)) 
		return 1;
	else
		return 0;
} 

/*
	this function can be passed an array of numbers 
	(like those submitted as part of a named[] check 
	box array in the $_POST array).
*/
function sumCheckBox($array)
{
	$num_checks = count($array); 
	$sum = 0;
	for ($i = 0; $i < $num_checks; $i++)
	{
	  $sum += $array[$i]; 
	}
	return $sum;
}

function getCookie($name)
{
    $value = 0;
    if (isset($_COOKIE[$name]))
    {
        $value = $_COOKIE[$name];
    }
    return $value;
}

function enableDisableUser($userId, $newUserType)
{
    global $conn;
    pg_execute($conn, "client_update", array($newUserType, $userId));
    //Add code to change user type status to closed if user has been disabled
    if ($newUserType == DISABLED_CLIENT)
    {
        pg_execute($conn, "handle_user_report", array($userId));
    }
}


?>














