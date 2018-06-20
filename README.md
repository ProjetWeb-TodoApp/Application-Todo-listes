# Application-Todo-listes
Cette application web de todo listes à pour objectif de faciliter la gestion de projet en équipes telles que celles des projets de G1/G2 (12-20 personnes et différents pôles)

Structure : 
On se base sur la structure utilisée lors du TD TinyMVC
On aura : 
un dossier templates qui contiendra les différentes vues : home.php, header.php, footer.php, management.php (permettra éventuellement au chef de projet de modifier les rôles), tasks.php, group.php (accéder aux pôles), tasks_edition.php ( accessible seulement par les chefs de pôle)
un dossier assets qui contiendra les médias extérieurs : images, … 
un dossier js avec les fichiers javascript
un dossier libraries qui contiendra les différentes librairies dont on pourrait avoir besoin ( dont celles récupérées en TD), fichier modele.php
une page index.php qui sera la “page d’accueil” de l’application web
une page config_bdd.php qui permet de configurer l’accès à la base de données 
un dossier css qui contiendra la feuille de style main.css
une page controller.php

Conventions de nommage : 
en anglais

Préfixe de chaque variable : table de données associée 
tasks : tsk
users : usr
checklists : ckl
groups : grp
Exemples:
usr_id
usr_name
grp_chief
ckl_task...

underscore à la place des espaces 

noms de variables en minuscules 
noms de fonctions: tout en minuscules, avec des underscores 
