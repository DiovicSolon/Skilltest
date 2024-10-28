<form action="" method="POST">
    InterEMPID<input type="text" name="empID">
    <input type="Submit" value="Search">
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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $empID = $_POST['empID'];

    $sql = " SELECT deparments.depName, employees.FName, employees.empRPH
                   attendance.attRN, attendance.empID, attendance.TimeIn, attendance.TimeOut, attendance.attStats 
                   FROM employees
                   LEFT JOIN attendance on employees.empID = attendance.empID
                   LEFT JOIN department on employees.depCode = departments.depCode
                   WHERE empID = '$empID';
                   ";

    $result = $conn->query($sql);
    $totalhourwork = 0;
    $rateperhour = 0;
    $employeeName = '';
    $departmentName = '';
    $totalsalary = '';

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $departmentName = $row['depName'];
        $employeeName = $row['empFName'];

        echo"Name: $employeeName - Department: $departmentName";
    }
}
?>