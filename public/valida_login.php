<?php
    session_start();

    if (!isset($_SESSION['login'])){
        header("Location: index.php");
    }

    require_once '../db/conn.php';
    function sanitize_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    };

    if (isset($_SESSION["error"]["login"])){
        unset($_SESSION["error"]["login"]);
    };

    $validar_email=sanitize_input($_POST['email']);
    $validar_password=sanitize_input($_POST['password']);

    $errorLogin=True;
    if ( $validar_email && $validar_password ){

        $u_email = $_POST['email'];
        $u_pass = $_POST['password'];
        
            $sql = "SELECT * FROM usuaris WHERE u_email='$u_email'";
            $login = mysqli_query($conn, $sql);
            
            //Comprovem que hi sigui
    
            if ($login && mysqli_num_rows($login) == 1){
    
                //fa un array associatiu de l'usuari
                $usuari = mysqli_fetch_assoc($login);
    
                //ara ja podem comprovar el password
                $verify = password_verify($u_pass, $usuari['u_pass']);
    
                if ($verify){
                    //fer una sessió amb l'usuari logejat
                    $usuari['u_pass']="";
                    $_SESSION['usuari'] = $usuari;
                    $errorLogin=false;
                    $_SESSION['login']=True;
                };
    
            };
    };

    if ($errorLogin){
        $_SESSION["error"]["login"] = "Usuari o contrasenya incorrectes.";
        header("Location: index.php");
    } else{
        header("Location: dash.php");
    };
?>