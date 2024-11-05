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

// Hente data

$firstName = $mysqli->real_escape_string($_POST['firstName']);
$lastName = $mysqli->real_escape_string($_POST['lastName']);
$email = $mysqli->real_escape_string($_POST['email']);
$telephoneNumber = $mysqli->real_escape_string($_POST['telephoneNumber']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "
INSERT INTO users (
    firstName,
    lastName, 
    email, 
    telephoneNumber, 
    password, 
    membership_level,
    points)
VALUES (
    '$firstName',
    '$lastName',
    '$email',
    '$telephoneNumber',
    '$password',
    'Bronze',
    0)
";


if ($mysqli->query($sql) === TRUE) {
    echo "New user created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Close the connection
$mysqli->close();

?>