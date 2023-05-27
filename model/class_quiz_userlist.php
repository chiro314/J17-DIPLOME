<?php
/*****************************************************************************************
* Object:      class class_quiz_userlist
* admin/user:  user
* Scope:	   quiz (dashboard)
* 
* Feature (maquette): Consult the list of sessions and quizzes (maq-08)
* Trigger:            Button menu "Vos quiz" /index.php/$_REQUEST: "quiz/userlist" / class class_quiz_userlist_controller (class_quiz_userlist_controller.php)
*
* Major tasks:  get data to of all the sessions and their quizzes for one user (account)
*               for each quiz, get the number of questions (a quiz with no question cannot be launched)
*******************************************************************************************/

class class_quiz_userlist {

    private $quiz_userlist;

    private const ANAME = 0, AFIRSTNAME = 1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
    private const SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6, SQZDURATION = 7;
    private const QZTITLE = 8, QZRID = 9, QZRSTARTDATE = 10, QZRSCORE = 11, QZRMAXSCORE = 12;
    private const QZID = 13, SID = 14, NBINLINEQUESTIONS=15;

    public function __construct($login){

        global $conn;
        
        $sql = "SELECT"; 
        $sql.= " account_name, account_firstname,";
        $sql.= " session_id, session_title, session_startdate, session_enddate,";
        $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration,";
        $sql.= " quiz_title, quiz_id,";
        $sql.= " quizresult_id, quizresult_startdate, quizresult_questaskedscore, quizresult_maxscore";

        $sql.= " FROM session_user";
        $sql.= " LEFT JOIN session ON session_id = session_user_idsession";
        $sql.= " LEFT JOIN account ON account_login = session_loginadmin";
        $sql.= " LEFT JOIN session_quiz ON session_quiz_idsession = session_id";
        $sql.= " LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
        $sql.= " LEFT JOIN quizresult ON quizresult_idquiz = quiz_id";
               
        $sql.= " WHERE session_user_loginuser = '$login'"; //$login of the connected person
        $sql.= " AND (quiz_status = 'inline' OR quiz_title IS NULL)"; //the user can see his sessions even if there is no quiz
        $sql.= " ORDER BY session_startdate DESC, session_quiz_openingdate DESC, quizresult_startdate DESC"; 
       
        $result = $conn->query($sql);

        if($result != null and $result->num_rows !== 0){ // null when the table is empty
            $i=0;
            while($row = $result-> fetch_assoc()){
                $this->quiz_userlist[$i][self::ANAME] = $row['account_name'];
                $this->quiz_userlist[$i][self::AFIRSTNAME] = $row['account_firstname'];
                $this->quiz_userlist[$i][self::STITLE] = $row['session_title'];
                $this->quiz_userlist[$i][self::SSTARTDATE] = $row['session_startdate'];
                $this->quiz_userlist[$i][self::SENDDATE] = $row['session_enddate'];
                $this->quiz_userlist[$i][self::SQZOPENINGDATE] = $row['session_quiz_openingdate'];
                $this->quiz_userlist[$i][self::SQZCLOSINGDATE] = $row['session_quiz_closingdate'];
                $this->quiz_userlist[$i][self::SQZDURATION] = $row['session_quiz_minutesduration'];
                $this->quiz_userlist[$i][self::QZTITLE] = $row['quiz_title'];
                $this->quiz_userlist[$i][self::QZRID] = $row['quizresult_id'];
                $this->quiz_userlist[$i][self::QZRSTARTDATE] = $row['quizresult_startdate'];
                $this->quiz_userlist[$i][self::QZRSCORE] = $row['quizresult_questaskedscore'];
                $this->quiz_userlist[$i][self::QZRMAXSCORE] = $row['quizresult_maxscore'];
                $this->quiz_userlist[$i][self::QZID] = $row['quiz_id'];
                $this->quiz_userlist[$i][self::SID] = $row['session_id'];

                $this->quiz_userlist[$i][self::NBINLINEQUESTIONS] = 0;

                $i++;
            }
            // for each quiz, get the number of inline questions
            for($i=0;$i<count($this->quiz_userlist);$i++){
                if($this->quiz_userlist[$i][self::QZID] != null){
                    $quizid = $this->quiz_userlist[$i][self::QZID] + 0;

                    $sql2 = "SELECT quiz_question_idquiz, COUNT(quiz_question_idquestion) AS nbinlinequestions"; 
                    $sql2.= " FROM quiz_question LEFT JOIN question ON question_id = quiz_question_idquestion";
                    $sql2.= " WHERE quiz_question_idquiz = $quizid ";
                    $sql2.= " AND question_status = 'inline'";
                    $sql2.= " GROUP BY quiz_question_idquiz";

                    $result2= $conn->query($sql2);
                    $row2 = $result2-> fetch_assoc();
                    if ($row2 != null){
                        $this->quiz_userlist[$i][self::NBINLINEQUESTIONS] = $row2['nbinlinequestions'];
                    }
                }
            }
        }    
    }

    public function getAll() 
    {
        return $this->quiz_userlist;
    }
}