<?php 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "nice";

          
            $conn = new mysqli($servername, $username, $password, $dbname);

        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            ?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
</head>
<body>
    <h2>Attendance Records</h2>

   
    <form method="POST" action="">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td>
                    <label for="dateFrom">Date From:</label>
                    <input type="date" name="dateFrom" id="dateFrom" required>
                </td>
                <td>
                    <label for="dateTo">Date To:</label>
                    <input type="date" name="dateTo" id="dateTo" required>
                </td>
                <td>
                    <input type="submit" value="Filter">
                </td>
                <td style="text-align: right;"><a href="index.php">Back to Menu</a></td>
            </tr>
        </table>
    </form>

    
    <table border="1" style="width: 100%; text-align: center;">
        <tr>
            <th>Record #</th>
            <th>Emp ID</th>
            <th>Date</th>
            <th>Date/Time In</th>
            <th>Date/Time Out</th>
            <th>Total Hours Worked</th>
        </tr>

        <?php
        
        if (isset($_POST['dateFrom']) && isset($_POST['dateTo'])) {
          
            $dateFrom = $_POST['dateFrom'];
            $dateTo = $_POST['dateTo'];

           
            $sql = "SELECT attRN, empID, attDate, attTimeIn, attTimeOut 
                    FROM Attendance 
                    WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";

            $result = $conn->query($sql);

            
            $totalHoursWorked = 0;

            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                 
                    $attTimeIn = new DateTime($row['attTimeIn']);
                    $attTimeOut = new DateTime($row['attTimeOut']);
                    $interval = $attTimeIn->diff($attTimeOut);

                    $hoursWorked = $interval->h + ($interval->i / 60);
                    $totalHoursWorked += $hoursWorked;

              
                    echo "<tr>";
                    echo "<td>" . $row['attRN'] . "</td>";
                    echo "<td>" . $row['empID'] . "</td>";
                    echo "<td>" . $row['attDate'] . "</td>";
                    echo "<td>" . $row['attTimeIn'] . "</td>";
                    echo "<td>" . $row['attTimeOut'] . "</td>";
                    echo "<td>" . number_format($hoursWorked, 2) . " hours</td>"; 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No attendance records found for the selected date range</td></tr>";
            }

            $conn->close();
        } else {
            echo "<tr><td colspan='6'>Please select a date range and filter the records.</td></tr>";
        }
        ?>

    </table>

    
    <?php if (isset($totalHoursWorked)): ?>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td>Date Generated: <?php echo date('Y-m-d'); ?></td>
                <td style="text-align: right;">Total Hours Worked: <?php echo number_format($totalHoursWorked, 2); ?> hours</td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>
