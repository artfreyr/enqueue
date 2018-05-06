<?php
// For initial debugging
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Declare database credentials here
define( 'DB_SERVER', 'localhost:3306' );
define( 'DB_USERNAME', 'INSERT DB USERNAME BETWEEN QUOTES' );
define( 'DB_PASSWORD', 'INSERT DB PASSWORD BETWEEN QUOTES' );
define( 'DB_DBNAME', 'INSERT DB NAME BETWEEN QUOTES' );

$conn = new MySQLi( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DBNAME );

if($conn->connect_error) {
  exit('Error connecting to database');
}
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn->set_charset("utf8mb4");

// Declare TMDB API Key here
$tmdbapi = 'INSERT TMDB API KEY BETWEEN QUOTES';
?>