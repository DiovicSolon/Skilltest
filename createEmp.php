<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depCode = $_POST['depCode'];
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];

 
    $sql = "INSERT INTO Employees (depCode, empFName, empLName, empRPH) VALUES ('$depCode', '$empFName', '$empLName', '$empRPH')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: EmpManagement.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Employee</title>
</head>
<body>
<h2>Create New Employee</h2>

<form method="post">
    <label>Department Code:</label><br>
    <input type="text" name="depCode" required><br><br>

    <label>First Name:</label><br>
    <input type="text" name="empFName" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="empLName" required><br><br>

    <label>Rate Per Hour:</label><br>
    <input type="number" step="0.01" name="empRPH" required><br><br>

    <input type="submit" name="create" value="Create">
</form>
</body>
</html>
