<?php
/*****************************************************************************************
* Object:      class class_sessions_list
* admin/user:  admin
* Scope:	   session
* 
* Feature (maquette): get data of your sessions (maq-18-19) : data from each session and quizzes from each session, with Supp. and Maj links for each session.
* Trigger:            Menu button "Vos sessions" / index.php/$_REQUEST: "session/list" / class class_sessions_list_controller (class_sessions_list_controller.php)
*
* Major tasks:  get data of all the sessions and their quizzes. 
*******************************************************************************************/

class class_sessions_list{

    private $sessions_list;
    private const SESSIONID=0, TITLE = 1, ENDDATE = 2, SSTARTDATE = 3, SUBTITLE = 4;
    private const SESSIONQUIZ = 5, NBUSERS = 6;
    private const QUIZID=0, STATUS = 2; //TITLE = 1
  
    public function __construct($login){

        global $conn;
        
        $sql = "SELECT session_id, session_title, session_subtitle, session_startdate, session_enddate,";
        $sql.= " quiz_id, quiz_title, quiz_status";
        $sql.= " FROM session LEFT JOIN session_quiz ON session_quiz_idsession  = session_id";
        $sql.= " LEFT JOIN quiz ON quiz_id = session_quiz_idquiz";
        $sql.= " WHERE session_loginadmin = '$login'";
        $sql.= " ORDER BY session_id DESC"; 
    
        $result = $conn->query($sql);
        
        if($result != null){ // null when the table is empty
            
            $sessionId = 0;
            $i=-1; //session index
            while($row = $result->fetch_assoc()){
                if($row['session_id'] != $sessionId){ //new session
                    $sessionId = $row['session_id'];
                    $iq=0; //quiz index
                    $i++;
                    $this->sessions_list[$i][self::SESSIONID] = $row['session_id'];
                    $this->sessions_list[$i][self::TITLE] = $row['session_title'];
                    $this->sessions_list[$i][self::ENDDATE] = $row['session_enddate'];
                    $this->sessions_list[$i][self::SSTARTDATE] = $row['session_startdate'];
                    $this->sessions_list[$i][self::SUBTITLE] = $row['session_subtitle'];
                }
                $this->sessions_list[$i][self::SESSIONQUIZ][$iq][QUIZID] = $row['quiz_id'];
                $this->sessions_list[$i][self::SESSIONQUIZ][$iq][TITLE] = $row['quiz_title']; 
                $this->sessions_list[$i][self::SESSIONQUIZ][$iq][STATUS] = $row['quiz_status']; 
                $iq++;
            }

            //NBUSERS :
            $sql = "SELECT session_id, COUNT(session_user_loginuser) AS nbusers FROM session LEFT JOIN session_user";
            $sql.= " ON session_user_idsession = session_id";
            $sql.= " WHERE session_loginadmin = '$login'";
            $sql.= " GROUP BY session_id ORDER BY session_id DESC";
            $result = $conn->query($sql);
            $i=0;
            while($row = $result->fetch_assoc()){
                $this->sessions_list[$i][self::NBUSERS] = $row['nbusers'];
                $i++;
            }
            /*
            //https://www.webrankinfo.com/forum/t/sql-casse-tete-dun-tri-sur-une-requete-employant-union-all.122899/

            SELECT Nom_utilisateur, Pays_utilisateur
            FROM (  SELECT 1 AS critere, Nom_utilisateur, Pays_utilisateur
                    FROM UTILISATEUR
                    WHERE partenaire="1" AND pays IN ("France")
                  UNION ALL
                    SELECT 2, Nom_utilisateur, Pays_utilisateur
                    FROM UTILISATEUR
                    WHERE pays IN ("France") 
                 )
            x ORDER BY critere, Nom_utilisateur ;
            */

        }
    }

    public function getSessions() 
    {
        return $this->sessions_list;
    }
}