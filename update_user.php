<?php

// Read JSON file
$json = file_get_contents('users.json');
$users = json_decode($json, true);

// Update user data
// Assume the updated user data is sent as JSON in the request body
$updateData = json_decode(file_get_contents('php://input'), true);
if ($updateData) {
    $users = $updateData; // Replace the entire user data with the updated data
}

// Write updated data back to JSON file
file_put_contents('users.json', json_encode($users));

// Respond with success message
echo json_encode(['message' => 'User data updated successfully']);

?>
