<?php 
    include ("names.php");
    function createUsers()
    {
        $conn = db_connect();
        global $last_names;
        global $male_names;
        global $female_names;
        
        $totalGenderSought = pg_num_rows($genderSoughtResult = pg_query($conn, "select * from gender_sought;"));
        $totalBodyType = pg_num_rows($bodyTypeResult = pg_query($conn, "select * from body_type;"));
        $totalChildren = pg_num_rows($childrenResult = pg_query($conn, "select * from children;"));
        $totalCity = pg_num_rows($cityResult = pg_query($conn, "select * from city;"));
        $totalDrinks = pg_num_rows($drinkResult = pg_query($conn, "select * from drinks;"));
        $totalDrugs = pg_num_rows($drugResult = pg_query($conn, "select * from drugs;"));
        $totalEducation = pg_num_rows($educationResult = pg_query($conn, "select * from education;"));
        $totalHair = pg_num_rows($hairResult = pg_query($conn, "select * from hair;"));
        $totalSeeking = pg_num_rows($seekingResult = pg_query($conn, "select * from seeking;"));
        $totalSmokes = pg_num_rows($smokesResult = pg_query($conn, "select * from smokes;"));
        $totalStatus = pg_num_rows($statusResult = pg_query($conn, "select * from status;"));
        
        $gender = true;
        
        $number = 2500;
        $sql = "";
        $sql2 = "";
        $password = md5("password");
        $accounts = array("c", "c", "c", "c", "c", "c", "c", "c", "c", "c", "c", "c", "i", "i", "d", "d", "a");
        $baseTwo = array(1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024);
        $enroll = $last = date("Y-m-d");
        for ($index = 0; $index < $number; $index++)
        {
            $year = mt_rand(1, 49) +  1947;     
            $month = mt_rand(1, 12);
            $day = mt_rand(1, 28);
            $dob = $year . "-" . $month . "-" . $day;
            $userType = $accounts[mt_rand(0, (sizeof($accounts) - 1))];
            $lastName = $last_names[mt_rand(0, (sizeof($last_names) - 1))];
            if ($gender)
            {
                $firstName = $male_names[mt_rand(0, (sizeof($male_names) - 1))];
                $gender = !$gender;
            }
            else
            {
                $firstName = $female_names[mt_rand(0, (sizeof($female_names) - 1))];
                $gender = !$gender;
            }
            $firstName = ucwords(strtolower($firstName));
            $lastName = ucwords(strtolower($lastName));
            $username = $firstName[0] . $lastName . $index;
            $email = $firstName . "." . $lastName . "@gmail.com";
            //echo $dob . " " . $firstName . " ". $lastName . " " . $userType . " " . $username .  " " . $email .  " " . $enroll .  " " . $last . "<br/>";
            // $sql = "INSERT INTO users(user_id, password, user_type, first_name, last_name, email_address, birth_date, enrol_date, last_access) VALUES(
					// '" . $username . "',
					// '" . $password . "',
					// '" . $userType . "',
					// '" . $firstName . "',
					// '" . $lastName . "',
					// '" . $email . "',
					// '" . $dob . "',
					// '" . $enroll . "',
					// '" . $last . "'); ";
                    // user_id, first_name, last_name, birth_date, email_address, password, enrol_date, last_access, user_type
            pg_execute($conn, "user_insert", array($username, $firstName, $lastName, $dob, $email, $password, $enroll, $last, $userType));
            if ($userType == "c" || $userType == "d")
            {
                $sGender = ($gender)? 2: 1;
                $GenderSought = mt_rand() % $totalGenderSought;
                $selfDescription = (($gender)? "female": "male") . " looking for " . pg_fetch_result($genderSoughtResult, $GenderSought , "property") . " ";
                $GenderSought = $baseTwo[$GenderSought];
                $BodyType = mt_rand(0, ($totalBodyType - 2));
                $selfDescription .= "Body Type: " . pg_fetch_result($bodyTypeResult, $BodyType , "property") . ", ";
                $BodyType = $baseTwo[$BodyType];
                
                $Children = mt_rand(0, ($totalChildren - 2));
                $selfDescription .= "Children: " . pg_fetch_result($childrenResult, $Children , "property") . ", ";
                $Children = $baseTwo[$Children];
                
                $City = mt_rand(0, ($totalCity - 1));
                $selfDescription .= "City: " . pg_fetch_result($cityResult, $City , "property") . ", ";
                $City = $baseTwo[$City];
                
                $Drinks = mt_rand(0, ($totalDrinks - 2));
                $selfDescription .= "Drinks: " . pg_fetch_result($drinkResult, $Drinks , "property") . ", ";
                $Drinks = $baseTwo[$Drinks];
                
                $Drugs = mt_rand(0, ($totalDrugs - 2));
                $selfDescription .= "Drugs: " . pg_fetch_result($drugResult, $Drugs , "property") . ", ";
                $Drugs = $baseTwo[$Drugs];
                
                $Education = mt_rand(0, ($totalEducation - 2));
                $selfDescription .= "Education: " . str_replace("'" , "''" , pg_fetch_result($educationResult, $Education , "property")) . ", ";
                $Education = $baseTwo[$Education];
                
                $Hair = mt_rand(0, ($totalHair - 2));
                $selfDescription .= "Hair: " . pg_fetch_result($hairResult, $Hair , "property") . ", ";
                $Hair = $baseTwo[$Hair];
                
                $Seeking = mt_rand(0, $totalSeeking - 2);
                $selfDescription .= "Seeking: " . pg_fetch_result($seekingResult, $Seeking , "property") . ", ";
                $Seeking = $baseTwo[$Seeking];
                
                $Smokes = mt_rand(0, ($totalSmokes - 2));
                $selfDescription .= "Smokes: " . pg_fetch_result($smokesResult, $Smokes , "property") . ", ";
                $Smokes = $baseTwo[$Smokes];
                
                $Status = mt_rand(0, ($totalStatus - 2));
                $selfDescription .= "Status: " . str_replace("'" , "''" , pg_fetch_result($statusResult, $Status , "property")) . ", ";
                $Status = $baseTwo[$Status];
                
                $Height = mt_rand() % 34 + 152;
                $selfDescription .= "Height: " . $Height . ", ";
                $minimumAge = mt_rand() % 33 + 18;
                $maximumAge = mt_rand() % 33 + 18;
                $selfDescription .= "Looking For: " . (($minimumAge <= $maximumAge)? $minimumAge: $maximumAge) . " to " . (($minimumAge >= $maximumAge)? $minimumAge: $maximumAge) . " ";
                
                //echo $selfDescription . "</br>";
                //19
                // $sql .= "INSERT INTO profiles(user_id, gender, gender_sought, city, images, headline, self_description, match_description, interests, height, minimum_age, maximum_age, body_type, education, smokes, drinks, drugs, status, hair, children, seeking) VALUES(
                    // '" . $username . "', 
                    // '" . $sGender . "', 
                    // '" . $GenderSought. "', 
                    // '" . $City . "', 
                    // '0',
                    // '" . $lastName . "', 
                    // '" . $selfDescription ."', 
                    // 'Desperate', 
                    // 'Star Wars, Star Trek, Gaming', 
                    // '" . $Height ."', 
                    // '" . (($minimumAge <= $maximumAge)? $minimumAge: $maximumAge) . "', 
                    // '" . (($minimumAge >= $maximumAge)? $minimumAge: $maximumAge) . "', 
                    // '" . $BodyType . "', 
                    // '" . $Education . "', 
                    // '" . $Smokes . "', 
                    // '" . $Drinks . "', 
                    // '" . $Drugs . "', 
                    // '" . $Status . "', 
                    // '" . $Hair . "', 
                    // '" . $Children . "', 
                    // '" . $Seeking . "');";
                    // user_id, gender, gender_sought, seeking, minimum_age,
            // maximum_age, status, city, height, body_type, hair, education, smokes, drinks, drugs, children, headline,
            // self_description, match_description, interests
                pg_execute($conn, "profile_insert", array($username, $sGender, $GenderSought, $Seeking, (($minimumAge <= $maximumAge)? $minimumAge: $maximumAge), (($minimumAge >= $maximumAge)? $minimumAge: $maximumAge),
                                                            $Status, $City, $Height, $BodyType, $Hair, $Education, $Smokes, $Drinks, $Drugs, $Children, $lastName, $selfDescription, "Desperate", "Star Wars, Star Trek, Gaming"));
            }
            echo $username . " \n";
        }
       
    }
?>
