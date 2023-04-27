<?php
/*****************************************************************************************
* Object:      class class_up_account_controller
* admin/user:  admin
* Scope:	   account
* 
* Feature (maquette) : Get data and display the Modify screen (cf. view/div_account.php) for one account (maq-17)
* Trigger: Link "Maj" in div_accounts_list.php>>>index.php/$_REQUEST: "account/update"
* 
* Major tasks:  get data to display the account,
*               get the sessions of the account,  
*               get all the open sessions to associate with the account.
*               
* Uses:  class class_up_account (cf. class_up_account.php)
*        and the screen view/div_account.php
*******************************************************************************************/

class class_up_account_controller {

    private $account;

    public function __construct($accountlogin, $login)
    {
        $this->account = new class_up_account($accountlogin, $login);
    }

    public function displayOne(){
        $account = []; $account = $this->account->getAccount();
        $accountsessions = []; $accountsessions = $this->account->getAccountsessions(); 
        $opensessions = [] ; $opensessions = $this->account->getOpensessions();  //not closed sessions
   
        $title = "Mettre à jour ou consulter ce compte";
        include "view/div_account.php";
    }
}