<?php
//renvoi rien
//les id des utlisateurs sont rentrés en tableaux dans usr_tab
function new_task($grp,$id_usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){}

function new_checklist($tsk_id,$etat,$label){}

function edit_task($grp,$usr_tab,$label,$chef=null,$description=null,$deadline,$grp_id,$parent=null){}

//field_tab correspond aux champs que l'on veut afficher en tableau
function affiche_task_group($field_tab,$order_by=null){}

function affiche_task_user($field_tab,$order_by=null){}


function affiche_checklist_task(){}

function verif_user_BDD(){}

function late_task(){}

function delete_task(){}

