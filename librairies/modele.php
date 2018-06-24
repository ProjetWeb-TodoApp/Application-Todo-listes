<?php

include_once('maLibSQL.pdo.php');


//renvoi rien
//les id des utlisateurs sont rentrés en tableaux dans usr_tab
function new_task($grp,$id_usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){}

function new_checklist($tsk_id,$etat,$label){}

function edit_task($grp,$usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){}

//field_tab correspond aux champs que l'on veut afficher en tableau
function prompt_task_group($group,$order_by=null){
    $sql='SELECT * from task where group=$group ';
    SQLSelect($sql);


}

function prompt_task_user($user,$order_by=null){}


function prompt_checklist_task(){}

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
function late_task(){}

function delete_task(){}

