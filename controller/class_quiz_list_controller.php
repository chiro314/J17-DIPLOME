<?php
/*****************************************************************************************
* Object:      class class_quiz_list_controller
* admin/user:  admin
* Scope:	   quiz
* 
* Feature 1 (maquette): Consult the list of your quizzes (maq-21) : Display the data of each quiz as well as its number of sessions and its number of questions; with additional Supp. and Maj links for each quiz.
* Trigger:              index.php/$_REQUEST: "quiz/list"
*
* Feature 2 (maquette): Create a quiz (maq-21) : Display the questions (and their keywords for filtering) to associate with the quiz when it is created.
* Trigger:              Button "Créer un quiz" (data are already loaded : cf. feature 1)
*
* Major tasks:  get data to display all the quizzes, 
*               get the questions (and their keywords for filtering) to associate with the quiz when it is created.
*            
* Uses: class class_quiz_list (cf. class_quiz_list.php)
*       class class_questions_list (cf. class_questions_list.php) : to get the questions that can be associated with the quiz when it is created
*       screen view/div_quiz_list.php
*******************************************************************************************/

class class_quiz_list_controller {

    private $quiz_list;  
    private $questions_list;  

    public function __construct($login)
    {
        $this->quiz_list = new class_quiz_list($login);
        $this->questions_list = new class_questions_list($login);
    }

    public function displayAll(){
        $quizList = $this->quiz_list->getQuiz(); 
        $questionList = $this->questions_list->getQuestions();
        $keywordList = $this->questions_list->getKeywords(); //keywords used with the questions       
        $title = "Liste de vos quiz";
        include "view/div_quiz_list.php";
    }
}