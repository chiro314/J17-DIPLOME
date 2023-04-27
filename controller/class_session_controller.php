<?php
/*****************************************************************************************
* Object:      class class_session_controller
* admin/user:  admin
* Scope:	   session
* 
* Features (maquette) : Get data and display the Modify screen (cf. view/div_session.php) for one session (maq-20)
* Triggers: Link "Maj" in div_sessions_list.php>>>index.php/$_REQUEST: "session/update"
* 
* Major tasks:  get data to display the session,
*               get the quizzes of the session,  
*               get all the quizzes to associate with the session,
*               get the accounts of the session,  
*               get all the accounts to associate with the session.
*
* Uses:  class class_session (cf. class_session.php)
*        and the screen view/div_session.php
*******************************************************************************************/

class class_session_controller {

    private $session;  

    public function __construct($id, $login)
    {
        $this->session = new class_session($id, $login);
    }

    public function displayOne(){
        $session = []; $session = $this->session->getSession();        
        $sessionQuiz =[]; $sessionQuiz = $this->session->getSessionQuiz(); //the quiz of the session     
        $allQuiz = []; $allQuiz = $this->session->getAllQuiz(); //select * from quiz
        $sessionAccounts =[]; $sessionAccounts = $this->session->getSessionAccounts();  //the accounts of the session     
        $allAccounts = []; $allAccounts = $this->session->getAllAccounts(); //select * from account
        
        $allCompaniesData = []; 
        if($allAccounts != null){
            $j=0;
            for ($i=0; $i < count($allAccounts); $i++) { 
                if($allAccounts[$i][ACOMPANY] != null){
                    $allCompaniesData[$j] = $allAccounts[$i][ACOMPANY];
                    $j++;
                }
            }
            sort($allCompaniesData);
        }
        $allCompanies0[0] = 'Aucun';
        $allCompanies = array_merge($allCompanies0, $allCompaniesData);

        $title = "Mettre à jour ou consulter cette session";
        include "view/div_session.php";
    }
}