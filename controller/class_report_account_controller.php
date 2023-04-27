<?php
/*****************************************************************************************
* Object:      class_report_account_controller
* admin/user:  admin
* Scope:	   quiz result
* 
* Feature (maquette): consult the quiz results of one session, one user (account) and his quizzes (maq-14)
* Trigger:            Link on a session ("Sessions and results" column of div_accounts_list.php) /index.php/$_REQUEST: "account/reporting"
*
* Major tasks: get data to display or calculate KPI for : the session, the account (user), the quizzes ;
*              get data to display or calculate KPI for each quiz of the user ;
*              get data to display or calculate KPI of the quiz of the session not in the user playlist.
*            
* Uses: class class_report_account (cf. class_report_account.php)
*       screen view/div_stat_account_session_quiz.php
*******************************************************************************************/

class class_report_account_controller {

    private $report_account;  

    public function __construct($accountid, $sessionid, $login)
    {
        $this->report_account = new class_report_account($accountid, $sessionid, $login);
    }

    public function display(){
        $account = $this->report_account->getAccount();   
        $session = $this->report_account->getSession();        
        $sessionQuizAccountResults = $this->report_account->getSessionQuizAccountResults(); //the account quizresult for this session
        $sessionQuizWithoutAccountResult = $this->report_account->getSessionQuizWithoutAccountResult(); //the quizzes of this session without result from this account     
        $title = "Résultats d’un participant aux quiz d’une session";
        include "view/div_stat_account_session_quiz.php";
    }
}