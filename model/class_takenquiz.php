<?php
/*****************************************************************************************
* Object:      class class_takenquiz_controller
* admin/user:  user
* Scope:	   quiz
* 
* Feature (maquette): Run a quiz (with or without time limit) that has just been started (maq-11).
* Trigger:              div_quiz_userlist.php /Button "Commencer" / form_lock_quiz /class class_takenquiz_controller (class_takenquiz_controller.php)
*
* Major tasks:  get data to display and run a quiz,
*               get questions and answers data to run a quiz.
*******************************************************************************************/

class class_takenquiz {

    private $quiz = [
        'sessionId' => 0,
        'sessionTitle' => "",
        'sessionSubtitle' => "",
        'quizId' => 0,
        'quizTitle' => "",
        'quizSubtitle' => "",
        'quizDuration' => 0
    ];

    private $questions = [ [] ]; //all at random (draft)
    private $questionsOnly = []; //questions id (draft)
    private $questionsAnswers = [ [] ]; //all at random but answers grouped by questions


    private const QUESTIONID =0, QUESTION = 1, QUIDELINE = 2, WIDGET = 3, WEIGHT = 4, NUMORDER = 5;
    private const ANSWERSIDQUESTION = 6, ANSWER = 7, ANSWEROK = 8, ANSWERID = 9; 

    public function __construct($sessionId, $quizId){

        global $conn;

        //Getting general information about session and quiz :
        $sqlQuiz = "SELECT";
        $sqlQuiz.= " session_id, session_title, session_subtitle,";
        $sqlQuiz.= " quiz_id, quiz_title, quiz_subtitle, session_quiz_minutesduration";
    
        $sqlQuiz.= " FROM session";
        $sqlQuiz.= " LEFT JOIN session_quiz ON session_id = $sessionId AND session_quiz_idsession = session_id AND session_quiz_idquiz = $quizId";
        $sqlQuiz.= " LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
         
        $sqlQuiz.= " WHERE quiz_status = 'inline'"; 

        $resultQuiz = $conn->query($sqlQuiz);
        if($resultQuiz != null){ // null when no inline quiz 
            $i = 0;
            while($row = $resultQuiz->fetch_assoc()){
                
                $this->quiz['sessionId'] = $row['session_id'];
                $this->quiz['sessionTitle'] = $row['session_title'];
                $this->quiz['sessionSubtitle'] = $row['session_subtitle'];
                $this->quiz['quizId'] = $row['quiz_id'];
                $this->quiz['quizTitle'] = $row['quiz_title'];
                $this->quiz['quizSubtitle'] = $row['quiz_subtitle'];
                $this->quiz['quizDuration'] = $row['session_quiz_minutesduration'];
                
                $i++;
            }

            //Getting questions and answers all at random (with numorder taken into account before random):
            $sqlQuestions = "SELECT";
            $sqlQuestions.= " question_id, question_question, question_guideline, widget_id, quiz_question_weight, quiz_question_numorder,";
            $sqlQuestions.= " answer_idquestion, answer_answer, answer_ok, answer_id";

            $sqlQuestions.= " FROM quiz_question";
            $sqlQuestions.= " LEFT JOIN question ON quiz_question_idquiz = $quizId AND question_id = quiz_question_idquestion";
            $sqlQuestions.= " LEFT JOIN answer ON answer_idquestion = question_id";
            $sqlQuestions.= " LEFT JOIN widget ON  widget_id = question_idwidget";
            $sqlQuestions.= " WHERE question_status = 'inline' AND answer_status = 'inline'"; 
            $sqlQuestions.= " ORDER BY quiz_question_numorder, RAND()"; 

            $resultQuestions = $conn->query($sqlQuestions);
            if($resultQuestions != null){ // null when no inline questions
                unset($row);
                $i  =  0; //ligns counter
                while($row = $resultQuestions-> fetch_assoc()){

                    $this->questions[$i][self::QUESTIONID] = $row['question_id'];
                    $this->questions[$i][self::QUESTION] = $row['question_question'];
                    $this->questions[$i][self::QUIDELINE] = $row['question_guideline'];
                    $this->questions[$i][self::WIDGET] = $row['widget_id'];
                    $this->questions[$i][self::WEIGHT] = $row['quiz_question_weight'];
                    $this->questions[$i][self::NUMORDER] = $row['quiz_question_numorder'];
                   
                    $this->questions[$i][self::ANSWERSIDQUESTION] = $row['answer_idquestion'];
                    $this->questions[$i][self::ANSWER] = $row['answer_answer'];
                    $this->questions[$i][self::ANSWEROK] = $row['answer_ok'];
                    $this->questions[$i][self::ANSWERID] = $row['answer_id'];

                    $i++; //for the next lign
                }
                //Get only the questions (at random) :
                /*
                $sqlQuestionsOnly = "SELECT question_id";
                $sqlQuestionsOnly.= " FROM quiz_question, question";
                $sqlQuestionsOnly.= " WHERE question_status = 'inline'";
                $sqlQuestionsOnly.= " AND quiz_question_idquiz = $quizId";
                $sqlQuestionsOnly.= " AND question_id = quiz_question_idquestion";
                $sqlQuestionsOnly.= " ORDER BY RAND()";
                */
                $sqlQuestionsOnly = "SELECT question_id";
                $sqlQuestionsOnly.= " FROM quiz_question, question";
                $sqlQuestionsOnly.= " WHERE question_status = 'inline'";
                $sqlQuestionsOnly.= " AND quiz_question_idquiz = $quizId";
                $sqlQuestionsOnly.= " AND question_id = quiz_question_idquestion";
                $sqlQuestionsOnly.= " ORDER BY quiz_question_numorder, RAND()";

                $resultQuestionsOnly = $conn->query($sqlQuestionsOnly);
                unset($row);
                $i  =  0; //ligns counter
                while($row = $resultQuestionsOnly-> fetch_assoc()){ 
                    $this->questionsOnly[$i] = $row['question_id'];
                    $i++;
                }
            
                // Building $questionsAnswers=[[]] : all at random and numorder still taken into account, but answers grouped by questions :
                $questionsWork = $this->questions;
                $iQuestionsAnswers = 0;
                for($i=0;$i<count($this->questionsOnly);$i++){
                    $nextQuestion = false;
                    while(!$nextQuestion){
                        $found = false;
                        for($j=0;$j<count($questionsWork);$j++){
                            if($this->questionsOnly[$i] == $questionsWork[$j][self::ANSWERSIDQUESTION]){
                                $this->questionsAnswers[$iQuestionsAnswers] = $questionsWork[$j];
                                array_splice ($questionsWork, $j, 1);
                                $iQuestionsAnswers++;
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) $nextQuestion = true;
                    }
                }
            }
        }    
    }

    public function getQuiz() 
    {
        return $this->quiz;
    }
    public function getQuestions() 
    {
        return $this->questionsAnswers;
    }
}