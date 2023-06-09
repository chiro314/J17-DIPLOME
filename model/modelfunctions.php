<?php
/* All these functions are called from index.php */

//https://www.php.net/manual/fr/mysqli-stmt.bind-param.php
//https://codescracker.com/php/php-get-result-and-mysqli-stmt-get-result.htm
//https://www.php.net/manual/fr/mysqli.quickstart.prepared-statements.php

/* List of the functions :

/////////////////////////// QUESTION ///////////////////////////////////////////////////

function createQuestion($question_question, $question_guideline,
$question_explanationtitle, $question_explanation, $question_status,
$question_creationdate, $question_lastmodificationdate, 
$question_idwidget, $question_loginadmin)

function inlineQuestionIntegrity($questionId) //TEST (to test the integrity of a question getting 'inline' status, in relation to answers)
function draftQuestionIntegrity($questionId) //TEST (to test the integrity of quezzes 'inline', in relation to a question getting 'draft' status)
function questionToStatusDraft($questionId) //TEST (used before deleting a question to be able to test the consequences on quezzes status)
function draftQuestionIntegrityMessage($questionId) //TEST (draftQuestionIntegrity + update of the global $message)

function updateQuestion($updatedquestiondid, $question_question, $question_guideline,$question_explanationtitle,
                        $question_explanation, $question_status, $date,
                        $question_idwidget, $login)

function deleteQuestion($question_id)
function createAnswers ($answers, $dates, $question_id)
function bindKeywords($question_id, $questionKeywords)
function up_bindKeywords($question_id, $questionKeywords)
function deleteAnswers($answersToDelete)
function updateAnswers($answersToUpdate, $date, $questionid)

/////////////////////////// QUIZ ///////////////////////////////////////////////////

//index.php/form_lock_quiz (from div_quiz_userlist.php)///////////////////////////////////////////////////
function lockQuiz($quizid, $userlogin)

function createQuiz($quiz_title, $quiz_subtitle,
    $quiz_status, $quiz_creationdate, $quiz_lastmodificationdate, $quiz_loginadmin)

function deleteQuiz($quiz_id)
function updateQuiz($quizid, $quizTitle, $quizSubtitle, $quizStatus, $date)
function bindQuestions ($quiz_id, $questions)
function inlineQuizIntegrity($quizId) //TEST (to test the integrity of a quiz getting 'inline' status, in relation to its questions)
function bindQuizQuestions($questionsToBind, $quizid)
function unbindQuestions($questionsToUnbind, $quizid)
function updateQuizQuestions($questionsToUpdate, $quizid)

/////////////////////////// ACCOUNT ////////////////////////////////////////////////////////

function createAccountadmin($name, $firstname, $login, $psw)
function createAccount($accountLoginadmin, $accountLogin, $accountName, $accountFirstname, $accountCompany, $accountEmail, $addCreateAccountSessions)

//index.php/form_delete_account from div_account_list.php///////////////////////
function deleteAccount($deletedaccountlogin, $login)
function updateAccount($accountLogin, $accountName, $accountFirstname, $accountCompany, $accountEmail, $ressetPsw){


//////////////////////////// SESSION ///////////////////////////////////////////////////

//index.php/form_delete_session from div_session_list.php///////////////////////
function deleteSession($deletedsessionid, $login, $suppWhollyOwnedAccounts)

//index.php/form_create_session from div_session_list.php///////////////////////
function createSession($login, $sessionTitle, $sessionSubtitle, $sessionStartdate, $sessionEnddate)

///////////////////index.php/form_update_session (from div_session.php)//////////////
function updateSession($session_id, $session_title, $session_subtitle, $session_startdate,
    $session_enddate, $session_logolocation, $session_bgimagelocation)

function bindQuizToSession($quizToBind, $session_id)
function unbindSessionQuiz($quizToUnbind, $session_id)
function updateSessionQuiz($quizToUpdate, $session_id)
function bindAccountsToSession($accountsToBind, $session_id)
function unbindSessionAccounts($accountsToUnbind, $session_id)

END OF THE LIST ///////////////////////////////////////////////
*/

///////////////////////// QUESTION /////////////////////////////////////////////////////////////////////

/* SELECT without 'prepare'

function createQuestion($question_question, $question_guideline,
$question_explanationtitle, $question_explanation, $question_status,
$question_creationdate, $question_lastmodificationdate, 
$question_idwidget, $question_loginadmin){

    //maj de la base :
    global $conn;
    $sql = "INSERT INTO question (question_question, question_guideline,";
    $sql.= " question_explanationtitle, question_explanation, question_status,";
    $sql.= " question_creationdate, question_lastmodificationdate, question_idwidget, question_loginadmin)";
    $sql.= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare ($sql);
    $stmt -> bind_param ("sssssiiss", $question_question, $question_guideline,
        $question_explanationtitle, $question_explanation, $question_status,
        $question_creationdate, $question_lastmodificationdate, 
        $question_idwidget, $question_loginadmin
    ); 
    $stmt ->execute();
    $stmt -> close();

    //Get the id back :
    $sql = "SELECT question_id FROM question";
    $sql.= " WHERE question_loginadmin = '$question_loginadmin' AND question_creationdate = $question_creationdate";
    $result = $conn->query($sql);
    if($result != null){ 
        $row = $result->fetch_assoc();
        return $row['question_id'];
    }
    else return null;
}
*/
function createQuestion($question_question, $question_guideline,
$question_explanationtitle, $question_explanation, $question_status,
$question_creationdate, $question_lastmodificationdate, 
$question_idwidget, $question_loginadmin){

    //maj de la base :
    global $conn;
    $sql = "INSERT INTO question (question_question, question_guideline,";
    $sql.= " question_explanationtitle, question_explanation, question_status,";
    $sql.= " question_creationdate, question_lastmodificationdate, question_idwidget, question_loginadmin)";
    $sql.= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare ($sql);
    $stmt -> bind_param ("sssssiiss", $question_question, $question_guideline,
        $question_explanationtitle, $question_explanation, $question_status,
        $question_creationdate, $question_lastmodificationdate, 
        $question_idwidget, $question_loginadmin
    ); 
    $stmt ->execute();
    $stmt -> close();

    //Get the id back :
    $sql = "SELECT question_id FROM question";
    $sql.= " WHERE question_loginadmin = ? AND question_creationdate = ?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param ("si", $question_loginadmin, $question_creationdate);
    $stmt ->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($result and $row){ 
        $stmt -> close();
        return $row['question_id'];
    }
    else{
        $stmt -> close();
        return null;
    }
}

function inlineQuestionIntegrity($questionId, $widget){ //TEST
    /*Controls :
    Si demande de publication de la question (statut « inline ») alors contrôler :
        Si widget « radio », la question sera Maj avec un statut « draft » dans les cas suivants :
            Si Nombre de réponses publiées < 2
            Sinon si Nombre de bonnes réponses publiées différent de 1
        Si widget « checkbox », la question sera Maj avec un statut « draft » dans le cas suivant :
            Si pas de réponse publiée
    
    Translation : if(question status == « inline ») then control:
        If widget == radio, the status question is updated with 'draft' when:
            Number of inline answers < 2
            Number of inline 'good answer' != 1
        If widget == checkbox, the status question is updated with 'draft' when:
            Number of inline answers == 0
    */

    global $conn;
    $sql = "SELECT COUNT(*) AS nbInlineAnswers FROM answer";
    $sql.= " WHERE answer_idquestion = $questionId AND answer_status = 'inline'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    switch($widget){
        case 'checkbox':
            if($row['nbInlineAnswers'] == '0'){
                $sql = "UPDATE question SET question_status = 'draft' WHERE question_id =$questionId";
                $conn->query($sql);
            }
            return $row['nbInlineAnswers'];
        break;
        case 'radio':
            if($row['nbInlineAnswers'] < '2'){
                $sql = "UPDATE question SET question_status = 'draft' WHERE question_id =$questionId";
                $conn->query($sql);
                return "ko-2";
            }
            else{
                $sql = "SELECT COUNT(*) AS nbInlineGoodAnswers FROM answer";
                $sql.= " WHERE answer_idquestion = $questionId AND answer_ok = 1";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                if($row['nbInlineGoodAnswers'] != '1'){
                    $sql = "UPDATE question SET question_status = 'draft' WHERE question_id =$questionId";
                    $conn->query($sql);
                    return "ko-1";
                }
                else return "ok";
            }
        break;
    }
}

function draftQuestionIntegrity($questionId){ //TEST
    /*Controls :
    Après Maj/dépublication (ou inline/Supp.) de la question (statut 'draft') alors contrôler :
        si l'un des quiz inline utilisant cette question
            a moins de 1 question inline (==0) alors il prend le statut 'draft'

    Translation : After Update/depublication (or inline/Supp.) of the question (status 'draft') the check:
        if one of the inline quizzes using this question
            has less than 1 inline question (==0) then it takes the status 'draft'
    */

    global $conn, $login;
    
    //quiz with unless 1 question inline:
    $sql ="SELECT DISTINCT quiz_question_idquiz, quiz_title";
    $sql.=" FROM quiz_question";
    $sql.=" LEFT JOIN quiz ON quiz_id = quiz_question_idquiz";
    $sql.=" WHERE quiz_status = 'inline'";
    $sql.=" AND quiz_loginadmin = '$login'";
    //only quizzes with the question (Maj/draft or inline/Supp.):
    $sql.=" AND quiz_question_idquiz IN";
    $sql.=" (SELECT DISTINCT quiz_question_idquiz";
    $sql.=" FROM quiz_question";
    $sql.=" WHERE quiz_question_idquestion = $questionId)";
    //only quizzes without inline question:
    $sql.=" AND quiz_question_idquiz NOT IN";
    $sql.=" (SELECT DISTINCT quiz_question_idquiz";
    $sql.=" FROM quiz_question";
    $sql.=" LEFT JOIN question ON question_id = quiz_question_idquestion";
    $sql.=" WHERE question_status = 'inline'";
    $sql.=" AND question_loginadmin = '$login')";

    $result = $conn->query($sql);
    $myReturn = [];
    if($result != null){
        while($row = $result->fetch_assoc()){
            $quizid = $row['quiz_question_idquiz'];
            $sql2 = "";
            $sql2 = "UPDATE quiz SET quiz_status = 'draft' WHERE quiz_id = $quizid";
            $conn->query($sql2);

            //$myReturn[] = $quizid;
            $myReturn[] = $row['quiz_title'];  
        }
    }
var_dump($myReturn);
    return $myReturn;
}
function draftQuestionIntegrityMessage($questionId){
    global $message;
    
    //$draftQuestionIntegrity = draftQuestionIntegrity($_POST['updatedquestiondid']);
    $draftQuestionIntegrity = draftQuestionIntegrity($questionId);
    if($draftQuestionIntegrity != null){
        $message.="<br>Quiz passé(s) à l'état 'draft' : ";
        $message.=implode(", ", $draftQuestionIntegrity).".";
    }
}
function questionToStatusDraft($questionId){
    global $conn;
    $sql = "UPDATE question SET question_status = 'draft' WHERE question_id =$questionId";
    $conn->query($sql);
}

//https://www.php.net/manual/en/mysqli-stmt.bind-param.php

/* SELECT without 'prepare'

function deleteQuestion($question_id){
    global $conn;
    $sql = "DELETE from question WHERE question_id = $question_id";
    $conn->query($sql);
}
*/
/*
function deleteQuestion($question_id){
    global $conn;
    $sql = "DELETE from question WHERE question_id = ?";
    $stmt = $conn->prepare ($sql);
    $stmt -> bind_param ("i", $question_id);
    $stmt ->execute();
    $stmt -> close();
}
*/
function deleteQuestion($question_id){
    global $conn, $login;
    $sql = "DELETE from question WHERE question_id = ? AND question_loginadmin = ?";
    $stmt = $conn->prepare ($sql);
    $stmt -> bind_param ("is", $question_id, $login);
    $stmt ->execute();
    $stmt -> close();
}

////////Answers//////////////

function createAnswers ($answers, $dates, $question_id){
    //maj de la base :
    global $conn;
    $sql = "INSERT INTO answer (answer_answer, answer_ok, answer_status,";
    $sql.= " answer_creationdate, answer_lastmodificationdate, answer_idquestion)";
    $sql.= " VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($answers);$i++){
        $stmt -> bind_param ("sisiii", $answers[$i][aANSWER], $answers[$i][aANSWEROK], $answers[$i][STATUS],
            $dates, $dates, $question_id); 
        $stmt ->execute();
    }
    $stmt -> close();
}

////////Keywords//////////////

function bindKeywords($question_id, $questionKeywords){ //for a question

    //maj de la base :
    global $conn;
    $sql = "INSERT INTO question_keyword (question_keyword_idquestion , question_keyword_idkeyword)";
    $sql.= " VALUES (?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($questionKeywords);$i++){
        
        $stmt->bind_param("ii", $question_id, $questionKeywords[$i]); 
        $stmt->execute(); 
    }
    $stmt->close();
}

/////////////////////////Update a question/////////////////////////////////////////////////////////////////////

function updateQuestion($updatedquestiondid, $question_question, $question_guideline,$question_explanationtitle,
                        $question_explanation, $question_status, $date,
                        $question_idwidget, $login){
    //update the DB :
    global $conn;
    $sql = "UPDATE question SET question_question=?, question_guideline=?, question_explanationtitle=?,";
    $sql.= " question_explanation=?, question_status=?, question_lastmodificationdate=?,";
    $sql.= " question_idwidget=?, question_loginadmin=? WHERE question_id=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param ("sssssissi",$question_question, $question_guideline, $question_explanationtitle,
            $question_explanation, $question_status, $date,
            $question_idwidget, $login, $updatedquestiondid); 
    $stmt ->execute();
    $stmt -> close();
}

///////keywords/////////////////

function up_bindKeywords($question_id, $questionKeywords){ //for a question

    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    global $conn;

    //Update the DB : get all the keywords off an then bind the new list of keywords :
    $conn->begin_transaction();
    try {
        //get all the keywords off
        $sql = "DELETE from question_keyword WHERE question_keyword_idquestion = $question_id";
        $conn->query($sql);

        //bind the new list of keywords
        $sql = "INSERT INTO question_keyword (question_keyword_idquestion , question_keyword_idkeyword)";
        $sql.= " VALUES (?, ?)";
        $stmt = $conn->prepare ($sql);

        for($i=0;$i<count($questionKeywords);$i++){  
            $stmt->bind_param("ii", $question_id, $questionKeywords[$i]); 
            $stmt->execute(); 
        }
        $stmt->close();
        $conn->commit();

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        throw $exception;
    } 
}
///////Answers/////////////////

//use function createAnswers ($answers, $dates, $question_id)

function deleteAnswers($answersToDelete){
    global $conn;
    $sql = "DELETE from answer WHERE answer_id IN (";
    for($i=0;$i<count($answersToDelete);$i++) {
        $sql.= $answersToDelete[$i].",";
    }
    $sql = substr($sql, 0, -1); //get the last ',' away
    $sql.= ")";

    $conn->query($sql);
}
/*
function deleteAnswers($answersToDelete){
    global $conn;
    $sql = "DELETE from answer WHERE answer_id IN (";
    for($i=0;$i<count($answersToDelete);$i++){
        $sql.="?,";
    }
    $sql = substr($sql, 0, -1); //get the last ',' away
    $sql.= ")";
    $stmt = $conn->prepare ($sql);
    $ii = "";
    for($i=0;$i<count($answersToDelete);$i++) {
        $ii.="i";
    }
    $stmt->bind_param($ii, $answersToDelete); 
    $stmt->execute();
    $stmt -> close();
}
*/

function updateAnswers($answersToUpdate, $date, $questionid){
    //update the DB :
    global $conn;
    $sql = "UPDATE answer SET answer_answer=?, answer_ok=?, answer_status=?, answer_lastmodificationdate=?, answer_idquestion=? WHERE answer_id =?";
    $stmt = $conn->prepare($sql);

    //aANSWER = 0, aANSWEROK = 1, STATUS = 2, upANSWERID = 3;
    for($i=0;$i<count($answersToUpdate);$i++){
        $stmt -> bind_param ("sisiii", $answersToUpdate[$i][aANSWER], $answersToUpdate[$i][aANSWEROK], $answersToUpdate[$i][STATUS],
            $date, $questionid, $answersToUpdate[$i][upANSWERID]); 
        $stmt ->execute();
    }
    $stmt -> close();
}

///////////////////////////////// QUIZ /////////////////////////////////////////////////////////////////////

//index.php/form_lock_quiz (from div_quiz_userlist.php)///////////////////////////////////////////////////
/*
function lockQuiz($quizid, $userlogin){
    global $conn;
    
    $sql = "SELECT COUNT(*) AS islocked FROM quizlock";
    $sql.= " WHERE quizlock_user = '$userlogin' AND quizlock_quizid = $quizid";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['islocked'] > 0) return 0;
    else{
        $sql2 = "INSERT INTO quizlock (quizlock_user , quizlock_quizid, quizlock_datetime)";
        $sql2.= " VALUES (?, ?, ?)";
        $stmt = $conn->prepare ($sql2);

        $date= time();
        $stmt -> bind_param ("sii", $userlogin, $quizid, $date); 
        $stmt ->execute();
        $stmt -> close();
        return $date;
    }
}       
*/
function lockQuiz($quizid, $sessionid, $userlogin){
    global $conn;
    
    $sql = "SELECT COUNT(*) AS islocked FROM quizlock";
    $sql.= " WHERE quizlock_user = '$userlogin' AND quizlock_quizid = $quizid AND quizlock_sessionid = $sessionid";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['islocked'] > 0) return 0;
    else{
        $sql2 = "INSERT INTO quizlock (quizlock_user , quizlock_quizid, quizlock_datetime, quizlock_sessionid)";
        $sql2.= " VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare ($sql2);

        $date= time();
        $stmt -> bind_param ("siii", $userlogin, $quizid, $date, $sessionid); 
        $stmt ->execute();
        $stmt -> close();
        return $date;
    }
}     
function unlockQuiz($quizid, $sessionid, $userlogin){

//echo("<br>quizid : ".$quizid." - sessionid : ".$sessionid." - userlogin : ".$userlogin);

    global $conn;
    
    $sql = "SELECT COUNT(*) AS islocked FROM quizlock";
    $sql.= " WHERE quizlock_user = '$userlogin' AND quizlock_quizid = $quizid AND quizlock_sessionid = $sessionid";

    $result = $conn->query($sql);

    if($result and $result->num_rows){
        $row = $result->fetch_assoc();
        if(!$row['islocked']) return 0;
        else{
            $sql2 = "DELETE from quizlock WHERE quizlock_user = ? AND quizlock_quizid = ? AND quizlock_sessionid = ?";
            $stmt = $conn->prepare ($sql2);
            $stmt -> bind_param ("sii", $userlogin, $quizid, $sessionid);
            $stmt -> execute();
            $stmt -> close();

            return 1;
        }
    }
    else return 0;
} 

function deleteResult($session_id, $user_id, $quiz_id){
    global $conn;
    $sql = "DELETE from quizresult WHERE quizresult_idsession = $session_id AND quizresult_loginuser ='$user_id' AND quizresult_idquiz = $quiz_id";
    $conn->query($sql);

    unlockQuiz($quiz_id, $session_id, $user_id);
}

function createQuiz($quiz_title, $quiz_subtitle,
$quiz_status, $quiz_creationdate, $quiz_lastmodificationdate, $quiz_loginadmin){

    //update the DB :
    global $conn;
    $sql = "INSERT INTO quiz (quiz_title, quiz_subtitle,";
    $sql.= " quiz_status, quiz_creationdate, quiz_lastmodificationdate, quiz_loginadmin)";
    $sql.= " VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare ($sql);
    $stmt -> bind_param ("sssiis", $quiz_title, $quiz_subtitle,
        $quiz_status, $quiz_creationdate, $quiz_lastmodificationdate, $quiz_loginadmin
    ); 
    $stmt ->execute();
    $stmt -> close();

    //Get the id back :
    $sql = "SELECT quiz_id FROM quiz";
    $sql.= " WHERE quiz_loginadmin = '$quiz_loginadmin' AND quiz_creationdate = $quiz_creationdate";
    $result = $conn->query($sql);
    if($result != null){ 
        $row = $result->fetch_assoc();
        return $row['quiz_id'];
    }
    else return null;
}

function deleteQuiz($quiz_id){
    global $conn;
    $sql = "DELETE from quiz WHERE quiz_id = $quiz_id";
    $conn->query($sql);
}

function updateQuiz($quizid, $quizTitle, $quizSubtitle, $quizStatus, $date){
    //update the DB :
    global $conn;
    $sql = "UPDATE quiz SET quiz_title=?, quiz_subtitle=?, quiz_status=?, quiz_lastmodificationdate=? WHERE quiz_id=?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param ("sssii", $quizTitle, $quizSubtitle, $quizStatus, $date, $quizid); 
    $stmt ->execute();
    $stmt -> close();
}

////////Questions//////////////

function bindQuestions($quiz_id, $questions){
    //maj de la base :
    global $conn;
    $sql = "INSERT INTO quiz_question (quiz_question_idquiz, quiz_question_idquestion)";
    $sql.= " VALUES (?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($questions);$i++){
        $stmt -> bind_param ("ii", $quiz_id, $questions[$i]); 
        $stmt ->execute();
    }
    $stmt -> close();
}

function inlineQuizIntegrity($quizId){
    //Controls :
    //Si demande de publication du quiz (statut « inline ») alors contrôler :
    //si pas de question publiée alors le quiz sera Maj avec un statut « draft »
    //Translation : if(quiz status == « inline ») then control that the quiz has at least one inline question.
    global $conn;
    $sql = "SELECT COUNT(*) AS nbInlineQuestions";
    $sql.= " FROM quiz_question INNER JOIN question ON question_id = quiz_question_idquestion";
    $sql.= " WHERE quiz_question_idquiz = $quizId AND question_status = 'inline'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row['nbInlineQuestions'] == "0"){
        $sql = "UPDATE quiz SET quiz_status= 'draft' WHERE quiz_id=$quizId";
        $conn->query($sql);
    }

    return $row['nbInlineQuestions'];
}

function bindQuizQuestions($questionsToBind, $quizid){
    //maj de la base :
    global $conn;
    $sql = "INSERT INTO quiz_question (quiz_question_idquiz, quiz_question_idquestion, quiz_question_weight, quiz_question_numorder)";
    $sql.= " VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($questionsToBind);$i++){
        $stmt -> bind_param ("iiii", $quizid, $questionsToBind[$i][QUESTIONID], $questionsToBind[$i][qqWEIGHT], $questionsToBind[$i][qqNUMORDER]); 
        $stmt ->execute();
    }
    $stmt -> close();
}

function unbindQuestions($questionsToUnbind, $quizid){
    global $conn;
    for($i=0;$i<count($questionsToUnbind);$i++){
        $sql = "DELETE from quiz_question WHERE quiz_question_idquiz = $quizid AND quiz_question_idquestion = $questionsToUnbind[$i]";
        $conn->query($sql);
    }
}

function updateQuizQuestions($questionsToUpdate, $quizid){
    //update the DB :
    global $conn;
    $sql = "UPDATE quiz_question SET quiz_question_weight=?, quiz_question_numorder=? WHERE quiz_question_idquiz =? AND quiz_question_idquestion=?";
    $stmt = $conn->prepare($sql);

    for($i=0;$i<count($questionsToUpdate);$i++){
        $stmt -> bind_param ("iiii", $questionsToUpdate[$i][qqWEIGHT], $questionsToUpdate[$i][qqNUMORDER], $quizid, $questionsToUpdate[$i][QUESTIONID]); 
        $stmt -> execute();
    }
    $stmt -> close();
}

/////////////////////////////// ACCOUNT ////////////////////////////////////////////////////////

function createAccountadmin($name, $firstname, $login, $psw){
    global $conn;
    //check if the account Login is free :
    $sql = "SELECT COUNT(*) AS nblog FROM account WHERE account_login = '$login'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    //the account Login is not free :
    if($row['nblog'] != "0") return null;
    else{
    //the account Login is free, create the account :
        $profile = "admin";
        $encryptedpsw = sha1($psw);
        $sql = "INSERT INTO account (account_login, account_psw, account_profile, account_name, account_firstname, account_loginadmin)";
        $sql.= " VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare ($sql);   
        $stmt -> bind_param ("ssssss", $login, $encryptedpsw, $profile, $name, $firstname, $login);
        $stmt ->execute();
        $stmt -> close();
        return $login;
    }
}

function createAccount($accountLoginadmin, $accountLogin, $accountName, $accountFirstname, $accountCompany, $accountEmail, $addCreateAccountSessions){
    
    //update the DB :
    global $conn;
   
    //the account :

    //check if the account Login is free :
    $sql = "SELECT COUNT(*) AS nblog FROM account WHERE account_login = '$accountLogin'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    //the account Login is not free :
    if($row['nblog'] != "0") return null;
    else{ //the account Login is free, create the account :
        //$accountPsw = DEFAULTPSW;
        $accountPsw = sha1(DEFAULTPSW);
        $accountProfile = "user";
        $sql = "INSERT INTO account (account_login, account_psw, account_profile, account_name, account_firstname, account_loginadmin, account_company, account_email)";
        $sql.= " VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare ($sql);

        $stmt -> bind_param ("ssssssss", $accountLogin, $accountPsw, $accountProfile, $accountName, $accountFirstname, $accountLoginadmin, $accountCompany, $accountEmail);
        $stmt ->execute();
        $stmt -> close();

        //Sessions to bind :
        //No session to attach
        if($addCreateAccountSessions == null) return $accountLogin;
        else{ //One or several sessions to attach :
            $sql = "INSERT INTO session_user (session_user_idsession, session_user_loginuser)";
            $sql.= " VALUES (?, ?)";
            $stmt = $conn->prepare ($sql);
            for($i=0;$i<count($addCreateAccountSessions);$i++){
                $stmt -> bind_param ("is", $addCreateAccountSessions[$i], $accountLogin);
                $stmt ->execute();
            }
            $stmt -> close();
            return $i;
        }
    }
}

//index.php/form_delete_account from div_account_list.php///////////////////////
function deleteAccount($deletedaccountlogin, $login){
    //$deletedaccountlogin : account to delete
    //$login : login admin of the caller
    global $conn;

    //Get the account_loginadmin and the profile of the account to be deleted
    $sql = "SELECT account_loginadmin, account_profile FROM account WHERE account_login = '$deletedaccountlogin'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row['account_loginadmin'] != $login) {
        return "Vous n'êtes pas administrateur de ce compte";
    }
    else if($row['account_profile'] == 'admin' and $deletedaccountlogin != $login){
        return "Seul l'administrateur peut supprimer son propre compte";
    }
    else{ //Controls are over : delete the account :
        switch($row['account_profile']){
            case'user':
            
                $sql = "DELETE from account WHERE account_login = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("s", $deletedaccountlogin);
                $stmt -> execute();
                $stmt -> close();
                /*
                $sql = "DELETE from account WHERE account_login = '$deletedaccountlogin'";
                $conn->query($sql);
                */

                return "user";
            break;
            case'admin':
                //keywords
                $sql = "DELETE from keyword WHERE keyword_loginadmin = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("s", $login);
                $stmt -> execute();
                $stmt -> close();

                //questions
                $sql = "DELETE from question WHERE question_loginadmin = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("s", $login);
                $stmt -> execute();
                $stmt -> close();

                //quiz
                $sql = "DELETE from quiz WHERE quiz_loginadmin = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("s", $login);
                $stmt -> execute();
                $stmt -> close();

                //sessions
                $sql = "DELETE from session WHERE session_loginadmin = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("s", $login);
                $stmt -> execute();
                $stmt -> close();
                
                //user accounts
                $userProfile = 'user';
                $sql = "DELETE from account WHERE account_loginadmin = ? AND account_profile = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("ss", $login, $userProfile);
                $stmt -> execute();
                $stmt -> close();

                //the admin account
                $sql = "DELETE from account WHERE account_loginadmin = ? AND account_login = ?";
                $stmt = $conn->prepare ($sql);
                $stmt -> bind_param ("ss", $login, $deletedaccountlogin);
                $stmt -> execute();
                $stmt -> close();

                return "admin";
            break; 
            default:
                return $row['account_profile']." n'est pas un profil.";
            break;
        }
    }
}

function updateAccount($accountLogin, $accountName, $accountFirstname, $accountCompany, $accountEmail, $ressetPsw){
    //update the DB :
    global $conn;

    if($ressetPsw){
        $sql = "UPDATE account SET account_name=?, account_firstname=?, account_company=?, account_email=?, account_psw=? WHERE account_login =?";
        $stmt = $conn->prepare($sql);
        $accountPsw=sha1(DEFAULTPSW);
        $stmt -> bind_param ("ssssss", $accountName, $accountFirstname, $accountCompany, $accountEmail, $accountPsw, $accountLogin);
    }
    else{
        $sql = "UPDATE account SET account_name=?, account_firstname=?, account_company=?, account_email=? WHERE account_login =?";
        $stmt = $conn->prepare($sql);
        $stmt -> bind_param ("sssss", $accountName, $accountFirstname, $accountCompany, $accountEmail, $accountLogin); 
    }
    $stmt -> execute();
    $stmt -> close();
}

function bindAccountSessions($sessionsToBind, $accountLogin){
    //maj de la base :
    global $conn;
    $sql = "INSERT INTO session_user (session_user_idsession , session_user_loginuser)";
    $sql.= " VALUES (?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($sessionsToBind);$i++){
        $stmt -> bind_param ("is", $sessionsToBind[$i], $accountLogin); 
        $stmt ->execute();
    }
    $stmt -> close();
}

function unbindSessions($sessionsToUnbind, $accountLogin){
    global $conn;
    $sql = "DELETE from session_user WHERE session_user_loginuser = ? AND session_user_idsession = ?";
    $stmt = $conn->prepare ($sql);
    for($i=0;$i<count($sessionsToUnbind);$i++){
        $stmt -> bind_param ("si", $accountLogin, $sessionsToUnbind[$i]);
        $stmt -> execute();
    }
    $stmt -> close();
}

//////////////////////////// SESSION ///////////////////////////////////////////////////

//index.php/form_delete_session from div_session_list.php///////////////////////
function deleteSession($deletedsessionid, $login, $suppWhollyOwnedAccounts){
    //$deletedsessionid : session to delete
    //$login : login admin of the caller
    //$suppWhollyOwnedAccounts : if true, supp wholly owned accounts.

    global $conn;

    //Get the session_loginadmin of the session to be deleted
    $sql = "SELECT session_loginadmin FROM session WHERE session_id = $deletedsessionid";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row['session_loginadmin'] != $login) {
        return "Vous n'êtes pas propriétaire de cette session";
    }
    else{ //Controls are over, treatment goes on :
        
        //Delete the accounts first (because of the CIR) and then the session :
        if($suppWhollyOwnedAccounts){
            //delete the wholly owned accounts of this session :
            /*
            $sql = "SELECT onesession.session_user_loginuser, onesession.nbsessions, su.session_user_idsession FROM session_user AS su,";
            $sql.= " (SELECT session_user_loginuser, COUNT(session_user_idsession) AS nbsessions";
            $sql.= "  FROM session_user";
            $sql.= "  GROUP BY session_user_loginuser";
            $sql.= " ) AS onesession";
            $sql.= " WHERE onesession.nbsessions = 1"; //the user belongs only to one session
            $sql.= " AND onesession.session_user_loginuser = su.session_user_loginuser";
            $sql.= " AND su.session_user_idsession = $deletedsessionid"; //the user belongs to the session
            $result = $conn->query($sql);
            */
            $sql = "SELECT onesession.session_user_loginuser, onesession.nbsessions, su.session_user_idsession FROM session_user AS su,";
            $sql.= " (SELECT session_user_loginuser, COUNT(session_user_idsession) AS nbsessions";
            $sql.= "  FROM session_user";
            $sql.= "  GROUP BY session_user_loginuser";
            $sql.= " ) AS onesession";
            $sql.= " WHERE onesession.nbsessions = 1"; //the user belongs only to one session
            $sql.= " AND onesession.session_user_loginuser = su.session_user_loginuser";
            $sql.= " AND su.session_user_idsession = ?"; //the user belongs to the session
            $stmt = $conn->prepare($sql);
            $stmt -> bind_param ("i", $deletedsessionid);
            $stmt ->execute();
            $result = $stmt->get_result();
            $stmt -> close();

            if($result == null) $i=0;  //no account to delete
            else{ //accounts to delete :
                $sql = "DELETE from account WHERE account_loginadmin = ? AND account_login = ?";
                $stmt = $conn->prepare ($sql);
                $i=0;
                while($row = $result->fetch_assoc()){
                    $stmt -> bind_param ("ss", $login, $row['session_user_loginuser']);
                    $stmt -> execute();
                    $i++;
                }
                $stmt -> close();
            }
        }
        //Then delete the session :
        $sql = "DELETE from session WHERE session_id = ?";
        $stmt = $conn->prepare ($sql);
        $stmt -> bind_param ("i", $deletedsessionid);
        $stmt -> execute();
        $stmt -> close();

        if($suppWhollyOwnedAccounts) return "session-".$i; //may be "session-0"
        else return "session-0";
    }
}

//index.php/form_create_session from div_session_list.php///////////////////////
function createSession($login, $sessionTitle, $sessionSubtitle, $sessionStartdate, $sessionEnddate){
    //$login : login admin of the caller

    //Create the session :
    global $conn;

    $sql = "INSERT INTO session (session_title, session_subtitle,";
    $sql.= " session_startdate, session_enddate, session_loginadmin)";
    $sql.= " VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare ($sql);

    $startdate = strtotime($sessionStartdate);  
    if($startdate == false) $startdate = 0;
    $enddate = strtotime($sessionEnddate);  
    if($enddate == false) $enddate = 0;

    $stmt -> bind_param ("ssiis", $sessionTitle, $sessionSubtitle, $startdate, $enddate, $login
    ); 
    $stmt ->execute();
    $stmt -> close();
}

///////////////////index.php/form_update_session (from div_session.php)//////////////
function updateSession(
    $session_id,
    $session_title,
    $session_subtitle,
    $session_startdate,
    $session_enddate,
    $session_logolocation,
    $session_bgimagelocation
    ){
    global $conn;
    $sql = "UPDATE session SET session_title=?, session_subtitle=?, session_startdate=?, session_enddate=?,";
    $sql.= " session_logolocation=?, session_bgimagelocation=? WHERE session_id =?";
    $stmt = $conn->prepare($sql);
    $stmt -> bind_param ("ssiissi", $session_title, $session_subtitle, $session_startdate,
        $session_enddate, $session_logolocation, $session_bgimagelocation, $session_id); 
    $stmt -> execute();
    $stmt -> close();
}

function bindQuizToSession($quizToBind, $session_id){
    global $conn;
    $sql = "INSERT INTO session_quiz (session_quiz_idquiz, session_quiz_idsession,";
    $sql.= " session_quiz_openingdate, session_quiz_closingdate, session_quiz_minutesduration)";
    $sql.= " VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($quizToBind);$i++){
        $stmt -> bind_param ("iiiii", $quizToBind[$i][QUIZID], $session_id,
        $quizToBind[$i][OPENINGDATE], $quizToBind[$i][CLOSINGDATE], $quizToBind[$i][DURATION]); 
        $stmt ->execute();
    }
    $stmt -> close();
}

function unbindSessionQuiz($quizToUnbind, $session_id){
    global $conn;
    $sql = "DELETE from session_quiz WHERE session_quiz_idsession = ? AND session_quiz_idquiz = ?";
    $stmt = $conn->prepare ($sql);
    for($i=0;$i<count($quizToUnbind);$i++){
        $stmt -> bind_param ("ii", $session_id, $quizToUnbind[$i]);
        $stmt -> execute();
    }
    $stmt -> close();  
}   

function updateSessionQuiz($quizToUpdate, $session_id){
    global $conn;
    $sql = "UPDATE session_quiz SET session_quiz_openingdate=?, session_quiz_closingdate=?,";
    $sql.= " session_quiz_minutesduration=?";
    $sql.= " WHERE session_quiz_idquiz=? AND session_quiz_idsession=?";
    $stmt = $conn->prepare($sql);

    for($i=0;$i<count($quizToUpdate);$i++){
        $stmt -> bind_param ("iiiii", $quizToUpdate[$i][OPENINGDATE], $quizToUpdate[$i][CLOSINGDATE],
            $quizToUpdate[$i][DURATION], $quizToUpdate[$i][QUIZID], $session_id); 
        $stmt -> execute();
    }
    $stmt -> close();
}

function bindAccountsToSession($accountsToBind, $session_id){
    global $conn;
    $sql = "INSERT INTO session_user (session_user_loginuser, session_user_idsession)";
    $sql.= " VALUES (?, ?)";
    $stmt = $conn->prepare ($sql);

    for($i=0;$i<count($accountsToBind);$i++){
        $stmt -> bind_param ("si", $accountsToBind[$i], $session_id); 
        $stmt ->execute();
    }
    $stmt -> close();
}

function unbindSessionAccounts($accountsToUnbind, $session_id){
    global $conn;
    $sql = "DELETE from session_user WHERE session_user_loginuser = ? AND session_user_idsession = ?";
    $stmt = $conn->prepare ($sql);
    for($i=0;$i<count($accountsToUnbind);$i++){
        $stmt -> bind_param ("si", $accountsToUnbind[$i], $session_id);
        $stmt -> execute();
    }
    $stmt -> close();  
}

                  

                            
