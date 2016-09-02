<?php
$avoid_sql = true;
require_once("srcphp/access_db.php");
// Create connection
$conn = new mysqli($host_db, $usuario_db, $clave_db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE ".$nombre_db;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

$conn = new mysqli($host_db, $usuario_db, $clave_db, $nombre_db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE users (
user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_name VARCHAR(16) NOT NULL,
user_pass VARCHAR(32) NOT NULL,
user_type VARCHAR(3) NOT NULL DEFAULT 'def' ,
user_firstname VARCHAR(30) ,
user_lastname VARCHAR(30) ,
user_mail VARCHAR(50),
user_sex VARCHAR(9) ,
user_datereg DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table Users: " . $conn->error;
}

$sql = "CREATE TABLE books (
book_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
book_title VARCHAR(50) NOT NULL,
book_subject VARCHAR(50) NOT NULL,
book_size VARCHAR(100) ,
book_uploader VARCHAR(16) NOT NULL,
book_link TEXT NOT NULL,
book_datereg DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table Books: " . $conn->error;
}

$sql = "CREATE TABLE chat (
chat_id INT(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
chat_message VARCHAR(200) NOT NULL,
chat_userid INT(6) NOT NULL,
chat_sendto VARCHAR(6) NOT NULL,
chat_sendtime DATETIME,
chat_read INT(1) NOT NULL DEFAULT '0'
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Chat created successfully";
} else {
    echo "Error creating table Chat: " . $conn->error;
}

$sql = "CREATE TABLE subjects (
sub_id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
sub_teachers TEXT,
sub_title VARCHAR(50) NOT NULL,
sub_time TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Subjects created successfully";
} else {
    echo "Error creating table Subjects: " . $conn->error;
}

$sql = "CREATE TABLE files (
file_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
file_title VARCHAR(50) NOT NULL,
file_subject VARCHAR(50) NOT NULL,
file_uploader VARCHAR(16) NOT NULL,
file_link TEXT NOT NULL,
file_datereg DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Files created successfully";
} else {
    echo "Error creating table Files: " . $conn->error;
}

$sql = "CREATE TABLE videos (
video_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
video_title VARCHAR(50) NOT NULL,
video_subject VARCHAR(50) NOT NULL,
video_uploader VARCHAR(16) NOT NULL,
video_link TEXT NOT NULL,
video_datereg DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Videos created successfully";
} else {
    echo "Error creating table Videos: " . $conn->error;
}

$sql = "CREATE TABLE apps (
app_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
app_title VARCHAR(50) NOT NULL,
app_subject VARCHAR(50) NOT NULL,
app_uploader VARCHAR(16) NOT NULL,
app_web TEXT,
app_windows TEXT,
app_linux TEXT,
app_android TEXT,
app_ios TEXT,
app_datereg DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Apps created successfully";
} else {
    echo "Error creating table Apps: " . $conn->error;
}

$conn->close();


?> 
