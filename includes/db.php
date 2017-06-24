<?php
    /*
    Name:   
    File:   db.php
    Date:   October 10 2015
    Class:  WEDE3201
    */
    
    function db_connect()
    {
        $conn = pg_connect("host=127.0.0.1 dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASSWORD );
        return $conn;
    }	
    $conn = db_connect();
    $stmt1 = pg_prepare($conn, "user_insert", "INSERT INTO users(user_id, first_name, last_name, birth_date, email_address, password, enrol_date, last_access, user_type)
                                            VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9 )");

    $stmt2 = pg_prepare($conn, "login_query", 'SELECT * FROM users WHERE user_id = $1 AND password = $2');
    $stmt3 = pg_prepare($conn, "profile_query", 'SELECT * FROM profiles WHERE user_id = $1');
    $stmt4 = pg_prepare($conn, "profile_insert", "INSERT INTO profiles(user_id, gender, gender_sought, seeking, minimum_age,
            maximum_age, status, city, height, body_type, hair, education, smokes, drinks, drugs, children, headline,
            self_description, match_description, interests) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20 )");
    $stmt5 = pg_prepare($conn, "client_update", "UPDATE users SET user_type = $1 WHERE user_id = $2");
    $stmt6 = pg_prepare($conn, "profile_update", "UPDATE profiles SET gender = $2, gender_sought = $3, seeking = $4,
            minimum_age = $5, maximum_age = $6, status = $7, city = $8, height = $9, body_type = $10, hair = $11, education = $12,
            smokes = $13, drinks = $14, drugs = $15, children = $16, headline = $17, self_description = $18, match_description = $19,
            interests = $20 WHERE user_id = $1 ");
    $stmt7 = pg_prepare($conn, "update_date", 'UPDATE users SET last_access = current_date WHERE user_id = $1 and password = $2');
    $stmt8 = pg_prepare($conn, "user_query", 'SELECT * FROM users WHERE user_id = $1');
    $stmt9 = pg_prepare($conn, "birthdate_query", 'SELECT * FROM users WHERE user_id = $1');
	$stmt10 = pg_prepare($conn, "user_password_update", 'UPDATE users SET password = $1 WHERE user_id = $2');
    $stmt11 = pg_prepare($conn, "user_update", 'UPDATE users SET first_name = $2, last_name = $3, birth_date = $4, email_address = $5 WHERE user_id = $1');
	$stmt12 = pg_prepare($conn, "email_query", 'SELECT * FROM users WHERE user_id = $1 AND email_address = $2'); 
	$stmt13 = pg_prepare($conn, "image_update", 'UPDATE profiles SET images = $1 WHERE user_id = $2');


    $stmt14 = pg_prepare($conn, "user_query_by_type", 'SELECT user_id FROM users WHERE user_type = $1');
	//interests
    $stmt15 = pg_prepare($conn, "add_interest", "INSERT INTO interests(user_id, user_interest, time) VALUES ($1, $2, $3)");
    $stmt16 = pg_prepare($conn, "remove_interest", "DELETE FROM interests WHERE user_id = $1 AND user_interest = $2");
    $stmt18 = pg_prepare($conn, "interst_exist", "SELECT * FROM interests WHERE user_id = $1 AND user_interest = $2");
    
    $stmt19 = pg_prepare($conn, "disabled_user_update", 'UPDATE users SET user_type = $1 WHERE user_id = $2');
    //Reports
    $stmt17 = pg_prepare($conn, "report_user", "INSERT INTO reports(user_id, user_reported, status, time) VALUES($1, $2, $3, $4)");
    $stmt18 = pg_prepare($conn, "find_user_reports", "SELECT * FROM reports WHERE user_reported = $1 AND user_id = $2");
    $stmt19 = pg_prepare($conn, "add_user_report", "INSERT INTO reports(user_id, user_reported, time, status) VALUES($1, $2, $3, '" . OPEN . "')");
    $stmt19 = pg_prepare($conn, "handle_user_report", "UPDATE reports SET status = '" . CLOSED . "', time_handled = '" . date("Y-m-d H:i:s", time()) . "' WHERE user_reported = $1 AND time_handled IS NULL");
	$stmt20 = pg_prepare($conn, "find_reports", "SELECT * FROM reports WHERE status = $1");
	$stmt22 = pg_prepare($conn, "handle_user_reporter", "UPDATE reports SET status = '" . CLOSED . "', time_handled = '" . date("Y-m-d H:i:s", time()) . "' WHERE user_id = $1 AND time_handled IS NULL");
    
	$stmt21 = pg_prepare($conn, "close_report", "UPDATE reports SET status = '" . CLOSED . "', time_handled = '" . date("Y-m-d H:i:s", time()) . "' WHERE user_id = $1 AND user_reported = $2 AND time_handled IS NULL");
	
    $stmt23 = pg_prepare($conn, "my_interests", "SELECT * FROM interests WHERE user_id = $1");
    $stmt24 = pg_prepare($conn, "interested_in_me", "SELECT * FROM interests WHERE user_interest = $1");
    

    

    function buildDropDown($table, $value = -1, $required = false)
    {
        global $conn;
        $sql = "SELECT * FROM " . $table;
        $result = pg_query($conn, $sql);
        $records = pg_num_rows($result);
        echo "\n<select name=\"" . $table . "\">";

        if ($required)
        {
            echo "\n\t<option  selected=\"selected\" disabled=\"disabled\"> -- select an option -- </option>";
        }
        for ($i = 0; $i < $records; $i++)
        {
            if (pg_fetch_result($result, $i, "value") == $value)
            {
                echo "\n\t<option value=\"" . pg_fetch_result($result, $i, "value") . "\" selected>" .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "</option>";
            }
            else
            {
                echo "\n\t<option value=\"" . pg_fetch_result($result, $i, "value") . "\">" .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "</option>";
            }
        }
        echo "\n</select>";
    }
    
    function buildRadioButton($table, $value = -1, $required = false)
    {
        global $conn;
        $sql = "SELECT * FROM " . $table;
        $result = pg_query($conn, $sql);
        $records = pg_num_rows($result);
        for ($i = 0; $i < $records; $i++)
        {
            if (pg_fetch_result($result, $i, "value") == $value)
            {
                echo "<input type=\"radio\" name=\"" . $table . "\" value=\"" . pg_fetch_result($result, $i, "value") . "\" checked=\"checked\"/> " .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "<br/>";
            }
            elseif ($i == 0 && !$required && $value == -1)
            {
                echo "<input type=\"radio\" name=\"" . $table . "\" value=\"" . pg_fetch_result($result, $i, "value") . "\" checked=\"checked\"/> " .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "<br/>";
            }
            else
            {
                echo "<input type=\"radio\" name=\"" . $table . "\" value=\"" . pg_fetch_result($result, $i, "value") . "\"/> ".
                    htmlentities(pg_fetch_result($result, $i, "property")) . "<br/>";
            }
        }
    }
    
    function buildCheckBox($table, $value = 0)
    {
        global $conn;
        $sql = "SELECT * FROM " . $table;
        $result = pg_query($conn, $sql);
        $records = pg_num_rows($result);
        $index = 0;
        for ($i = 0; $i < $records; $i++)
        {
            if (pg_fetch_result($result, $i, "value") == 0)
            {
                $index--;
            }
            else if (isBitSet($index, $value) == 1)
            {
                echo "\t<input type=\"checkbox\" name='" . $table . "[]' value=\"" . pg_fetch_result($result, $i, "value") . "\" checked=\"checked\"/>" .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "<br/>\n";
            }
            else
            {
                echo "\t<input type=\"checkbox\" name='" . $table . "[]' value=\"" . pg_fetch_result($result, $i, "value") . "\"/>" .
                    htmlentities(pg_fetch_result($result, $i, "property")) . "<br/>\n";
            }
            $index++;
        }
    }
    
    function buildSqlStatement($userId, $values, $nameOfValues, $cityValue)
    {
        global $conn;
        $values[NUMBER_OF_FIELDS] = $cityValue;
        $nameOfValues[NUMBER_OF_FIELDS] = "city";
        $userResult = pg_execute($conn, "user_query", array($userId));
        $user = pg_fetch_assoc($userResult, 0);
        $userProfileResult = pg_execute($conn, "profile_query", array($userId));
        $userProfile = pg_fetch_assoc($userProfileResult);
        $returnSql = "SELECT profiles.user_id FROM profiles, users ";
        $returnSql .= "WHERE 1 = 1 ";
        if ($values[0] != 4)
            $returnSql .= "AND profiles.gender = " . $values[0] . " ";
        if ($user['user_type'] == INCOMPLETE_CLIENT || $user['user_type'] == ADMIN)
            $returnSql .= "AND (profiles.gender_sought = 1 OR profiles.gender_sought = 2 OR profiles.gender_sought = 4) ";
        else
            $returnSql .= "AND (profiles.gender_sought = " . $userProfile['gender'] . " OR profiles.gender_sought = 4) ";
        if ($values[1] > 0)
        {
            $minimumDate = date('Y');
            $minimumDate = ($minimumDate - $values[1]) . "-" . date('m-d');
            $returnSql .= "AND users.birth_date <= '" . $minimumDate . "' ";
        }
        if ($values[2] > 0)
        {
            $maximumDate = date('Y');
            $maximumDate = ($maximumDate - $values[2]) . "-" . date('m-d');
            $returnSql .= "AND users.birth_date >= '" . $maximumDate . "' ";
        }
        for ($i = 3; $i < NUMBER_OF_FIELDS + 1; $i++)
        {
            $first = true;
            if ($values[$i] > 0)
            {   
                for($inner = 0; $values[$i] >= pow(2, $inner); $inner++)
                {
                    $power = pow(2, $inner);
                    if (isBitSet($inner, $values[$i]))
                    {
                        if($first)
                        {
                            $returnSql .= "AND (profiles." . $nameOfValues[$i] . " = " . $power . " ";
                            $first = false;
                        }
                        else
                        {
                            $returnSql .= "OR profiles." . $nameOfValues[$i] . " = " . $power . " ";
                        }
                    }
                }
                $returnSql .= ") ";
                
            }
        }
        $returnSql .= "AND users.user_id = profiles.user_id AND users.user_type <> '" . DISABLED_CLIENT . "'";
        $returnSql .= "ORDER BY users.last_access DESC LIMIT " . MAXIMUM_RESULTS . "; ";
        return $returnSql;
    }
    
    function getProperty($table, $value)
    {
        global $conn;
        $sql = "SELECT property FROM " . $table . " WHERE value='" . $value . "';";
        $result = pg_query($conn, $sql);
        return pg_fetch_result($result, 0, "property");
    }
    
    function citySelected($value)
    {
        global $conn;
        $output = "";
        for($i = 0; $value >= pow(2, $i); $i++)
        {
            if (isBitSet($i, $value))
            {
                $output .= getProperty("city", pow(2, $i)) . " ";
            }
        }
        return $output;
    }
?>







