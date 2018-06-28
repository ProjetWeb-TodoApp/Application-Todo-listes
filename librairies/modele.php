<?php

include_once('maLibSQL.pdo.php');


//renvoi rien
//les id des utlisateurs sont rentrés en tableaux dans usr_tab

function new_task($title, $description = null, $deadline, $id_group, $id_usr_tab)
{
    $sql = "INSERT INTO task (title,description,deadline,id_group) VALUES ('$title', '$description', '$deadline' ,'$id_group')";
    echo "$sql";
    SQLInsert($sql);

    $id_task = SQLGetChamp("SELECT id from task WHERE title='$title' AND description='$description'");
    echo "$id_task";
    for ($i = 0; $i < count($id_usr_tab); $i++) {
        echo "$id_usr_tab[$i]";
        $inser = "INSERT INTO realize (id_user,id_task) VALUES($id_usr_tab[$i],$id_task)";
        SQLInsert($inser);
    }

}


//renvoit un tableau des taches à réaliser par groupe
//entree: id du groupe

function prompt_task_group($id_group)
{
    $sql = "SELECT * from task where id_group=$id_group ";
    return parcoursRS(SQLSelect($sql));

}

//renvoit les realisatuers d'une tache
function prompt_user_task($id_task)
{
    $sql = "SELECT user.first_name, user.last_name, user.id from user join realize on realize.id_user=user.id WHERE realize.id_task='$id_task'";
    return parcoursRs(SQLSelect($sql));
}

//Renvoie les taches d'un utilisateur
function prompt_task_user($usr_id)
{
    $sql = "SELECT t.title, t.description, t.deadline, t.id from task as t join realize as r on r.id_task = t.id where r.id_user=$usr_id";
    return parcoursRs(SQLSelect($sql));
}


function edit_task($id_task, $description, $deadline, $id_group, $id_usr_tab)
{
    $sql = "UPDATE task SET description= '$description',deadline='$deadline',id_group=$id_group WHERE id=$id_task";

    SQLUpdate($sql);

    $del = "DELETE FROM realize where id_task=$id_task";
    SQLDelete($del);
    for ($i = 0; $i < count($id_usr_tab); $i++) {

        $inser = "INSERT INTO realize (id_user,id_task) VALUES($id_usr_tab[$i],$id_task)";
        SQLInsert($inser);
    }
}


function dont_realize_tsk($id_usr, $id_tsk)
{
    $sql = "SELECT * FROM realize WHERE id_user='$id_usr' AND id_task='$id_tsk'";
    return (SQLGetChamp($sql) == False);

}

//renvoit la liste des taches qui devraient etre terminees avant la date passée en entrée
//entrée: date(format:"année-mois-jour")
function deadline_task($id)
{
    $sql = "SELECT deadline from task where id=$id";
    return SQLGetChamp($sql);
}

function delete_task($id_task)
{
    $sql = "delete from task where id=$id_task";
    SQLDelete($sql);
}


//renvoit la liste des checklist contenus dans une tache
//prend en entrée l'id de la tache
function prompt_checklist_task($id_task)
{
    $sql = "SELECT title, state from checklist where id_task=$id_task";
    return parcoursRs(SQLSelect($sql));

}

function new_checklist($tsk_id, $etat, $label)
{

}


function check_user_BDD($login, $password)
{
    $sql = "SELECT login, password,id from user where login='$login '";
    $user = parcoursRS(SQLSelect($sql));
    if ($user[0]["password"] == $password) {
        return $user[0]["id"];
    } else {
        return false;
    }
}

//Renvoie si un user est chef de projet
function is_project_manager($id)
{
    $sql = "SELECT project_manager from user where id=$id";
    return (SQLGetChamp($sql) == 1);
}


//Renvoie le group d'un utilisateur
//Renvoie le groupe d'un utilisateur

function prompt_group_user($usr_id)
{
    $sql = "SELECT groupe.id from belongs join groupe on groupe.id=belongs.id_group where belongs.id_user=$usr_id ";
    return SQLGetChamp($sql);

}


//Si un id_groupe est soumis, renvoie true si une personne est manager de ce groupe
// Sinon renvoie true si la personne est manager d'un groupe

function is_group_manager($id_user, $id_groupe = null)
{
    if (is_project_manager($id_user)) return True;
    else {
        if ($id_groupe != null) {
            $sql = "SELECT groupe.id FROM groupe JOIN belongs ON groupe.id=belongs.id_group WHERE belongs.id_user=$id_user AND belongs.id_group=$id_groupe";
            $grp = SQLSelect($sql);
            if ($grp) {
                return (true);
            }
        } else {
            $sql = "SELECT id from groupe WHERE id_group_manager=$id_user";
            $grp = SQLSelect($sql);
            if ($grp) {
                return (true);
            }
        }

    }
    return False;
}


function grp_members($grp_id)
{
    $sql = "SELECT user.first_name, user.last_name,user.id from user join belongs on user.id=belongs.id_user where belongs.id_group=$grp_id";
    return parcoursRS(SQLSelect($sql));
}


function prompt_grp()
{
    $sql = "SELECT title, id FROM groupe ";
    return parcoursRS(SQLSelect($sql));
}


function prompt_task($tsk_id)
{
    $sql = "SELECT * FROM task WHERE id='$tsk_id'";
    $tab = parcoursRs(SQLSelect($sql));
    $tab["members"] = prompt_user_task($tsk_id);
    return $tab;
}

// cette fonction prend en argument la date de réalisation de la tâche  et son id et modifie la base de données en conséquence
function validate_task($tsk_id, $date)
{
    $sql = "update task set completion_date='$date' where id='$tsk_id'";
    SQLUpdate($sql);
}

// cette fonction prend en argument l'id d'une tâche et renvoie un booléen correspondant à l'état de la tâche, réalisée ou non
function is_done($tsk_id)
{
    $sql = "select completion_date from task where id='$tsk_id' and completion_date is not null";
    $date = SQLSelect($sql);
    if ($date == NULL) return false;
    return true;
}

// cette fonction prend en argument l'id d'un user et d'une tâche et renvoie un booléen : true si l'utilisateur est assigné à la tâche, false sinon

function is_task_member($tsk_id, $usr_id)
{
    $tab_members = prompt_user_task($tsk_id); // on récupère la liste des réalisateurs de la tâche
    foreach ($tab_members as $member) {
        if ($member["id"] == $usr_id) return true;
    }
    return false;

}

function task_group($task_id){
    $sql="select id_group from task where id=$task_id";
    SQLGetChamp($sql);
}