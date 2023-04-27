<?php
/*****************************************************************************************
 * Object: class account_controller
 * admin/user:  admin & user
 * Scope:	    Login & Account
 *
 * Features (maquettes) : Log in (maq-01-02) ; Change password (maq-06-07)
 * Triggers:    index.php/$_REQUEST: "account/connection"
 *              index.php/$_REQUEST: "account/password"
 * 
 * Major tasks: updatePassword(log, psw), checkExists (log, psw), checkIsFree (login)
 * Use : class account (cf. class_account.php)
 *******************************************************************************************/

 class account_controller {

    private $account;

    public function __construct($login, $psw){
        $this->account = new account($login, $psw);
    }

    public function getProfile(){
        return $this->account->getProfile();
    }
    public function getFirstname(){
        return $this->account->getFirstname();
    }
    public function updatePassword($login, $newpsw){
        return $this->account->updatePassword($login, $newpsw);
    }
    
    public function checkExists()
    {
        return $this->account->checkExists();
    }

    public function checkIsFree()
    {
        return $this->account->checkIsFree();
    }

    public function insert($profile)
    {
        $this->account->insert($profile);
    }
} 