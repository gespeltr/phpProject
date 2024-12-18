<?php
    session_start();

    if (!$_SESSION['login']){
        header("Location: index.php");
    }
    require_once '../db/conn.php';
    include 'header.php';
    include 'footer.php';
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
    <?php
        $w_id = $_GET['w_id'];

        $sql = "SELECT * FROM passwd WHERE p_id='$w_id';";
        $query = mysqli_query($conn, $sql);
        $web = mysqli_fetch_assoc($query);

    ?>
    <section class="principal">
        <?php capcalera_dash(); ?>
        <section class="subprincipal">
            <div class="login">
                <p class="login">Afegir web</p>
            </div>
            <form action="<?= ($web) ? 'valida_web.php?w_id=' . $web['p_id'] : 'valida_web.php' ?>" method="post">
                Web* <br>
                <input type="text" name="web" class="form-control" id="web" name="web" aria-describedby="nameHelp" 
                        value="<?= ($web) ? $web['p_web'] : '' ?>" required>
                <small class="form-text text-muted">Nom de la pàgina web</small>
                <br><br>

                URL* <br>
                <input type="url" name="URL" class="form-control" id="URL" name="URL" aria-describedby="nameHelp" 
                        value="<?= ($web) ? $web['p_url'] : '' ?>" required>
                <small class="form-text text-muted">URL de la pàgina web</small>
                <br><br>
                
                Usuari* <br>
                <input type="text" name="username" class="form-control" id="username" name="username" aria-describedby="nameHelp" 
                        value="<?= ($web) ? $web['p_user'] : '' ?>" required>
                <small class="form-text text-muted">Usuari de la pàgina web</small>
                <br><br>

                Password* <br>
                <input type="text" name="password" class="form-control" id="password" name="password" aria-describedby="nameHelp" 
                        value="<?= ($web) ? $web['p_password'] : '' ?>" required>
                <small class="form-text text-muted">Contrasenya de l'usuari</small>
                <br><br>

                Data expiració <br>
                <!-- Arreglat -->
                <input type="date" name="expiration_date" class="form-control" id="p_data_caduc" name="p_data_caduc" aria-describedby="nameHelp" 
                        value="<?= ($web) ? $web['p_data_caduc'] : '' ?>"><br>

                <input class="btn btn-success" type="submit" name="a_web" 
                    value="<?= ($web) ? 'Actualitzar' : 'Afegir' ?>">
                <input type="button" value="Cancelar" class="btn btn-outline-danger" onClick="location.href='dash.php'"> 
            </form>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>