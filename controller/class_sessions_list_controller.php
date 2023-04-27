<?php
/*****************************************************************************************
* Object:      class class_sessions_list_controller
* admin/user:  admin
* Scope:	   session
* 
* Feature (maquette): get data for consulting the list of your sessions (maq-18-19) : view data from each session and quizzes from each session, with Supp. and Maj links for each session.
* Trigger:            Menu button "Vos sessions" / index.php/$_REQUEST: "session/list"
*
* Major tasks:  get data to display all the sessions and their quizzes. 
*                           
* Uses: class class_sessions_list (cf. class_sessions_list.php)
*       screen view/div_sessions_list.php
*******************************************************************************************/

class class_sessions_list_controller {

    private $sessions_list;  

    public function __construct($login)
    {
        $this->sessions_list = new class_sessions_list($login);

    }

    public function displayAll(){
        $sessionsList = $this->sessions_list->getSessions();        
        $title = "Liste de vos sessions";
        include "view/div_sessions_list.php";
    }
}