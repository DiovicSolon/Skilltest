<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
</head>
<body>
    <h2>Attendance Records</h2>
    <table border="1">
        <tr>
            <th>Record #</th>
            <th>Emp ID</th>
            <th>Date/Time In</th>
            <th>Date/Time Out</th>
            <th>Status</th>
         

            <th>Action</th>
        </tr>

        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nice";

       
        $conn = new mysqli($servername, $username, $password, $dbname);

       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       
        $sql = "SELECT attRN, empID, attDate, attTimeIn, attTimeOut, attStats FROM Attendance";
        $result = $conn->query($sql);

  
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['attRN'] . "</td>";
                echo "<td>" . $row['empID'] . "</td>";
                echo "<td>" . $row['attTimeIn'] . "</td>";
                echo "<td>" . $row['attTimeOut'] . "</td>";
                echo "<td>" . $row['attStats'] . "</td>";
              
                echo "<td><a href='AttendCancel.php?id=" . $row['attRN'] . "'>Cancel</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No attendance records found</td></tr>";
        }

        $conn->close();
        ?>

    </table>
    <br>
    <a href="AttendHere.php">Attendance Here</a>
    <a href="index.php">Back to Menu</a>
</body>
</html>
