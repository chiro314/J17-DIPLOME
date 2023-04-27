<?php
/*****************************************************************************************
* Object:      class class_accountresult
* admin/user:  user
* Scope:	   quiz result
* 
* Feature 1 (maquettes) :  Consult the result of a quiz (maq-09)
* Trigger:                 index.php/$_REQUEST: "quizresult/display" /class class_accountresult_controller (class_accountresult_controller.php)
* 
* Feature 2 (maquettes) :  Run a quiz (maq-11-12) : get questions and answers and save results 
* Trigger:                 div_takenquiz.php/form_taken_quiz /class class_accountresult_controller (class_accountresult_controller.php)
* 
* Major DB operations : insertOne, getOne (quiz results and failed questions with their explanations)
*******************************************************************************************/

class class_accountresult {

    //private $failedquestions = [ [] ]; 
    private $failedquestions;  // on demand with getFailedQuestions()

    private $quizresult = [   //on demand with getQuizresults() or on return of insertOne() and getOne()
        'quizresultId' => 0, 

        'loginUser' => "",
        
        'idSession' => 0,
        'sessionTitle' => "",
        'sessionSubtitle' => "",

        'idQuiz' => 0,

        'quizTitle' => "", 
        'quizSubtitle' => "",
        'quizMaxDuration' => 0, //Duration imposed by the trainer
        'quizStartdate' => 0,
        'quizEnddate' => 0,
        'quizMaxnbquest' => 0,
        'quizNbquestasked' => 0, //If the quiz is time limited and this time reached before the end of the quiz.
        'quizQuestaskedscore' => 0,    //A mark is calculated on the basis of the questions asked,
        'quizMaxquestaskedscore' => 0, //brought back to the maximum score reachable with those questions.
                                       //This relative mark is quizQuestaskedscore / quizMaxquestaskedscore
        'quizMaxscore' => 0, //The real mark is brought back to the maximum score reachable with all the questions.
                             //The real mark is quizQuestaskedscore / quizMaxscore
    ];

    ////////////////////////////////////////////////private const/////////////////////////////////////////////////////

    private const QUESTIONID =0, QUESTION = 1, QUIDELINE = 2, WIDGET = 3; //widget_id 
    private const WEIGHT = 4, NUMORDER = 5, ANSWERSIDQUESTION = 6, ANSWER = 7, ANSWEROK = 8; 

    private const OKKO = 1, WIDNAME = 2; //widget_id 
    private const OK = 1, KO = 0;

    private const QUESTIONKO = 0, EXPLANATIONTITLE = 1, EXPLANATION = 2;

    //insertOne() / $questionsResults [[]]:
    private const dqrWIDGETID = 0, dqrQUESTIONID = 1, dqrOKKOQUESTION = 2;

    ////////////////////////////////////////////////getOne (existing result)///////////////////////////////////////

    public function getOne($squizresultId){  //get an existing result
        global $conn, $login;

        //Get the data :
        $sql = "SELECT quizresult_sessiontitle,quizresult_sessionsubtitle, quizresult_quiztitle, quizresult_quizsubtitle,";
        $sql.= " quizresult_firstnameadmin, quizresult_loginadmin, quizresult_nameadmin,";
        $sql.= " quizresult_startdate, quizresult_enddate, quizresult_maxduration, quizresult_nbquestasked,";
        $sql.= " quizresult_maxnbquest, quizresult_questaskedscore, quizresult_maxquestaskedscore, quizresult_maxscore,";
        $sql.= " quizresult_loginuser, quizresult_idsession, quizresult_idquiz";
        $sql.= " FROM quizresult WHERE quizresult_id = $squizresultId";
        
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $this->quizresult['quizresultId'] = $squizresultId;
        $this->quizresult['loginUser'] = $row['quizresult_loginuser'];
        $this->quizresult['idSession'] = $row['quizresult_idsession'];
        $this->quizresult['sessionTitle'] = $row['quizresult_sessiontitle'];
        $this->quizresult['sessionSubtitle'] = $row['quizresult_sessionsubtitle'];
        $this->quizresult['idQuiz'] = $row['quizresult_idquiz'];
        $this->quizresult['quizTitle'] = $row['quizresult_quiztitle'];
        $this->quizresult['quizSubtitle'] = $row['quizresult_quizsubtitle'];
        $this->quizresult['quizMaxDuration'] = $row['quizresult_maxduration'];
        $this->quizresult['quizStartdate'] = $row['quizresult_startdate'];
        $this->quizresult['quizEnddate'] = $row['quizresult_enddate'];
        $this->quizresult['quizMaxnbquest'] = $row['quizresult_maxnbquest'];
        $this->quizresult['quizNbquestasked'] = $row['quizresult_nbquestasked'];
        $this->quizresult['quizQuestaskedscore'] = $row['quizresult_questaskedscore'];
        $this->quizresult['quizMaxquestaskedscore'] = $row['quizresult_maxquestaskedscore'];
        $this->quizresult['quizMaxscore'] = $row['quizresult_maxscore'];
        
        //Get in $This->failedquestions the questions ko and their explanations :
        $sql = "SELECT question_question, question_explanationtitle, question_explanation"; 
        $sql.= " FROM quizresult_questionko, question";              
        $sql.= " WHERE quizresult_questionko_idquizresult = $squizresultId"; 
        $sql.= " AND question_id = quizresult_questionko_idquestion";
        $sql.= " AND question_explanation IS NOT NULL";

        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
            $i=0;
            while($row = $result-> fetch_assoc()){
                $this->failedquestions[$i][self::QUESTIONKO] = $row['question_question'];
                $this->failedquestions[$i][self::EXPLANATIONTITLE] = $row['question_explanationtitle'];
                $this->failedquestions[$i][self::EXPLANATION] = $row['question_explanation'];

                $i++;
            } 
        }
        return $this->quizresult['quizresultId'];
    }
    /////////////////////////////////////////////////////////insertOne (new result) //////////////////////////////
    
    public function insertOne($loginUser, $idSession, $sessionTitle, $sessionSubtitle,
    $idquiz, $quizTitle, $quizSubtitle, $quizMaxDuration, $quizStartdate, $quizEnddate,
    $quizMaxnbquest, $quizNbquestasked, $questionsResults){

        global $conn, $login;
      
        //$maxscore : get the quiz_question_weight from quiz_question for every questions of the quiz
        $sql = "SELECT SUM(quiz_question_weight) AS maxscore FROM quiz_question";
        $sql.= " WHERE quiz_question_idquiz = $idquiz";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $maxscore = $row['maxscore'];
            
        //$maxscore : get the quiz_question_weight from quiz_question only for questions asked
        //using $questionsResults (questions asked and their score okko)
        $in = "";
        for($i=0;$i<count($questionsResults);$i++){
            $in.= $questionsResults[$i][self::dqrQUESTIONID].",";
        }
        $in = substr($in, 0, -1); //get the last ',' away
            
        if($in=="") $maxquestaskedscore = 0;
        else {
            $sql = "SELECT SUM(quiz_question_weight) AS maxquestaskedscore FROM quiz_question";
            $sql.= " WHERE quiz_question_idquiz = $idquiz";
            $sql.= " AND quiz_question_idquestion IN ($in)";
      
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $maxquestaskedscore = $row['maxquestaskedscore'];
        }

        //$questaskedscore : get the quiz_question_weight only for questions ok
        //using $questionsResults (questions asked and their score okko)
        $in = "";
        for($i=0;$i<count($questionsResults);$i++){
            if($questionsResults[$i][self::dqrOKKOQUESTION]) $in.= $questionsResults[$i][self::dqrQUESTIONID].",";
        }
        $in = substr($in, 0, -1); //get the last ',' away

        if($in=="") $questaskedscore = 0;
        else {
        //echo "in : ".$in;       
            $sql = "SELECT SUM(quiz_question_weight) AS questaskedscore FROM quiz_question";
            $sql.= " WHERE quiz_question_idquiz = $idquiz";
            $sql.= " AND quiz_question_idquestion IN ($in)";
        //echo $sql;
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $questaskedscore = $row['questaskedscore'];
        }

        //INSERT :
        $sql ="INSERT INTO quizresult (quizresult_sessiontitle, quizresult_quiztitle,";
        $sql.=" quizresult_startdate, quizresult_enddate, quizresult_maxduration,";
        $sql.=" quizresult_nbquestasked, quizresult_maxnbquest, quizresult_questaskedscore,";
        $sql.=" quizresult_maxquestaskedscore, quizresult_maxscore, quizresult_loginuser,";
        $sql.=" quizresult_idsession, quizresult_idquiz) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssiiiiiiiisii", $sessionTitle, $quizTitle,
            $quizStartdate, $quizEnddate, $quizMaxDuration,
            $quizNbquestasked, $quizMaxnbquest, $questaskedscore,
            $maxquestaskedscore, $maxscore, $login,
            $idSession, $idquiz);
        $stmt->execute();
        $stmt->close();

        //update the object ($quizresult) : 
        //$this->quizresult['quizresultId'] = $squizresultId;
        $this->quizresult['loginUser'] = $login;
        $this->quizresult['idSession'] = $idSession;
        $this->quizresult['sessionTitle'] = $sessionTitle;
        //$this->quizresult['sessionSubtitle'] = $row['quizresult_sessionsubtitle'];
        $this->quizresult['idQuiz'] = $idquiz;
        $this->quizresult['quizTitle'] = $quizTitle;
        //$this->quizresult['quizSubtitle'] = $row['quizresult_quizsubtitle'];
        $this->quizresult['quizMaxDuration'] = $quizMaxDuration;
        $this->quizresult['quizStartdate'] = $quizStartdate;
        $this->quizresult['quizEnddate'] = $quizEnddate;
        $this->quizresult['quizMaxnbquest'] = $quizMaxnbquest;
        $this->quizresult['quizNbquestasked'] = $quizNbquestasked;
        $this->quizresult['quizQuestaskedscore'] = $questaskedscore;
        $this->quizresult['quizMaxquestaskedscore'] = $maxquestaskedscore;
        $this->quizresult['quizMaxscore'] = $maxscore;

        //get back the quizresultId :
        $sql = "SELECT quizresult_id FROM quizresult WHERE quizresult_loginuser = '$login' AND quizresult_idsession = $idSession AND quizresult_idquiz = $idquiz";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $this->quizresult['quizresultId'] = $row['quizresult_id'];

        $quizresult_id = $row['quizresult_id'];

        //Update quizresult_questionko :
        /*
        array (size=3)
        0 => 
        array (size=3)
            0 => string '1' (length=1)
            1 => string '1' (length=1)
            2 => string 'radio' (length=5)
        1 => 
        array (size=3)
            0 => string '2' (length=1)
            1 => string '1' (length=1)
            2 => string 'radio' (length=5)
        2 => 
        array (size=3)
            0 => string '3' (length=1)
            1 => string '1' (length=1)
            2 => string 'radio' (length=5)
        */

        //$INSERT the questions ko (using $questionsResults : question asked id, score okko, and widget)            
        //get the questions ko : 
        $into = "";
        for($i=0;$i<count($questionsResults);$i++){
            if(!$questionsResults[$i][self::dqrOKKOQUESTION]) {
                $into.= "(".$this->quizresult['quizresultId'].",".$questionsResults[$i][self::dqrQUESTIONID]."),";
            }
        }
        $into = substr($into, 0, -1); //get the last ',' away
            
        //insert the questions ko : 
        if($into!=""){ //then insert the questions ko :  
    
            $sql ="INSERT INTO quizresult_questionko (quizresult_questionko_idquizresult, quizresult_questionko_idquestion) VALUES ";
            $sql.= $into;
            $conn->query($sql); 
        } 
     
        //update the object ($failedquestions) with explanations :
        $sql = "SELECT question_question, question_explanationtitle, question_explanation"; 
        $sql.= " FROM quizresult_questionko, question";              
        $sql.= " WHERE quizresult_questionko_idquizresult = $quizresult_id"; 
        $sql.= " AND question_id = quizresult_questionko_idquestion";
        $sql.= " AND question_explanation IS NOT NULL";

        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
            $i=0;
            while($row = $result-> fetch_assoc()){
                $this->failedquestions[$i][self::QUESTIONKO] = $row['question_question'];
                $this->failedquestions[$i][self::EXPLANATIONTITLE] = $row['question_explanationtitle'];
                $this->failedquestions[$i][self::EXPLANATION] = $row['question_explanation'];

                $i++;
            } 
        }   
        //Update questionstat : 

        //Get loginadmin :
        $sql = "SELECT quiz_loginadmin FROM quiz WHERE quiz_id = ".$this->quizresult['idQuiz'];
    
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $logadmin = $row['quiz_loginadmin'];
        
        $date = time();

        //$INSERT all the questions (using $questionsResults : question asked id, score okko, and widget)            
        //get the questions : 
        $into = "";
        for($i=0;$i<count($questionsResults);$i++){
            $into.= "(".$questionsResults[$i][self::dqrQUESTIONID].",".$questionsResults[$i][self::dqrOKKOQUESTION].",";
            $into.= "'".$questionsResults[$i][self::dqrWIDGETID]."',".$date.",".$this->quizresult['idQuiz'].",";
            $into.= "'".$this->quizresult['quizTitle']."','".$logadmin."'),";
        }
        $into = substr($into, 0, -1); //get the last ',' away

        //insert the questions : 
        if($into!=""){ //then insert the questions ko :  
            $sql ="INSERT INTO questionstat (questionstat_idquestion, questionstat_ok, questionstat_idwidget, questionstat_date, questionstat_idquiz, questionstat_quiztitle, questionstat_loginadmin) VALUES ";
            $sql.= $into;
            $conn->query($sql); 
        } 
        
        return $this->quizresult['quizresultId'];
    } //end insertOne()

    ///////////////////////////////////////getQuizresult (quiz part of an existing result)////////////////////////
    public function getQuizresult(){
        return $this->quizresult;
    }

    ///////////////////////////////////////getFailedQuestions (questions part of an existing result)//////////////
    public function getFailedQuestions(){

        return $this->failedquestions;   
    }  
}