<?php

session_start();
include "../dbconnection.php";

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if (!isset($_SESSION['nume']) || $row['drept'] != 2){ 
    exit('Your session expiried!');
  }

if (isset($_POST['nume']) && isset($_POST['data']) && isset($_POST['afectiune']) && isset($_POST['mail']) && isset($_POST['doctor']) && isset($_POST['ora'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }


    $name = validate($_POST['nume']);
    $data = validate($_POST['data']);
    $afectiune = validate($_POST['afectiune']);
    $mail = validate($_POST['mail']);
    $doctor = validate($_POST['doctor']);
    $ora = validate($_POST['ora']);
    $usr = $_SESSION['nume'];



if(empty($name)){
    header("Location: home.php?errorp=Introduceti numele!");
    exit();
} else if(empty($data)){
    header("Location: home.php?errorp=Introduceti data!");
    exit();
}else if(empty($afectiune)){
    header("Location: home.php?errorp=Introduceti afectiunea!");
    exit();
}else if(empty($mail)){
    header("Location: home.php?errorp=Introduceti mailul!");
    exit();
}else if($doctor==""){
    header("Location: home.php?errorp=Alegeti un doctor!");
    exit();
}else if(empty($ora)){
    header("Location: home.php?errorp=Alegeti o ora!");
    exit();
}

$qry = "SELECT * FROM programari WHERE username = '$usr'";
$ct = mysqli_query($conn, $qry);
$x =  mysqli_num_rows($ct);

if($x < 4){
    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' AND dataprog = '$data' AND ora = '$ora'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 0){
        
        $sql_ora = "SELECT interval_orar FROM doctor WHERE nume_doctor = '$doctor'";
        $interval = mysqli_query($conn, $sql_ora);    
        $row = mysqli_fetch_row($interval);

        $ora_start =(int) $row[0][0] . $row[0][1];
        $ora_finish =(int) $row[0][6] . $row[0][7];
        $ora = (int) $ora;

        if($ora < 0 || $ora > 23){
            header("Location: home.php?errorp=Alege o ora potrivita!");
            exit();
        }else if ($ora < $ora_start || $ora > $ora_finish){
            header("Location: home.php?errorp=Medicul selectat nu lucreaza in acel interval orar!");
            exit();
        }else{

            $insertSQL = "INSERT INTO programari VALUES ('$doctor', '$data', '$name', '$mail', '$afectiune', '$ora', '$usr')";
            $wasInserted = mysqli_query($conn, $insertSQL);

            if($wasInserted){
            
                // TEST
                $to      = $mail;
                $subject = 'Confirmarea programarii';
                $message = 'Buna ziua, ' . $name . ' acest mail reprezinta confirmarea programarii dvs. Va multumim!';
                $headers = 'From: petru.theodor@outlook.com'       . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
                //TEST
            
                header("Location: home.php?errorp=Programare inregistrata! Veti primi confirmarea pe mail!");
                exit();
            } else {
                header("Location: home.php?errorp=Bad luck! Try again");
                exit();
            }
        }
    }else {
        header("Location: home.php?errorp=Doctorul are deja o programare la acea data!");
        exit();
        }
    }
else{
    header("Location: home.php?errorp=limita de programari a fost atinsa!");    
    exit();
    }
}
?>