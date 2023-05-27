<?php
/*****************************************************************************************
* Object: class account
* admin/user:  admin & user
* Scope:	   Login & Account
*
* Features (maquettes) : Log in (maq-01-02) ; Change password (maq-06-07)
* Triggers:    index.php/$_REQUEST: "account/connection" /class account_controller (class_account_controller.php)
*              index.php/$_REQUEST: "account/password" /class account_controller (class_account_controller.php)
* 
* Major DB operations : updatePassword(log, psw), checkExists (log, psw), checkIsFree (log)
*******************************************************************************************/

class account {
    private $plaintextPassword;
    private $login;
    private $psw;
    private $profile; // (admin, user) 
    private $firstname;
    private $name;

    public function __construct($login, $psw){
        $this->plaintextPassword = $psw;
        $this->login = $login;
        $this->psw = sha1($psw);
        $this->profile = "";
        $this->firstname = "";
        $this->name = "";
    }
    
    public function getName(){
        return $this->name;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getProfile(){
        return $this->profile;
    }

    public function checkIsFree(){
        global $conn;
        /*
        $sql = "SELECT account_login from account where account_login = '$this->login'";
        $result = $conn->query($sql);
        $i=0;
        while($row = $result-> fetch_assoc()) {$i++;}
        return ($i == 0)? true : false;
        */
        $sql = "SELECT count(*) from account where account_login = '$this->login'";
        $result = $conn->query($sql);
        $row = $result-> fetch_assoc();
        return ($row == 0)? true : false;
    }

    public function checkExists(){
        global $conn; 

        $sql = "SELECT account_login, account_firstname, account_name, account_profile";
        $sql.= " from account where account_login = '$this->login' and account_psw = '$this->psw'";
        $result = $conn->query($sql);
        $i=0;
        while($row = $result-> fetch_assoc()) {
            $i++;
            $this->profile = $row['account_profile'];
            $this->firstname = $row['account_firstname'];
            $this->name = $row['account_name'];
        }
        if($i == 0) return 0; //ko
        else if ($this->psw == sha1(DEFAULTPSW)) return 1; //change password
        else return 2; //ok
    }

    public function checkAdmin($loginadmin){ //function not used
        global $conn;
        $sql = "SELECT account_loginadmin from account where account_login = '$this->login'";
        $result = $conn->query($sql);
        $row = $result-> fetch_assoc();
        if($row['account_loginadmin'] == $loginadmin) return true;
        else return false;
    }

    public function updatePassword($login, $newpsw){
        global $conn;
        $sql = "UPDATE account SET account_psw=? WHERE account_login=?";

        $stmt = $conn->prepare($sql);

        $encryptedPsw = sha1($newpsw);
        $stmt -> bind_param("ss", $encryptedPsw, $login);
        $stmt ->execute();
        $stmt -> close();

        //try to disconnect() here...
    }

    public function controlPassword($inputpsw){
        return pswcontrol($inputpsw, $this->plaintextPassword, $this->name, $this->firstname);
    }
}