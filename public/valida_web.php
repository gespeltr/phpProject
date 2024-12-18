<?php
    session_start();

    if (!$_SESSION['login']){
        header("Location: index.php");
    }

    require_once '../db/conn.php';

    $conn = mysqli_connect($host, $usuari, $password, $database);
    mysqli_query($conn, "SET NAMES 'utf8'");

    if ( !$conn ){
        die('Unable to connect');
    };

    $u_id = $_SESSION['u_id'];
    
    $correcte=True;
    #Web
    $p_web = $_POST["web"];
    if (strlen($p_web) > 50){
        $correcte=False;
    };

    #User
    $p_user = $_POST["username"];
    if (strlen($p_user) > 50){
        $correcte=False;
    };

    #URL
    $p_url = $_POST["URL"];
    if (strlen($p_url) > 255){
        $correcte=False;
    };

    #Password
    $p_password = $_POST["password"];
    if (strlen($p_password) > 255){
        $correcte=False;
    };

    $p_data_caduc = $_POST["expiration_date"];

    if ($p_data_caduc == ""){
        $p_data_caduc=NULL;
    };
    
    #Fortalesa del password;

    $min='abcdefghijklmnopqrstuvwxyz';
    $may='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $digits='0123456789';
    $caracters="!#$%&()*+,-./:;<=>?@[\]^_`{|}~";

    #Dèbil
    if (strlen($p_password)>=5 && strlen($p_password)<=7){
        $p_fortalesa = 1;
    #Acceptable
    } elseif (strlen($p_password)>=8){
            #Acceptable
            $p_fortalesa = 2;

            if (strlen($p_password)>=12){
                $minuscules=False;
                $mayuscules=False;
                $conte_digits=False;
                $caracters_especials=False;

                for($i=0; $i<strlen($p_password); $i++) {
                    if (strpos($min, $p_password[$i])){
                        $minuscules=True;
                    };

                    if (strpos($may, $p_password[$i])){
                        $mayuscules=True;
                    };

                    if (strpos($digits, $p_password[$i])){
                        $conte_digits=True;
                    };

                    if (strpos($caracters, $p_password[$i])){
                        $caracters_especials=True;
                    };
                
                };

                if ($minuscules && $mayuscules && $conte_digits && $caracters_especials){
                    $p_fortalesa=3;

                    if (strlen($p_password)>=16){
                        $p_fortalesa=4;
                    };
                };

            };
    } else{
        $p_fortalesa=0;
    };

    $alta = true;
    if (isset($_GET['w_id'])){
        $alta=false;
        $w_id = (int) $_GET['w_id'];
    }
    
    if ($correcte){
        if ($alta){
            try {
                if ($p_data_caduc == NULL){
                    $sql = "INSERT INTO passwd VALUES(null, '$u_id', '$p_web', '$p_user', '$p_url', '$p_password', null, '$p_fortalesa');";
                } else{
                    $sql = "INSERT INTO passwd VALUES(null, '$u_id', '$p_web', '$p_user', '$p_url', '$p_password', '$p_data_caduc', '$p_fortalesa');";
                };
                $desarDB = mysqli_query($conn, $sql);
            } catch (Exception $e) {
                $_SESSION['errors']['afegir'] = "Error a l'afegir la web: " . mysqli_error($conn);
            };
        } else{
            try {
                if ($p_data_caduc == NULL){
                    $sql = "UPDATE passwd SET p_web='$p_web', p_url='$p_url', p_user='$p_user', p_password='$p_password', p_fortalesa='$p_fortalesa', p_data_caduc=null WHERE p_id='$w_id';";
                } else{
                    $sql = "UPDATE passwd SET p_web='$p_web', p_url='$p_url', p_user='$p_user', p_password='$p_password', p_fortalesa='$p_fortalesa', p_data_caduc='$p_data_caduc' WHERE p_id='$w_id';";
                };
                $desarDB = mysqli_query($conn, $sql);
            } catch (Exception $e) {
                $_SESSION['errors']['afegir'] = "Error al modificar la web: " . mysqli_error($conn);
            };
        };
    };
    header("Location: dash.php");
?>