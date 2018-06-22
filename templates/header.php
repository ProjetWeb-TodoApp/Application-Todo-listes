<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Todo App</title>
    <link rel="stylesheet" href="../style/main.css">
</head>
</html>

<body>
<header>
    <h1>Todo App</h1>
    <a href="index.php?view=home">Home</a>

    <?php
    // Si l'utilisateur n'est pas connecte, on affiche un lien de connexion
	
	tprint($_SESSION);
    if (!valider("online", "SESSION"))
        echo "<a href=\"index.php?view=login\">Log in</a>";
    else {
      }
    ?>

    <?php
    // Si l'utilisateur est connecte, on affiche un lien de deconnexion
    if (valider("online","SESSION"))
    {
        echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; ";
        echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
    }
    ?>

</header>
