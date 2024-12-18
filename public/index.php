<?php
    include 'headerfooter.php';
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
        <?php capcalera(); ?>
        <section class="subprincipal">
            <div class="login">
                <p class="login">Login</p>
            </div>
            <?php
                if (isset($_SESSION["error"]["login"])){
                    ?><p style="color: red;"> <?php echo $_SESSION["error"]["login"];?> </p><?php
                };
            ?>

            <form action="valida_login.php" method="post">
                <label>Email:</label> <br>
                <input type="email" name="email" class="form-control"><br>
                Password: <br>
                <input type="password" name="password" class="form-control"><br><br>
                <input class="btn btn-success" type="submit" value="Login">
            </form>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>