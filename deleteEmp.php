<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $empID = $_GET['id']; 


    $sql = "DELETE FROM Employees WHERE empID=$empID";

    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Success: Record deleted successfully");</script>';
    
        header("Location: EmpManagement.php");
        exit();
    } 
}


$conn->close();
?>
