<?php
    if (!isset($_SESSION)){
        session_start();
    };

    if (!$_SESSION['login']){
        header("Location: index.php");
    }

    $host="localhost";
    $usuari="root";
    $password="R0derick.cs";
    $database="projecte";

    $conn = mysqli_connect($host, $usuari, $password, $database);
    mysqli_query($conn, "SET NAMES 'utf8'");

    if ( !$conn ){
        die('Unable to connect');
    };
?>