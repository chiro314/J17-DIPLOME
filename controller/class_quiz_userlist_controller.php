<?php
/*****************************************************************************************
* Object:      class class_quiz_userlist_controller
* admin/user:  user
* Scope:	   quiz (dashboard)
* 
* Feature (maquette): Consult the list of sessions and quizzes (maq-08)
* Trigger:            Button menu "Vos quiz" /index.php/$_REQUEST: "quiz/userlist"
*
* Major tasks:  get data to display all the sessions and their quizzes for a user 
*            
* Uses: class class_quiz_userlist (cf. class_quiz_userlist.php)
*       screen view/div_quiz_userlist.php
*******************************************************************************************/

class class_quiz_userlist_controller {

    private $quiz_userlist;  

    public function __construct($login)
    {
        $this->quiz_userlist = new class_quiz_userlist($login);
    }

    public function displayAll(){
        $quiz = $this->quiz_userlist->getAll();
        $title = "Liste de vos quiz classés par sessions";
        //$message="";
        include "view/div_quiz_userlist.php";
    }
} 