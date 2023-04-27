<?php
/*****************************************************************************************
* Object:      class class_accounts_list_controller
* admin/user:  admin
* Scope:	   account
* 
* Feature (maquette) :  Consult the list of your own accounts (maq-13)
* Trigger:              index.php/$_REQUEST: "account/list" /class class_accounts_list_controller (class_accounts_list_controller.php)
* 
* Major DB operations : get the accounts and all the oppened sessions (for account creation).
*******************************************************************************************/

//https://fr.tuto.com/blog/2021/01/php-foreach-tableau.htm# 

class class_accounts_list{

    private $accounts_list;
    private $allopensessions_list; //for account creation
  
    private const LOGIN=0, PROFILE=1, NAME=2, FIRSTNAME=3, COMPANY=4, ACCOUNTSESSIONS=5, EMAIL = 6;
    private const SESSIONID=0, TITLE=1, ENDDATE=2, SSTARTDATE = 3;

    public function __construct($login){

        global $conn;
        
        $sql = "SELECT account_login, account_profile, account_name, account_firstname, account_company,";
        $sql.= " session_id, session_title, session_enddate, session_startdate";
        $sql.= " FROM account LEFT JOIN session_user ON session_user_loginuser = account_login";
        $sql.= " LEFT JOIN session ON session_id = session_user_idsession";
        $sql.= " WHERE account_loginadmin = '$login'";
        $sql.= " ORDER BY account_login"; 
    
        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
            
            $accountLogin = "";
            $i=-1; //account index
            while($row = $result->fetch_assoc()){
                if($row['account_login'] != $accountLogin){ //new account
                    $accountLogin = $row['account_login'];
                    $is=0;
                    $i++;
                    $this->accounts_list[$i][self::LOGIN] = $row['account_login'];
                    $this->accounts_list[$i][self::PROFILE] = $row['account_profile'];
                    $this->accounts_list[$i][self::NAME] = $row['account_name'];
                    $this->accounts_list[$i][self::FIRSTNAME] = $row['account_firstname'];
                    $this->accounts_list[$i][self::COMPANY] = $row['account_company'];
                }
                //ENDDATE=2; // SESSIONID=0, TITLE=1 
                $this->accounts_list[$i][self::ACCOUNTSESSIONS][$is][SESSIONID] = $row['session_id'];
                $this->accounts_list[$i][self::ACCOUNTSESSIONS][$is][TITLE] = $row['session_title']; 
                $this->accounts_list[$i][self::ACCOUNTSESSIONS][$is][ENDDATE] = $row['session_enddate']; 
                $this->accounts_list[$i][self::ACCOUNTSESSIONS][$is][SSTARTDATE] = $row['session_startdate']; 
                $is++;
            }
        }

        //Get all open sessions for the account creation screen :
        $daydate = time();
        $sql = "SELECT session_id, session_title, session_enddate FROM session";
        $sql.= " WHERE session_loginadmin = '$login'";
        $sql.= " AND (session_enddate = 0 OR session_enddate >= $daydate)";
        $sql.= " ORDER BY session_enddate ASC"; 
        $result0 = $conn->query($sql);

        if($result0 != null){
            $i=0;
            while($row = $result0->fetch_assoc()){ 
                $this->allopensessions_list[$i][self::SESSIONID] = $row['session_id'];
                $this->allopensessions_list[$i][self::TITLE] = $row['session_title'];
                $this->allopensessions_list[$i][self::ENDDATE] = $row['session_enddate'];
                $i++;
            }
        }
    }

    public function getAccounts() 
    {
        return $this->accounts_list;
    }
    public function getAllOpenSessions() 
    {
        return $this->allopensessions_list;
    }
}