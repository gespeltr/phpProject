<!DOCTYPE html>
<?php
    if (!isset($_SESSION)){
        session_start();
    };

    if (!$_SESSION['login']){
        header("Location: index.php");
    }

    require_once '../db/conn.php';
    include 'header.php';
    include 'footer.php';
?>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet"> <!-- Vincula style.css per aplicar CSS-->

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <section class="principal">
        <?php 
            capcalera_dash(); 
            menu();
        ?>
        <section class="subprincipal">
            <?php
            
                $u_email = $_SESSION['usuari']['u_email'];
                $sql = "SELECT u_id FROM usuaris WHERE u_email='$u_email';";
                $query = mysqli_query($conn, $sql);
                #Falta el id_usuari
                if ($query && mysqli_num_rows($query) == 1){
                    $u_id = mysqli_fetch_assoc($query);
                };

                $_SESSION['u_id'] = $u_id['u_id'];
                            
                #Llistar web
                function calcular_fortalesa($num){
                    if ($num == 0){
                        echo "Molt dèbil";
                    } elseif ($num == 1){
                        echo "Dèbil";
                    } elseif ($num == 2){
                        echo "Acceptable";
                    } elseif ($num == 3){
                        echo "Forta";
                    } elseif ($num == 4){
                        echo "Molt forta";
                    };
                };

                $w_id = $_GET['w_id'];
                $u_id = $u_id['u_id'];

                $sql = "SELECT * FROM passwd WHERE u_id = '$u_id' AND p_id = '$w_id';";
                $resultat = mysqli_query($conn, $sql);
                ?>
                    <br>
                            <?php
                                if (isset($_GET['del'])){?>
                                    <div class="error">
                                        <p>
                                            <?php
                                                echo "Segur que vols eliminar aquesta web?";
                                            };?>
                                        </p> 
                                    </div>
                    <table style = "border:1px solid black;" class="table table-striped table-bordered">
                        <tr style = "border:1px solid black;">
                            <th style = "border:1px solid black;">Web</td>
                            <th style = "border:1px solid black;">URL</td>
                            <th style = "border:1px solid black;">Usuari</td>
                            <th style = "border:1px solid black;">Password</td>
                            <th style = "border:1px solid black;">Fortalesa</td>
                            <th style = "border:1px solid black;">Caducitat</td>
                        </tr>
                    <?php
                        while ($row = mysqli_fetch_assoc($resultat)){
                            ?>  
                                <tr style = "border:1px solid black;">
                                    <td style = "border:1px solid black;"><?php echo $row['p_web']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $row['p_url']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $row['p_user']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $row['p_password']; ?></td>
                                    <td style = "border:1px solid black; text-align: center"><?php calcular_fortalesa($row['p_fortalesa']); ?></td>
                                    <td style = "border:1px solid black; text-align: center"><?php echo $r = ($row['p_data_caduc'] == NULL) ? '-' : $row['p_data_caduc']; ?></td>
                                </tr>
                            <?php
                        };
                    ?>
                    </table>
                    <?php
                        if (isset($_GET['del'])){

                            ?>
                            <form method="post" action="">
                                <input type="submit" name="eliminar" class="btn btn-outline-danger" value="Eliminar">
                            </form>
                            <?php
                            function fun_eliminar() {
                                global $host, $usuari, $password, $database, $conn;

                                $w_id = $_GET['w_id'];
                                mysqli_connect($host, $usuari, $password, $database);

                                $sql = "DELETE FROM passwd WHERE p_id='$w_id'";
                                $resultat = mysqli_query($conn, $sql);
    
                                if ($resultat){
                                    $_SESSION['web'] = 'Web eliminada correctament';
                                } else {
                                    $_SESSION['error_database_wen'] = 'Error eliminant el registre: ' . mysqli_error($conn);
                                };
                            }
                            
                            if(isset($_POST['eliminar'])){
                                fun_eliminar();
                                header("Location: dash.php");
                            };

                        };
                    ?>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>