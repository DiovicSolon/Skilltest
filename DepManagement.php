<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nice";

    $conn = new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection Failed: " .$conn->connect_error);
    }
$depName = '';
if(isset($_GET['depName'])){
    $depName = $_GET['depName'];
}

    $sql = " SELECT depCode, depName, depHead, depTelNo FROM departments ";
    $sql.= " WHERE depName LIKE '%$depName%'";

    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="GET">
    <input type="text" name="depName" value="<?php echo $depName; ?>">
    <button type="Submit">Search</button>

    </form>


    <a href="create.php" >register here</a> <a href="index.php">Back to menu</a>
    <table border="5" >

        <tr>
            <th>depCode</th>
            <th>depName</th>
            <th>depHead</th>
            <th>depTelNo</th>
           
        </tr>
        <?php 
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['depCode'] . "</td>";
                    echo "<td>" . $row['depName'] . "</td>";
                    echo "<td>" . $row['depHead'] . "</td>";
                    echo "<td>" . $row['depTelNo'] . "</td>";
                    echo "<td><a href='edit.php?depCode=" . $row['depCode'] . "'>Edit</a></td>"; 
                    echo "<td><a href='delete.php?depCode=" . $row['depCode'] . "'>Delete</a></td>"; 
              
                     "</tr>";
                }
            }
        
        ?>
    </table>
   
</body>
</html>