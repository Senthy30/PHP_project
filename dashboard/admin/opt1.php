<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

$sql = "SELECT * FROM doctor";
$result = mysqli_query($conn, $sql);
$select_str = "Doctorii acestei clinici sunt: <br>";
$i = 1;

while ($row = mysqli_fetch_row($result)){
    $select_str .= $i . ". " . $row[0] . "<br>"; 
    $i = $i + 1;
} 

if($select_str == "Doctorii acestei clinici sunt: <br>"){
    header("Location: homeADMIN.php?raspuns=Clinica nu mai are momentan niciun doctor angajat!");
    exit();
}else{
    header("Location: homeADMIN.php?raspuns=$select_str");
    exit();
}
?>