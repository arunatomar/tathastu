<?php
session_start();
if(!isset($_SESSION["id"])) {
  header("Location:login.php");
}
$id = trim($_GET['client_id']);
if(isset($id) && !empty($id)){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tathastu";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "DELETE FROM clients WHERE id= $id";
    $result  = $conn->query($sql);
} 
header("Location:list.php");


?>