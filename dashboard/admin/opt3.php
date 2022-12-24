<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['numedr'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $doctor = validate($_POST['numedr']);



    if(empty($doctor)){
        header("Location: homeADMIN.php?raspuns=Completeaza numele doctorului!");
        exit();
    }else{
        $sql = "SELECT * FROM doctor WHERE nume_doctor = '$doctor'";
        $result =  mysqli_query($conn, $sql);

        $row = mysqli_fetch_row($result);

        if($row[0]){
            $sql_del = "DELETE FROM doctor WHERE nume_doctor = '$doctor'";
            $result_del = mysqli_query($conn, $sql_del);

            $sql_del2 = "DELETE FROM credentiale WHERE nume = '$doctor'";
            $result_del2 = mysqli_query($conn, $sql_del2);

            $ans = "Doctorul " . $row[0] . " a fost sters!";

            header("Location: homeADMIN.php?raspuns=$ans");
            exit();
        }else{
            header("Location: homeADMIN.php?raspuns=Doctorul pe care doriti sa-l stergeti nu exista!");
            exit();
        }
    }
}