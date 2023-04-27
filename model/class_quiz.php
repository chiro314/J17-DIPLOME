<?php
/*****************************************************************************************
* Object:      class class_quiz
* admin/user:  admin
* Scope:	   quiz
* 
* Feature (maquette) : Get data for the Modify screen (cf. view/div_quiz.php) for a quiz (maq-23)
* Trigger: Link "Maj" in div_quiz_list.php / index.php/$_REQUEST: "quiz/update" /class class_quiz_controller (class_quiz_controller.php)
* 
* Major tasks:  get data of the quiz (included its questions),
*               get the sessions using the quiz (the change will impact these sessions),  
*******************************************************************************************/

class class_quiz {  
    
    private $quiz;
    private const QUIZID = 0, TITLE= 1, STATUS = 2, LMDATE = 3, SUBTITLE = 4, CRDATE = 5;
    
    private $sessions;
    private const SESSIONID = 0, SSUBTITLE = 1; //new
    private const STITLE = 2, SSTARTDATE = 3, SENDDATE = 4, SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6, SQZDURATION = 7;

    private $questions;
    private const QUESTIONID = 0, QUESTION = 1, WIDGETID = 4, NUMORDER = 5; //STATUS = 2, LMDATE = 3
    private const QUESTIONWEIGHT = 6; //new

    public function __construct($idquiz, $login){
        
        global $conn;
        
        $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status, quiz_creationdate, quiz_lastmodificationdate";
        $sql.= " FROM quiz WHERE quiz_id = $idquiz";

        $result0 = $conn->query($sql);
        if($result0 != null){ // null when the quizid doesn't exist
           
            $row = $result0->fetch_assoc();

            $this->quiz[self::QUIZID] = $row['quiz_id'];
            $this->quiz[self::TITLE] = $row['quiz_title'];
            $this->quiz[self::SUBTITLE] = $row['quiz_subtitle'];
            $this->quiz[self::STATUS] = $row['quiz_status'];
            $this->quiz[self::CRDATE] = $row['quiz_creationdate'];
            $this->quiz[self::LMDATE] = $row['quiz_lastmodificationdate'];
        
            //Get the questions of the quiz
            $sql = "SELECT question_id, question_question, question_status, question_lastmodificationdate, question_idwidget,";
            $sql.= " quiz_question_numorder, quiz_question_weight";
            $sql.= " FROM quiz_question INNER JOIN question ON question_id = quiz_question_idquestion";
            $sql.= " WHERE quiz_question_idquiz = '$idquiz'";
            $sql.= " ORDER BY quiz_question_numorder, quiz_question_weight"; 

            $result2 = $conn->query($sql);

            if($result2 != null){
                $i=0;
                while($row = $result2->fetch_assoc()){ 
                    $this->questions[$i][self::QUESTIONID] = $row['question_id'];
                    $this->questions[$i][self::QUESTION] = $row['question_question'];
                    $this->questions[$i][self::STATUS] = $row['question_status'];
                    $this->questions[$i][self::LMDATE] = $row['question_lastmodificationdate'];
                    $this->questions[$i][self::WIDGETID] = $row['question_idwidget'];
                    $this->questions[$i][self::NUMORDER] = $row['quiz_question_numorder'];
                    $this->questions[$i][self::QUESTIONWEIGHT] = $row['quiz_question_weight'];

                    $i++;
                }
            }

            //Get the sessions of the quiz
            $sql = "SELECT session_id, session_title, session_subtitle, session_startdate, session_enddate,";
            $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration";
            $sql.= " FROM session_quiz INNER JOIN session ON session_id = session_quiz_idsession ";
            $sql.= " WHERE session_quiz_idquiz = '$idquiz'";
            $sql.= " ORDER BY session_enddate DESC"; 
            
            $result2 = $conn->query($sql);

            if($result2 != null){
                $i=0;
                while($row = $result2->fetch_assoc()){ 
                    $this->sessions[$i][self::SESSIONID] = $row['session_id'];///
                    $this->sessions[$i][self::STITLE] = $row['session_title'];//
                    $this->sessions[$i][self::SSUBTITLE] = $row['session_subtitle'];///
                    $this->sessions[$i][self::SSTARTDATE] = $row['session_startdate'];
                    $this->sessions[$i][self::SENDDATE] = $row['session_enddate'];
                    $this->sessions[$i][self::SQZOPENINGDATE] = $row['session_quiz_openingdate'];
                    $this->sessions[$i][self::SQZCLOSINGDATE] = $row['session_quiz_closingdate'];
                    $this->sessions[$i][self::SQZDURATION] = $row['session_quiz_minutesduration'];

                    $i++;
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
        return $this->questions;
    }
    public function getSessions() 
    {
        return $this->sessions;
    }
}