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

    if (isset($_SESSION["error_usuari"])){
        unset($_SESSION["error_usuari"]);
    };
    if (isset($_SESSION["error_email"])){
        unset($_SESSION["error_email"]);
    };
    if (isset($_SESSION["error_password"])){
        unset($_SESSION["error_password"]);
    };
    if (isset($_SESSION['AltaDB'])){
        unset($_SESSION['AltaDB']);
    };
    if (isset($_SESSION['errors']['general'])){
        unset($_SESSION['errors']['general']);
    };

    $correcte=True;
    $caracters_username="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    $caracters_password="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789!@#$%^&*()-_+=";


    #Username
    if (empty($_POST['username']) === False){
        $comprovacio=sanitize_input($_POST["username"]);

        if ($comprovacio){
            for($i=0; $i<strlen($_POST["username"]); $i++) {

                if (strpos($caracters_username, $_POST["username"][$i]) === False) {
                    $correcte=False;
                    $_SESSION["error_usuari"]="Només lletres, espais i signés de puntuació";
                    $i=strlen($_POST["username"]);
                };
            };
        };
    } else {
        $correcte = False;
    };

    #Email
    if (empty($_POST['email']) === False){
        $comprovacio=sanitize_input($_POST["email"]);

        if ($comprovacio){
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === False){
                $_SESSION["error_email"]="Email incorrecte";
                $correcte=False;
            };
        };
    } else {
        $correcte = False;
    };

    #Password
    if (empty($_POST['password']) === False){
        $comprovacio=sanitize_input($_POST["password"]);

        if ($comprovacio){
            if (strlen($_POST["password"]) > 7){
                for($i=0; $i<strlen($_POST["password"]); $i++) {

                    if (strpos($caracters_password, $_POST["password"][$i]) === False) {
                        $correcte=False;
                        $_SESSION["error_password"]="Password incorrecte, mínim 8 caràcters";
                        $i=strlen($_POST["password"]);
                    };
                };
            } else{
                $correcte=False;
                $_SESSION["error_password"]="Password incorrecte, mínim 8 caràcters";
            };
        };
    } else {
        $correcte = False;
    };

    if ($correcte){
        $_SESSION["username"] = $_POST['username'];
        $_SESSION["email"] = $_POST['email'];
        $_SESSION["password"] = $_POST['password'];

        $u_name = $_SESSION["username"];
        $u_email = $_SESSION["email"];
        $u_pass_segur = password_hash($_SESSION["password"], PASSWORD_BCRYPT, ['cost'=>4]);

        try {
            $sql = "INSERT INTO usuaris VALUES(null, '$u_name', '$u_email', '$u_pass_segur');";
            $desarDB = mysqli_query($conn, $sql);
            if ($desarDB){
                $_SESSION['AltaDB'] = "Usuari donat d'alta correctament";
            };
        } catch (Exception $e) {
            $_SESSION['errors']['general'] = "Error al desar l'usuari: " . mysqli_error($conn);
        };
    };
    header("Location: registre.php");
?>