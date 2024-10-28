<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nice";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


if (isset($_GET['depCode'])) {
    $depCode = $_GET['depCode'];

 
    $sql = "SELECT depName, depHead, depTelNo FROM departments WHERE depCode=$depCode";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $depName = $row['depName'];
        $depHead = $row['depHead'];
        $depTelNo = $row['depTelNo'];
    } 

} 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelNo = $_POST['depTelNo'];


        $sql = "UPDATE departments SET depName='$depName', depHead='$depHead', depTelNo='$depTelNo' WHERE depCode=$depCode";

       
        if ($conn->query($sql) === TRUE) {
            header("location: DepManagement.php"); 
            exit();
        }
}



$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
</head>
<body>
    <h2>Edit Department</h2>

    <form action="edit.php?depCode=<?php echo $depCode; ?>" method="POST">
        <label for="depName">Department Name:</label>
        <input type="text" name="depName" value="<?php echo $depName; ?>" ><br><br>
        
        <label for="depHead">Department Head:</label>
        <input type="text" name="depHead" value="<?php echo $depHead; ?>" ><br><br>
        
        <label for="depTelNo">Department Tel No:</label>
        <input type="number" name="depTelNo" value="<?php echo $depTelNo; ?>" ><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
