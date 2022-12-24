<?php 

session_start(); 

include "../dbconnection.php";

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

if (empty($uname)) {

    header("Location: ../index.php?error_login=User Name is required");
    exit();
    
}else if(empty($pass)){

    header("Location: ../index.php?error_login=Password is required");
    exit();
}

$sql = "SELECT * FROM credentiale WHERE nume = '$uname' AND parola = '$pass'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);

    if ($row['nume'] === $uname && $row['parola'] === $pass) {
        echo "Logged in!";
        $_SESSION['nume'] = $row['nume'];
        if($row['drept'] === '2'){
            header("Location: \dashboard\pacient\home.php");
            exit();
        }else if($row['drept'] === '1'){
            header("Location: \dashboard\doctor\homeDOCTOR.php");
            exit();
        }else if($row['drept'] === '0'){
            header("Location: \dashboard\admin\homeADMIN.php");
            exit();
        }

    }else{
            header("Location: ../index.php?error_login=Incorect User name or password. Try again");
            exit();
    }
}
else{
    header("Location: ../index.php?error_login=Incorect User name or password. Try again");
    exit();
}