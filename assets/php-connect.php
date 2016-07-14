<?php
//
// Comp 199 - Database connection function
// Mere Cats
// Rory Drysdale
// April 27th, 2012
//


// Define the Server Type
function returnServerType() {
  // If localhost
  if(strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $server_type = 'localhost';
  } else {
    $server_type = 'production';
  }

  return $server_type;
}


function dbConnect() {
  $server_type = returnServerType();

  // Determine appropriate Database credentials
  if($server_type == 'production') {
    $DSN_datasource  = 'localhost';
    $DSN_username  = '<user>';
    $DSN_password  = '<pass>';
    $DSN_database  = '<db>';
  }

  if($server_type == 'localhost') {
    $DSN_datasource  = 'localhost';
    $DSN_username  = '<user>';
    $DSN_password  = '<pass>';
    $DSN_database  = '<db>';
  }

  // Conncet to Database and Datasource
  $db = mysql_connect ($DSN_datasource, $DSN_username, $DSN_password) or die ('Cannot connect to the database because: ' . mysql_error());
  mysql_select_db($DSN_database);

  // Return the database
  return $db;
}

?>
