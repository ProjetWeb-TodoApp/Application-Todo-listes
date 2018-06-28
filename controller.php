<?php
session_start();
include_once "librairies/maLibUtils.php";
include_once "librairies/maLibSQL.pdo.php";
include_once "librairies/maLibSecurisation.php";
include_once "librairies/modele.php";


//echo 'console.log("dans le session start");';
if ($action = valider("action")) {
    ob_start();
    //echo 'console.log("action valide");';


    switch ($action) {
        //echo 'console.log("dans le switch");';
        // dans le GET, on admet qu'on reçoit 'password' et 'login'
        // la connexion crée toutes les variables de session et rediri
        case "login":
            //echo 'console.log("dans le case login");';
            if ($login = valider("login")) {
                if ($password = valider("password")) {
                    //On appelle bien la fonction de sécurisation, qui crée les variables de session suivantes:
                    //$_SESSION['usr_login'] = $login;
                    //$_SESSION['usr_id'] = $id;
                    //$_SESSION['connexion_time'] = date("H:i:s");
                    //$_SESSION['is_project_manager'] = is_project_manager($usr_id);
                    //$_SESSION['online'] = true;

                    //On appelle aussi la fonction is_project_manager() qui devra être faite dans modele
                    //echo 'console.log("dans la boucle");';
                    if (check_user($login, $password)) {

                        $qs = "?view=home";
                    } else {
                        $qs = "?view=login&msg=" . urlencode("Please enter a valid password");
                    }
                } else {
                    $qs = "?view=login&msg=" . urlencode("Please enter a password");
                }
            } else {
                $qs = "?view=login&msg=" . urlencode("Please enter a username");
            }
            break;

        //on a appuyé sur le bouton "logout", donc on détruit la session et on renvoie vers l'index qui va nous rediriger vers la vue "home"
        case "logout":
            //echo 'console.log("dans le case logout");';
            unset($_SESSION);
            session_destroy();
            $qs = "?view=home";

            break;


        //New_task: crée une nouvelle tache à partir des données envoyées par
        //la view groupe avec la methode GET.

        case "new_task":
            //On valide toutes les valeurs qui viennent par le GET
            if ($tsk_title = valider("tsk_name")) {
                if ($tsk_deadline = valider("tsk_deadline")) {
                    $id_usr_tab = array();
                    //Cette boucle parcours les entiers de 1 à 100, et verifie
                    //si les vaiables ($i) sont définies.
                    //Ce sont les checkbox des membres du group qui sont nomées par des entiers,
                    //et on suppose qu'il y en aura moins de 100 par pôle.
                    for ($i = 1; $i <= 100; $i++) {
                        if (valider("$i")) {
                            array_push($id_usr_tab, $i);
                        }
                    }
                    if ($grp_id = valider("grp_id")) {
                        if ($tsk_description = valider("tsk_description")) {
                            //tout est vérifié, on peut appeler la fonction de création dans modele.
                            new_task($tsk_title, $tsk_description, $tsk_deadline, $grp_id, $id_usr_tab);
                        }
                    }
                }
            }
            break;

        //Le case edit fonctionne comme le new_task sauf qu'il n'a pas exactement
        // les mêmes paramètres, et appelle edit_task.
        case "edit_task":

            //On valide toutes les valeurs qui viennent par le GET
            if(($tsk_id=valider('tsk_id'))&&($grp_id = valider("grp_id"))&&($tsk_description = valider("tsk_description"))) {
                $id_usr_tab = array();
                //Cette boucle parcours les entiers de 1 à 100, et verifie
                //si les variables ($i) sont définies.
                //Ce sont les checkbox des membres du group qui sont nommées par des entiers,
                //et on suppose qu'il y aura moins de 100 id dans le groupe projet total  
                for ($i = 1; $i <= 100; $i++) {
                    if (valider("$i")) {
                        array_push($id_usr_tab, $i);      
                    }
                }
                if ($tsk_deadline = valider("tsk_deadline")) {
                    //tout est vérifié, on peut appeler la fonction de création dans modele.
                    edit_task($tsk_id, $tsk_description, $tsk_deadline, $grp_id, $id_usr_tab);
                    edit_task((int)$tsk_id, $tsk_description, $tsk_deadline, $grp_id, $id_usr_tab);
                }
				else{
					$tsk_deadline=deadline_task($tsk_id);
					edit_task($tsk_id, $tsk_description, $tsk_deadline, $grp_id, $id_usr_tab);
                    edit_task((int)$tsk_id, $tsk_description, $tsk_deadline, $grp_id, $id_usr_tab);
				}
				
            }
			else{
				 $qs = "?view=task_edition&tsk_id=$tsk_id&msg=" . urlencode("Please enter description");
                }   
                
            
            break;

        //Permet de supprimer une tache.
        case "delete":
            if ($tsk_id = valider("tsk_id")) {
                //fonction créée dans le modele.
                delete_task($tsk_id);
            }
            break;

        //si on est bien le chef de pole, on peut dire que la tache est finie
        case "validate":
            if ($tsk_id = valider("tsk_id")) {
                if ($date = valider("date")) {
                    validate_task($tsk_id, $date);
                    validate_task((int)$tsk_id, $date);
                }
            }
            break;

        case "":
            break;


    }
}
$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
// On redirige vers la page index avec les bons arguments

header("Location:" . $urlBase . $qs);
//qs doit contenir le symbole '?'
ob_end_flush();

