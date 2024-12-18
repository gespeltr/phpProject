<?php
    session_start();

    if (!$_SESSION['login']){
        header("Location: index.php");
    }

    require_once '../db/conn.php';

    function sanitize_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    };

    if (isset($_SESSION["error"]["dades"])){
        unset($_SESSION["error"]["dades"]);
    };

    if ($_POST['username'] != ''){
        $validar_username=sanitize_input($_POST['username']);
    } else{
        $validar_username=False;
    };

    $errorLogin=True;
    if ( $validar_username ){

        $u_name = $_POST['username'];
        $u_email = $_SESSION['usuari']['u_email'];
        
            $sql = "UPDATE usuaris SET u_name='$u_name' WHERE u_email='$u_email'";
            $login = mysqli_query($conn, $sql);
    
            if ($login){
                $_SESSION['usuari']['u_name'] = $u_name;
                header("Location: dash.php");
            } else{
                $_SESSION["error"]["dades"] = "Nom d'usuari no vàlid.";
                header("Location: modificar_dades.php");
            };
    } else{
        $_SESSION["error"]["dades"] = "Nom d'usuari no vàlid.";
        header("Location: modificar_dades.php");
    };
?>