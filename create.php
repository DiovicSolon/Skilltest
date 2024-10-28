<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nice";

    $conn = new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection Failed: " .$conn->connect_error);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
         $depName = $_POST['depName'];
        $depHead = $_POST['depHead'];
        $depTelNo = $_POST['depTelNo'];
       
      👍  

        $sql = " INSERT INTO departments ( depName, depHead, depTelNo) VALUES ( '$depName', '$depHead', '$depTelNo')";
        
        if($conn->query($sql) === TRUE){
            header("location: DepManagement.php");
            exit();
         }
         
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="create.php" method="POST"> 
        depName: <input type="text" name="depName">
        depHead: <input type="text" name="depHead">
        depTelNo: <input type="number" name="depTelNo">
    <input type="submit" value="create">


    </form>

    
</body>
</html>