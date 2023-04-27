<?php
/*****************************************************************************************
* Object:      class class_quiz_list_controller
* admin/user:  admin
* Scope:	   quiz
* 
* Feature (maquette): Consult the list of your quizzes (maq-21) : Display the data of each quiz as well as its number of sessions and its number of questions; with additional Supp. and Maj links for each quiz.
* Trigger:            index.php/$_REQUEST: "quiz/list" / class class_quiz_list_controller (class_quiz_list_controller.php)
*
* Major DB operations: get data of all the quizzes and count questions and sessions of each quiz 
*******************************************************************************************/

class class_quiz_list {

    private $quiz_list;
    private const QUIZID = 0, TITLE= 1, STATUS = 2, LMDATE = 3, SUBTITLE = 4, CRDATE = 5, NBQUESTIONS = 6, NBONGOINGSESSIONS = 7;

    public function __construct($login){

        global $conn;
        /*       
        $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status, quiz_creationdate, quiz_lastmodificationdate";
        $sql.= " FROM quiz WHERE quiz_loginadmin = '$login' ORDER BY quiz_creationdate DESC"; 
        */       
        //get quiz data and the 2 counters : questions and sessions :
        $sql = "SELECT a.quiz_id, a.quiz_title, a.quiz_subtitle, a.quiz_status, a.quiz_creationdate, a.quiz_lastmodificationdate,";
        $sql.= " a.ycountquestions, b.zcountsessions FROM";
        // count the questions (and get quiz data) :
        $sql.= " (";
        // quiz with questions :
        $sql.= "  (SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status, quiz_creationdate, quiz_lastmodificationdate,";
        $sql.= "   COUNT(*) AS ycountquestions";
        $sql.= "   FROM (SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status, quiz_creationdate, quiz_lastmodificationdate";
        $sql.= "         FROM quiz_question, quiz WHERE quiz_loginadmin = '$login' AND quiz_id = quiz_question_idquiz";
        $sql.= "        ) AS y";
        $sql.= "   GROUP BY quiz_id)";
        $sql.= "  UNION";
        // quiz without question :
        $sql.= "  (SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status, quiz_creationdate, quiz_lastmodificationdate, quiz_question_idquiz";
        $sql.= "   FROM quiz LEFT JOIN quiz_question ON quiz_id = quiz_question_idquiz";
        $sql.= "   WHERE quiz_loginadmin = '$login' AND quiz_question_idquiz IS NULL";
        $sql.= "  )";
        $sql.= " ) AS a,";
        // count the sessions (only count but take into account the session end date : 0 or >= today) :
        $sql.= " (";
        $sql.= "  (SELECT quiz_id, COUNT(*) AS zcountsessions";
        $sql.= "   FROM (SELECT quiz_id FROM session_quiz, quiz, session WHERE quiz_loginadmin = '$login' AND quiz_id = session_quiz_idquiz";
        $sql.= "         AND session_id = session_quiz_idsession";
        $sql.= "         AND (session_enddate = 0 OR (UTC_TIMESTAMP() < FROM_UNIXTIME(session_enddate)))";
        $sql.= "        ) AS z";
        $sql.= "   GROUP BY quiz_id)";
        $sql.= "   UNION";
        // quiz without a session :
        $sql.= "   (SELECT quiz_id, session_quiz_idquiz FROM quiz LEFT JOIN session_quiz ON quiz_id = session_quiz_idquiz";
        $sql.= "    WHERE quiz_loginadmin = '$login' AND session_quiz_idquiz IS NULL";
        $sql.= "   )";
        $sql.= "   UNION";
        // quiz with a not over session :
        $sql.= "   (SELECT DISTINCT quiz_id, NULL";
        $sql.= "    FROM (SELECT quiz_id FROM session_quiz, quiz, session WHERE quiz_loginadmin = '$login'";
        $sql.= "          AND quiz_id = session_quiz_idquiz AND session_id = session_quiz_idsession";
        $sql.= "          AND (session_enddate != 0 AND (UTC_TIMESTAMP() >= FROM_UNIXTIME(session_enddate)))";
        $sql.= "         ) AS w";
        $sql.= "   )";
        $sql.= " ) AS b";
        $sql.= " WHERE a.quiz_id = b.quiz_id";
        $sql.= " ORDER BY a.quiz_id DESC";
    
        $result = $conn->query($sql);

        if($result != null){ // null when the tables are empty
           
            $i=0; //quiz index
            while($row = $result->fetch_assoc()){

                $this->quiz_list[$i][self::QUIZID] = $row['quiz_id'];
                $this->quiz_list[$i][self::TITLE] = $row['quiz_title'];
                $this->quiz_list[$i][self::SUBTITLE] = $row['quiz_subtitle'];
                $this->quiz_list[$i][self::STATUS] = $row['quiz_status'];
                $this->quiz_list[$i][self::CRDATE] = $row['quiz_creationdate'];
                $this->quiz_list[$i][self::LMDATE] = $row['quiz_lastmodificationdate'];
                $this->quiz_list[$i][self::NBQUESTIONS] = $row['ycountquestions'];
                $this->quiz_list[$i][self::NBONGOINGSESSIONS] = $row['zcountsessions'];
                
                $i++;
            }
        }
    }

    public function getQuiz() 
    {
        return $this->quiz_list;
    }
}
