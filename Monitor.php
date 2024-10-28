<form method="POST" action="">
    <label for="empID">Input Employee ID:</label>
    <input type="text" name="empID" id="empID" required>
    <input type="submit" value="Search">
    <a href="index.php">Back to Menu</a>
</form>

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
    $empID = $_POST['empID'];


    $sql = "SELECT Employees.empFName, Departments.depName, Employees.empRPH, 
                   Attendance.attRN, Attendance.empID, Attendance.attTimeIn, Attendance.attTimeOut, Attendance.attStats 
            FROM Employees
            LEFT JOIN Attendance ON Employees.empID = Attendance.empID
            LEFT JOIN Departments ON Employees.depCode = Departments.depCode
            WHERE Employees.empID = '$empID'";

    $result = $conn->query($sql);

    $totalHoursWorked = 0;
    $ratePerHour = 0;
    $employeeName = '';
    $departmentName = '';
    $totalSalary = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeName = $row['empFName'];
        $departmentName = $row['depName'];
      
        
        echo "Name: $employeeName - Department: $departmentName";

        echo '<table border="1">
                <tr>
                    <th>Record #</th>
                    <th>Emp ID</th>
                    <th>Date/Time In</th>
                    <th>Date/Time Out</th>
                    <th>Total Hours Worked</th>
                </tr>';

        do {
            $attTimeIn = new DateTime($row['attTimeIn']);
            $attTimeOut = new DateTime($row['attTimeOut']);
            $interval = $attTimeIn->diff($attTimeOut);

            $hoursWorked = $interval->h + ($interval->i / 60); 
            $totalHoursWorked += $hoursWorked;

            echo "<tr>";
            echo "<td>" . $row['attRN'] . "</td>";
            echo "<td>" . $row['empID'] . "</td>";
            echo "<td>" . $row['attTimeIn'] . "</td>";
            echo "<td>" . $row['attTimeOut'] . "</td>";
            echo "<td>" . $hoursWorked . " hours</td>";
            echo "</tr>";
        } 
        while ($row = $result->fetch_assoc());

        echo '</table>';

        $totalSalary = $totalHoursWorked * $ratePerHour;

        echo "Rate per hour: " . $ratePerHour . " ";
        echo "Total Hours Worked: " . $totalHoursWorked . " hours<br>";
        echo "Salary: " . $totalSalary . " - ";
        echo "Date Generated: " . date('Y-m-d');
    } 

    $conn->close();
}
?>
