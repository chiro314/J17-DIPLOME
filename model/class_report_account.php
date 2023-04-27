<?php
/*****************************************************************************************
* Object:      class_report_account
* admin/user:  admin
* Scope:	   quiz result
* 
* Feature (maquette): consult the quiz results of one session, one user (account) and their quizzes (maq-14)
* Trigger:            Link on a session ("Sessions and results" column of div_accounts_list.php) /index.php/$_REQUEST: "account/reporting" / class class_report_account_controller (class_report_account_controller.php)
*
* Major tasks: get data to display or calculate KPI for : the session, the account (user), the quizzes ;
*              get data to display or calculate KPI for each quiz of the user ;
*              get data to display or calculate KPI of the quiz of the session not in the user playlist.
*******************************************************************************************/

class class_report_account {

    private $session;
    private $account;
    private $sessionQuizAccountResults;
    private $sessionQuizWithoutAccountResult;

    //$session : info + stat
    private const SESSIONID = 0, SSUBTITLE=1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4,
                  NBQUIZ = 5, NBACCOUNTS = 6, SPARTICIPRATE = 7, SSUCCESSRATE = 8; 
    
    //$account : info + stat
    private const LOGIN=0, AEMAIL=1, NAME=2, FIRSTNAME=3, COMPANY=4,
                  ANBQUIZRESULTS = 5, APARTICIPRATE = 6,  ASUCCESSRATE = 7; 
        
    //sessionQuizAccountResults & sessionQuizWithoutAccountResult : quiz of the session : info
    private const QUIZID = 0, TITLE= 1, STATUS = 2, DURATION=3, SUBTITLE = 4, 
                  SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6;
    //sessionQuizAccountResults & sessionQuizWithoutAccountResult : quiz of the session : stat
    private const
        AVGDURSEC = 7,
        QDURATIONRATE = 8,
        NBQUIZQUESTIONS = 9,
        QTREATEDQUESTRATE = 10,
        NBQUIZRESULTS = 11,
        QPARTICIPATIONRATE = 12,
        QSUCCESSRATE = 13;

    //sessionQuizWithoutAccountResult:
    private const BLOCKED = 14;
    
    //sessionQuizAccountResults : quizresult : info
    private const QRSTARTDATE = 14, QRENDDATE = 15, QRMAXDUR = 16, QRNBQUESTASKED = 17,
        QRMAXNBQUEST =18, QRQUESTASKEDSCORE = 19, QRMAXQUESTASKEDSCORE = 20, QRMAXSCORE = 21; 
    
    //sessionQuizAccountResults : quizresult : stat :
    private const
        SQAQRDURATION = 22,
        SQAQRDURATIONRATE = 23,
        SQAQRNBQUESTRATE = 24,
        SQAQRQUESTASKEDSCORERATE = 25,
        SQAQRSCORERATE = 26;
    
       
    public function __construct($accountid, $sessionid, $login){
        global $conn; // $mypassword;

        //get the session : ///////////////////
        $sql = "SELECT session_id, session_title, session_subtitle, session_startdate, session_enddate";
        $sql.= " FROM session INNER JOIN account ON account_login = session_loginadmin";
        $sql.= " WHERE session_id = $sessionid";
        //$sql.= " AND account_login = '$login' AND account_psw = '$mypassword'";
        $sql.= " AND account_login = '$login'";

        $result0 = $conn->query($sql);

        if($result0 and $result0->num_rows){ 
           
            $row = $result0->fetch_assoc();

            $this->session[self::SESSIONID] = $row['session_id'];
            $this->session[self::SSUBTITLE] = $row['session_subtitle'];
            $this->session[self::STITLE] = $row['session_title'];
            $this->session[self::SSTARTDATE] = $row['session_startdate'];
            $this->session[self::SENDDATE] = $row['session_enddate'];

            //NBQUIZ :
            /*
            $sql = "SELECT session_quiz_idsession, COUNT(session_quiz_idquiz) AS nbquiz";
            $sql.= " FROM session_quiz WHERE session_quiz_idsession = $sessionid";
            $sql.= " GROUP BY session_quiz_idsession";
            */
            $sql = "SELECT COUNT(session_quiz_idquiz) AS nbquiz";
            $sql.= " FROM session_quiz WHERE session_quiz_idsession = $sessionid";

            $result1 = $conn->query($sql);
            if($result1 and $result1->num_rows){
                $row = $result1->fetch_assoc();
                $this->session[self::NBQUIZ] = $row['nbquiz'];
            } 
            else {
                $this->session[self::NBQUIZ] = 0;
            }

            //NBACCOUNTS :
            /*
            $sql = "SELECT session_user_idsession, COUNT(session_user_loginuser) AS nbaccouts";
            $sql.= " FROM session_user WHERE session_user_idsession = $sessionid";
            $sql.= " GROUP BY session_user_idsession";
            */
            $sql = "SELECT COUNT(session_user_loginuser) AS nbaccouts";
            $sql.= " FROM session_user WHERE session_user_idsession = $sessionid";

            $result2 = $conn->query($sql);
            if($result2 and $result2->num_rows){
                $row = $result2->fetch_assoc();
                $this->session[self::NBACCOUNTS] = $row['nbaccouts'];
            }
            else{
                $this->session[self::NBACCOUNTS] =0;
            } 

            //SPARTICIPRATE :

            $sql = "SELECT COUNT(quizresult_idquiz) AS nbquizresults";
            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
            $result3 = $conn->query($sql);
            $nbquizresults = 0;
            if($result3 and $result3->num_rows){
                $row = $result3->fetch_assoc();
                $nbquizresults = $row['nbquizresults'];

                if($this->session[self::NBQUIZ] * $this->session[self::NBACCOUNTS] !=0){
                    $participationrate = $nbquizresults / ($this->session[self::NBQUIZ] * $this->session[self::NBACCOUNTS]);
                    $participationrate = round($participationrate, 3);
                    $this->session[self::SPARTICIPRATE] = $participationrate;
                }
                else{
                    $this->session[self::SPARTICIPRATE] ='';
                }
            }
            else{
                $this->session[self::SPARTICIPRATE] ='';
            }

            //SSUCCESSRATE :
            if ($nbquizresults){
                /*
                $sql = "SELECT quizresult_idsession, AVG(quizresult_questaskedscore / quizresult_maxscore) AS successrate";
                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                $sql.= " GROUP BY quizresult_idsession";
                */
                $sql = "SELECT AVG(quizresult_questaskedscore / quizresult_maxscore) AS successrate";
                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";

                $result4 = $conn->query($sql);
                if($result4 and $result4->num_rows){
                    $row = $result4->fetch_assoc();
                    $successrate = $row['successrate'];
                    $successrate = round($successrate, 3);
                    $this->session[self::SSUCCESSRATE] = $successrate;
                }
                else{
                    $this->session[self::SSUCCESSRATE] =''; //braces
                }
            }
            else{
                $this->session[self::SSUCCESSRATE] ='';
            }

            //get the account : /////////////////// 

            $sql = "SELECT user.account_login, user.account_name, user.account_firstname, user.account_company, user.account_email";
            $sql.= " FROM account AS user INNER JOIN account AS admin ON admin.account_login = user.account_loginadmin";
            $sql.= " WHERE user.account_login = '$accountid'";
            //$sql.= " AND admin.account_login = '$login' AND admin.account_psw = '$mypassword'";
            $sql.= " AND admin.account_login = '$login'";

            $result5 = $conn->query($sql);

            if($result5 and $result5->num_rows){ 
           
                $row = $result5->fetch_assoc();

                $this->account[self::LOGIN] = $row['account_login'];
                $this->account[self::AEMAIL] = $row['account_email'];
                $this->account[self::NAME] = $row['account_name'];
                $this->account[self::FIRSTNAME] = $row['account_firstname'];
                $this->account[self::COMPANY] = $row['account_company'];
                
                //ANBQUIZRESULTS :
                /*
                $sql = "SELECT quizresult_loginuser, COUNT(quizresult_id) AS nbaccountquizresults";
                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                $sql.= " GROUP BY quizresult_loginuser";
                */
                $sql = "SELECT COUNT(quizresult_id) AS nbaccountquizresults";
                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                $sql.= " AND quizresult_loginuser = '$accountid'";

                $result6 = $conn->query($sql);
                if($result6 and $result6->num_rows){
                    $row = $result6->fetch_assoc();
                    $this->account[self::ANBQUIZRESULTS] = $row['nbaccountquizresults'];
                }
                else{
                    $this->account[self::ANBQUIZRESULTS] = 0;
                }

                //APARTICIPRATE :
                if($this->session[self::NBQUIZ]){
                    $accountparticipationrate = $this->account[self::ANBQUIZRESULTS] / $this->session[self::NBQUIZ];
                    $accountparticipationrate = round($accountparticipationrate, 3);
                    $this->account[self::APARTICIPRATE] = $accountparticipationrate;
                }
                else $this->account[self::APARTICIPRATE] = '';

                //ASUCCESSRATE : moyenne des notes des quizresult pour cette session
                if ($this->account[self::ANBQUIZRESULTS]){
                    /*
                    $sql = "SELECT quizresult_idsession, AVG(quizresult_questaskedscore / quizresult_maxscore) AS accountsuccessrate";
                    $sql.= " FROM quizresult";
                    $sql.= " WHERE quizresult_idsession = $sessionid";
                    $sql.= " AND quizresult_loginuser = '$accountid'";
                    $sql.= " GROUP BY quizresult_idsession";
                    */
                    $sql = "SELECT AVG(quizresult_questaskedscore / quizresult_maxscore) AS accountsuccessrate";
                    $sql.= " FROM quizresult";
                    $sql.= " WHERE quizresult_idsession = $sessionid";
                    $sql.= " AND quizresult_loginuser = '$accountid'";

                    $result7 = $conn->query($sql);
                    if($result7 and $result7->num_rows){
                        $row = $result7->fetch_assoc();                       
                        $accountsuccessrate = $row['accountsuccessrate'];
                        $accountsuccessrate = round($accountsuccessrate, 3);
                        $this->account[self::ASUCCESSRATE] = $accountsuccessrate;
                    }
                    else{
                        $this->account[self::ASUCCESSRATE] =''; //braces
                    }
                }
                else{
                    $this->account[self::ASUCCESSRATE] ='';
                }

                if($this->session[self::NBQUIZ]){ //NBQUIZ : all the quiz of the session
                  
                    //LIST OF THE QUIZ OF THE SESSION with AT LEAST ONE RESULT for the account:

                    $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status,";
                    $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration,";
                    $sql.= " quizresult_startdate, quizresult_enddate, quizresult_maxduration,";
                    $sql.= " quizresult_nbquestasked, quizresult_maxnbquest, quizresult_questaskedscore,";
                    $sql.= " quizresult_maxquestaskedscore, quizresult_maxscore";
                    $sql.= " FROM session_quiz";
                    $sql.= " LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
                    $sql.= " LEFT JOIN quizresult ON quizresult_idquiz = quiz_id";
                    $sql.= " WHERE session_quiz_idsession = $sessionid";
                    $sql.= " AND quizresult_loginuser = '$accountid'";
                    $sql.= " AND quizresult_idsession = $sessionid";
                    $sql.= " ORDER BY session_quiz_openingdate";
                    $result8 = $conn->query($sql);
    
                    if($result8 and $result8->num_rows){ 
                        $i=0;
                        while($row8 = $result8->fetch_assoc()){ 
                            $this->sessionQuizAccountResults[$i][self::QUIZID] = $row8['quiz_id'];
                            $this->sessionQuizAccountResults[$i][self::TITLE] = $row8['quiz_title'];
                            $this->sessionQuizAccountResults[$i][self::STATUS] = $row8['quiz_status'];
                            $this->sessionQuizAccountResults[$i][self::DURATION] = $row8['session_quiz_minutesduration'];
                            $this->sessionQuizAccountResults[$i][self::SUBTITLE] = $row8['quiz_subtitle'];
                            $this->sessionQuizAccountResults[$i][self::SQZOPENINGDATE] = $row8['session_quiz_openingdate'];
                            $this->sessionQuizAccountResults[$i][self::SQZCLOSINGDATE] = $row8['session_quiz_closingdate'];
                            
        
                            //QUIZ : info consolidées :

                            $quizid = $this->sessionQuizAccountResults[$i][self::QUIZID];
                            
                            //Durée moyenne passée sur le quiz :
                            /*
                            $sql = "SELECT quizresult_idquiz, AVG(quizresult_enddate - quizresult_startdate) AS avgdurationsec";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid";
                            $sql.= " GROUP BY quizresult_idquiz";
                            */
                            $sql = "SELECT AVG(quizresult_enddate - quizresult_startdate) AS avgdurationsec";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid";
                            $result9 = $conn->query($sql);
                        
                            if($result9 and $result9->num_rows){
                                $row = $result9->fetch_assoc();
                                $int = round($row['avgdurationsec'], 0);
                                $this->sessionQuizAccountResults[$i][self::AVGDURSEC] = $int;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::AVGDURSEC] = '';
                            }
                            if( $this->sessionQuizAccountResults[$i][self::DURATION] >0
                            and $this->sessionQuizAccountResults[$i][self::AVGDURSEC] ){

                                //% temps utilisé dans cette session sur ce quiz :
                                $quizdurationrate = $this->sessionQuizAccountResults[$i][self::AVGDURSEC] / $this->sessionQuizAccountResults[$i][self::DURATION];
                                $quizdurationrate = round($quizdurationrate, 3);
                                $this->sessionQuizAccountResults[$i][self::QDURATIONRATE] = $quizdurationrate;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::QDURATIONRATE] = "";
                            }

                            //Nb questions (current)
                            //$quizid = $this->sessionQuizAccountResults[$i][self::QUIZID];
                            /*
                            $sql = "SELECT quiz_question_idquiz, COUNT(quiz_question_idquestion) AS nbquizquestions";
                            $sql.= " FROM quiz_question WHERE quiz_question_idquiz = $quizid";
                            $sql.= " GROUP BY quiz_question_idquiz";
                            */
                            $sql = "SELECT COUNT(quiz_question_idquestion) AS nbquizquestions";
                            $sql.= " FROM quiz_question WHERE quiz_question_idquiz = $quizid";

                            $result10 = $conn->query($sql);
                            if($result10 and $result10->num_rows){
                                $row = $result10->fetch_assoc();
                                $this->sessionQuizAccountResults[$i][self::NBQUIZQUESTIONS] = $row['nbquizquestions'];
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::NBQUIZQUESTIONS] = 0;
                            }

                            //% questions traitées
                            if( $this->sessionQuizAccountResults[$i][self::DURATION] >0){

                                //% de questions de ce quiz, traitées par cette session :
                                $nbquizquestions =  $this->sessionQuizAccountResults[$i][self::NBQUIZQUESTIONS];
                                if($nbquizquestions>0){
                                    /*
                                    $sql = "SELECT quizresult_idquiz, AVG(quizresult_nbquestasked) AS avgnbquestasked";
                                    $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                    $sql.= " AND quizresult_idquiz = $quizid";
                                    $sql.= " GROUP BY quizresult_idquiz";
                                    */
                                    $sql = "SELECT AVG(quizresult_nbquestasked) AS avgnbquestasked";
                                    $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                    $sql.= " AND quizresult_idquiz = $quizid";

                                    $result11 = $conn->query($sql);
                                    if($result11 and $result11->num_rows){
                                        $row = $result11->fetch_assoc();
                                        $quizTreatedQuestionRate = $row['avgnbquestasked'] / $nbquizquestions;
                                        $quizTreatedQuestionRate = round($quizTreatedQuestionRate, 3);
                                        $this->sessionQuizAccountResults[$i][self::QTREATEDQUESTRATE] = $quizTreatedQuestionRate;
                                    }
                                    else{
                                        $this->sessionQuizAccountResults[$i][self::QTREATEDQUESTRATE] = "";
                                    }
                                }
                                else{
                                    $this->sessionQuizAccountResults[$i][self::QTREATEDQUESTRATE] = "";
                                }
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::QTREATEDQUESTRATE] = "";
                            }

                            //Nb quizresult
                            /*
                            $sql = "SELECT quizresult_idquiz, COUNT(quizresult_id) AS nbquizresults";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid"; 
                            $sql.= " GROUP BY quizresult_idquiz";
                            */
                            $sql = "SELECT COUNT(quizresult_id) AS nbquizresults";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid"; 

                            $result12 = $conn->query($sql);
                            if($result12 and $result12->num_rows){
                                $row = $result12->fetch_assoc();
                                $this->sessionQuizAccountResults[$i][self::NBQUIZRESULTS] = $row['nbquizresults'];
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::NBQUIZRESULTS] = 0;
                            }

                            //% participation : nombre de quizresult de la session et du quiz / (nb comptes de la session)
                            if($this->session[self::NBACCOUNTS]){
                   
                                $participationRate = $this->sessionQuizAccountResults[$i][self::NBQUIZRESULTS] / $this->session[self::NBACCOUNTS];
                                $participationRate = round($participationRate, 3);
                                $this->sessionQuizAccountResults[$i][self::QPARTICIPATIONRATE] = $participationRate;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::QPARTICIPATIONRATE] = "";
                            }
                            
                            //% succès participants
                            //SSUCCESSRATE : moyenne des notes des quizresult de la session pour ce quiz
                            if ($this->sessionQuizAccountResults[$i][self::NBQUIZRESULTS]){
                                /*
                                $sql = "SELECT quizresult_idquiz, AVG(quizresult_questaskedscore / quizresult_maxscore) AS quizsuccessrate";
                                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                $sql.= " AND quizresult_idquiz = $quizid"; 
                                $sql.= " GROUP BY quizresult_idquiz";
                                */
                                $sql = "SELECT AVG(quizresult_questaskedscore / quizresult_maxscore) AS quizsuccessrate";
                                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                $sql.= " AND quizresult_idquiz = $quizid"; 

                                $result13 = $conn->query($sql);
                                if($result13 and $result13->num_rows){
                                    $row = $result13->fetch_assoc();
                                    $quizsuccessrate = $row['quizsuccessrate'];
                                    $quizsuccessrate = round($quizsuccessrate, 3);
                                    $this->sessionQuizAccountResults[$i][self::QSUCCESSRATE] = $quizsuccessrate;
                                }
                                else{
                                    $this->sessionQuizAccountResults[$i][self::QSUCCESSRATE] =''; //braces
                                }
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::QSUCCESSRATE] ='';
                            }
                            $this->sessionQuizAccountResults[$i][self::QRSTARTDATE] = $row8['quizresult_startdate'];
                            $this->sessionQuizAccountResults[$i][self::QRENDDATE] = $row8['quizresult_enddate'];
                            $this->sessionQuizAccountResults[$i][self::QRMAXDUR] = $row8['quizresult_maxduration'];
                            $this->sessionQuizAccountResults[$i][self::QRNBQUESTASKED] = $row8['quizresult_nbquestasked'];
                            $this->sessionQuizAccountResults[$i][self::QRMAXNBQUEST] = $row8['quizresult_maxnbquest'];
                            $this->sessionQuizAccountResults[$i][self::QRQUESTASKEDSCORE] = $row8['quizresult_questaskedscore'];
                            $this->sessionQuizAccountResults[$i][self::QRMAXQUESTASKEDSCORE] = $row8['quizresult_maxquestaskedscore'];
                            $this->sessionQuizAccountResults[$i][self::QRMAXSCORE] = $row8['quizresult_maxscore'];
                            
                            //QUIZRESULT OF THE ACCOUNT :

                            //Durée
                            $this->sessionQuizAccountResults[$i][self::SQAQRDURATION] =
                                round($this->sessionQuizAccountResults[$i][self::QRENDDATE] 
                                    - $this->sessionQuizAccountResults[$i][self::QRSTARTDATE], 0);
                            
                            if( $this->sessionQuizAccountResults[$i][self::QRMAXDUR] >0){
                                //% temps utilisé
                                $sqaQRdurationRate =  $this->sessionQuizAccountResults[$i][self::SQAQRDURATION]
                                    / $this->sessionQuizAccountResults[$i][self::QRMAXDUR];
                                $sqaQRdurationRate = round($sqaQRdurationRate, 3);
                                $this->sessionQuizAccountResults[$i][self::SQAQRDURATIONRATE] = $sqaQRdurationRate;
                            }
                            else{ 
                                $this->sessionQuizAccountResults[$i][self::SQAQRDURATIONRATE] = "";
                            }

                            //Nb questions traitées
                            //% questions traitées
                            if($this->sessionQuizAccountResults[$i][self::QRMAXNBQUEST] >0){
                                $sqaQRnbQuestRate = $this->sessionQuizAccountResults[$i][self::QRNBQUESTASKED] 
                                / $this->sessionQuizAccountResults[$i][self::QRMAXNBQUEST];
                                $sqaQRnbQuestRate = round($sqaQRnbQuestRate, 3);
                                $this->sessionQuizAccountResults[$i][self::SQAQRNBQUESTRATE] = $sqaQRnbQuestRate;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::SQAQRNBQUESTRATE] = "";
                            }

                            //% succès questions traitées
                            if($this->sessionQuizAccountResults[$i][self::QRMAXQUESTASKEDSCORE] >0){
                                $sqaQRquestAskedScoreRate = $this->sessionQuizAccountResults[$i][self::QRQUESTASKEDSCORE] 
                                    /$this->sessionQuizAccountResults[$i][self::QRMAXQUESTASKEDSCORE];
                                $sqaQRquestAskedScoreRate = round($sqaQRquestAskedScoreRate, 3);
                                $this->sessionQuizAccountResults[$i][self::SQAQRQUESTASKEDSCORERATE] = $sqaQRquestAskedScoreRate;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::SQAQRQUESTASKEDSCORERATE] = "";
                            }
                            //% succès (note)
                            if($this->sessionQuizAccountResults[$i][self::QRMAXSCORE] >0){
                                $sqaQRscoreRate = $this->sessionQuizAccountResults[$i][self::QRQUESTASKEDSCORE] 
                                    /$this->sessionQuizAccountResults[$i][self::QRMAXSCORE];
                                $sqaQRscoreRate = round($sqaQRscoreRate, 3);
                                $this->sessionQuizAccountResults[$i][self::SQAQRSCORERATE] = $sqaQRscoreRate;
                            }
                            else{
                                $this->sessionQuizAccountResults[$i][self::SQAQRSCORERATE] = "";
                            }
                            
                            $i++;                        
                        }
                    }
                    
                    //LIST OF THE QUIZ OF THE SESSION WITHOUT ACOUNTRESULT FOR THIS ACCOUNT :
                    //$sessionQuizWithoutAccountResult

                    $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status,";
                    $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration";
                    $sql.= " FROM session_quiz";
                    $sql.= " LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
                    $sql.= " WHERE session_quiz_idsession = $sessionid";
                    $sql.= " AND quiz_id NOT IN";
                    $sql.= " (SELECT quizresult_idquiz FROM quizresult";
                    $sql.= " WHERE quizresult_idsession = $sessionid";
                    $sql.= " AND quizresult_idquiz = quiz_id";
                    $sql.= " AND quizresult_loginuser = '$accountid')";
                    $sql.= " ORDER BY session_quiz_openingdate";

                    $result14 = $conn->query($sql);
                    if($result14 and $result14->num_rows){ 
                        $i=0;
                        while($row14 = $result14->fetch_assoc()){ 
                          
                            $this->sessionQuizWithoutAccountResult[$i][self::QUIZID] = $row14['quiz_id'];
                            $this->sessionQuizWithoutAccountResult[$i][self::TITLE] = $row14['quiz_title'];
                            $this->sessionQuizWithoutAccountResult[$i][self::STATUS] = $row14['quiz_status'];
                            $this->sessionQuizWithoutAccountResult[$i][self::DURATION] = $row14['session_quiz_minutesduration'];
                            $this->sessionQuizWithoutAccountResult[$i][self::SUBTITLE] = $row14['quiz_subtitle'];
                            $this->sessionQuizWithoutAccountResult[$i][self::SQZOPENINGDATE] = $row14['session_quiz_openingdate'];
                            $this->sessionQuizWithoutAccountResult[$i][self::SQZCLOSINGDATE] = $row14['session_quiz_closingdate'];
                            
                            //QUIZ : info consolidées :
                            $quizid = $this->sessionQuizWithoutAccountResult[$i][self::QUIZID];

                            //Durée moyenne passée sur le quiz :
                            /*
                            $sql = "SELECT quizresult_idquiz, AVG(quizresult_enddate - quizresult_startdate) AS avgdurationsec";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid";
                            $sql.= " GROUP BY quizresult_idquiz";
                            */
                            $sql = "SELECT AVG(quizresult_enddate - quizresult_startdate) AS avgdurationsec";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid";

                            $result9 = $conn->query($sql);
                        
                            if($result9 and $result9->num_rows){
                                $row = $result9->fetch_assoc();
                                $int = round($row['avgdurationsec'], 0);
                                $this->sessionQuizWithoutAccountResult[$i][self::AVGDURSEC] = $int;
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::AVGDURSEC] = '';
                            }
                            
                            if( $this->sessionQuizWithoutAccountResult[$i][self::DURATION] >0
                            and $this->sessionQuizWithoutAccountResult[$i][self::AVGDURSEC] ){
                                //% temps utilisé dans cette session sur ce quiz :
                                $quizdurationrate = $this->sessionQuizWithoutAccountResult[$i][self::AVGDURSEC] / $this->sessionQuizWithoutAccountResult[$i][self::DURATION];
                                $quizdurationrate = round($quizdurationrate, 3);
                                $this->sessionQuizWithoutAccountResult[$i][self::QDURATIONRATE] = $quizdurationrate;
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::QDURATIONRATE] = "";
                            }

                            //Nb questions (current)
                            //$quizid = $this->sessionQuizWithoutAccountResult[$i][self::QUIZID];
                            /*
                            $sql = "SELECT quiz_question_idquiz , COUNT(quiz_question_idquestion ) AS nbquizquestions";
                            $sql.= " FROM quiz_question WHERE quiz_question_idquiz = $quizid";
                            $sql.= " GROUP BY quiz_question_idquiz ";
                            */
                            $sql = "SELECT COUNT(quiz_question_idquestion ) AS nbquizquestions";
                            $sql.= " FROM quiz_question WHERE quiz_question_idquiz = $quizid";

                            $result10 = $conn->query($sql);
                            if($result10 and $result10->num_rows){
                                $row = $result10->fetch_assoc();
                                $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZQUESTIONS] = $row['nbquizquestions'];
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZQUESTIONS] = 0;
                            }

                            //% questions traitées
                            if( $this->sessionQuizWithoutAccountResult[$i][self::DURATION] >0){

                                //% de questions de ce quiz, traitées par cette session :
                                $nbquizquestions =  $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZQUESTIONS];
                                if($nbquizquestions>0){
                                    /*
                                    $sql = "SELECT quizresult_idquiz, AVG(quizresult_nbquestasked) AS avgnbquestasked";
                                    $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                    $sql.= " AND quizresult_idquiz = $quizid";
                                    $sql.= " GROUP BY quizresult_idquiz";
                                    */
                                    $sql = "SELECT AVG(quizresult_nbquestasked) AS avgnbquestasked";
                                    $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                    $sql.= " AND quizresult_idquiz = $quizid";

                                    $result11 = $conn->query($sql);
                                    if($result11 and $result11->num_rows){
                                        $row = $result11->fetch_assoc();
                                        $quizTreatedQuestionRate = $row['avgnbquestasked'] / $nbquizquestions;
                                        $quizTreatedQuestionRate = round($quizTreatedQuestionRate, 3);
                                        $this->sessionQuizWithoutAccountResult[$i][self::QTREATEDQUESTRATE] = $quizTreatedQuestionRate;
                                    }
                                    else{
                                        $this->sessionQuizWithoutAccountResult[$i][self::QTREATEDQUESTRATE] = "";
                                    }
                                }
                                else{
                                    $this->sessionQuizWithoutAccountResult[$i][self::QTREATEDQUESTRATE] = "";
                                }
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::QTREATEDQUESTRATE] = "";
                            }

                            //Nb quizresult
                            /*
                            $sql = "SELECT quizresult_idquiz, COUNT(quizresult_id) AS nbquizresults";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid"; 
                            $sql.= " GROUP BY quizresult_idquiz";
                            */
                            $sql = "SELECT COUNT(quizresult_id) AS nbquizresults";
                            $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                            $sql.= " AND quizresult_idquiz = $quizid"; 

                            $result12 = $conn->query($sql);
                            if($result12 and $result12->num_rows){
                                $row = $result12->fetch_assoc();
                                $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZRESULTS] = $row['nbquizresults'];
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZRESULTS] = 0;
                            }

                            //% participation : nombre de quizresult de la session et du quiz / (nb comptes de la session)
                            if($this->session[self::NBACCOUNTS]){
                   
                                $participationRate = $this->sessionQuizWithoutAccountResult[$i][self::NBQUIZRESULTS] / $this->session[self::NBACCOUNTS];
                                $participationRate = round($participationRate, 3);
                                $this->sessionQuizWithoutAccountResult[$i][self::QPARTICIPATIONRATE] = $participationRate;
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::QPARTICIPATIONRATE] = "";
                            }
                            
                            //% succès participants
                            //SSUCCESSRATE : moyenne des notes des quizresult de la session pour ce quiz
                            if ($this->sessionQuizWithoutAccountResult[$i][self::NBQUIZRESULTS]){
                                /*
                                $sql = "SELECT quizresult_idquiz, AVG(quizresult_questaskedscore / quizresult_maxscore) AS quizsuccessrate";
                                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                $sql.= " AND quizresult_idquiz = $quizid"; 
                                $sql.= " GROUP BY quizresult_idquiz";
                                */
                                $sql = "SELECT AVG(quizresult_questaskedscore / quizresult_maxscore) AS quizsuccessrate";
                                $sql.= " FROM quizresult WHERE quizresult_idsession = $sessionid";
                                $sql.= " AND quizresult_idquiz = $quizid";

                                $result13 = $conn->query($sql);
                                if($result13 and $result13->num_rows){
                                    $row = $result13->fetch_assoc();
                                    $quizsuccessrate = $row['quizsuccessrate'];
                                    $quizsuccessrate = round($quizsuccessrate, 3);
                                    $this->sessionQuizWithoutAccountResult[$i][self::QSUCCESSRATE] = $quizsuccessrate;
                                }
                                else{
                                    $this->sessionQuizWithoutAccountResult[$i][self::QSUCCESSRATE] =''; //braces
                                }
                            }
                            else{
                                $this->sessionQuizWithoutAccountResult[$i][self::QSUCCESSRATE] ='';
                            }

                            // Blocked quiz ?

                            $sql = "SELECT COUNT(*) AS islocked FROM quizlock";
                            $sql.= " WHERE quizlock_user = '$accountid' AND quizlock_quizid = $quizid AND quizlock_sessionid = $sessionid";
                            $result15 = $conn->query($sql);
                            if($result15 and $result15->num_rows){
                                $row = $result15->fetch_assoc();
                                $this->sessionQuizWithoutAccountResult[$i][self::BLOCKED] = $row['islocked'];
                            } 
                            else {
                                $this->sessionQuizWithoutAccountResult[$i][self::BLOCKED] = 0;
                            }

                            $i++;
                        }
                    }
                }
            }
        }
    }

    public function getSession(){
        return $this->session;
    }
    public function getAccount(){
        return $this->account;
    }
    public function getSessionQuizAccountResults(){
        return $this->sessionQuizAccountResults;
    }
    public function getSessionQuizWithoutAccountResult(){
        return $this->sessionQuizWithoutAccountResult;
    }
}
