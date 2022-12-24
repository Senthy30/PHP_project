<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['datapr'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }


    $datapr = validate($_POST['datapr']);
    $doctor = $_SESSION['nume'];

    if(empty($datapr)){
        header("Location: homeDOCTOR.php?raspuns=Selecteaza o data!");
        exit();
    }

    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' and dataprog = '$datapr' ORDER BY ORA";
    $result = mysqli_query($conn, $sql);
    $select_str = "Pe data selectata aveti urmatoarele programari: <br>";
    $i = 1;

    while ($row = mysqli_fetch_row($result)){
        $select_str .= $i . ". " . $row[2] . " la ora " . $row[5] .  " Simptom descris: " . $row[4] . "<br>"; 
        $i = $i + 1;
    } 
    if($select_str == "Pe data selectata aveti urmatoarele programari: <br>"){
        header("Location: homeDOCTOR.php?raspuns=Nu exista nicio programare la acea data!");
        exit();
    }else{
        header("Location: homeDOCTOR.php?raspuns=$select_str");
        exit();
    }

}