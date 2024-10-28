<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['record'])) {
    $empID = $_POST['empID'];
    $attDate = $_POST['attDate'];
    $attTimeIn = $_POST['attDate']. ' ' .$_POST['attTimeIn']; 
    $attTimeOut = $_POST['attDate']. ' ' .$_POST['attTimeOut']; 
    $attStats = 'Cancel'; 

    $sql = "INSERT INTO Attendance (empID, attDate, attTimeIn, attTimeOut, attStats) VALUES ('$empID', '$attDate', '$attTimeIn', '$attTimeOut', '$attStats')";

    if ($conn->query($sql) === TRUE) {
        echo "Attendance record saved successfully.";
        header("location: AttendRecording.php");
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
    <title>Record Attendance</title>
</head>
<body>
    <h2>Record Attendance Here</h2>
    <form method="post">
        <label for="empID">Employee ID:</label><br>
        <input type="number" name="empID" id="empID" required><br><br>

        <label for="attDate">Date (YYYY-MM-DD):</label><br>
        <input type="date" name="attDate" id="attDate" required><br><br>

        <label for="attTimeIn">Time In (HH:MM:SS):</label><br>
        <input type="time" name="attTimeIn" id="attTimeIn" required><br><br>

        <label for="attTimeOut">Time Out (HH:MM:SS):</label><br>
        <input type="time" name="attTimeOut" id="attTimeOut" required><br><br>

        <input type="submit" name="record" value="Record Attendance">
    </form>
    <br>
    <a href="AttendRecording.php">View Attendance Records</a>
</body>
</html>
