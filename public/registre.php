<?php
    session_start();

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
    <title>Inici</title>

</head>
<body>
    <section class="principal">
        <?php capcalera(); ?>
        <section class="subprincipal">
            <div class="login">
                <p class="login">Formulari de registre</p>
            </div>
            <?php
            
                $mostrar_formulari=True;

                if (isset($_SESSION['AltaDB'])){ ?>
                    <div class="login">
                        <p><?php echo $_SESSION['AltaDB']; ?></p>
                    </div> <?php
                    unset($_SESSION['AltaDB']);
                    $mostrar_formulari=False;
                };

                if (isset($_SESSION['errors']['general'])){ ?>
                        <p class="error"><?php echo $_SESSION['errors']['general']; ?></p>
                    <?php
                    $mostrar_formulari=False;
                };
            ?>

            <?php
                if ($mostrar_formulari){                
            ?>
            <form action="valida_registre.php" method="post">
                Nom<br>
                <input type="text" name="username" class="form-control">
                <small class="form-text text-muted">
                    <?php
                        if (isset($_SESSION["error_usuari"])){ ?>
                            <div style="color: #f50505;">
                                <p><?php echo $_SESSION["error_usuari"]; ?></p>
                            </div> <?php
                        } else{
                            ?> <p> <?php echo "Nom i cognoms";?> </p> <?php
                        };
                    ?>
                </small>
                
                <br>

                Email<br>
                <input type="text" name="email" class="form-control">
                <small class="form-text text-muted">
                <?php
                    if (isset($_SESSION["error_email"])){ ?>
                        <div style="color: #f50505;">
                            <p><?php echo $_SESSION["error_email"]; ?></p>
                        </div> <?php
                    } else{
                        ?> <p> <?php echo "Introdueix un email vàlid";?> </p> <?php
                    };
                ?>
                </small>
                
                <br>

                Password<br>
                <input type="password" name="password" class="form-control">
                <small class="form-text text-muted">
                <?php
                    if (isset($_SESSION["error_password"])){?>
                        <div style="color: #f50505;">
                            <p><?php echo $_SESSION["error_password"]; ?></p>
                        </div> <?php
                    } else{
                        ?> <p> <?php echo "Mínim 8 caràcters, format per lletres majúscules, dígits i símbols";?> </p> <?php
                    };
                ?>
                </small>

                <br>
                
                <input type="submit" value="Registre" class="btn btn-success">
            </form>
            <?php
                };                
            ?>
        </section>
        <?php peu_pagina(); ?>
    </section>
</body>
</html>