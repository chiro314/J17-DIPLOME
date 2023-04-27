<?php
/*****************************************************************************************
* Object: class class_question_controller
* admin/user:  admin
* Scope:	   question
*
* Features (maquette) : Get data and display the Modify screen (cf. view/div_question.php) for a question (maq-26)
* Triggers: Link "Maj" in div_questions_list.php>>>index.php/$_REQUEST: "question/update"
*              
* Major tasks: display a question for amendment 
* Uses : class class_question in connection with DB (cf. class_question.php)
*******************************************************************************************/

class class_question_controller {

    private $question;  

    public function __construct($id)
    {
        $this->question = new class_question($id);
    }

    public function displayOne(){
        $question = $this->question->getQuestion();        
        $keywordsList = $this->question->getKeywords();  //the keywords of the question     
        $allKeywordsList = $this->question->getAllKeywords(); //select * from keyword
        //$averageSuccessRate = $this->question->getAverageSuccessRate();
        $answers = $this->question->getAnswers();
        //$quiz = [];
        //$quiz = $this->question->getQuiz();

        $title = "Mettre à jour ou consulter cette question";
        include "view/div_question.php";
    }
}


class class_question_average_success_rate_controller {

    private $question_average_success_rate;  

    public function __construct($id)
    {
        $this->question_average_success_rate = new class_question_average_success_rate($id);
    }

    public function displayOne(){
        $averageSuccessRate = $this->question_average_success_rate->getAverageSuccessRate();
        return $averageSuccessRate;
    }
}

class class_quiz_question_average_success_rate_controller {

    private $quizzes_question_average_success_rates;  

    public function __construct($questionid) 
    {
        $this->quizzes_question_average_success_rates = new class_quiz_question_average_success_rate($questionid);
    }

    public function displayAll(){
        $qQaverageSuccessRate = $this->quizzes_question_average_success_rates->getQqAverageSuccessRate();
        return $qQaverageSuccessRate;
    }
}