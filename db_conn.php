<?php
// db_conn.php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';     // <-- set your MySQL password
$DB_NAME = 'bookstore';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB connect failed: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

function is_logged_in(){ return isset($_SESSION['user_id']); }
function current_user_id(){ return $_SESSION['user_id'] ?? null; }
function is_admin(){ return !empty($_SESSION['is_admin']); }
?>