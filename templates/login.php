<?php


// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login");
    die("");
}

?>
<main class="l-main">
    <section class="l-section-small login_form">

        <h2>Log in</h2>

        <?php
        if ($msg = valider('msg')) {
            echo('<p class="alerte"><strong>' . $msg . '</strong></p>');
        }
        ?>

        <form action="controller.php" method="GET">
            <!--<label class="form_item">Log in<input type="text" name="login"></label>
            <label class="form_item">Password<input type="text" name="password"></label>
            -->
            <input type="text" name="login" placeholder="Login">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" >Log in</button>
        </form>


    </section>
</main>

