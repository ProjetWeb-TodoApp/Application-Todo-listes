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
    $sql="SELECT user.first_name, user.last_name from user join realize  on  realize.id_user=user.id WHERE realize.id_task=$id_task";
    return parcoursRs(SQLSelect($sql));
}

//Renvoie les taches d'un utilisateur
function prompt_task_user($usr_id) {
    $sql="SELECT t.title, t.description, t.deadline, t.id from task as t join realize as r on r.id_task = t.id where r.id_user=$usr_id";
    return parcoursRs(SQLSelect($sql));
}


function edit_task($grp,$usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){

}
//renvoit la liste des taches qui devraient etre terminees avant la date passée en entrée
//entrée: date(format:"année-mois-jour")
function deadline_task($id){
    $sql="SELECT deadline from task where id=$id";
    return SQLGetChamp($sql);
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

//Renvoie si un user est chef de projet
function is_project_manager($id){
    $sql="SELECT project_manager from user where id=$id";
    return(SQLGetChamp($sql)==1);
}



//Renvoie le group d'un utilisateur
//Renvoie le groupe d'un utilisateur

function prompt_group_user($usr_id) {
    $sql="SELECT groupe.title from belongs join groupe on groupe.id=belongs.id_group where belongs.id_user=$usr_id ";
    SQLSelect($sql);

}



//Renvoie si un user est chef de group
//Renvoie si un user est chef de groupe

function is_group_manager($id){

    if(is_project_manager($id))return True;
    else{
        $sql="SELECT groupe.id_group_manager from groupe join belongs on groupe.id=belongs.id_group where belongs.id_user=$id";
        $grp=SQLGetChamp($sql);
        for ($i=0; $i<count($grp);$i++) {if ($id==$grp[$i]) return true;}
    }
    return False;
}


function grp_members($grp_id){
    $sql="SELECT user.first_name, user.last_name,user.id from user join belongs on user.id=belongs.id_user where belongs.id_group=$grp_id";
    return parcoursRS(SQLSelect($sql));
}


function prompt_grp(){
    $sql="SELECT title, id FROM groupe ";
    return parcoursRS(SQLSelect($sql));
}


function prompt_task($tsk_id){
    $sql="SELECT * FROM task WHERE id=$tsk_id";
    $tab= parcoursRs(SQLSelect($sql));
    $tab["members"]=prompt_user_task($tsk_id);
}