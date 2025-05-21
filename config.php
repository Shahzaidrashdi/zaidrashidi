<?php
$host='localhost';
$dbname='online_voting';
$username='root';
$password='';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("database connection failed :". $e->getMessage());
}
?>
