<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Todo App</title>
    <link href="https://fonts.googleapis.com/css?family=Advent+Pro|Lato" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">
</head>
</html>

<body class="l-body">
<header class="l-header">
    <h1 class="app_title">Todo App</h1>
    <nav class="menu">
        <ul>
            <li class="menu_item"><a href="index.php?view=home">Home</a></li>
            <?php
            // Si l'utilisateur n'est pas connecte, on affiche un lien de connexion


            if (!valider("online", "SESSION"))
                echo "<li class=\"menu_item\"><a href=\"index.php?view=login\">Log in</a></li>";
            else {
            }
            ?>

        </ul>
    </nav>
    <div class="account">
        <?php
        // Si l'utilisateur est connecte, on affiche un lien de deconnexion
        if (valider("online", "SESSION")) {
            echo "<svg class='account_icon' ><path d=\"M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 6c3.31 0 6 2.69 6 6 0 3.32-2.69 6-6 6s-6-2.68-6-6c0-3.31 2.69-6 6-6zm0 28.4c-5.01 0-9.41-2.56-12-6.44.05-3.97 8.01-6.16 12-6.16s11.94 2.19 12 6.16c-2.59 3.88-6.99 6.44-12 6.44z\"/></svg>";
            echo "$_SESSION[usr_login]";
            echo "<a href=\"controller.php?action=logout\">Se Déconnecter</a>";
        }
        ?>
    </div>

</header>

