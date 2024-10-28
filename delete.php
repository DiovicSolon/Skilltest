<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


if (isset($_GET['depCode'])) {
    $depCode = $_GET['depCode']; 


    $sql = "DELETE FROM departments WHERE depCode=$depCode";

    
    if ($conn->query($sql) === TRUE) {
   
    
        header("Location: DepManagement.php");
        exit();
    } 
}


$conn->close();
?>
