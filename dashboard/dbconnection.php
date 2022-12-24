<?php

$sname= "localhost";

$uname= "root";

$password = "";

$db="utilizatori";

$conn = mysqli_connect($sname, $uname, $password, $db);

if (!$conn) {

    echo "Connection failed!";

}