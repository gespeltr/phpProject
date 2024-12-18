<?php
    session_start();

    if (!isset($_SESSION['login'])){
        header("Location: index.php");
    }

    require_once '../db/conn.php';
    include 'headerfooter.php';
?>
<!DOCTYPE html>
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
            
                if (isset($_SESSION['errors']['afegir'])){ ?>
                    <div class="error">
                        <p><?php echo $_SESSION['errors']['afegir']; ?></p>
                    </div> <?php
                    unset($_SESSION['errors']['afegir']);
                };

                if (isset($_SESSION['error_database_wen'])){ ?>
                    <div class="error">
                        <p><?php echo $_SESSION['error_database_wen']; ?></p>
                    </div> <?php
                    unset($_SESSION['error_database_wen']);
                } elseif(isset($_SESSION['web'])){ ?>
                    <div class="login">
                        <p><?php echo $_SESSION['web']; ?></p>
                    </div> <?php
                    unset($_SESSION['web']);
                }
                
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

                $u_id = $u_id['u_id'];
                $sql = "SELECT * FROM passwd WHERE u_id = '$u_id';";
                $resultat = mysqli_query($conn, $sql);
                if (mysqli_num_rows($resultat) > 0){
                    ?>
                    <br>
                    <p>Llistat de webs i dades d'accés</p>
                    <table style = "border:1px solid black;" class="table table-striped table-bordered">
                    <tr style = "border:1px solid black;">
                                    <th style = "border:1px solid black;">Web</td>
                                    <th style = "border:1px solid black;">URL</td>
                                    <th style = "border:1px solid black;">Usuari</td>
                                    <th style = "border:1px solid black;">Password</td>
                                    <th style = "border:1px solid black;">Fortalesa</td>
                                    <th style = "border:1px solid black;">Caducitat</td>
                                    <th style = "border:1px solid black;">Opcions</td>
                                </tr>
                    <?php
                        while ($row = mysqli_fetch_assoc($resultat)){
                            ?>  
                                <tr style = "border:1px solid black;">
                                    <td style = "border:1px solid black;"><?php echo $r = (strlen($row['p_web'])>10) ? substr($row['p_web'], 0, 10) : $row['p_web']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $r = (strlen($row['p_url'])>20) ? substr($row['p_url'], 0, 20) : $row['p_url']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $row['p_user']; ?></td>
                                    <td style = "border:1px solid black;"><?php echo $r = (strlen($row['p_password'])>20) ? substr($row['p_password'], 0, 20) : $row['p_password']; ?></td>
                                    <td style = "border:1px solid black; text-align: center"><?php calcular_fortalesa($row['p_fortalesa']); ?></td>
                                    <td style = "border:1px solid black; text-align: center"><?php echo $r = ($row['p_data_caduc'] == NULL) ? '-' : $row['p_data_caduc']; ?></td>
                                    <td style = "border:1px solid black;">
                                        <form method="GET" action="detall_web.php">
                                            <input type="hidden" name="w_id" value="<?php echo $row['p_id'] ?>">
                                            <input type="submit" class='btn btn-outline-primary' value="Mostrar">
                                        </form> 
                                        <form method="GET" action="afegir_web.php">
                                            <input type="hidden" name="w_id" value="<?php echo $row['p_id'] ?>">
                                            <input type="submit" class='btn btn-outline-success' value="Editar">
                                        </form>
                                        <form method="GET" action="detall_web.php">
                                            <input type="hidden" name="w_id" value="<?php echo $row['p_id'] ?>">
                                            <input type="hidden" name="del" value="true">
                                            <input type="submit" class="btn btn-outline-danger" value="Eliminar">
                                        </form>
                                    </td>    
                                </tr>
                            <?php
                        };
                    ?>
                    </table>
                    <?php
                } else{
                    echo "0 resultats";
                };

            ?>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>