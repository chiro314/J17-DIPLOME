<?php
//Various constants
    const DEFAULTPSW = "quiztiti"; //modelfunctions.php / function createAccount
    const NP1 = 163, NP2 = 181;

//Sizes :
    const TEXTAREA = 500, NBRESPONSESMAX = 20, NBQUESTIONSMAX = 100, NBQUIZMAX = 30, NBACCOUNTSMAX= 50;
    const SIZESESSIONS = 10, SIZEQUESTIONS = 10;
    const SECURITY=50, IDENTIFY=30, ADDRESS=50, INTITULE=50;

//index.php
    const OKKO = 1, WIDNAME = 2;
    const OK = 1, KO = 0;
    // QUESTIONID = 0

//class_quiz_userlist - div_quiz_userlist
    const ANAME = 0, AFIRSTNAME = 1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
    const SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6, SQZDURATION = 7;
    const QZTITLE = 8, QZRID = 9, QZRSTARTDATE = 10, QZRSCORE = 11, QZRMAXSCORE = 12;
    const QZID = 13, SSID = 14; //pb avec SID qui serait déjà définie...
    const NBINLINEQUESTIONS = 15;

//class_questions_list - div_questions_list
    //QUESTIONID = 0, QUESTION = 1
    const STATUS = 2, LMDATE = 3, WIDGETID = 4, qKEYWORDID = 8;
    const GUIDELINE = 5, qEXPLANATIONTITLE = 6, qEXPLANATION = 7;
    
    const KEYWORDID = 0, KEYWORD = 1;

//class_questions - div_questions :

    //QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4;
    //GUIDELINE = 5, qEXPLANATIONTITLE = 6, qEXPLANATION = 7;
    const CREATIONDATE = 8;

    //KEYWORDID = 0, KEYWORD = 1

    // aANSWER = 0, aANSWEROK = 1, STATUS = 2, LMDATE = 3 
    const aCREATIONDATE = 4, aANSWERID = 5;
    const upANSWERID = 3;

    const QUIZID = 0, TITLE= 1; // STATUS = 2, LMDATE = 3
    const SUBTITLE = 4, NUMOK = 5, NUM = 6;

//class_quiz_list - div_quiz_list - quiz
    //QUIZID = 0, TITLE= 1, STATUS = 2, LMDATE = 3, SUBTITLE = 4,
    const CRDATE = 5, NBQUESTIONS = 6, NBONGOINGSESSIONS = 7;
//class_quiz_list - div_quiz_list - questions
    //KEYWORDID = 0, KEYWORD = 1, STATUS = 2, WIDGETID = 4, qKEYWORDID = 8
    //QUESTIONID = 0, QUESTION = 1, STATUS = 2 

//class_quiz - div_quiz
    //QUIZID = 0, TITLE= 1, STATUS = 2, LMDATE = 3, SUBTITLE = 4, CRDATE = 5 
    //QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4, NUMORDER = 5
    const QUESTIONWEIGHT = 6;
    const SESSIONID = 0, SSUBTITLE = 1;
    //  STITLE = 2, SSTARTDATE = 3, SENDDATE = 4, SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6, SQZDURATION = 7
    ///QUESTIONID = 0
    const qqNUMORDER = 1, qqWEIGHT = 2;

//class_session - div_session
    //SESSIONID = 0, SSUBTITLE=1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
    const LOGO=5, BGIMAGE=6; //new

    //QUIZID = 0, TITLE= 1, STATUS = 2;
    const DURATION=3; //SUBTITLE = 4, SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6;
    const QSUBTITLE=3; //new
    const OPENINGDATE = 1, CLOSINGDATE = 2;

    //LOGIN=0, NAME=2, FIRSTNAME=3, COMPANY=4;
    const AEMAIL = 1;//new
    const ACOMPANY=1;//new

// index.php/modelfunction.php/createAnswers()
    const aANSWER = 0, aANSWEROK = 1;  //STATUS = 2

//class_keywords_list - div_keywords_list
    //KEYWORDID = 0, KEYWORD = 1
    const COUNTQUESTIONS = 2;
    const kqQUESTION = 0, kqKEYWORDID = 1;

//class_accounts_list - div_accounts_list
    const LOGIN=0, PROFILE=1, NAME=2, FIRSTNAME=3, COMPANY=4, ACCOUNTSESSIONS=5;
    const ENDDATE=2; // SESSIONID=0, TITLE=1

//class_up_accounts - div_up_accounts
    //LOGIN=0, PROFILE=1, NAME=2, FIRSTNAME=3, COMPANY=4
    const EMAIL=5;
    // SESSIONID=0, TITLE=1, ENDDATE=2

//class_sessions_list - div_sessions_list
    //SESSIONID=0, TITLE = 1, ENDDATE = 2, SSTARTDATE = 3, SUBTITLE = 4;
    const SESSIONQUIZ = 5, NBUSERS = 6;
    //QUIZID=0, TITLE = 1, STATUS = 2

// div_takenquiz.php
    const QUESTIONID =0, QUESTION = 1, QUIDELINE = 2, WIDGET = 3, WEIGHT = 4, NUMORDER = 5;
    const ANSWERSIDQUESTION = 6, ANSWER = 7, ANSWEROK = 8, ANSWERID = 9; 

//div_quizresult.php
    const QUESTIONKO = 0, EXPLANATIONTITLE = 1, EXPLANATION = 2;

// Determine Questions Results
    const dqrWIDGETID = 0, dqrQUESTIONID = 1, dqrANSWERID = 2, dqrOKKO = 3;
    const dqrOKKOQUESTION = 2;

//STAT - div_stat_account_session_quiz.php from class_report_account.php
    //$session : info + stat
    // SESSIONID = 0, SSUBTITLE=1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4,
    const NBQUIZ = 5, NBACCOUNTS = 6, SPARTICIPRATE = 7, SSUCCESSRATE = 8; 
    
    //$account : info + stat
    // LOGIN=0, AEMAIL=1, NAME=2, FIRSTNAME=3, COMPANY=4,
    const ANBQUIZRESULTS = 5, APARTICIPRATE = 6,  ASUCCESSRATE = 7; 
        
    //sessionQuizAccountResults & sessionQuizWithoutAccountResult : quiz of the session : info
        // QUIZID = 0, TITLE= 1, STATUS = 2, DURATION=3, SUBTITLE = 4, 
        //          SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6;
    //sessionQuizAccountResults & sessionQuizWithoutAccountResult : quiz of the session : stat
    const
        AVGDURSEC = 7,
        QDURATIONRATE = 8,
        NBQUIZQUESTIONS = 9,
        QTREATEDQUESTRATE = 10,
        NBQUIZRESULTS = 11,
        QPARTICIPATIONRATE = 12,
        QSUCCESSRATE = 13;
    
    //sessionQuizWithoutAccountResult
    const BLOCKED = 14;

    //sessionQuizAccountResults : quizresult : info
    const QRSTARTDATE = 14, QRENDDATE = 15, QRMAXDUR = 16, QRNBQUESTASKED = 17,
        QRMAXNBQUEST =18, QRQUESTASKEDSCORE = 19, QRMAXQUESTASKEDSCORE = 20, QRMAXSCORE = 21; 
    
    //sessionQuizAccountResults : quizresult : stat :
    const
        SQAQRDURATION = 22,
        SQAQRDURATIONRATE = 23,
        SQAQRNBQUESTRATE = 24,
        SQAQRQUESTASKEDSCORERATE = 25,
        SQAQRSCORERATE = 26;

//FUNCTIONS :
/*
function prefix($str)
function theEnd($str)
function root($str)
function suffix($str)
function inQuestionsAnswersChecked($Qid)

function className($wording)
function disconnect($message)
function testStrs($operation, $strsTransmises)
function testStrsOnly($operation, $strsTransmises)
function testNotEmpty($operation, $strsTransmises)
function validerCaptcha()

function minHoursMin($min)
function secHoursMinSec($sec)
function min_into_h_m($format, $min)
function sec_into_h_m_s($format, $sec)
*/

//////////////////////// FUNCTIONS USED BY questionanswered.php /////////////////////////

function prefix($str){ //always returns the prefix - used by root($str)
    return substr($str, 0, strpos($str, "-"));
}
function theEnd($str){ //always returns all minor the prefix
    return substr($str, strpos($str, "-")+1);
}
function root($str){ //always returns only the field after the prefix
    return prefix(theEnd($str));
}
function suffix($str){ //always returns all after the root
    return theEnd(theEnd($str));
}
$questionsAnswersChecked = [[]];
function inQuestionsAnswersChecked($Qid){
    global $questionsAnswersChecked;
    for($i=0;$i<count($questionsAnswersChecked);$i++){
        if($Qid == $questionsAnswersChecked[$i][dqrQUESTIONID]) return true;
    }
    return false;
}

///////////////////// FUNCTIONS USED BY div_session.php //////////////////////////////////

//Keep only the characters a-z, A-Z et 0-9 (else replace by '_') 
function className($wording){
    $string = trim($wording);
    for($i=0;$i<strlen($string);$i++){
        if(!(   mb_ord($string[$i]) >= mb_ord("A") and mb_ord($string[$i]) <= mb_ord("Z") or
                mb_ord($string[$i]) >= mb_ord("a") and mb_ord($string[$i]) <= mb_ord("z") or
                mb_ord($string[$i]) >= mb_ord("0") and mb_ord($string[$i]) <= mb_ord("9")
        )){
            $string[$i] = '_';
        }
    }
    $string = 'c_'.$string;
    return $string;
}

///////////////////// FUNCTIONS USED BY index.php //////////////////////////////////

function disconnect($message){
    session_destroy();
    header("Location: http://quiztiti/index.php?msghdr=".$message);
}

//Control there is no html introduced, and if mandatory field are not empty :
function testStrs($operation, $strsTransmises){
    if(count($strsTransmises) == 0) return "";
    else{
        $strsTestees = [];
        for($i=0;$i<count($strsTransmises);$i++) { 
            array_push($strsTestees, strip_tags($strsTransmises[$i]));
        }
        //$adjOrdinal = [" 1ère", " 2e", " 3e", " 4e", " 5e", " 6e"] :
        $adjOrdinal[0] = "1ère";
        for($i=1;$i<count($strsTransmises);$i++) { 
            array_push($adjOrdinal, ($i +1)."e");
        }
        //Contrôles de chaque zone de saisie : 
        for($i=0;$i<count($strsTransmises);$i++) { 
            if ($strsTestees[$i] != $strsTransmises[$i]) {
                return "L'information de la ".$adjOrdinal[$i]." zone n'était pas valide.<br>".$operation." n'a pas eu lieu.";
            }
        }
        for($i=0;$i<count($strsTransmises);$i++) { 
            if(empty($strsTransmises[$i])) {
                return "La ".$adjOrdinal[$i]." zone obligatoire était vide. ".$operation." n'a pas eu lieu.";
            }
        }
        //Tous les contrôles sont négatif (= sont OK) :
        return "";
    }
}

//Control there is no html introduced :
function testStrsOnly($operation, $strsTransmises){
    if(count($strsTransmises) == 0) return "";
    else{
        $strsTestees = [];
        for($i=0;$i<count($strsTransmises);$i++) { 
            array_push($strsTestees, strip_tags($strsTransmises[$i]));
        }
        //$adjOrdinal = [" 1ère", " 2e", " 3e", " 4e", " 5e", " 6e"] :
        $adjOrdinal[0] = "1ère";
        for($i=1;$i<count($strsTransmises);$i++) { 
            array_push($adjOrdinal, ($i +1)."e");
        }
        //Contrôles de chaque zone de saisie : 
        for($i=0;$i<count($strsTransmises);$i++) { 
            if ($strsTestees[$i] != $strsTransmises[$i]) {
                return "L'information de la ".$adjOrdinal[$i]." zone n'était pas valide.<br>".$operation." n'a pas eu lieu.";
            }
        }
        //Tous les contrôles sont négatif (= sont OK) :
        return "";
    }
}

//Control mandatory field are not empty :
function testNotEmpty($operation, $strsTransmises){  
    //$adjOrdinal = [" 1ère", " 2e", " 3e", " 4e", " 5e", " 6e"] :
    if(count($strsTransmises) == 0) return "";
    else{
        $adjOrdinal[0]="1ère";
        for($i=1;$i<count($strsTransmises);$i++) { 
            array_push($adjOrdinal, ($i +1)."e");
        }
        //Contrôles de chaque zone de saisie : 
        for($i=0;$i<count($strsTransmises);$i++) { 
            if(empty($strsTransmises[$i])) {
                return "La ".$adjOrdinal[$i]." zone obligatoire était vide. ".$operation." n'a pas eu lieu.";
            }
        }
        //Tous les contrôles sont négatif (= sont OK) :
        return "";
    }
}

function validerCaptcha(){
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LfpDcElAAAAACcuM13fkgKOxuOIvV7EZpD6_Ycl&response={$_POST['g-recaptcha-response']}";
    
    $response = file_get_contents($url);
    
    if(empty($response) || is_null($response)) {
        echo "empty $response";  //header('Location: index.php');
        return false;
    }
    else{
        $data = json_decode($response);

        if($data->success) return true;
        else  return false;    //header('Location: index.php');
    }
}

///////////////////// FUNCTIONS USED BY div_quizresult.php //////////////////////////////////

function minHoursMin($min){ //minutes into minutes or into hours + minutes
    if($min > 59) {
        $strDuration = intdiv($min, 60);   
        $strDuration = $strDuration > 1 ? strval($strDuration)." heures" : strval($strDuration)." heure";
        
        //$strDuration.= $min % 60 ? " et ".strval($min % 60)." minutes" : "";
        //$strDuration.= $min % 60 ? " et ".strval($min % 60).($min % 60 > 1 ? " minutes" : " minute") : "";
        $strDuration.= $min % 60 ? " ".strval($min % 60).($min % 60 > 1 ? " minutes" : " minute") : "";
    }
    else $strDuration = $min." minute".($min > 1? "s" : "");

    return $strDuration;
}

function secHoursMinSec($sec){ //secondes into secondes or into minutes + secondes or into hours + minutes + secondes 
    if($sec > 59) {
        $strDuration = minHoursMin(intdiv($sec, 60));   // min       
        
        //$strDuration.= $sec % 60 ? " et ".strval($sec % 60)." secondes" : "";
        $strDuration.= $sec % 60 ? " et ".strval($sec % 60).($sec % 60 > 1 ? " secondes" : " seconde") : "";
    }
    else $strDuration = $sec." seconde".($sec <=1 ? "" : "s");

    return $strDuration;
}

function min_into_h_m($format, $min){ // minutes >> 'h:m' : minutes into minutes or into hours + minutes
    switch($format){

        case'h:m':
            return strval(intdiv($min, 60)).":".strval($min % 60);
        break;
        case'hh:mm':
            $strDuration = intdiv($min, 60) <10 ? "0" : "";
            $strDuration.= strval(intdiv($min, 60)).":";
            $strDuration.= strval($min % 60) <10 ? "0" : "";
            $strDuration.= strval($min % 60);
            return $strDuration;
        break;
        default: //hh:mm:00
            $strDuration = intdiv($min, 60) <10 ? "0" : "";
            $strDuration.= strval(intdiv($min, 60)).":";
            $strDuration.= strval($min % 60) <10 ? "0" : "";
            $strDuration.= strval($min % 60);
            $strDuration.= ":00";
            return $strDuration;
        break;
    }
}

function sec_into_h_m_s($format, $sec){ //secondes into secondes or into minutes + secondes or into hours + minutes + secondes 
    switch($format){
        case'h:m:s':
            return min_into_h_m('h:m', intdiv($sec, 60)).':'.strval($sec % 60);
        break;
        default: //hh:mm:ss
            $strDuration = min_into_h_m('hh:mm', intdiv($sec, 60)).':';
            $strDuration.= strval($sec % 60) <10 ? "0" : "";
            $strDuration.= strval($sec % 60); 
            
            return $strDuration;
        break;
    }
}

function timeusedpercent($durationInSec, $quizMaxDuration){
    return (100 * round($durationInSec / (60 * $quizMaxDuration), 2));   
}
