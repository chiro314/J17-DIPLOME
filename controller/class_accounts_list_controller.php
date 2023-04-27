<?php
/*****************************************************************************************
* Object:      class class_accounts_list_controller
* admin/user:  admin
* Scope:	   account
* 
* Feature (maquette) :  Consult the list of your own accounts (maq-13)
* Trigger:              index.php/$_REQUEST: "account/list"
* 
* Major tasks: display all the accounts
* Uses:  class class_accounts_list connected with the DB (cf. class_accounts_list.php)
*       and the screen view/div_accounts_list.php
*******************************************************************************************/

class class_accounts_list_controller {

    private $accounts_list; 
    

    public function __construct($login)
    {
        $this->accounts_list = new class_accounts_list($login);
    }

    public function displayAll(){
        $accountsList = $this->accounts_list->getAccounts();       
        $allOpenSessions = $this->accounts_list->getAllOpenSessions(); //for creation   
        $title = "Liste de vos comptes et de leurs résultats";
        global $message;
    //var_dump($accountsList);
        include "view/div_accounts_list.php";
    }
}