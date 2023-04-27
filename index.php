<?php      //http://localhost/exo/J17-DIPLOME/index.php
/*
There are 3 main files : index.php, view/scriptv1.js, view/style.css.
All other files are required by index.php when needed.

The nominal process starts with the menu buttons (headers.php)
where 'href' attributs lead to the index.php switch($_REQUEST), in the file below. 

There, the suitable model/class.php (DB solicitations) and controller/class_controller.php are required.

The controller/class_controller.php instantiates its model/class.php, get data
and includes the suitable screen (view/div*.php or view/form*.php).

The screen displays data and interacts with view/scriptv1.js.
A list type screen always includes delete and create functions (e.g. div_sessions_list.php).
Most of the time, the edit function is on a separate screen (e.g. div_session.php)
The submit of the screen POST form then returns control to the file index.php below.

Each form is treated by index.php below using :
    o objects controller/class_controller.php and model/class.php (DB solicitations)
    o functions from functions.php
    o functions from model/modelfunctions.php (DB solicitations).

At any time, a click on a menu button stops the current process to initialize a new process.
*/

require "header.php";
//<div id="container">
    //<header></header>
    ?>
    
    <main class="row">

        <?php //require "help.php"; ?>
    
        <div class="col-12 col-md-1">
        </div>

        <div class="col-12 col-md-10">       
            <?php 
            //////////////////////////////////MENU or LINK INPUTS/////////////////////////////////////////////

            if (isset($_REQUEST['controller']) and isset($_REQUEST['action'])){ 
                $controller = $_REQUEST['controller'];
                $action = $_REQUEST['action'];             

                switch($controller){
                    
                    case"session":

                        switch($action){

                            case"list": // Sessions list for 'admin', from menu admin button 'Vos sessions' (header.php)
                                require "model/connexionbdd.php";
                                /*require "model/class_accounts_list.php"; //to add accounts to the session
                                require "model/class_quiz_list.php"; //to add Quiz to the session*/
                                require "model/class_sessions_list.php";
                                require "controller/class_sessions_list_controller.php";
                                $ctrl = new class_sessions_list_controller($login);
                                
                                if(isset($_REQUEST['from']) AND $_REQUEST['from'] == "bt-update-session"){
                                    $message = "Aucune modification n'a été effectuée.";
                                }
                                $ctrl->displayAll();
                            break;

                            case"update": //update a Session for 'admin', from a link 'Maj' of the page 'div_sessions_list' 
                                require "model/connexionbdd.php";
                                require "model/class_session.php";
                                require "controller/class_session_controller.php";
                                $ctrl = new class_session_controller($_REQUEST['id'], $login);

                                if(isset($_REQUEST['from'])){
                                    switch($_REQUEST['from']){
                                        case'this':
                                            $message = "Champ obligatoire non renseigné. Aucune modification n'a été effectuée.";
                                        break;
                                        case'bt-reset-session':
                                            $message = "Aucune modification n'a été effectuée.";
                                        break;
                                    }
                                }
                                $ctrl->displayOne();
                            break; 
                        }
                    break; //case"session"

                    case"account":

                        switch($action){
                            
                            case"connection": //for user and admin, from menu button 'Se connecter'
                                $message = "";
                                require "view/form_login.php";
                            break;

                            case"password": //for user and admin, from menu button 'Mot de passe'
                                $message = "";
                                $title = "Changer de mot de passe";
                                require "view/form_password.php";
                            break;

                            case"disconnection": //for user and admin, from menu 'Quitter'
                                disconnect("A bientôt");
                            break;

                            case"list": //for admin, from menu button 'Vos comptes'
                                require "model/connexionbdd.php";
                                require "model/class_accounts_list.php";
                                require "controller/class_accounts_list_controller.php";
                                $ctrl = new class_accounts_list_controller($login);

                                if(isset($_REQUEST['from']) AND $_REQUEST['from'] == "bt-update-account"){
                                    $message = "Aucune modification n'a été effectuée.";
                                }
                                $ctrl->displayAll();
                            break;

                            case"createadmin": //for anybody who wants to create his own quiz : from the home menu button'Créer un compte administrateur'
                                $message = "";
                                $title= "Créer un compte administrateur";
                                require "view/form_createadmin.php";
                            break;

                            case"update": //for admin, from a link 'Maj' of the accounts list in div_accounts_list.php.
                                require "model/connexionbdd.php";
                                require "model/class_up_account.php";
                                require "controller/class_up_account_controller.php";
                                $ctrl = new class_up_account_controller($_REQUEST['id'], $login);

                                if(isset($_REQUEST['from'])){
                                    switch($_REQUEST['from']){
                                        case'this':
                                            $message = "Champ obligatoire non renseigné. Aucune modification n'a été effectuée.";
                                        break;
                                        case'bt-reset-account':
                                            $message = "Aucune modification n'a été effectuée.";
                                        break;
                                    }
                                }
                                $ctrl->displayOne();
                            break; 
                            
                            case"reporting": //for admin, from a link on a session, toward the account results for this session (Sessions and results column of div_accounts_list.php)
                                require "model/connexionbdd.php";
                                require "model/class_report_account.php";
                                require "controller/class_report_account_controller.php";
                                $ctrl = new class_report_account_controller($_REQUEST['ida'],$_REQUEST['ids'], $login);

                                $ctrl->display();
                            break; 
                        }                          

                    break; //case"account"

                    case"quiz":

                        switch($action){
                            
                            case"userList": // Quiz list for 'user', from menu button 'Vos quiz' 
                                require "model/connexionbdd.php";
                                require "model/class_quiz_userlist.php";
                                require "controller/class_quiz_userlist_controller.php";
                                $ctrl = new class_quiz_userlist_controller($login);
                                
                                $ctrl->displayAll();
                            break;
                            
                            case"list": // Quiz list for 'admin', from admin menu button 'Vos quiz' 
                                require "model/connexionbdd.php";
                                require "model/class_questions_list.php"; //to add a question to the quiz
                                require "model/class_quiz_list.php";
                                require "controller/class_quiz_list_controller.php";
                                $ctrl = new class_quiz_list_controller($login);
                                
                                if(isset($_REQUEST['from']) AND $_REQUEST['from'] == "bt-update-quiz"){
                                    $message = "Aucune modification n'a été effectuée.";
                                }
                                $ctrl->displayAll();
                            break;

                            case"update": // Quiz update, from a link "Maj" in the Quiz list for 'admin' of div_quiz_list.php
                                require "model/connexionbdd.php";
                                require "model/class_questions_list.php"; //to add a question to the quiz
                                require "model/class_quiz.php";
                                require "controller/class_quiz_controller.php";
                                $ctrl = new class_quiz_controller($_REQUEST['id'], $login);

                                if(isset($_REQUEST['from'])){
                                    switch($_REQUEST['from']){
                                        case'this':
                                            $message = "Champ obligatoire non renseigné. Aucune modification n'a été effectuée.";
                                        break;
                                        case'bt-reset-quiz':
                                            $message = "Aucune modification n'a été effectuée.";
                                        break;
                                    }
                                }
                                $ctrl->displayOne();
                            break;
                        }
                    break; //case"quiz"

                    case"quizresult":

                        switch($action){
                            
                            case"display": //for user, from the link on the result of a quiz, at the end of a line of the userlist (column 'Réussite'), in div_quiz_userlist.php 
                                require "model/connexionbdd.php";
                                require "model/class_accountresult.php";
                                require "controller/class_accountresult_controller.php";
                                $squizresultId = $_REQUEST['qzrid'];
                                $ctrl = new class_accountresult_controller();
                                $ctrl->getOne($squizresultId);
                                $ctrl->displayOne();
                            break;
                        }
                    break; //case"quizresult"

                    case"question":

                        switch($action){
                            
                            case"list": // list of the questions for the 'admin', from the admin menu button 'Vos questions' 
                                require "model/connexionbdd.php";
                                require "model/class_questions_list.php";
                                require "controller/class_questions_list_controller.php";
                                $ctrl = new class_questions_list_controller($login);

                                if(isset($_REQUEST['from']) AND $_REQUEST['from'] == "bt-update-question"){
                                    $message = "Aucune modification n'a été effectuée.";
                                }
                                $ctrl->displayAll();
                            break;

                            case"update": // from a link "Maj" in the admin list of the questions in div_questions_list.php
                                require "model/connexionbdd.php";
                                require "model/class_question.php";
                                require "controller/class_question_controller.php";
                                $ctrl = new class_question_controller($_REQUEST['id']);

                                if(isset($_REQUEST['from']) AND $_REQUEST['from'] == "this"){
                                    $message = "Champ obligatoire non renseigné. Aucune modification n'a été effectuée.";
                                }
                                $ctrl->displayOne();
                            break;                            
                        }
                    break; //case"question"

                    case"keyword":

                        switch($action){
                            
                            case"list": // list of the keywords of the 'admin', from the admin menu button 'Vos mots clés' 
                                require "model/connexionbdd.php";
                                require "model/class_keywords_list.php";
                                require "controller/class_keywords_list_controller.php";
                                $ctrl = new class_keywords_list_controller($login);
                                $message = "";
                                $ctrl->displayAll();
                            break;
                        }
                    break; //case"keyword"
                }
            }

            
            //////////////////////////////////FORMS INPUTS///////////////////////////////////////////////////

            ///////////////////////////////// form_login (to log in, user or admin) ////////////////////////////////////////////////////
            //submited by the screen form_login.php/button 'Envoyer'

            if (isset($_POST['form_login']) and $_POST['form_login'] ==1) {
                $givenStrs = array($_POST['login'], $_POST['psw']);
                $message = testStrs("La connexion", $givenStrs);
                if($message!="") require "view/form_login.php";
                else if (!validerCaptcha()){ 
                    $message = "Captcha ko, recommencez !";
                    require "view/form_login.php";
                }
                else{
                    //Verify in the DB that login and psw exist : 
                    require "model/connexionbdd.php";
                    require "model/class_account.php";
                    require "controller/class_account_controller.php";
                    
                    $ctrl = new account_controller($_POST['login'], $_POST['psw']);
                    switch($ctrl->checkExists()){
                        case'0':
                            session_unset(); // unset($_SESSION['nomvariable']); session_destroy();
                            $message = "Login ou mot de passe incorrect.";
                            require "view/form_login.php";
                        break;
                        case'1': //psw == DEFAULTPSW
                            $message = "";
                            $title = "Changer de mot de passe.";
                            require "view/form_password.php";
                        break;
                        case'2':
                            $_SESSION["login"] = $_POST['login']; //ou $givenStrs[0];
                            //$_SESSION["mypassword"] = sha1($_POST['psw']);
                            $_SESSION["profile"] = $ctrl->getProfile();
                            $_SESSION["firstname"] = $ctrl->getFirstname();
                            header("Location: http://localhost/exo/J17-DIPLOME/index.php");
                        break;
                    }
                }
            }

            ///////////////////////////////// form_createadmin (save an admin account) ////////////////////////////////////////////////////
            //submited by the screen form_createadmin.php/button 'Envoyer'

            //TEST
            /*
            if (isset($_POST['form_createadmin']) and $_POST['form_createadmin'] ==1) {
                echo "<br>name : ".$_POST['name'];
                echo "<br>firstname : ".$_POST['firstname'];
                echo "<br>login : ".$_POST['login'];
                echo "<br>psw : ".$_POST['psw'];
            }
            */
            //TREATMENT
            if (isset($_POST['form_createadmin']) and $_POST['form_createadmin'] ==1) {
                $givenStrs = array($_POST['name'], $_POST['firstname'], $_POST['login'], $_POST['psw']);
                $message = testStrs("La connexion", $givenStrs);
                if($message!="") require "view/form_login.php";
                else if (!validerCaptcha()){ 
                    $message = "Captcha ko, recommencez !";
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";
                    //Verify in the DB that the login is free and create the account :
                    
                    $accountcreation = createAccountadmin($_POST['name'], $_POST['firstname'], $_POST['login'], $_POST['psw']);
                    
                    if($accountcreation == null){  
                        $message = "ATTENTION : le login ".$_POST['login']." n'est pas disponible, le compte n'a pas pu être créé.";
                        $title= "Créer un compte administrateur";
                        require "view/form_createadmin.php";
                    }
                    else{
                        $message = "Le compte '".$_POST['login']."' (".$_POST['firstname']." ".$_POST['name'].") a été créé.";
                        require "view/form_login.php";
                    }
                }
            }
            
            ///////////////////////////////// form_password (save changed password, admin or user)////////////////////////////////////////////////////
            //submited by the screen form_password.php/button 'Envoyer'
            
            //TEST
        /*var_dump($_POST);
            if (isset($_POST['form_password']) and $_POST['form_password'] ==1) {
                echo "<br>login : ".$_POST['login'];
                echo "<br>psw : ".$_POST['psw'];
                echo "<br>newpsw : ".$_POST['newpsw'];
                echo "<br>confirmpsw : ".$_POST['confirmpsw'];
            }
            */
            //TREATMENT

            if (isset($_POST['form_password']) and $_POST['form_password'] ==1) {
                $givenStrs = array($_POST['login'], $_POST['psw'], $_POST['newpsw'], $_POST['confirmpsw']);
                $message = testStrs("Le changement", $givenStrs); 
                if($message!="") require "view/form_login.php";
                else if (!validerCaptcha()){ 
                    $message = "Captcha ko !";
                    require "view/form_login.php";
                }
                else{
                    //check there are no typing errors in the new password :
                    if($_POST['newpsw'] != $_POST['confirmpsw']){
                        $message = "Les deux nouveaux mots de passe saisis étaient différents : recommencez !";
                        $title = "Changer de mot de passe";
                        require "view/form_password.php";
                    } 
                    else{ //check in the DB that login and psw exist :                  
                        require "model/connexionbdd.php";
                        require "model/class_account.php";
                        require "controller/class_account_controller.php";
                        
                        $ctrl = new account_controller($_POST['login'], $_POST['psw']);
                        if ($ctrl->checkExists()){
                            //update password :
                
                            $ctrl->updatePassword($_POST['login'], $_POST['newpsw']);
                            $messageHeader="Le mot de passe a été changé, reconnectez-vous.";
                            disconnect($messageHeader);
                        }
                        else{
                            $messageHeader = "Login ou mot de passe incorrect.";
                            disconnect($messageHeader);
                        }
                    }
                }
            }

            ///////////////////////////////// form_taken_quiz (save result of a quiz run by a user) ////////////////////////////////////////////////////
            //submited by JavaScript for the user screen div_takenquiz.php/button id="bt-taken-quiz"
            
            if (isset($_POST['form_taken_quiz']) and $_POST['form_taken_quiz'] ==1) {
                
                //TEST
                /*
                echo "<br>loginUser : ".$_POST['loginUser'];
                echo "<br>sessionId : ".$_POST['sessionId'];
                echo "<br>sessionTitle : ".$_POST['sessionTitle'];
                echo "<br>sessionSubtitle : ".$_POST['sessionSubtitle'];
                echo "<br>quizId : ".$_POST['quizId'];
                echo "<br>quizTitle : ".$_POST['quizTitle'];
                echo "<br>quizSubtitle : ".$_POST['quizSubtitle'];
                echo "<br>quizMaxDuration : ".$_POST['quizMaxDuration'];
                echo "<br>quizStartdate : ".$_POST['quizStartdate'];
                echo "<br>quizEnddate : ".$_POST['quizEnddate'];
                echo "<br>quizMaxnbquest : ".$_POST['quizMaxnbquest'];
                echo "<br>quizNbquestasked : ".$_POST['quizNbquestasked'];
                echo "<br>quizMaxnbanswersNames : ".$_POST['quizMaxnbanswersNames'];
                echo "<br>quizNbanswersaskedNames : ".$_POST['quizNbanswersaskedNames'];
                */

                //TREATMENT
                require "questionsanswered.php"; //server treatment versus client treatment

                $questionsResults = $questionsAnswered;

                //require "model/connexionbdd.php";
                require "model/class_accountresult.php";
                require "controller/class_accountresult_controller.php";

                // Create the accountresult :
                $ctrlQuiz = new class_accountresult_controller();
                $ctrlQuiz->insertOne(
                $_POST['loginUser'], $_POST['sessionId'], $_POST['sessionTitle'], $_POST['sessionSubtitle'],
                $_POST['quizId'], $_POST['quizTitle'], $_POST['quizSubtitle'], $_POST['quizMaxDuration'], $_POST['quizStartdate'], $_POST['quizEnddate'],
                $_POST['quizMaxnbquest'], $_POST['quizNbquestasked'], $questionsResults);              

                // Back to the user quiz list :
                require "model/class_quiz_userlist.php";
                require "controller/class_quiz_userlist_controller.php";
                $ctrl = new class_quiz_userlist_controller($login);  
                $ctrl->displayAll();
            }

            ////////////////////////// form_create_keyword (save a new keyword) ///////////////////////////////////////////////////
            //submited by the admin screen div_keywords_list.php/button 'Envoyer'
            
            if (isset($_POST['form_create_keyword']) and $_POST['form_create_keyword'] ==1) {
                $givenStrs = array($_POST['keyword']);
                $message = testStrs("La création", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    //Check in the DB that this keyword doesn't already exist : 
                    require "model/connexionbdd.php";
                    require "model/class_keywords_list.php";
                    require "controller/class_keywords_list_controller.php";
 
                    $ctrl = new class_keywords_list_controller($login);
                                
                    if ($ctrl->checkExists($_POST['keyword'], $login)){
                        $message = "Le mot clé '".$_POST['keyword']."' existe déjà !";
                        $ctrl->displayAll();
                    }
                    else{
                        $ctrl->create($_POST['keyword'], $login);
                        
                        $ctrl = new class_keywords_list_controller($login);
                        $message = "Le mot clé '".$_POST['keyword']."' a été créé avec succès !";
                        $ctrl->displayAll();
                    }
                }
            }
            ////////////////////////// form_delete_keyword (delete a keyword)///////////////////////////////////////////////////
            //submited by the admin screen div_keywords_list.php/button 'Envoyer'
            
            if (isset($_POST['form_delete_keyword']) and $_POST['form_delete_keyword'] ==1) {
    
                require "model/connexionbdd.php";
                require "model/class_keywords_list.php";
                require "controller/class_keywords_list_controller.php";
                        
                $ctrl = new class_keywords_list_controller($login);
                $ctrl->deleteKeyword( $_POST['deletedkeywordid']  ); 

                $ctrl = new class_keywords_list_controller($login);
                $message = "Le mot clé '".$_POST['deletedkeyword']."' a été supprimé avec succès !";
                $ctrl->displayAll();
            }
            //////////////////////////form_update_keyword (update a keyword)///////////////////////////////////////////////////
            //submited by the admin screen div_keywords_list.php/button 'Envoyer'
            
            if (isset($_POST['form_update_keyword']) and $_POST['form_update_keyword'] ==1) {
                $givenStrs = array($_POST['newkeyword']);
                $message = testStrs("La modification", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";
                    require "model/class_keywords_list.php";
                    require "controller/class_keywords_list_controller.php";
 
                    if(isset($_POST['newkeyword'])){
                        $ctrl = new class_keywords_list_controller($login);
                                    
                        $ctrl->updateKeyword($_POST['updatedkeywordid'], $_POST['newkeyword']); 
                            
                        $ctrl = new class_keywords_list_controller($login);
                        $message = "Le mot clé '".$_POST['updatedkeyword']."' a été changé pour '".$_POST['newkeyword']."' !";
                        $ctrl->displayAll(); 
                    }
                    else{
                        $ctrl = new class_keywords_list_controller($login);
                        $message = "Aucune modification n'a été effectuée.";
                        $ctrl->displayAll(); 
                    }
                }
            }
            //////////////////////////form_create_question (Create a question) ///////////////////////////////////////////////////
            //submited by the admin screen div_questions_list.php/button 'Envoyer'
            
            //TEST :
            /*
            if (isset($_POST['form_create_question']) and $_POST['form_create_question'] ==1) {
                echo "<br>question_question : ".$_POST['question_question'];
                echo "<br>question_guideline : ".$_POST['question_guideline'];
                echo "<br>question_explanationtitle : ".$_POST['question_explanationtitle'];
                echo "<br>question_explanation : ".$_POST['question_explanation'];
                echo "<br>question_idwidget : ".$_POST['question_idwidget'];
                echo "<br>".(isset($_POST['question_status']) ? "inline" : "draft");
                
                echo "<br>nb-responses-max : ".$_POST['nb-responses-max'];
                for($i=0;$i<min(intval($_POST['nb-responses-max']),NBRESPONSESMAX);$i++){
                    if(isset($_POST['answer_answer_'.$i])){
                        echo "<br>".$_POST['answer_answer_'.$i].(isset($_POST['answer_ok_'.$i]) ? " - ok - " : " - ko - ").(isset($_POST['answer_status_'.$i]) ? "inline" : "draft");
                    }
                }

                if(isset($_POST['addCreateQuestionKeywords'])){

                    $addCreateQuestionKeywords = $_POST['addCreateQuestionKeywords'];
                
                    for($i=0;$i<count($addCreateQuestionKeywords);$i++) {
                        echo("<br>".$addCreateQuestionKeywords[$i]);
                    }
                }
            }
            */
            //TREATMENT :

            if (isset($_POST['form_create_question']) and $_POST['form_create_question'] ==1) {
                
                $givenStrs = array($_POST['question_question'], $_POST['question_guideline'], $_POST['question_explanationtitle'], $_POST['question_explanation']);
                
                //$answers = [];
                $answers = array();

                //$j=0;
                for($i=0;$i<min(intval($_POST['nb-responses-max']),NBRESPONSESMAX);$i++){
                    if(isset($_POST['answer_answer_'.$i]) and $_POST['answer_answer_'.$i] != ""){
                        //For control :
                        $givenStrs[] = $_POST['answer_answer_'.$i];
                        
                        //For the DB, later :
                        
                        //$answers[$j] = [$_POST['answer_answer_'.$i], (isset($_POST['answer_ok_'.$i]) ? 1 : 0), (isset($_POST['answer_status_'.$i]) ? "inline" : "draft")];
                        $answers[] = [$_POST['answer_answer_'.$i], (isset($_POST['answer_ok_'.$i]) ? 1 : 0), (isset($_POST['answer_status_'.$i]) ? "inline" : "draft")];
                        //$j++;
                    }
                }
                
                $message = testStrsOnly("La création", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";

                    $givenStrs = array();
                    $givenStrs = array($_POST['question_question'], $_POST['question_idwidget']);
                    
                    for($i=0;$i<min(intval($_POST['nb-responses-max']),NBRESPONSESMAX);$i++){
                        if(isset($_POST['answer_answer_'.$i])){
                            $givenStrs[] = $_POST['answer_answer_'.$i];
                        }
                    }
                    $message = testNotEmpty("La création", $givenStrs);
                    if($message!="") {
                        //Display the list of the questions :
                        require "model/class_questions_list.php";
                        require "controller/class_questions_list_controller.php";
                        $ctrl = new class_questions_list_controller($login);
                        $ctrl->displayAll();
                    }
                    else{ //Controls are over, continue the treatment :

                        //update the DB :

                        //Create the question :
                        $date = time();
                        $question_id = createQuestion($_POST['question_question'], $_POST['question_guideline'],
                            $_POST['question_explanationtitle'], $_POST['question_explanation'],
                            (isset($_POST['question_status']) ? "inline" : "draft"),
                            $date, $date, $_POST['question_idwidget'], $login
                        );
                        if ($question_id == null){
                            $message = "ATTENTION : suite à un problème technique, la question n'a pas pu être créé.";
                        }
                        else { //Create the answers and bind the keywords :
                            $message = "La question a été créée avec succès.";

                            //Create the answers
                            if($answers != null){
                                createAnswers ($answers, $date, $question_id);
                                $message = substr($message, 0, -1); //get the last character off
                                $message.= " ainsi que ses réponses.";
                            }
                            //Bind the keywords
                            if(isset($_POST['addCreateQuestionKeywords'])){

                                bindKeywords($question_id, $_POST['addCreateQuestionKeywords']);
                                
                                $message = substr($message, 0, -1); //get the last character off
                                $message.= ", avec le ou les mots clés rattachés.";
                            }
                        }
                        //Display the list of the questions :
                        require "model/class_questions_list.php";
                        require "controller/class_questions_list_controller.php";
                        $ctrl = new class_questions_list_controller($login);
                        $ctrl->displayAll();
                    }
                }
            }
            
            //////////////////////////form_delete_question (delete a question) ///////////////////////////////////////////////////
            //submited by the admin screen div_questions_list.php/button 'Envoyer'
            
            if (isset($_POST['form_delete_question']) and $_POST['form_delete_question'] ==1) {
    
                require "model/connexionbdd.php";
                deleteQuestion($_POST['deletedquestionid']);   

                //Display the questions list
                require "model/class_questions_list.php";
                require "controller/class_questions_list_controller.php";
                $ctrl = new class_questions_list_controller($login);
                $message = "La question '".$_POST['deletedquestion']."' a été supprimée avec succès !";
                $ctrl->displayAll();
            }

            ////////////////////////// form_update_question (update a question) ///////////////////////////////////////////////////
            //submited by the admin screen div_question.php/button 'Envoyer toutes les modifications de la page'
            
            //TEST :
            /*
            if (isset($_POST['form_update_question']) and $_POST['form_update_question'] ==1) {
                
                echo "<br>Question :"; //////////////////////////////////////////
                echo "<br>updatedquestiondid (QUESTIONID) : ".$_POST['updatedquestiondid'];
                echo "<br>question_question (new question) : ".$_POST['question_question'];
                echo "<br>updatedquestion (old question) : ".$_POST['updatedquestion'];
                echo "<br>question_guideline : ".$_POST['question_guideline'];
                echo "<br>question_guideline_old : ".$_POST['question_guideline_old'];
                echo "<br>question_explanationtitle : ".$_POST['question_explanationtitle'];
                echo "<br>question_explanationtitle_old : ".$_POST['question_explanationtitle_old'];
                echo "<br>question_explanation : ".$_POST['question_explanation'];
                echo "<br>question_explanation_old : ".$_POST['question_explanation_old'];
                echo "<br>question_idwidget : ".$_POST['question_idwidget'];
                echo "<br>question_idwidget_old : ".$_POST['question_idwidget_old'];
                echo "<br>question_status : ".(isset($_POST['question_status']) ? "inline" : "draft");
                echo "<br>question_status_old : ".$_POST['question_status_old'];
                echo "<br>";
                echo "<br>Keywords : "; //////////////////////////////////////////////////
                echo "<br>addCreateQuestionKeywords_old : ".$_POST['addCreateQuestionKeywords_old'];
                echo "<br>up_question-keywords (si vide : d'origine ou suite à décoche) : ".$_POST['up_question-keywords'];
                if(isset($_POST['addCreateQuestionKeywords'])){
                    echo "<br>addCreateQuestionKeywords[] (select) :";
                    $addCreateQuestionKeywords = $_POST['addCreateQuestionKeywords'];
                    for($i=0;$i<count($addCreateQuestionKeywords);$i++) {
                        echo("<br>".$addCreateQuestionKeywords[$i]);
                    }
                }
                else echo "<br>addCreateQuestionKeywords not set <=> aucun keyword coché (peut-être décoché)";
                echo "<br>up_question-keywords_click : ".$_POST['up_question-keywords_click'];
                echo "<br>"; echo "<br>";
                
                echo "<br>Answers :";//////////////////////////////////////////////

                echo "<br>Old answers to detete : ";////////////////

                for($i=0;$i<$_POST['nb-answers_original'];$i++){

                    if($_POST['up_answer_action_'.$i] == 'delete'){
                        echo "<br>deleteAnswer(".$_POST['answer_id_'.$i].")";
                    }
                }

                echo "<br><br>Old answers to update : ";////////////////

                for($i=0;$i<$_POST['nb-answers_original'];$i++){

                    if($_POST['up_answer_action_'.$i] == 'update'){
                        echo "<br>updateAnswer("
                        .$_POST['answer_id_'.$i]
                        .", "
                        .$_POST['answer_answer_'.$i]
                        .", "
                        .(isset($_POST['answer_ok_'.$i]) ? 1 : 0)
                        .", "
                        .(isset($_POST['answer_status_'.$i]) ? 'inline' : 'draft')
                        .")";
                    }
                }
             
                echo "<br><br>New answers to create : ";////////////////

                for($i=0;$i<$_POST['nb-max-answers-new'];$i++){
                    if(isset($_POST['answer_answer_'.$i.'_new'])){
                        echo "<br>createAnswer("
                        .$_POST['answer_answer_'.$i.'_new']
                        .", "
                        .(isset($_POST['answer_ok_'.$i.'_new']) ? 1 : 0)
                        .", "
                        .(isset($_POST['answer_status_'.$i.'_new']) ? 'inline' : 'draft')
                        .")";
                    }
                }
                echo "<br>";
                echo "<br>metadata :"; ///////////////////////////////////
                echo "<br>up_question (update question data or not) : ".$_POST['up_question']; // 1 means at least one change in the data question
                echo "<br>";
                echo "<br>up_question-keywords_click : ".$_POST['up_question-keywords_click']; //click on the select : 0 means no modification
                echo "<br>up_question-keywords : ".$_POST['up_question-keywords']; //the new keyword ids : 2,5,9
                echo "<br>";
                echo "<br>nb-max-answers-new : ".$_POST['nb-max-answers-new']; //number max of new answers (one empty shell is already displayed) 
                echo "<br>nb-answers_original : ".$_POST['nb-answers_original'];  //number of existing original answers
                
            }//end of the test
            */
            //TREATMENT :

            if (isset($_POST['form_update_question']) and $_POST['form_update_question'] ==1) {

                //givenStrs to control input strings :

                $givenStrs = array($_POST['question_question'], $_POST['question_guideline'], $_POST['question_explanationtitle'], $_POST['question_explanation']);
                //New answers to create
                $answersToCreate = array();
                for($i=0;$i<$_POST['nb-max-answers-new'];$i++){
                    if(isset($_POST['answer_answer_'.$i.'_new'])) {
                        $givenStrs[]=$_POST['answer_answer_'.$i.'_new'];

                        //For the DB, later :
                        $answersToCreate[] = [$_POST['answer_answer_'.$i.'_new'], (isset($_POST['answer_ok_'.$i.'_new']) ? 1 : 0), (isset($_POST['answer_status_'.$i.'_new']) ? "inline" : "draft")];
                    }
                }
                //Old answers to update
                $answersToUpdate = array();

                for($i=0;$i<$_POST['nb-answers_original'];$i++){
                    if($_POST['up_answer_action_'.$i] == 'update') {
                        $givenStrs[]=$_POST['answer_answer_'.$i];

                        //For the DB, later :
                        $answersToUpdate[] = [$_POST['answer_answer_'.$i], (isset($_POST['answer_ok_'.$i]) ? 1 : 0), (isset($_POST['answer_status_'.$i]) ? "inline" : "draft"), $_POST['answer_id_'.$i]];

                    }
                }

                //control input strings :
                $message = testStrsOnly("La mise à jour", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    //givenStrs to control empty inputs :

                    $givenStrs = array();
                    $givenStrs = array($_POST['question_question']);

                    //New answers to create
                    for($i=0;$i<$_POST['nb-max-answers-new'];$i++){
                        if(isset($_POST['answer_answer_'.$i.'_new'])) $givenStrs[]=$_POST['answer_answer_'.$i.'_new'];
                    }
                    //Old answers to update
                    for($i=0;$i<$_POST['nb-answers_original'];$i++){
                        if($_POST['up_answer_action_'.$i] == 'update') $givenStrs[]=$_POST['answer_answer_'.$i];
                    }
                    //control empty inputs :
                    $message = testNotEmpty("La mise à jour", $givenStrs);
                    if($message!="") {
                        //Display the update question screen :
                        header("Location: http://localhost/exo/J17-DIPLOME/index.php?controller=question&action=update&id=".$_POST['updatedquestiondid']."&from=this");
                        
                    }
                    else{ //Controls are over, continue the treatment :

                        $message = "";
                        $date = time();

                        //update the DB :
                        require "model/connexionbdd.php";

                        //Update the question :
                        if($_POST['up_question']){ // 1 means at least one change in the data question
                            
                            updateQuestion($_POST['updatedquestiondid'], $_POST['question_question'], $_POST['question_guideline'],
                                $_POST['question_explanationtitle'], $_POST['question_explanation'],
                                (isset($_POST['question_status']) ? "inline" : "draft"),
                                $date, $_POST['question_idwidget'], $login
                            ); 
                            $message = "Les données de la question ont été mises à jour.";
                        }
                        //Bind the keywords
                        //if(isset($_POST['addCreateQuestionKeywords'])){
                        if($_POST['up_question-keywords_click'] != 0){

                            up_bindKeywords($_POST['updatedquestiondid'], $_POST['addCreateQuestionKeywords']);
                            
                            if($message != '') {
                                $message = substr($message, 0, -1); //get the last character off
                                $message.= ", ainsi que les mots clés rattachés.";
                            }
                            else $message = "Les mots clés ont été mis à jour pour la question.";
                        }  
                        //Answers :
                
                        //New answers to create////////////////

                        if($answersToCreate != null) {
                            createAnswers ($answersToCreate, $date, $_POST['updatedquestiondid']);

                            $message.= " Réponse(s) créée(s) : ".count($answersToCreate).".";
                        }

                        ////Old answers to delete////////////////
                        $answersToDelete=array();
                        $j=0;
                        for($i=0;$i<$_POST['nb-answers_original'];$i++){

                            if($_POST['up_answer_action_'.$i] == 'delete'){
                                $answersToDelete[$j] = $_POST['answer_id_'.$i];
                                $j++;
                            }
                        }
                        if($answersToDelete != null){
                            deleteAnswers($answersToDelete);
                            $message.= " Réponse(s) supprimée(s) : ".count($answersToDelete).".";
                        }

                        //Old answers to update
                        if($answersToUpdate != null){
                            updateAnswers($answersToUpdate, $date, $_POST['updatedquestiondid']);
                            $message.= " Réponse(s) mise(s) à jour : ".count($answersToUpdate).".";
                        }
                 
                        //Display the list of the questions :
                        require "model/class_questions_list.php";
                        require "controller/class_questions_list_controller.php";
                        $ctrl = new class_questions_list_controller($login);

                        if($message == "") $message = "Aucune modification n'a été effectuée.";
                        $ctrl->displayAll();
                    }
                }
            }

            //////////////////////////form_delete_quiz (delete a quiz) ///////////////////////////////////////////////////
            //submited by the admin screen div_quiz_list.php/button 'Envoyer'
            
            if (isset($_POST['form_delete_quiz']) and $_POST['form_delete_quiz'] ==1) {
    
                require "model/connexionbdd.php";
                deleteQuiz($_POST['deletedquizid']);   

                //Display the quiz list
                require "model/class_questions_list.php";
                require "model/class_quiz_list.php";
                require "controller/class_quiz_list_controller.php";
                $ctrl = new class_quiz_list_controller($login);
                $message = "Le quiz '".$_POST['deletedquiz']."' a été supprimé avec succès. Aucune question n'a été supprimée.";                
                $ctrl->displayAll();
            }

            //////////////////////////form_create_quiz (create a quiz) ///////////////////////////////////////////////////
            //submited by the admin screen div_quiz_list.php/button 'Envoyer'
            
            //TEST :
            /*
            if (isset($_POST['form_create_quiz']) and $_POST['form_create_quiz'] ==1) {
                echo "<br>quiz_title : ".$_POST['quiz_title'];
                echo "<br>quiz_subtitle : ".$_POST['quiz_subtitle'];
                echo "<br>".(isset($_POST['quiz_status']) ? "inline" : "draft");
                
                if(isset($_POST['addCreateQuizQuestions'])){
                    $addCreateQuizQuestions = $_POST['addCreateQuizQuestions'];
                    for($i=0;$i<count($addCreateQuizQuestions);$i++) {
                        echo("<br>".$addCreateQuizQuestions[$i]);
                    }
                }
            }*/
            //TREATMENT :

            if (isset($_POST['form_create_quiz']) and $_POST['form_create_quiz'] ==1) {
                
                $givenStrs = array($_POST['quiz_title'], $_POST['quiz_subtitle']);
                
                $message = testStrsOnly("La création", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";

                    $givenStrs = array();
                    $givenStrs = array($_POST['quiz_title']);
                    
                    $message = testNotEmpty("La création", $givenStrs);
                    if($message!="") {
                        //Display the list of the quiz :
                        require "model/class_questions_list.php";
                        require "model/class_quiz_list.php";
                        require "controller/class_quiz_list_controller.php";
                        $ctrl = new class_quiz_list_controller($login);
                        $ctrl->displayAll();
                    }
                    else{ //Controls are over, continue the treatment :

                        //update the DB :

                        //Create the quiz :
                        $date = time();
                        $quiz_id = createQuiz($_POST['quiz_title'], $_POST['quiz_subtitle'],
                            (isset($_POST['quiz_status']) ? "inline" : "draft"),
                            $date, $date, $login
                        );
                        if ($quiz_id == null){
                            $message = "ATTENTION : suite à un problème technique, le quiz n'a pas pu être créé.";
                        }
                        else { //Bind the questions :
                            $message = "Le quiz a été créé avec succès.";

                            //Bind the Questions
                            if(isset($_POST['addCreateQuizQuestions'])){

                                bindQuestions($quiz_id, $_POST['addCreateQuizQuestions']);
                                
                                $message = substr($message, 0, -1); //get the last character off
                                $message.= ", avec la ou les questions rattachées.";
                            }
                        }
                        //Display the list of the quiz :
                        require "model/class_questions_list.php";
                        require "model/class_quiz_list.php";
                        require "controller/class_quiz_list_controller.php";
                        $ctrl = new class_quiz_list_controller($login);
                        $ctrl->displayAll();
                    }
                }
            }
            
            //////////////////////////form_update_quiz (update a quiz) ///////////////////////////////////////////////////
            //submited by the admin screen div_quiz.php/button 'Envoyer toutes les modifications de la page'
            
            //TEST :
            /*
            if (isset($_POST['form_update_quiz']) and $_POST['form_update_quiz'] ==1) {
                
                echo "<br>Quiz :"; //////////////////////////////////////////
                //Quiz ref.
                echo "<br>updatedquizdid (QUIZID) : ".$_POST['updatedquizdid'];
                echo "<br>updatedquiz (old quiz) : ".$_POST['updatedquiz'];
                //quiz change 
                echo "<br>up_quiz : ".$_POST['up_quiz'];
                //Quiz :
                echo "<br>quiz_title (new quiz) : ".$_POST['quiz_title'];
                echo "<br>quiz_title_old (old quiz) : ".$_POST['quiz_title_old'];

                echo "<br>quiz_subtitle : ".$_POST['quiz_subtitle'];
                echo "<br>quiz_subtitle_old : ".$_POST['quiz_subtitle_old'];

                echo "<br>quiz_status : ".(isset($_POST['quiz_status']) ? "inline" : "draft");
                echo "<br>quiz_status_old : ".$_POST['quiz_status_old'];
                
                echo "<br>";
                echo "<br>Questions :";//////////////////////////////////////////////
                echo "<br>nb-questions_original : ".$_POST['nb-questions_original'];
                echo "<br>";
                echo "<br>Old questions to detete : ";////////////////
                echo "<br>";
                for($i=0;$i<$_POST['nb-questions_original'];$i++){

                    if($_POST['up_question_action_'.$i] == 'delete'){
                        echo "<br>deleteQuestion(".$_POST['question_id_'.$i].") : ".$_POST['question_question_'.$i];
                    }
                }
                echo "<br>";
                echo "<br>Old answers to update : ";////////////////
                echo "<br>";
                for($i=0;$i<$_POST['nb-questions_original'];$i++){

                    if($_POST['up_question_action_'.$i] == 'update'){
                        echo "<br>updateQuestion("
                        .$_POST['question_id_'.$i]
                        .", "
                        .$_POST['quiz_question_numorder_'.$i]
                        .", "
                        .$_POST['quiz_question_weight_'.$i]
                        .") : ".$_POST['question_question_'.$i];
                    }
                }
             
                echo "<br><br>New answers to create : ";////////////////
                echo "<br>nb-max-questions-new : ".$_POST['nb-max-questions-new'];
                echo "<br>";echo "<br>";
                for($i=0;$i<$_POST['nb-max-questions-new'];$i++){
                    if(isset($_POST['question_id_'.$i.'_new'])){
                        echo "<br>createQuestion("
                        .$_POST['question_id_'.$i.'_new']
                        .", "
                        .$_POST['quiz_question_numorder_'.$i.'_new']
                        .", "
                        .$_POST['quiz_question_weight_'.$i.'_new']
                        .")";
                    }
                }
            }//end of the test
            */
            //TREATMENT :
            
            if (isset($_POST['form_update_quiz']) and $_POST['form_update_quiz'] ==1) {

                //givenStrs to control input strings :

                $givenStrs = array($_POST['quiz_title'], $_POST['quiz_subtitle']);
                
                //control input strings :
                $message = testStrsOnly("La mise à jour", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    //givenStrs to control empty inputs :

                    $givenStrs = array();
                    $givenStrs = array($_POST['quiz_title']);
                    
                    //control empty inputs :
                    $message = testNotEmpty("La mise à jour", $givenStrs);
                    if($message!="") {
                        //Display the update quiz screen :
                        header("Location: http://localhost/exo/J17-DIPLOME/index.php?controller=quiz&action=update&id=".$_POST['updatedquizdid']."&from=this");
                    }
                    else{ //Controls are over, continue the treatment :

                        $message = "";
                        $date = time();

                        //update the DB :
                        require "model/connexionbdd.php";

                        //Update the quiz :
                        if($_POST['up_quiz']){ // 1 means at least one change in the data quiz
                            
                            updateQuiz($_POST['updatedquizdid'], $_POST['quiz_title'], $_POST['quiz_subtitle'],
                                (isset($_POST['quiz_status']) ? "inline" : "draft"), $date
                            ); 
                            $message = "Les données du quiz ont été mises à jour.";
                        }
                        
                        //Questions :

                        //New questions to bind////////////////
                        $questionsToBind =[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-max-questions-new'];$i++){
                            if(isset($_POST['question_id_'.$i.'_new'])){
                                $questionsToBind[$j][QUESTIONID] = $_POST['question_id_'.$i.'_new'];
                                $questionsToBind[$j][qqNUMORDER] = $_POST['quiz_question_numorder_'.$i.'_new'];
                                $questionsToBind[$j][qqWEIGHT] = $_POST['quiz_question_weight_'.$i.'_new'];
                                $j++;
                            }
                        }
                        if($questionsToBind != null) {
                            bindQuizQuestions($questionsToBind, $_POST['updatedquizdid']);

                            $message.= " Question(s) rattachée(s) : ".count($questionsToBind).".";
                        }

                        ////Old question to unbind////////////////
                        $questionsToUnbind=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-questions_original'];$i++){

                            if($_POST['up_question_action_'.$i] == 'delete'){
                                $questionsToUnbind[$j] = $_POST['question_id_'.$i];
                                $j++;
                            }
                        }
                        if($questionsToUnbind != null){
                            unbindQuestions($questionsToUnbind, $_POST['updatedquizdid']);
                            $message.= " Question(s) détachée(s) : ".count($questionsToUnbind).".";
                        }

                        //Old questions to update
                        $questionsToUpdate=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-questions_original'];$i++){

                            if($_POST['up_question_action_'.$i] == 'update'){
                                $questionsToUpdate[$j][QUESTIONID] = $_POST['question_id_'.$i];
                                $questionsToUpdate[$j][qqNUMORDER] = $_POST['quiz_question_numorder_'.$i];
                                $questionsToUpdate[$j][qqWEIGHT] = $_POST['quiz_question_weight_'.$i];
                                $j++;
                            }
                        }
                        if($questionsToUpdate != null){
                            updateQuizQuestions($questionsToUpdate, $_POST['updatedquizdid']);
                            $message.= " Question(s) mise(s) à jour : ".count($questionsToUpdate).".";
                        }
                 
                        //Display the list of the quiz :                    
                        require "model/class_questions_list.php"; //to add a question to the quiz
                        require "model/class_quiz_list.php";
                        require "controller/class_quiz_list_controller.php";
                        $ctrl = new class_quiz_list_controller($login);
                        $ctrl->displayAll();
                    }
                }
            }
 
            //////////////form_create_account (create a user account) ///////////////////////////////////////////////////
            //submited by the admin screen div_account_list.php/button 'Envoyer'
            
            //TEST :
            /*
            if (isset($_POST['form_create_account']) and $_POST['form_create_account'] ==1){
                echo "<br>account_login : ".$_POST['account_login'];
                echo "<br>account_name : ".$_POST['account_name'];
                echo "<br>account_firstname : ".$_POST['account_firstname'];
                echo "<br>account_company : ".$_POST['account_company'];
                echo "<br>account_email : ".$_POST['account_email'];

                if(isset($_POST['addCreateAccountSessions'])){
                    $addCreateAccountSessions = $_POST['addCreateAccountSessions'];
                    for($i=0;$i<count($addCreateAccountSessions);$i++) {
                        echo "<br>addCreateAccountSessions[".$i."] : ".$addCreateAccountSessions[$i];
                    }
                }
            }*/
            //TREATMENT :

            if (isset($_POST['form_create_account']) and $_POST['form_create_account'] ==1) {
                
                $givenStrs = array($_POST['account_login'], $_POST['account_name'], $_POST['account_firstname'], $_POST['account_company'], $_POST['account_email']);
                
                $message = testStrsOnly("La création", $givenStrs);
                if($message!="") {
                    $messageHeader=$message;
                    disconnect($messageHeader);
                }
                else{
                    require "model/connexionbdd.php";

                    $givenStrs = array();
                    $givenStrs = array($_POST['account_login'], $_POST['account_name'], $_POST['account_firstname']);
                    
                    $message = testNotEmpty("La création", $givenStrs);
                    if($message!="") {
                        //Display the list of the accounts :
                        require "model/class_accounts_list.php";
                        require "controller/class_accounts_list_controller.php";
                        $ctrl = new class_accounts_list_controller($login);
                        $ctrl->displayAll();
                    }
                    else{ //Controls are over, continue the treatment :

                        //update the DB :

                        //Create the account :
                        $addCreateAccountSessions=null;
                        if(isset($_POST['addCreateAccountSessions'])){
                            $addCreateAccountSessions = $_POST['addCreateAccountSessions'];
                        }
                        $accountcreation = createAccount($login, $_POST['account_login'], $_POST['account_name'], $_POST['account_firstname'], $_POST['account_company'], $_POST['account_email'], $addCreateAccountSessions);
                        $accountLogin = $_POST['account_login'];
               
                        if($accountcreation == $accountLogin) $message = "Le compte a été créé mais n'a été rattaché à aucune session.";
                        else if($accountcreation == null) $message = "ATTENTION : le login ".$_POST['account_login']." n'est pas disponible, le compte n'a pas pu être créé.";
                        else $message = "Le compte a été créé et rattaché à ".$accountcreation." session(s).";
                        
                        //Display the list of the accounts :
                        require "model/class_accounts_list.php";
                        require "controller/class_accounts_list_controller.php";
                        $ctrl = new class_accounts_list_controller($login);
                        $ctrl->displayAll();
                    }
                }
            }
            
            //////////////form_delete_account (delete an account) ///////////////////////////////////////////////////         
            //submited by the admin screen div_account_list.php/button 'Envoyer'
            
            //TESTS :
            /*
            if (isset($_POST['form_delete_account']) and $_POST['form_delete_account'] ==1) {
                echo "deletedaccountlogin : ".$_POST['deletedaccountlogin'];
            }
            */

            //TREATMENT :
            if (isset($_POST['form_delete_account']) and $_POST['form_delete_account'] ==1) {
                
                $givenStrs = array($_POST['deletedaccountlogin']);
                
                $message = testStrsOnly("La suppression", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                $message = testNotEmpty("La suppression", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }

                require "model/connexionbdd.php";

                //control on the logins KO
                $message = deleteAccount($_POST['deletedaccountlogin'], $login);
                if($message!="user" and $message!="admin") {
                    session_destroy();
                    require "view/form_login.php";
                }
                //delete an 'admin' account
                if($message=="admin") {
                    $messageHeader="Le compte administrateur '".$_POST['deletedaccountlogin']."' a été supprimé.";
                    disconnect($messageHeader);
                }
                //delete a 'user' account
                if($message=="user") {
                    //Display the list of the accounts :
                    require "model/class_accounts_list.php";
                    require "controller/class_accounts_list_controller.php";
                    $ctrl = new class_accounts_list_controller($login);
                    $message = "Le compte user '".$_POST['deletedaccountlogin']."' a été supprimé ainsi que ses éventuels résultats.";
                    $ctrl->displayAll();
                }
            }

            ////////////////// form_delete_session (delete a session) ///////////////////////////////////////////////////         
            //submited by the admin screen div_session_list.php/button 'Envoyer'
            
            //TESTS :
            /*
            if (isset($_POST['form_delete_session']) and $_POST['form_delete_session'] ==1) {
                echo "<br>deletedsessionid : ".$_POST['deletedsessionid'];
                echo "<br>deletedsessiontitle : ".$_POST['deletedsessiontitle'];
                if (isset($_POST['checksuppaccount'])) echo "<br>Supprimer aussi les comptes.";
                else echo "<br>Ne pas supprimer les comptes.";
            }
            */

            //TREATMENT :
            if (isset($_POST['form_delete_session']) and $_POST['form_delete_session'] ==1) {
                
                $givenStrs = array($_POST['deletedsessionid'],$_POST['deletedsessiontitle']);
                //test the data :
                $message = testStrsOnly("La suppression", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{ //test if not empty :
                    $message = testNotEmpty("La suppression", $givenStrs);
                    if($message!="") {
                        session_destroy();
                        require "view/form_login.php";
                    }
                    else{ //try to delete the session : 
                        require "model/connexionbdd.php";

                        if (isset($_POST['checksuppaccount'])) $suppWhollyOwnedAccounts = true;
                        else $suppWhollyOwnedAccounts = false; 
                        
                        $message = deleteSession($_POST['deletedsessionid'], $login, $suppWhollyOwnedAccounts);

                        //control on the logins KO
                        if(substr($message, 0, strlen("session"))!= "session") {
                            session_destroy();
                            require "view/form_login.php";
                        }
                        else{ // the session has been deleted with or witout accounts :                           
                            require "model/class_sessions_list.php";
                            require "controller/class_sessions_list_controller.php";
                            $ctrl = new class_sessions_list_controller($login);
                            
                            //get the number of accounts deleted (for example deleteSession() returns "session-12" if 12 accounts has been deteted)
                            $prefixLen= strlen("session") +1;
                            $nbaccounts = substr($message, $prefixLen, strlen($message) - $prefixLen);
                            if($nbaccounts == 0){
                                $message= "La session '".$_POST['deletedsessiontitle']."' a été supprimée et aucun compte n'a été supprimé.";
                            }
                            else{
                                $message= "La session '".$_POST['deletedsessiontitle']."' a été supprimée ainsi que ".$nbaccounts." de ses comptes.";
                            }
                            $ctrl->displayAll();
                        }
                    }
                }
            }
            
            ////////////// form_create_session (create a session) ///////////////////////////////////////////////////
            //submited by the admin screen div_session_list.php/button 'Envoyer'
            
            //TEST : 
            /*
            if (isset($_POST['form_create_session']) and $_POST['form_create_session'] ==1){

                echo "<br>session_title : ".$_POST['session_title'];
                echo "<br>session_subtitle : ".$_POST['session_subtitle'];
                echo "<br>";

                echo "<br>session_startdate : ".$_POST['session_startdate'];
                if (isset($_POST['session_startdate'])) echo "<br>is set";
                else echo "<br>is not set";
                $time = strtotime($_POST['session_startdate']);  
                if($time == false) echo "<br>strtotime is false";
                else echo "<br>strtotime : ".$time;
                echo "<br>date(strtotime) : ".date("d/m/Y", $time);

                echo "<br>";
                echo "<br>session_enddate : ".$_POST['session_enddate'];
                if (isset($_POST['session_enddate'])) echo "<br>is set";
                else echo "<br>is not set";
                $time = strtotime($_POST['session_enddate']);  
                if($time == false) echo "<br>strtotime is false";
                else echo "<br>strtotime : ".$time;
                echo "<br>date(strtotime) : ".date("d/m/Y", $time);
                //var_dump($time);
            }  
            */
            //TREATMENT :

            if (isset($_POST['form_create_session']) and $_POST['form_create_session'] ==1) {
                
                $givenStrs = array($_POST['session_title'], $_POST['session_subtitle'], $_POST['session_startdate'], $_POST['session_enddate']);
                
                $message = testStrsOnly("La création", $givenStrs);
                if($message!="") {
                    session_destroy(); //the PC session
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";

                    $givenStrs = array();
                    $givenStrs = array($_POST['session_title']);
                    
                    $message = testNotEmpty("La création", $givenStrs);
                    if($message!="") {
                        //Display the list of the sessions :
                        require "model/class_sessions_list.php";
                        require "controller/class_sessions_list_controller.php";
                        $ctrl = new class_sessions_list_controller($login);
                        $ctrl->displayAll();
                    }
                    
                    else{ //Controls are over, continue the treatment :

                        //update the DB :

                        //Create the session :                       
                        createSession($login, $_POST['session_title'], $_POST['session_subtitle'], $_POST['session_startdate'], $_POST['session_enddate']);
                        
                        //Display the list of the sessions :
                        require "model/class_sessions_list.php";
                        require "controller/class_sessions_list_controller.php";
                        $ctrl = new class_sessions_list_controller($login);

                        $message = "La session '".$_POST['session_title']."' a été créée.";
                        $ctrl->displayAll();
                    }
                }
            }
           
            //////////////////////////form_update_account (update an account) ///////////////////////////////////////////////////
            //submited by the admin screen div_account.php/button 'Envoyer toutes les modifications de la page'
            
            //TEST :
            /*
            if (isset($_POST['form_update_account']) and $_POST['form_update_account'] ==1) {
                //account
                echo "<br>account :"; //////////////////////////////////////////
                echo "<br>updatedaccountdid : ".$_POST['updatedaccountdid'];
                echo "<br>updatedaccount : ".$_POST['updatedaccount'];
                //account change 
                echo "<br>up_account : ".$_POST['up_account'];
                echo "<br>";
                echo "<br>account_name : ".$_POST['account_name'];
                echo "<br>account_name_old : ".$_POST['account_name_old'];
                echo "<br>account_firstname : ".$_POST['account_firstname'];
                echo "<br>account_firstname_old : ".$_POST['account_firstname_old'];
                echo "<br>account_company : ".$_POST['account_company'];
                echo "<br>account_company_old : ".$_POST['account_company_old'];
                echo "<br>account_email : ".$_POST['account_email'];
                echo "<br>account_email_old : ".$_POST['account_email_old'];
                echo "<br>".(isset($_POST['account_psw']) ? "RAZ psw" : "Pas de RAZ psw");
                echo "<br>";
                                
                echo "<br>Sessions :";//////////////////////////////////////////////
                echo "<br>nb-sessions_original : ".$_POST['nb-sessions_original'];
                echo "<br>";
                echo "<br>Old sessions to detach : ";////////////////
                for($i=0;$i<$_POST['nb-sessions_original'];$i++){

                    if($_POST['up_session_action_'.$i] == 'delete'){
                        echo "<br>deleteSession(".$_POST['session_id_'.$i].") : ".$_POST['session_session_'.$i];
                    }
                }
                echo "<br>";
             
                echo "<br>New sessions to bind : ";////////////////
                echo "<br>nb-max-sessions-new : ".$_POST['nb-max-sessions-new'];
                echo "<br>";
                for($i=0;$i<$_POST['nb-max-sessions-new'];$i++){
                    if(isset($_POST['session_id_'.$i.'_new'])){
                        echo "<br>createSession("
                        .$_POST['session_id_'.$i.'_new']
                        .")";
                    }
                }
            }//end of the test
            */
            //TREATMENT :
            
            if (isset($_POST['form_update_account']) and $_POST['form_update_account'] ==1) {
           
                //givenStrs to control input strings :

                $givenStrs = array($_POST['account_name'], $_POST['account_firstname'], $_POST['account_company'], $_POST['account_email']);
                
                //control input strings :
                $message = testStrsOnly("La mise à jour", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    //givenStrs to control empty inputs :

                    $givenStrs = array();
                    $givenStrs = array($_POST['account_name'], $_POST['account_firstname']);
                    
                    //control empty inputs :
                    $message = testNotEmpty("La mise à jour", $givenStrs);
                    if($message!="") {
                        //Display the update quiz screen :
                        header("Location: http://localhost/exo/J17-DIPLOME/index.php?controller=account&action=update&id=".$_POST['updatedaccountdid']."&from=this");
                    }
                    else{ //Controls are over, continue the treatment :

                        $message = "";

                        //update the DB :
                        require "model/connexionbdd.php";

                        //Update the account ////////////////
                        if($_POST['up_account']){ // '1' means at least one change in the data account
                            $ressetPsw = (isset($_POST['account_psw']) ? true : false);
                            updateAccount($_POST['updatedaccountdid'], $_POST['account_name'], $_POST['account_firstname'], $_POST['account_company'], $_POST['account_email'], $ressetPsw); 
                            $message = "Les données du compte ont été mises à jour.";
                        }

                        //New Sessions to bind////////////////
                        $sessionsToBind =[];
                        for($i=0;$i<$_POST['nb-max-sessions-new'];$i++){
                            if(isset($_POST['session_id_'.$i.'_new'])){
                                $sessionsToBind[] = $_POST['session_id_'.$i.'_new'];
                            }
                        }
                        if($sessionsToBind != null) {
                            bindAccountSessions($sessionsToBind, $_POST['updatedaccountdid']);

                            $message.= " Session(s) rattachée(s) : ".count($sessionsToBind).".";
                        }
                        ////Old sessions to unbind////////////////
                        $sessionsToUnbind=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-sessions_original'];$i++){

                            if($_POST['up_session_action_'.$i] == 'delete'){
                                $sessionsToUnbind[$j] = $_POST['session_id_'.$i];
                                $j++;
                            }
                        }
                        if($sessionsToUnbind != null){
                            unbindSessions($sessionsToUnbind, $_POST['updatedaccountdid']);
                            $message.= " Session(s) détachée(s) : ".count($sessionsToUnbind).".";
                        }
                        //Display the list of the accounts : 
                        require "model/class_accounts_list.php";
                        require "controller/class_accounts_list_controller.php";
                        $ctrl = new class_accounts_list_controller($login);
                        $ctrl->displayAll();
                    }
                }
            }
        
            
            ////////////////////////// form_update_session (update a session) ///////////////////////////////////////////////////
            //submited by the admin screen div_session.php/button 'Envoyer toutes les modifications de la page'
            
            //TEST :
            /*
            if (isset($_POST['form_update_session']) and $_POST['form_update_session'] ==1) {
                
                echo "<br>Session :"; /////////////////////////////////////////////////
                //Session ref.
                echo "<br>updatedsessiondid : ".$_POST['updatedsessiondid'];
                echo "<br>updatedsession : ".$_POST['updatedsession'];
                //Session change 
                echo "<br>up_session : ".$_POST['up_session'];
                //Session :
                echo "<br>session_title : ".$_POST['session_title'];
                echo "<br>session_title_old : ".$_POST['session_title_old'];

                echo "<br>session_subtitle : ".$_POST['session_subtitle'];
                echo "<br>session_subtitle_old : ".$_POST['session_subtitle_old'];
                
                echo "<br>session_startdate : ".((isset($_POST['session_startdate']) and $_POST['session_startdate'] != '') ? $_POST['session_startdate'] : "0");
                echo "<br>session_startdate_old : ".$_POST['session_startdate_old'];

                echo "<br>session_enddate : ".((isset($_POST['session_enddate']) and $_POST['session_enddate'] != '') ? $_POST['session_enddate'] : "0");
                echo "<br>session_enddate_old : ".$_POST['session_enddate_old'];

                echo "<br>session_logolocation : ".$_POST['session_logolocation'];
                echo "<br>session_logolocation_old : ".$_POST['session_logolocation_old'];

                echo "<br>session_bgimagelocation : ".$_POST['session_bgimagelocation'];
                echo "<br>session_bgimagelocation_old : ".$_POST['session_bgimagelocation_old'];
                echo"<br>";
                if ($_POST['up_session']){
                    echo "<br>updateSession("
                    .$_POST['updatedsessiondid']
                    .", "
                    ."'".$_POST['session_title']."'"
                    .", "
                    ."'".$_POST['session_subtitle']."'"
                    .", "
                    .((isset($_POST['session_startdate']) and $_POST['session_startdate'] != '') ? strtotime($_POST['session_startdate']) : "0")
                    .", "
                    .((isset($_POST['session_enddate']) and $_POST['session_enddate'] != '') ? strtotime($_POST['session_enddate']) : "0")
                    .", "
                    ."'".$_POST['session_logolocation']."'"
                    .", "
                    ."'".$_POST['session_bgimagelocation']."'"
                    .")";
                }

                echo "<br>"; ////////////////////////////////////////////////////////
                echo "<br>Quiz :";
                echo "<br>nb-quiz_original : ".$_POST['nb-quiz_original'];
                echo "<br>";
                echo "<br>Old quiz to unbind : ";////////////////
                for($i=0;$i<$_POST['nb-quiz_original'];$i++){

                    if($_POST['up_quiz_action_'.$i] == 'delete'){
                        echo "<br>unbindSessionQuiz(".$_POST['quiz_id_'.$i].")";
                    }
                }
                echo "<br>";
                echo "<br>Old quiz to update : ";////////////////
                for($i=0;$i<$_POST['nb-quiz_original'];$i++){

                    if($_POST['up_quiz_action_'.$i] == 'update'){
                        echo "<br>updateSessionQuiz("
                        .$_POST['quiz_id_'.$i]
                        .", "
                        .((isset($_POST['session_quiz_minutesduration'.$i]) and $_POST['session_quiz_minutesduration'.$i] != '') ? $_POST['session_quiz_minutesduration'.$i] : 0)
                        .", "
                        .((isset($_POST['session_quiz_openingdate'.$i]) and $_POST['session_quiz_openingdate'.$i] != '') ? $_POST['session_quiz_openingdate'.$i] : 0)
                        .", "
                        .((isset($_POST['session_quiz_closingdate'.$i]) and $_POST['session_quiz_closingdate'.$i] != '') ? $_POST['session_quiz_closingdate'.$i] : 0)
                        .")";
                    }

                    if($_POST['up_quiz_action_'.$i] == 'update'){
                        echo "<br>updateSessionQuiz("
                        .$_POST['quiz_id_'.$i]
                        .", "
                        .((isset($_POST['session_quiz_minutesduration'.$i]) and $_POST['session_quiz_minutesduration'.$i] != '') ? substr($_POST['session_quiz_minutesduration'.$i],0,2)*60+substr($_POST['session_quiz_minutesduration'.$i],3,2) : 0)
                        .", "
                        .((isset($_POST['session_quiz_openingdate'.$i]) and $_POST['session_quiz_openingdate'.$i] != '') ? $_POST['session_quiz_openingdate'.$i] : 0)
                        .", "
                        .((isset($_POST['session_quiz_closingdate'.$i]) and $_POST['session_quiz_closingdate'.$i] != '') ? $_POST['session_quiz_closingdate'.$i] : 0)
                        .")";
                    }
                    
                }
                echo "<br><br>nb-max-quiz-new : ".$_POST['nb-max-quiz-new'];
                echo "<br>New quiz to bind : ";////////////////
        //echo "<br>";$arr = get_defined_vars();print_r($arr["_POST"]);
                for($i=0;$i<$_POST['nb-max-quiz-new'];$i++){ // =1
                    if(isset($_POST['quiz_id_'.$i.'_new'])){

                        echo "<br>bindQuizToSession("
                        .$_POST['quiz_id_'.$i.'_new']
                        .", "
                        .((isset($_POST['session_quiz_minutesduration'.$i.'_new']) and $_POST['session_quiz_minutesduration'.$i.'_new'] != '') ? $_POST['session_quiz_minutesduration'.$i.'_new'] : 0)
                        .", "
                        .((isset($_POST['session_quiz_openingdate'.$i.'_new']) and $_POST['session_quiz_openingdate'.$i.'_new'] != '') ? $_POST['session_quiz_openingdate'.$i.'_new'] : 0)
                        .", "
                        .((isset($_POST['session_quiz_closingdate'.$i.'_new']) and $_POST['session_quiz_closingdate'.$i.'_new'] != '') ? $_POST['session_quiz_closingdate'.$i.'_new'] : 0)
                        .")";
                    }
                }

                echo "<br>";echo "<br>"; ////////////////////////////////////////////////////////
                echo "<br>Accounts :";
                echo "<br>nb-accounts_original : ".$_POST['nb-accounts_original'];
                echo "<br>";
                echo "<br>Old accounts to unbind : ";////////////////
                for($i=0;$i<$_POST['nb-accounts_original'];$i++){

                    if($_POST['up_account_action_'.$i] == 'delete'){
                        echo "<br>unbindSessionAccount(".$_POST['account_id_'.$i].")";
                    }
                }
                echo "<br>";
                echo "<br>nb-max-accounts-new : ".$_POST['nb-max-accounts-new'];
                echo "<br>New accounts to bind : ";////////////////
                for($i=0;$i<$_POST['nb-max-accounts-new'];$i++){
                    if(isset($_POST['account_id_'.$i.'_new'])){ ///
                        echo "<br>bindSessionAccount("
                        .$_POST['account_id_'.$i.'_new']
                        .")";
                    }
                }
            }//end of the test
            */
            //TREATMENT :
            
            if (isset($_POST['form_update_session']) and $_POST['form_update_session'] ==1) {
           
                //givenStrs to control input strings :

                $givenStrs = array($_POST['session_title'], $_POST['session_subtitle'],
                $_POST['session_startdate'], $_POST['session_enddate'],
                $_POST['session_logolocation'], $_POST['session_bgimagelocation'] );

                for($i=0;$i<$_POST['nb-quiz_original'];$i++){
                    if($_POST['up_quiz_action_'.$i] == 'update'){
                        $givenStrs[] = $_POST['quiz_id_'.$i];
                        $givenStrs[] = ((isset($_POST['session_quiz_minutesduration'.$i]) and $_POST['session_quiz_minutesduration'.$i] != '') ? $_POST['session_quiz_minutesduration'.$i] : 0);
                        $givenStrs[] = ((isset($_POST['session_quiz_openingdate'.$i]) and $_POST['session_quiz_openingdate'.$i] != '') ? $_POST['session_quiz_openingdate'.$i] : 0);
                        $givenStrs[] = ((isset($_POST['session_quiz_closingdate'.$i]) and $_POST['session_quiz_closingdate'.$i] != '') ? $_POST['session_quiz_closingdate'.$i] : 0);
                    }
                }
                //control input strings :
                $message = testStrsOnly("La mise à jour", $givenStrs);
                if($message!="") {
                    session_destroy();
                    require "view/form_login.php";
                }
                else{
                    //givenStrs to control empty inputs :

                    $givenStrs = array();
                    $givenStrs = array($_POST['session_title']);
                    
                    //control empty inputs :
                    $message = testNotEmpty("La mise à jour", $givenStrs);
                    if($message!="") {
                        //Display the update session screen :
                        header("Location: http://localhost/exo/J17-DIPLOME/index.php?controller=session&action=update&id=".$_POST['updatedsessiondid']."&from=this");
                    }
                    else{ //Controls are over, continue the treatment :
                        $message = "";

                        //update the DB :
                        require "model/connexionbdd.php";

                        //Update the session :
                        if ($_POST['up_session']){
                            updateSession(
                                $_POST['updatedsessiondid'],
                                $_POST['session_title'],
                                $_POST['session_subtitle'],
                                ((isset($_POST['session_startdate']) and $_POST['session_startdate'] != '') ? strtotime($_POST['session_startdate']) : "0"),
                                ((isset($_POST['session_enddate']) and $_POST['session_enddate'] != '') ? strtotime($_POST['session_enddate']) : "0"),
                                $_POST['session_logolocation'],
                                $_POST['session_bgimagelocation']
                            );
                            $message = "Les données de la session ont été mises à jour.";
                        }

                        //Quiz :

                        //New Quiz to bind////////////////
                                                
                        $quizToBind =[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-max-quiz-new'];$i++){
                            if(isset($_POST['quiz_id_'.$i.'_new'])){
                                $quizToBind[$j][QUIZID] = $_POST['quiz_id_'.$i.'_new'];
                                $quizToBind[$j][OPENINGDATE] = ((isset($_POST['session_quiz_openingdate'.$i.'_new']) and $_POST['session_quiz_openingdate'.$i.'_new'] != '') ? strtotime($_POST['session_quiz_openingdate'.$i.'_new']) : 0);
                                $quizToBind[$j][CLOSINGDATE] = ((isset($_POST['session_quiz_closingdate'.$i.'_new']) and $_POST['session_quiz_closingdate'.$i.'_new'] != '') ? strtotime($_POST['session_quiz_closingdate'.$i.'_new']) : 0);
                                $quizToBind[$j][DURATION] = ((isset($_POST['session_quiz_minutesduration'.$i.'_new']) and $_POST['session_quiz_minutesduration'.$i.'_new'] != '') ? substr($_POST['session_quiz_minutesduration'.$i.'_new'],0,2)*60+substr($_POST['session_quiz_minutesduration'.$i.'_new'],3,2) : 0);
                                $j++;
                            }
                        }
                        if($quizToBind != null) {
                            bindQuizToSession($quizToBind, $_POST['updatedsessiondid']);

                            $message.= " Quiz rattaché(s) : ".count($quizToBind).".";
                        }

                        ////Old quiz to unbind////////////////

                        $quizToUnbind=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-quiz_original'];$i++){

                            if($_POST['up_quiz_action_'.$i] == 'delete'){
                                $quizToUnbind[$j] = $_POST['quiz_id_'.$i];
                                $j++;
                            }
                        }
                        if($quizToUnbind != null){
                            unbindSessionQuiz($quizToUnbind, $_POST['updatedsessiondid']);
                            $message.= " Quiz détaché(s) : ".count($quizToUnbind).".";
                        }

                        //Old quiz to update

                        $quizToUpdate=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-quiz_original'];$i++){

                            if($_POST['up_quiz_action_'.$i] == 'update'){
                                $quizToUpdate[$j][QUIZID] = $_POST['quiz_id_'.$i];
                                $quizToUpdate[$j][OPENINGDATE] = ((isset($_POST['session_quiz_openingdate'.$i]) and $_POST['session_quiz_openingdate'.$i] != '') ? strtotime($_POST['session_quiz_openingdate'.$i]) : 0);
                                $quizToUpdate[$j][CLOSINGDATE] = ((isset($_POST['session_quiz_closingdate'.$i]) and $_POST['session_quiz_closingdate'.$i] != '') ? strtotime($_POST['session_quiz_closingdate'.$i]) : 0);
                                $quizToUpdate[$j][DURATION] = ((isset($_POST['session_quiz_minutesduration'.$i]) and $_POST['session_quiz_minutesduration'.$i] != '') ? substr($_POST['session_quiz_minutesduration'.$i],0,2)*60+substr($_POST['session_quiz_minutesduration'.$i],3,2) : 0);
                                $j++;
                            }
                        }
                        if($quizToUpdate != null){
                            updateSessionQuiz($quizToUpdate, $_POST['updatedsessiondid']);
                            $message.= " Quiz mis à jour : ".count($quizToUpdate).".";
                        }
                        /////////////////////////////////////////////////

                        //Accounts :

                        //New accounts to bind////////////////
                                                
                        $accountsToBind =[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-max-accounts-new'];$i++){
                            if(isset($_POST['account_id_'.$i.'_new'])){ ///
                                $accountsToBind[$j] = $_POST['account_id_'.$i.'_new'];
                                $j++;
                            }
                        }
                        if($accountsToBind != null) {
                            bindAccountsToSession($accountsToBind, $_POST['updatedsessiondid']);

                            $message.= " Comptes rattaché(s) : ".count($accountsToBind).".";
                        }

                        ////Old accounts to unbind////////////////

                        $accountsToUnbind=[];
                        $j=0;
                        for($i=0;$i<$_POST['nb-accounts_original'];$i++){

                            if($_POST['up_account_action_'.$i] == 'delete'){
                                $accountsToUnbind[$j] = $_POST['account_id_'.$i];
                                $j++;
                            }
                        }
                        if($accountsToUnbind != null){
                            unbindSessionAccounts($accountsToUnbind, $_POST['updatedsessiondid']);
                            $message.= " Comptes détaché(s) : ".count($accountsToUnbind).".";
                        }

                        ///////////////////////////////////////////////////
                        //Display the list of the session :     
                        require "model/class_sessions_list.php";
                        require "controller/class_sessions_list_controller.php";
                        $ctrl = new class_sessions_list_controller($login);
                        if($message = ""){
                            $message = "Aucune mise à jour n'a été effectuée.";
                        }
                        $ctrl->displayAll();
                    }
                }
            }

            //////////////form_lock_quiz (take a quiz and lock it) ///////////////////////////////////////////////////
            //submited by the user screen div_quiz_userlist.php/button 'Lancer le quiz'
            
            //TEST : 
            /*
            if (isset($_POST['form_lock_quiz']) and $_POST['form_lock_quiz'] ==1){
                echo "<br>lockedquizid : ".$_POST['lockedquizid'];
                echo "<br>quizduration : ".$_POST['quizduration'];
                echo "<br>quizsessionid : ".$_POST['quizsessionid'];
            }  
            */
            //TREATMENT :

            if (isset($_POST['form_lock_quiz']) and $_POST['form_lock_quiz'] ==1){
                
                $givenStrs = array($_POST['lockedquizid'], $_POST['quizduration'], $_POST['quizsessionid']);
                
                $message = testStrsOnly("Le lancement", $givenStrs);
                if($message!="") {
                    session_destroy(); //the PC session
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";

                    //If the quiz is not locked, lock the quiz :
                    if($quizlock_datetime = lockQuiz($_POST['lockedquizid'], $_POST['quizsessionid'], $login)){ //lock if unlocked, else false
                        //launch the quiz                       
                        require "model/class_takenquiz.php";
                        require "controller/class_takenquiz_controller.php";
                        $sessionId = $_POST['quizsessionid'];
                        $quizId = $_POST['lockedquizid'];
                        $duration = $_POST['quizduration']; //not used ?!
                        $ctrl = new class_takenquiz_controller($sessionId, $quizId);
                        $ctrl->displayOne();        
                    }
                    else{
                        $message = "Vous avez déjà verrouillé ce quiz. Contactez votre formateur.";
                        //Display the quiz list :
                        require "model/class_quiz_userlist.php";
                        require "controller/class_quiz_userlist_controller.php";
                        $ctrl = new class_quiz_userlist_controller($login);                            
                        $ctrl->displayAll();
                    }
                }
            }

            //////////////form_update_results (delete a result and/or unlock a quiz) ///////////////////////////////////////////////////
            //submited by the admin screen div_stat_account_session_quiz.php/button 'Supprimer les résultats cochés et/ou débloquer les quiz décochés'
            
            //TEST : 
            /*
            if (isset($_POST['form_update_results']) and $_POST['form_update_results'] ==1){
                echo "<br>update_results_session : ".$_POST['update_results_session'];
                echo "<br>update_results_account : ".$_POST['update_results_account'];
                echo "<br>unblocked_quizzes : ".$_POST['unblocked_quizzes'];
                echo "<br>deleted_results : ".$_POST['deleted_results']; //quiz ids
            }  
            */
            //TREATMENT :

            if (isset($_POST['form_update_results']) and $_POST['form_update_results'] ==1){
                
                $givenStrs = array($_POST['update_results_session'], $_POST['update_results_account'], $_POST['unblocked_quizzes'], $_POST['deleted_results']);
                
                $message = testStrsOnly("La mise à jour", $givenStrs);
                if($message!="") {
                    session_destroy(); //the PC session
                    require "view/form_login.php";
                }
                else{
                    require "model/connexionbdd.php";

                    //Delete results :
                    $results = explode(",", $_POST['deleted_results']);
                    if($results[0]){
                        for($i=0;$i<count($results);$i++){
                            deleteResult($_POST['update_results_session'],
                                $_POST['update_results_account'], $results[$i]);
                        }
                        $message="Résultats supprimés : ".$i.".";
                    }
                    else $message="Résultats supprimés : 0.";
                    
                    //unlock quizzes :
                    $quizzes = explode(",", $_POST['unblocked_quizzes']);
                    if($quizzes[0]){
                        for($i=0;$i<count($quizzes);$i++){
                            unlockQuiz($quizzes[$i], $_POST['update_results_session'], $_POST['update_results_account']);
                        }
                        $message.=" Quiz débloqués : ".$i.".";
                    }
                    else $message.=" Quiz débloqués : 0.";

                    //Display the reporting screen :
                    require "model/class_report_account.php";
                    require "controller/class_report_account_controller.php";
                    $ctrl = new class_report_account_controller($_POST['update_results_account'], $_POST['update_results_session'], $login);
                    $ctrl->display();
                }
            }


            ///////////////////////?????? NEXT ????????////////////////////////////////////////////////////////////
            ?>
        </div> <!-- col-md-10-->

        <div class="col-12 col-md-1">
        </div>
    </main>

    <footer>

        <?php require "help.php"; ?>

        <div class="row " id="div-hello-footer">
            <div  class="col-12 col-md-1" >
                <button><a class="h5 text-decoration-none" href="#div-h1">⏫</a></button>
            </div>
            <div  class="col-12 col-md-10" >
                <p class="text-center"><?php echo $helloFooter ?></p>
            </div>
            <div  class="col-md-1 d-none d-md-block" >
                <button><a class="h5 text-decoration-none" href="#div-h1">⏫</a></button>
            </div>
        </div>
    </footer>

</div> <!--container-->
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous">
</script>
<script type="text/javascript" src="view/scriptv1.js"></script>
</body>
</html>
