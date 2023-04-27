<?php
/*****************************************************************************************
* Object:      class class_questions_list_controller
* admin/user:  admin
* Scope:	   question
* 
* Feature (maquette): Consult the list of your questions (maq-24) : Display data for each question, with Supp. And Maj Links for each question..
* Trigger:              index.php/$_REQUEST: "question/list"
*
* Major tasks:  get data to display all the questions, 
*               get the keywords used by these questions (to filter on keywords)
*               get all the keywords for the creation part of the div
*
* Use:  class class_questions_list (cf. class_questions_list.php)
*       and the screen view/div_questions_list.php
*******************************************************************************************/

class class_questions_list_controller {

    private $questions_list;  

    public function __construct($login)
    {
        $this->questions_list = new class_questions_list($login);
    }

    public function displayAll(){
        $questionsList = $this->questions_list->getQuestions();        
        $keywordsList = $this->questions_list->getKeywords();       
        $keywordList = $this->questions_list->getAllKeywords(); //select * from keyword
        $title = "Liste de vos questions";
        include "view/div_questions_list.php";
    }
}