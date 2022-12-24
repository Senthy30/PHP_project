<?php

session_start();
include "../dbconnection.php";

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);

if(mysqli_num_rows($result) != 0){
    exit("Nu poti crea un cont cat timp esti logat!");
}

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;

    }
}
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $pass = hash("md5", $pass);

if(empty($uname)){
    header("Location: index.php?error_register=Username is required!");
    exit();
} else if(empty($pass)){
    header("Location: index.php?error_register=Password is required!");
    exit();
}

$sql = "SELECT * FROM credentiale WHERE nume = '$uname'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 0){
    //$pass = hash('sha512', $pass);
    $insertSQL = "INSERT INTO credentiale VALUES ('$uname', '$pass', '2')";
    $wasInserted = mysqli_query($conn, $insertSQL);

    if($wasInserted){
        header("Location: ../index.php?error_register=Registration successful!");
        exit();
    } else {
        header("Location: index.php?error_register=Bad luck! Try again");
        exit();
    }
} else {
    header("Location: index.php?error_register=An account with this username already exists!");
    exit();
}

?>