<?php

// Login function parameters
define("MINIMUM_LOGIN_LENGTH", "6");        // Constant to hold the minimum login ID length
define("MAXIMUM_LOGIN_LENGTH", "20");       // Constant to hold the maximum login ID length
define("MINIMUM_PASSWORD_LENGTH", "6");     // Constant to hold the minimum password length
define("MAXIMUM_PASSWORD_LENGTH", "8");     // Constant to hold the maximum password length
define("MAXIMUM_EMAIL_LENGTH", "256");      // Constant to hold the maximum e-mail address length
define("MINIMUM_DAY_MONTH_LENGTH", "1");    // Constant to hold the minimum length for a day or month
define("MAXIMUM_DAY_MONTH_LENGTH", "2");    // Constant to hold the maximum length for a day or month
define("MAXIMUM_YEAR_LENGTH", "4");         // Constant to hold the maximum year length
define("MINIMUM_AGE", "18");                // Constant to hold the minimum age
define("MAXIMUM_FIRST_NAME_LENGTH", "20");  // Constant to hold the minimum length for a first name
define("MAXIMUM_LAST_NAME_LENGTH", "30");   // Constant to hold the minimum length for a last name
define("MINIMUM_PROFILE_IMAGES", "1");		// Constant to hold the minimum number of images
define("MAXIMUM_PROFILE_IMAGES", "5");		// Constant to hold the maximum number of images
define("MAXIMUM_IMAGE_SIZE", "100000");		// Constant to hold the maximum image size

// User types
define("ADMIN", "a");                       // Constant to hold the value to represent an admin account
define("CLIENT", "c");                      // Constant to hold the value to represent a client account
define("INCOMPLETE_CLIENT", "i");           // Constant to hold the value to represent an incomplete client account
define("DISABLED_CLIENT", "d");             // Constant to hold the value to represent a disabled client account
define("DISABLED_ADMIN", "x");              // Constant to hold the value to represent a disabled admin account

// Sessions
define("EXPIRE_DATE","2592000");            // Constant to hold the number of seconds to determine a cookie's expiry date

// Database setup
define("DB_NAME","group09_db");             //Constant to hold database name
define("DB_USER","group09_admin");          //Constant to hold database user name
define("DB_PASSWORD","Donotlook1");         //Constant to hold database password

// Search Stuff
define("MAXIMUM_RESULTS", "200");           //Maximum results to be displayed while searching
define("NUMBER_OF_FIELDS", "12");                 //Number of search fields for array user

//Ticket Status
define("OPEN", "o");                 //Number of search fields for array user
define("CLOSED", "c");                 //Number of search fields for array user

?>