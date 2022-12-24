<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['tlf'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $tlf = validate($_POST['tlf']);
    $doctor = $_SESSION['nume'];

    if(empty($tlf)){
        header("Location: homeDOCTOR.php?raspuns=Introdu un nou numar de telefon!");
        exit();
    }else{

        $sql = "SELECT * FROM doctor WHERE nume_doctor = '$doctor'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $tlf_initial = "";
        if($row){
            $tlf_initial = $row[1];
        }

        if($tlf == $tlf_initial){
            header("Location: homeDOCTOR.php?raspuns=Noul numar de telefon nu poate fi identic cu cel vechi!");
            exit();
        }else{
            $sql_upd = "UPDATE doctor SET telefon_doctor = '$tlf' WHERE nume_doctor = '$doctor' ";
            $result_upd = mysqli_query($conn, $sql_upd);

            header("Location: homeDOCTOR.php?raspuns=Noul numar de telefon a fost inregistrat! Multumit!");
            exit();
        }
    }
}