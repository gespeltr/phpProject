<!DOCTYPE html>
<?php
    session_start();

    if (!$_SESSION['login']){
        header("Location: index.php");
    }
    
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
        <?php capcalera_dash(); ?>
        <section class="subprincipal">
            <div class="login">
                <p class="login">Modifica les teves dades</p>
            </div>
            <?php
                if (isset($_SESSION["error"]["dades"])){
                    ?><p style="color: red;"> <?php echo $_SESSION["error"]["dades"];?> </p><?php
                };
            ?>

            <form action="valida_dades.php" method="post">
                <label>Nom:</label> <br>
                <input type="text" name="username" class="form-control">
                <small class="form-text text-muted">Nom i cognoms</small><br><br>
                <input class="btn btn-success" type="submit" value="Modifica">
                <input class="btn btn-info" type="reset" value="Reiniciar">
                <input class="btn btn-outline-danger" type="button" value="Cancelar" onClick="location.href='dash.php'"> 
            </form>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>