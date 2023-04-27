<?php
/*****************************************************************************************
* Object:      class class_takenquiz_controller
* admin/user:  user
* Scope:	   quiz
* 
* Feature (maquette): Run a quiz (with or without time limit) that has just been started (maq-11).
* Trigger:              div_quiz_userlist.php /Button "Commencer" / form_lock_quiz
*
* Major tasks:  get data to display and run a quiz,
*               get questions and answers data to run a quiz.
*            
* Uses: class class_takenquiz (cf. class_takenquiz.php)
*       screen view/div_takenquiz.php
*******************************************************************************************/

class class_takenquiz_controller {

    private $takenquiz;

    public function __construct($sessionId, $quizId)
    {
        $this->takenquiz = new class_takenquiz($sessionId, $quizId);
    }

    public function displayOne(){
        $quiz = $this->takenquiz->getQuiz();
        $questions = $this->takenquiz->getQuestions();
        
        include "view/div_takenquiz.php";
    }
} 