<?php
/****************************************************************************************
* Object:      class class_session
* admin/user:  admin
* Scope:	   session
* 
* Features (maquette) : Get data for the Modify screen (cf. view/div_session.php) of one session (maq-20)
* Triggers: Link "Maj" in div_sessions_list.php>>>index.php/$_REQUEST: "session/update" / class class_session_controller (class_session_controller.php)
* 
* Major DB operations:  get data of the session,
*                       get the quizzes of the session,  
*                       get all the quizzes to associate with the session,
*                       get the accounts of the session,  
*                       get all the accounts to associate with the session.
*******************************************************************************************/

class class_session {

    private $session;
    private $quiz_list;
    private $all_quiz_list;
    private $accounts_list;
    private $all_accounts_list;

    private const SESSIONID = 0, SSUBTITLE=1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
    private const LOGO=5, BGIMAGE=6; //new

    private const QUIZID = 0, TITLE= 1, STATUS = 2;
    private const DURATION=3; //new
    private const SUBTITLE = 4, SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6;
    private const QSUBTITLE=3; //new
  
    private const LOGIN=0, NAME=2, FIRSTNAME=3, COMPANY=4;
    private const AEMAIL = 1;//new
    private const ACOMPANY=1;//new

    public function __construct($idsession, $login){
        global $conn; //, $mypassword;

        //get the session :
        $sql = "SELECT session_id, session_title, session_subtitle, session_startdate, session_enddate,";
        $sql.= " session_logolocation, session_bgimagelocation";
        $sql.= " FROM session INNER JOIN account ON account_login = session_loginadmin";
        $sql.= " WHERE session_id = $idsession";
        //$sql.= " AND account_login = '$login' AND account_psw = '$mypassword'";
        $sql.= " AND account_login = '$login'";

        $result0 = $conn->query($sql);
    
        if($result0 and $result0->num_rows){ // 0 when the idsession doesn't exist

            $row = $result0->fetch_assoc();

            $this->session[self::SESSIONID] = $row['session_id'];
            $this->session[self::SSUBTITLE] = $row['session_subtitle'];
            $this->session[self::STITLE] = $row['session_title'];
            $this->session[self::SSTARTDATE] = $row['session_startdate'];
            $this->session[self::SENDDATE] = $row['session_enddate'];
            $this->session[self::LOGO] = $row['session_logolocation'];
            $this->session[self::BGIMAGE] = $row['session_bgimagelocation'];

            //quiz of the session
            $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status,";
            $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration";
            $sql.= " FROM session_quiz LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
            $sql.= " WHERE session_quiz_idsession = $idsession";
            $sql.= " ORDER BY quiz_title";

            $result1 = $conn->query($sql);
            if($result1 != null){
                $i=0;
                while($row = $result1->fetch_assoc()){ 
                    $this->quiz_list[$i][self::QUIZID] = $row['quiz_id'];
                    $this->quiz_list[$i][self::TITLE] = $row['quiz_title'];
                    $this->quiz_list[$i][self::STATUS] = $row['quiz_status'];
                    $this->quiz_list[$i][self::DURATION] = $row['session_quiz_minutesduration'];
                    $this->quiz_list[$i][self::SUBTITLE] = $row['quiz_subtitle'];
                    $this->quiz_list[$i][self::SQZOPENINGDATE] = $row['session_quiz_openingdate'];
                    $this->quiz_list[$i][self::SQZCLOSINGDATE] = $row['session_quiz_closingdate'];
                    $i++;
                }
            }
            //Get all quiz :
            $sql = "SELECT quiz_id, quiz_title, quiz_subtitle, quiz_status FROM quiz";
            $sql.= " WHERE quiz_loginadmin = '$login'";
            $sql.= " ORDER BY quiz_title"; 
            $result2 = $conn->query($sql);
            if($result2 != null){
                $i=0;
                while($row = $result2->fetch_assoc()){ 
                    $this->all_quiz_list[$i][self::QUIZID] = $row['quiz_id'];
                    $this->all_quiz_list[$i][self::TITLE] = $row['quiz_title'];
                    $this->all_quiz_list[$i][self::STATUS] = $row['quiz_status'];
                    $this->all_quiz_list[$i][self::QSUBTITLE] = $row['quiz_subtitle'];
                    $i++;
                }
            }

            //accounts of the session :
            $sql = "SELECT account_login, account_name, account_firstname, account_company, account_email";
            $sql.= " FROM session_user LEFT JOIN account ON account_login = session_user_loginuser";
            $sql.= " WHERE session_user_idsession = $idsession";
            $sql.= " ORDER BY account_login";
            $result3 = $conn->query($sql);

            if($result3 != null){
                $i=0;
                while($row = $result3->fetch_assoc()){ 
                    $this->accounts_list[$i][self::LOGIN] = $row['account_login'];
                    $this->accounts_list[$i][self::AEMAIL] = $row['account_email'];
                    $this->accounts_list[$i][self::NAME] = $row['account_name'];
                    $this->accounts_list[$i][self::FIRSTNAME] = $row['account_firstname'];
                    $this->accounts_list[$i][self::COMPANY] = $row['account_company'];
                    $i++;
                }
            }
            //Get all accounts :
            $sql = "SELECT account_login, account_name, account_firstname, account_company";
            $sql.= " FROM account";
            $sql.= " WHERE account_profile = 'user' AND account_loginadmin = '$login'";
            $sql.= " ORDER BY account_login"; 
            $result4 = $conn->query($sql);
            if($result4 != null){
                $i=0;
                while($row = $result4->fetch_assoc()){ 
                    $this->all_accounts_list[$i][self::LOGIN] = $row['account_login'];
                    $this->all_accounts_list[$i][self::ACOMPANY] = $row['account_company'];
                    $this->all_accounts_list[$i][self::NAME] = $row['account_name'];
                    $this->all_accounts_list[$i][self::FIRSTNAME] = $row['account_firstname'];
                    $i++;
                }
            }
        }
    }

    public function getSession(){
        return $this->session;
    }
    public function getSessionAccounts(){
        return $this->accounts_list;
    }
    public function getAllAccounts(){
        return $this->all_accounts_list;
    }
    public function getSessionQuiz(){
        return $this->quiz_list;
    }
    public function getAllQuiz(){
        return $this->all_quiz_list;
    }
}