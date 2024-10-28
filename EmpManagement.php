<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nice";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if($conn->connect_error){
        die("Connection Failed: " .$conn->connect_error);
    }


    $sql = "SELECT empID, depCode, empFName, empLName, empRPH FROM Employees";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title >Employee Management</title>
    <style>
   a {
    text-align: center;
    display: inline-block; 
    width: 100%; 
}

    </style>
</head>
<body>

<h2 style="text-align:center;">Employee Management</h2>

<table border="5" align="center">
    <a href="createEmp.php" >Add Employee</a>
    <a href="index.php" >Back</a>
    <tr>
        <th>Employee ID</th>
        <th>Department Code</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Rate Per Hour</th>
        <th>Actions</th>
    </tr>

    <?php
        if ($result->num_rows > 0) {
          
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["empID"] . "</td>
                    <td>" . $row["depCode"] . "</td>
                    <td>" . $row["empFName"] . "</td>
                    <td>" . $row["empLName"] . "</td>
                    <td>" . $row["empRPH"] . "</td>
                    <td>
                        <a href='editEmp.php?id=" . $row['empID'] . "' >Edit</a>
                        <a href='deleteEmp.php?id=" . $row['empID'] . "' class='btn delete' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No employees found</td></tr>";
        }
        $conn->close();
    ?>
</table>

</body>
</html>
