<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$db = "pastebin";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo $e->getMessage();
}