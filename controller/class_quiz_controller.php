<?php
/*****************************************************************************************
* Object:      class class_quiz_controller
* admin/user:  admin
* Scope:	   quiz
* 
* Feature (maquette) : Get data and display the Modify screen (cf. view/div_quiz.php) for a quiz (maq-23)
* Trigger: Link "Maj" in div_quiz_list.php>>>index.php/$_REQUEST: "quiz/update"
* 
* Major tasks:  get data to display the quiz,
*               get the not closed sessions using the quiz (the change will impact these sessions),  
*               get the questions (and their keywords for filtering) to associate with the quiz.
*
* Uses:  class class_quiz (cf. class_quiz.php)
*       class_questions_list (cf. class_questions_list.php) : to get the questions (and their keywords) to associate with the quiz 
*       and the screen view/div_quiz.php
*******************************************************************************************/

class class_quiz_controller {

    private $quiz;  
    private $questions_list; 

    public function __construct($id, $login)
    {
        $this->quiz = new class_quiz($id, $login);
        $this->questions_list = new class_questions_list($login);
    }

    public function displayOne(){
        $quiz = []; $quiz = $this->quiz->getQuiz();        
        $questions = [] ; $questions = $this->quiz->getQuestions(); //questions of the quiz
        $sessions = []; $sessions = $this->quiz->getSessions(); //not closed sessions of the quiz

        $questionList = $this->questions_list->getQuestions(); //all the questions
        $keywordList = $this->questions_list->getKeywords(); //keywords used with the questions     
        
        $title = "Mettre à jour ou consulter ce quiz";
        include "view/div_quiz.php";
    }
}