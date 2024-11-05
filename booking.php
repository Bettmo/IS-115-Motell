<?php
$host ='localhost';
$dbname ='motell';
$username ='root';
$password = '';

$mysqli = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Assuming you have a way to get the user ID and booking points
$user_id = 1; // Example user ID (change it based on your test)
$points_earned = 2550; // Points to be awarded for this booking

// Insert the booking record
$sql = "INSERT INTO bookings (user_id, points_earned) VALUES ('$user_id', '$points_earned')";

if ($mysqli->query($sql) === TRUE) {
    // Update user's points
    $update_sql = "UPDATE users SET points = points + $points_earned WHERE id = $user_id";
    
    if ($mysqli->query($update_sql) === TRUE) {
        echo "Booking successful! User points updated.";
    } else {
        echo "Error updating points: " . $mysqli->error;
    }
} else {
    echo "Error creating booking: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
