

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Todo App</title>
    <link href="https://fonts.googleapis.com/css?family=Advent+Pro|Lato" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">
    <script src="js/timeknots_modified.js"></script>
    <script src="js/d3.v2.min.js"></script>
</head>
</html>

<body class="l-body">
<header class="l-header">
    <a href="index.php?view=home"><img 	id="logo"
				src="ressources/logo.png" /></a>
	
    <nav class="menu">
        <ul>
            <?php
            include_once "librairies/maLibUtils.php";
            include_once "librairies/modele.php";
            //Code à insérer pour afficher la liste des pages disponibles
            if (valider("online", "SESSION")) {
                echo "<li class=\"menu_item usr_group\"><a href=\"index.php?view=home\">Home</a></li>";
                $groups = prompt_grp();
                $usr_groups=prompt_usr_groups($_SESSION["usr_id"]);
                foreach ($groups as $grp) {
                    echo "<li class=\"menu_item ";
                    if (in_array($grp["id"],$usr_groups)){echo " usr_group";}
                    echo "\"><a href=\"index.php?view=group&grp_id=$grp[id]\">$grp[title] </a></li>";
                }
            }

            ?>

        </ul>
    </nav>
    <div class="account">
        <?php
        // Si l'utilisateur est connecte, on affiche un lien de deconnexion, sinon on affiche un lien de connexion
        if (valider("online", "SESSION")) {

            echo "<svg class='account_icon' viewBox=\"0 0 48 48\"><path d=\"M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm0 6c3.31 0 6 2.69 6 6 0 3.32-2.69 6-6 6s-6-2.68-6-6c0-3.31 2.69-6 6-6zm0 28.4c-5.01 0-9.41-2.56-12-6.44.05-3.97 8.01-6.16 12-6.16s11.94 2.19 12 6.16c-2.59 3.88-6.99 6.44-12 6.44z\"/></svg>";
            echo "<strong>$_SESSION[usr_login]</strong>";
            echo "<a href=\"controller.php?action=logout\"><button>Log out</button></a>";
        }         ?>
    </div>
</header>

