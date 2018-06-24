<?php

include_once('maLibSQL.pdo.php');


//renvoi rien
//les id des utlisateurs sont rentrés en tableaux dans usr_tab
function new_task($title,$description=null,$deadline,$completion_date=null,$parent_task=null,$id_group,$id_usr_tab){
    $sql="INSERT INTO task (id,title,description,deadline,completion_date,parent_task,id_group) VALUES (7,'$title', '$description', '$deadline', '$completion_date', $parent_task, $id_group)";
    SQLInsert($sql);
    $id_task=SQLGetChamp("SELECT id from task WHERE title='$title' AND description='$description'");
    for ($i=0;$i<count($id_usr_tab);$i++){
        $inser="INSERT INTO realize (id_user,id_task) VALUES($id_usr_tab[$i],$id_task)";
        SQLInsert($inser);
    }

}


//renvoit un tableau des taches à réaliser par groupe
//entree: id du groupe

function prompt_task_group($id_group){
    $sql="SELECT * from task where id_group=$id_group ";
    return parcoursRS(SQLSelect($sql));

}
//renvoit les realisatuers d'une tache
function prompt_user_task($id_task){
    $sql="SELECT * from user join realize  on  realize.id_user=user.id WHERE realize.id_task=$id_task";
    return parcoursRs(SQLSelect($sql));
}

function edit_task($grp,$usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){

}
//renvoit la liste des taches qui devazit etre termine avant la date passée en entrée
//enrrée: date(format:"année-mois-jour")
function late_task($date){
    $sql="SELECT * from task where deadline>'$date'";
    return parcoursRs(SQLSelect($sql));
}

function delete_task($id_task){
    $sql="delete from task where id=$id_task";
    SQLDelete($sql);
}



//renvoit la liste des checklist contenus dans une tache
//prend en entrée l'id de la tache
function prompt_checklist_task($id_task){
    $sql="SELECT title, state from checklist where id_task=$id_task";
    return parcoursRs(SQLSelect($sql));

}
function new_checklist($tsk_id,$etat,$label){

}






function check_user_BDD($login,$password){
    $sql="SELECT login, password,id from user where login='$login '";
    $user = parcoursRS(SQLSelect($sql));
    if ($user[0]["password"]==$password){return $user[0]["id"];}
    else {return false;};
}

function is_project_manager($id){
    $sql="SELECT project_manager from user where id=$id";
    return(SQLGetChamp($sql)==1);
}






function verif_user_BDD(){}


function grp_members($user_id){}
