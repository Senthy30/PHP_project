<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['numedr']) && isset($_POST['interval']) && isset($_POST['tlf']) && isset($_POST['specializare']) && isset($_POST['pass'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $doctor = validate($_POST['numedr']);
    $program = validate($_POST['interval']);
    $tlf = validate($_POST['tlf']);
    $specializare = validate($_POST['specializare']);
    $pass = validate($_POST['pass']);


    if(empty($doctor)){
        header("Location: homeADMIN.php?raspuns=Completeaza numele doctorului!");
        exit();
    }else if(empty($program)){
        header("Location: homeADMIN.php?raspuns=Introdu intervalul orar in care doctorul lucreaza!");
        exit();
    }else if(empty($tlf)){
        header("Location: homeADMIN.php?raspuns=Completeaza numarul de telefon al doctorului!");
        exit();
    }
    else if(empty($specializare)){
        header("Location: homeADMIN.php?raspuns=Completeaza specializarea doctorului!");
        exit();
    }else if(empty($pass)){
        header("Location: homeADMIN.php?raspuns=Introdu o parola pentru contul doctorului!");
        exit();
    }

    $insertSQL = "INSERT INTO doctor VALUES ('$doctor', '$tlf', '$program', '$specializare')";
    $wasInserted = mysqli_query($conn, $insertSQL);

    $pass = hash("md5", $pass);
    $insertSQLacc = "INSERT INTO credentiale VALUES ('$doctor', '$pass', '1')";
    $wasInsertedacc = mysqli_query($conn, $insertSQLacc);

    if($wasInserted){
        header("Location: homeADMIN.php?raspuns=Registration successful!");
        exit();
    } else {
        header("Location: homeADMIN.php?raspuns=Bad luck! Try again");
        exit();
    }

}