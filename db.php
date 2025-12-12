<?php
// db.php - update credentials
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'gioiello';


$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
die('DB connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>


<?php
$mysqli = new mysqli("localhost", "root", "", "gioiello");
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
?>

<?php
$mysqli = new mysqli("localhost", "root", "", "gioiello");

if ($mysqli->connect_errno) {
    die("Failed to connect to database: " . $mysqli->connect_error);
}
?>