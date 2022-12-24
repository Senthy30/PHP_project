<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['prog'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $prog = validate($_POST['prog']);
    $doctor = $_SESSION['doctor'];

    if(empty($doctor)){
        header("Location: homeADMIN.php?raspuns=Alege un doctor!");
        exit();
    }else{

        if($prog != $_SESSION["progr_initial"]){
            $sql = "UPDATE doctor SET interval_orar = '$prog' WHERE nume_doctor = '$doctor'";
            $result = mysqli_query($conn, $sql);
            $ans = "Programul doctorului " . $doctor . ' a fost actualizat!';
            header("Location: homeADMIN.php?raspuns=$ans");
            exit();
        }else{
            header("Location: homeADMIN.php?raspuns=Noul program trebuie sa fie diferit de cel initial!");
            exit();
        }
    }
}