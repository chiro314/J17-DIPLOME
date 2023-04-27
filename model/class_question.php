<?php
/*****************************************************************************************
* Object: class class_question
* admin/user:  admin
* Scope:	   question
*
* Features (maquette) : Get data for the Modify screen (cf. view/div_question.php) of a question (maq-26)
* Triggers: Link "Maj" in div_questions_list.php>>>index.php/$_REQUEST: "question/update" / class class_question_controller (class_question_controller.php)
*              
* Major DB operations:  Get data for the question display for amendment (include answers, keywords and quizzes)
*                       Get data to calculate the question average success rate for each quiz
*                       Get data to calculate the global question average success rate
*******************************************************************************************/

class class_question {

    private $question;
    //private $average_success_rate = ['nbok' => 0, 'nb' => 0];
    private $keywords_list; //keyword ids for this question 
    private $all_keywords_list;
    private $answers;
    //private $quiz;
    
    private const QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4;
    private const GUIDELINE = 5, EXPLANATIONTITLE = 6, EXPLANATION = 7;
    private const CREATIONDATE = 8;

    private const KEYWORDID = 0, KEYWORD = 1;

    private const ANSWER = 0, ANSWEROK = 1,  aCREATIONDATE = 4, ANSWERID = 5; //STATUS = 2, LMDATE = 3

    private const QUIZID = 0, TITLE= 1; // STATUS = 2, LMDATE = 3
    private const SUBTITLE = 4, NUMOK = 5, NUM = 6;

    public function __construct($idquestion){
        global $conn, $login;
        
        $sql = "SELECT question_id, question_question, question_guideline, question_explanationtitle, question_explanation,";
        $sql.= " question_status, question_creationdate, question_lastmodificationdate, question_idwidget";
        $sql.= " FROM question WHERE question_id = $idquestion";

        $result0 = $conn->query($sql);
        if($result0 != null){ // null when the questionid doesn't exist
           
            $row = $result0->fetch_assoc();

            $this->question[self::QUESTIONID] = $row['question_id'];
            $this->question[self::QUESTION] = $row['question_question'];
            $this->question[self::STATUS] = $row['question_status'];
            $this->question[self::LMDATE] = $row['question_lastmodificationdate'];
            $this->question[self::CREATIONDATE] = $row['question_creationdate'];
            $this->question[self::WIDGETID] = $row['question_idwidget'];
            $this->question[self::GUIDELINE] = $row['question_guideline'];
            $this->question[self::EXPLANATIONTITLE] = $row['question_explanationtitle'];
            $this->question[self::EXPLANATION] = $row['question_explanation'];

            //keywords of the question
            $sql = "SELECT DISTINCT keyword_id , keyword_word";
            $sql.= " FROM question_keyword INNER JOIN keyword ON question_keyword_idkeyword = keyword_id";
            $sql.= " WHERE question_keyword_idquestion = $idquestion";
            $sql.= " ORDER BY keyword_word ASC"; 

            $result1 = $conn->query($sql);

            if($result1 != null){
                $i=0;
                while($row = $result1->fetch_assoc()){ 
                    /*
                    $this->keywords_list[$i][self::KEYWORDID] = $row['keyword_id'];
                    $this->keywords_list[$i][self::KEYWORD] = $row['keyword_word'];
                    */
                    $this->keywords_list[$i] = $row['keyword_id'];

                    $i++;
                }
            }
        
            //Get all keywords  :
            $sql = "SELECT keyword_id , keyword_word FROM keyword";
            $sql.= " WHERE keyword_loginadmin = '$login'";
            $sql.= " ORDER BY keyword_word ASC"; 
            $result2 = $conn->query($sql);

            //$this->all_keywords_list[0][self::KEYWORDID] = 0;
            //$this->all_keywords_list[0][self::KEYWORD] = 'Aucun';
            if($result2 != null){
                //$i=1;
                $i=0;
                while($row = $result2->fetch_assoc()){ 
                    $this->all_keywords_list[$i][self::KEYWORDID] = $row['keyword_id'];
                    $this->all_keywords_list[$i][self::KEYWORD] = $row['keyword_word'];

                    $i++;
                }
            }

            //Get the answers :
            $sql = "SELECT answer_id, answer_answer, answer_ok, answer_status, answer_creationdate, answer_lastmodificationdate";
            $sql.= " FROM answer WHERE answer_idquestion = $idquestion";
            $sql.= " ORDER BY answer_lastmodificationdate DESC"; 
            $result3 = $conn->query($sql);

            if($result3 != null){
                $i=0;
                while($row = $result3->fetch_assoc()){ 
                    $this->answers[$i][self::ANSWER] = $row['answer_answer'];/////aANSWER
                    $this->answers[$i][self::ANSWEROK] = $row['answer_ok'];////aANSWEROK
                    $this->answers[$i][self::STATUS] = $row['answer_status'];/////STATUS
                    $this->answers[$i][self::LMDATE] = $row['answer_lastmodificationdate'];///LMDATE
                    $this->answers[$i][self::aCREATIONDATE] = $row['answer_creationdate'];///*aCREATIONDATE
                    $this->answers[$i][self::ANSWERID] = $row['answer_id'];/////*aANSWERID

                    $i++;
                }
            }

            //Get each quiz using this question, with or without stat :
            /*
            $sql = "(SELECT a.questionstat_idquiz, quiz_title, quiz_subtitle, quiz_status, quiz_lastmodificationdate,";
            $sql.= " COUNT(*) AS nbresults,";

            $sql.= " (SELECT COUNT(*) FROM questionstat AS b";
            $sql.= " WHERE b.questionstat_idquestion = 68 AND b.questionstat_ok = 1";
            $sql.= " AND b.questionstat_idquiz = a.questionstat_idquiz) AS nbok";

            $sql.= " FROM questionstat AS a LEFT JOIN quiz ON quiz_id = a.questionstat_idquiz";
            $sql.= " WHERE a.questionstat_idquestion = $idquestion";
            $sql.= " GROUP BY a.questionstat_idquiz";
            $sql.= " ORDER BY a.questionstat_idquiz";
            
            $sql.= " ) UNION ("; //questions without stat :

            $sql.= " SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status,";
            $sql.= " quiz_lastmodificationdate, NULL, NULL FROM quiz";
            $sql.= " WHERE quiz_id IN"; //in quiz_question but not in questionstat :

            $sql.= " (SELECT quiz_question_idquiz FROM quiz_question";
            $sql.= " WHERE quiz_question_idquestion = $idquestion";
            $sql.= " EXCEPT";
            $sql.= " SELECT questionstat_idquiz FROM questionstat";
            $sql.= " WHERE questionstat_idquestion = $idquestion) )";

            $result4 = $conn->query($sql);
            if($result4 != null){
                $i=1;
                while($row = $result4->fetch_assoc()){ 
                    $this->quiz[$i][self::QUIZID] = $row['questionstat_idquiz'];/////*QUIZID
                    $this->quiz[$i][self::TITLE] = $row['quiz_title'];////*TITLE
                    $this->quiz[$i][self::STATUS] = $row['quiz_status'];///STATUS
                    $this->quiz[$i][self::LMDATE] = $row['quiz_lastmodificationdate'];///LMDATE
                    $this->quiz[$i][self::SUBTITLE] = $row['quiz_subtitle'];/////*SUBTITLE

                    $this->quiz[$i][self::NUMOK] = $row['nbok'];/////*NUMOK
                    $this->quiz[$i][self::NUM] = $row['nbresults'];/////*NUM

                    $i++;
                }
            }
            */

            //Get the average success rate :
            /*
            //Get the number of ok :
            $sql = "SELECT COUNT(questionstat_ok) AS ok FROM questionstat"; 
            $sql.= " WHERE questionstat_idquestion = $idquestion AND questionstat_ok = 1";
            $result5 = $conn->query($sql);
            if($result5 != null){
                $row = $result5->fetch_assoc();
                $this->average_success_rate['nbok'] = $row['ok'];
            }
            else{
                $this->average_success_rate['nbok'] = "";
            }
            //Get the total number of answers (ok + ko) :
            $sql = "SELECT COUNT(questionstat_ok) AS nb FROM questionstat"; 
            $sql.= " WHERE questionstat_idquestion = $idquestion";
            $result6 = $conn->query($sql);
            if($result6 != null){
                $row = $result6->fetch_assoc();
                $this->average_success_rate['nb'] = $row['nb'];
            }
            else{
                $this->average_success_rate['nb'] = "";
            }
            */
        }
    }

    public function getQuestion() 
    {
        return $this->question;
    }
    public function getKeywords() 
    {
        return $this->keywords_list;
    }
    public function getAllKeywords() 
    {
        return $this->all_keywords_list;
    }
    /*
    public function getAverageSuccessRate() 
    {
        return $this->average_success_rate;
    }
    */
    public function getAnswers() 
    {
        return $this->answers;
    }
    /*
    public function getQuiz() 
    {
        return $this->quiz;
    }
    */
}

class class_question_average_success_rate {

    private $average_success_rate = ['nbok' => 0, 'nb' => 0];

    public function __construct($idquestion){
        global $conn, $login;
        
        //Get the average success rate :

        //Get the number of ok :
        $sql = "SELECT COUNT(questionstat_ok) AS ok FROM questionstat"; 
        $sql.= " WHERE questionstat_idquestion = $idquestion AND questionstat_ok = 1";
        $result5 = $conn->query($sql);
        if($result5 != null){
            $row = $result5->fetch_assoc();
            $this->average_success_rate['nbok'] = $row['ok'];
        }
        else{
            $this->average_success_rate['nbok'] = "";
        }
        //Get the total number of answers (ok + ko) :
        $sql = "SELECT COUNT(questionstat_ok) AS nb FROM questionstat"; 
        $sql.= " WHERE questionstat_idquestion = $idquestion";
        $result6 = $conn->query($sql);
        if($result6 != null){
            $row = $result6->fetch_assoc();
            $this->average_success_rate['nb'] = $row['nb'];
        }
        else{
            $this->average_success_rate['nb'] = "";
        }
    }

    public function getAverageSuccessRate() 
    {
        return $this->average_success_rate;
    }
}

class class_quiz_question_average_success_rate {

    private $qq_average_success_rate = [];

    public function __construct($idquestion){
        
        global $conn;
        
        //Get each quiz using this question, with or without stat :
            
        $sql = "(SELECT a.questionstat_idquiz, quiz_title, quiz_subtitle, quiz_status, quiz_lastmodificationdate,";
        $sql.= " COUNT(*) AS nbresults,";

        $sql.= " (SELECT COUNT(*) FROM questionstat AS b";
        $sql.= " WHERE b.questionstat_idquestion = $idquestion AND b.questionstat_ok = 1";
        $sql.= " AND b.questionstat_idquiz = a.questionstat_idquiz) AS nbok";

        $sql.= " FROM questionstat AS a LEFT JOIN quiz ON quiz_id = a.questionstat_idquiz";
        $sql.= " WHERE a.questionstat_idquestion = $idquestion";
        $sql.= " GROUP BY a.questionstat_idquiz";
        $sql.= " ORDER BY a.questionstat_idquiz";
            
        $sql.= ") UNION ("; //questions without stat :

        $sql.= "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status,";
        $sql.= " quiz_lastmodificationdate, NULL, NULL FROM quiz";
        $sql.= " WHERE quiz_id IN"; //in quiz_question but not in questionstat :

        $sql.= " (SELECT quiz_question_idquiz FROM quiz_question";
        $sql.= " WHERE quiz_question_idquestion = $idquestion";
        $sql.= " EXCEPT";
        $sql.= " SELECT questionstat_idquiz FROM questionstat";
        $sql.= " WHERE questionstat_idquestion = $idquestion))";

        $result4 = $conn->query($sql);
        if($result4 != null){
            $i=0;
            while($row = $result4->fetch_assoc()){ 
                $this->qq_average_success_rate[$i]['title'] = $row['quiz_title'].($row['quiz_subtitle'] ? " - ".$row['quiz_subtitle'] : "");
                $this->qq_average_success_rate[$i]['status'] = $row['quiz_status'];
                $this->qq_average_success_rate[$i]['lmd'] = $row['quiz_lastmodificationdate'];

                $this->qq_average_success_rate[$i]['nbok'] = $row['nbok'];
                $this->qq_average_success_rate[$i]['nbresults'] = $row['nbresults'];

                $i++;
            }
        }
    }

    public function getQqAverageSuccessRate() 
    {
        return $this->qq_average_success_rate;
    }
}