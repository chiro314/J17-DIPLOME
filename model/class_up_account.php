<?php
/*****************************************************************************************
* Object:      class class_up_account
* admin/user:  admin
* Scope:	   account
* 
* Feature (maquette) : Get data for the Modify screen (cf. view/div_account.php) of one account (maq-17)
* Trigger: Link "Maj" in div_accounts_list.php>>>index.php/$_REQUEST: "account/update" /class class_up_account_controller (class_up_account_controller.php)
* 
* Major tasks:  get data of the account,
*               get the sessions of the account,  
*               get all the open sessions to associate with the account.
*******************************************************************************************/

class class_up_account {  
    
    private $account;
    private $accountsessions_list;
    private $opensessions_list;

    private const LOGIN=0, PROFILE=1, NAME=2, FIRSTNAME=3, COMPANY=4;
    private const EMAIL=5;
    private const SESSIONID=0, TITLE=1, ENDDATE=2;
   
    public function __construct($accountlogin, $login){
        
        global $conn;
        
        $sql = "SELECT account_login, account_profile, account_name, account_firstname, account_company, account_email";
        $sql.= " FROM account WHERE account_login = '$accountlogin'";
     
        $result0 = $conn->query($sql);
        if($result0 != null){ // null when the account doesn't exist
           
            $row = $result0->fetch_assoc();

            $this->account[self::LOGIN] = $row['account_login'];
            $this->account[self::PROFILE] = $row['account_profile'];
            $this->account[self::NAME] = $row['account_name'];
            $this->account[self::FIRSTNAME] = $row['account_firstname'];
            $this->account[self::COMPANY] = $row['account_company'];
            $this->account[self::EMAIL] = $row['account_email'];
        
            //Get the sessions of the quiz
            $sql = "SELECT session_id, session_title, session_enddate";
            $sql.= " FROM session_user LEFT JOIN session ON session_id = session_user_idsession";
            $sql.= " WHERE session_user_loginuser = '$accountlogin'";
            $sql.= " ORDER BY session_id DESC"; 

            $result1 = $conn->query($sql);

            if($result1 != null){
                $i=0;
                while($row = $result1->fetch_assoc()){ 
                    $this->accountsessions_list[$i][self::SESSIONID] = $row['session_id'];
                    $this->accountsessions_list[$i][self::TITLE] = $row['session_title'];
                    $this->accountsessions_list[$i][self::ENDDATE] = $row['session_enddate'];
                    $i++;
                }
            }

            //Get all open sessions for the account creation screen :
            $daydate = time();
            $sql = "SELECT session_id, session_title, session_enddate FROM session";
            $sql.= " WHERE session_loginadmin = '$login'";
            $sql.= " AND (session_enddate = 0 OR session_enddate >= $daydate)";
            $sql.= " ORDER BY session_enddate ASC"; 
            $result2 = $conn->query($sql);

            if($result2 != null){
                $i=0;
                while($row = $result2->fetch_assoc()){ 
                    $this->opensessions_list[$i][self::SESSIONID] = $row['session_id'];
                    $this->opensessions_list[$i][self::TITLE] = $row['session_title'];
                    $this->opensessions_list[$i][self::ENDDATE] = $row['session_enddate'];
                    $i++;
                }
            }
        }
    }

    public function getAccount() 
    {
        return $this->account;
    }
    public function getAccountsessions() 
    {
        return $this->accountsessions_list;
    }
    public function getOpensessions() 
    {
        return $this->opensessions_list;
    }
}