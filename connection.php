<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//$server = "localhost";
//$database = "aiunicobet1";
//$username = "aiunicobet1";
//$password = "JaklZPEJfZT8R6BDeqAp";

$server = "localhost";
$database = "aiunicobet";
$username = "root";
$password = "";


$retry_limit = 10; // Number of retry attempts
$retry_count = 0;

do {
    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        $retry_count++;
        sleep(1); // Wait for 1 second before retrying
       // echo "Retry attempt #{$retry_count} failed: " . $conn->connect_error . "\n";
    } else {
        //echo "Connected successfully\n";
        break; // Exit the loop if connection successful
    }
} while ($retry_count < $retry_limit);

if ($retry_count >= $retry_limit) {
    die("Maximum number of retries reached. Could not connect to database.");
}

// Now $conn can be used for database operations

// Example query execution:
//$result = $conn->query("SELECT * FROM your_table");

?>
