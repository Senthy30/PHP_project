<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['datapr']) && isset($_POST['ora'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $ora = validate($_POST['ora']);
    $datapr = validate($_POST['datapr']);
    $doctor = $_SESSION['nume'];

    if(empty($ora)){
        header("Location: homeDOCTOR.php?raspuns=Selecteaza o ora!");
        exit();
    }else if(empty($datapr)){
        header("Location: homeDOCTOR.php?raspuns=Selecteaza o data!");
        exit();
    }

    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' and ora='$ora' and dataprog = '$datapr'";
    $result = mysqli_query($conn, $sql);
    $select_str = ""; 
    $row = mysqli_fetch_row($result);
    if($row){
        $_SESSION['ora_opt2'] = $row[5];
        $_SESSION['data_opt2'] = $row[1];
        $_SESSION['nume_pacient_opt2'] = $row[2];
        
        $select_str .= " ora " . $row[5] . " din data de " . $row[1] . " a pacientului " . $row[2]; 
    }

    $sql_del = "DELETE FROM programari WHERE nume_doctor = '$doctor' AND dataprog = '$datapr' AND ora = '$ora'";
    $result_del = mysqli_query($conn, $sql_del);

    if($select_str == "Ati selectat programarea urmatoare:<br> "){
        header("Location: homeDOCTOR.php?raspuns=Programare inexistenta");
        exit();
    }else{
        $delete = "Programarea anulata: " . $select_str;
        header("Location: homeDOCTOR.php?raspuns=$delete");
        exit();
    }

}