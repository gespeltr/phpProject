<?php

    session_start();

    if (!isset($_SESSION['login'])){
        header("Location: index.php");
    }

    function capcalera(){
        //EOT es per imprimir mes d'una liea com si fos un echo, ho faig servir perque s'entengui millor i
        //no doni problemes al obrir i tancar cometes
        echo <<<EOT
            <div class="container mt-3">
                <div class="header">
                    <div class="d-flex justify-content-between mb-3" style="background-color: #f5e187;">
                        <div class="p-2"><a href="index.php"><input class='btn btn-primary' type="button" value="Inici"></a></div>
                        <div class="p-2" style="color: #e2652b;"><h1>Projecte ASIX</h1></div>
                        <div class="p-2"><a href="registre.php"><input class='btn btn-primary' type="button" value="Registre"></a></div>
                    </div>
                </div>
            </div>
        EOT;
    };

    function capcalera_dash(){ ?>
            <div class="container mt-3">
                <div class="header">
                    <div class="d-flex justify-content-between mb-3" style="background-color: #f5e187;">
                        <div class="p-2"><a href="modificar_dades.php"><input class='btn btn-primary' type="button" value=<?php echo "Benvingut/da_".$_SESSION['usuari']['u_name'] ;?>></a></div>
                        <div class="p-2" style="color: #e2652b;"><h1>Projecte ASIX</h1></div>
                        <div class="p-2"><a href="logout.php"><input class='btn btn-primary' type="button" value="Logout"></a></div>
                    </div>
                </div>
            </div>
    <?php };

    function menu(){
        echo "<a class='btn btn-primary' href='dash.php' role='button'>Llista webs</a>";
        echo " ";
        echo "<a class='btn btn-primary' href='afegir_web.php' role='button'>Afegir web</a>";
    };

    function peu_pagina(){
        echo <<<EOT
            <br>
            <div>
                <div class="footer">
                        <div class="p-2 bg-secondary text-white">© 2023 ASIX-MP09-UF1</div>
                </div>
            </div>
        EOT;
    }
?>