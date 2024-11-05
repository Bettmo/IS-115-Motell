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
echo "Connected successfully to the database.<br>";

// Create users table
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephoneNumber VARCHAR(15) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    membership_level ENUM('Bronze', 'Silver', 'Gold') DEFAULT 'Bronze',
    points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

// Execute the create table query for users
if($mysqli->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table 'users': " . $mysqli->error . "<br>";
}

// Create bookings table
$sql = "
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    points_earned INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";

// Execute the create table query for bookings
if($mysqli->query($sql) === TRUE) {
    echo "Table 'bookings' created successfully.<br>";
} else {
    echo "Error creating table 'bookings': " . $mysqli->error . "<br>";
}

// Create membership levels table
$sql = "
CREATE TABLE IF NOT EXISTS membership_levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level_name ENUM('Bronze', 'Silver', 'Gold') UNIQUE NOT NULL,
    min_points INT NOT NULL
);";

// Execute the create table query for membership levels
if($mysqli->query($sql) === TRUE) {
    echo "Table 'membership_levels' created successfully.<br>";
} else {
    echo "Error creating table 'membership_levels': " . $mysqli->error . "<br>";
}

// Insert membership levels if they don't exist
$insertSql = "
INSERT INTO membership_levels (level_name, min_points) 
VALUES
('Bronze', 0),
('Silver', 2500),
('Gold', 5000)
ON DUPLICATE KEY UPDATE min_points=min_points;
";

if($mysqli->query($insertSql) === TRUE) {
    echo "Membership levels inserted successfully.<br>";
} else {
    echo "Error inserting membership levels: " . $mysqli->error . "<br>";
}

// Close the connection
$mysqli->close();
?>
