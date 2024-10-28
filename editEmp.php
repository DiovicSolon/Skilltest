<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $empID = $_GET['id'];

    // Get employee details
    $sql = "SELECT * FROM Employees WHERE empID = $empID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $depCode = $row['depCode'];
        $empFName = $row['empFName'];
        $empLName = $row['empLName'];
        $empRPH = $row['empRPH'];
    } else {
        echo "Employee not found.";
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depCode = $_POST['depCode'];
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];

    $sql = "UPDATE Employees SET depCode='$depCode', empFName='$empFName', empLName='$empLName', empRPH='$empRPH' WHERE empID=$empID";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: EmpManagement.php"); 
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
</head>
<body>
<h2>Edit Employee Details</h2>
<form method="post">
    <label>Department Code:</label><br>
    <input type="text" name="depCode" value="<?php echo $depCode; ?>" required><br><br>

    <label>First Name:</label><br>
    <input type="text" name="empFName" value="<?php echo $empFName; ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="empLName" value="<?php echo $empLName; ?>" required><br><br>

    <label>Rate Per Hour:</label><br>
    <input type="number" step="0.01" name="empRPH" value="<?php echo $empRPH; ?>" required><br><br>
    <input type="submit" name="update" value="Update">
</form>
  
