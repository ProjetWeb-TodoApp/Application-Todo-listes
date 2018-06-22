<?php



// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
    header("Location:../index.php?view=login");
    die("");
}

?>

    <div id="corps">

        <h1>Connexion</h1>
        <?php
        if ($msg = valider('msg')) {
            echo('<strong>' . $msg . '</strong>');
        }
        ?>
        <div id="formLogin">
            <form action="controller.php" method="GET">
                <label>Log in<input type="text" name="login"></label>
                <label>Password<input type="text" name="password"></label>
                <input type="submit" name="action" value="login" />
            </form>
        </div>


    </div>


