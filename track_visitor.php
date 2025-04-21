<?php
// track_visitor.php

// Include the database connection file
include 'connection.php';

// Get visitor data
$ipAddress = $_SERVER['REMOTE_ADDR']; // Capture the IP address
$pageVisited = $_SERVER['REQUEST_URI']; // Capture the page visited
$visitTime = date('Y-m-d H:i:s'); // Capture the current time

// Check if the IP is already in the database
$stmtCheck = $conn->prepare("SELECT country FROM visitors WHERE ip_address = ? ORDER BY visit_time DESC LIMIT 1");
$stmtCheck->bind_param("s", $ipAddress);
$stmtCheck->execute();
$stmtCheck->bind_result($country);
$stmtCheck->fetch();
$stmtCheck->close();

// If country is not cached, get it from the external service
if (empty($country)) {
    $country = 'Unknown'; // Default country
    if ($ipAddress) {
        // Use try-catch to handle potential errors with the external service
        try {
            $response = file_get_contents("https://ipinfo.io/{$ipAddress}/json");
            if ($response !== false) {
                $data = json_decode($response, true);
                $country = isset($data['country']) ? $data['country'] : 'Unknown';
            }
        } catch (Exception $e) {
            error_log("Error fetching country: " . $e->getMessage());
        }
    }
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO visitors (ip_address, page_visited, visit_time, country) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $ipAddress, $pageVisited, $visitTime, $country);

// Execute the query and check for errors
if (!$stmt->execute()) {
    error_log("Error inserting visitor data: " . $stmt->error);
}

// Close the statement
$stmt->close();
?>
