<?php
/*****************************************************************************************
 * Object:      class class_accountresult_controller
 * admin/user:  user
 * Scope:	    quiz result
 * 
 * Feature 1 (maquettes) :  Consult the result of a quiz (maq-09)
 * Trigger:                 index.php/$_REQUEST: "quizresult/display"
 * 
 * Feature 2 (maquettes) :  Run a quiz (maq-11-12) : get questions and answers and save results
 * Trigger:                 div_takenquiz.php/form_taken_quiz
 * 
 * Major tasks: insertOne, getOne, displayOne
 * Uses:    class accountresult (cf. class_accountresult.php)
 *          and the screen view/div_quizresult.php
 *******************************************************************************************/


class class_accountresult_controller {

    private $accountresult_controller;  

    public function __construct(){
        $this->accountresult_controller = new class_accountresult();
    }

    public function getOne($squizresultId){
        $this->accountresult_controller->getOne($squizresultId);
    }
    
    public function insertOne($loginUser, $idSession, $sessionTitle, $sessionSubtitle,
    $idquiz, $quizTitle, $quizSubtitle, $quizMaxDuration, $quizStartdate, $quizEnddate,
    $quizMaxnbquest, $quizNbquestasked, $questionsResults)
    {
        $this->accountresult_controller->insertOne($loginUser, $idSession, $sessionTitle, $sessionSubtitle,
        $idquiz, $quizTitle, $quizSubtitle, $quizMaxDuration, $quizStartdate, $quizEnddate,
        $quizMaxnbquest, $quizNbquestasked, $questionsResults);
    }

    public function displayOne(){
        $failedquestions = $this->accountresult_controller->getFailedQuestions();
        $quizresult = $this->accountresult_controller->getQuizresult();
        
        $title = "";
        $message="";
        include "view/div_quizresult.php";///////////////////////////
    }
} 