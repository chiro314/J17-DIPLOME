<?php
/*****************************************************************************************
* Screen:       view/div_session.php
* admin/user:   admin
* Scope:	    session
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): screen to modify one session (maq-20)
* Trigger: Link "Maj" in div_sessions_list.php / index.php/$_REQUEST: "session/update" / class class_session_controller (class_session_controller.php)
* 
* Major tasks:  o Show session name, data, accounts and quizzes (Links Maj in the list of sessions)
*                   - JS: onchange="onChangeDivAccountData()" 
*               o Collect session changed data
*                   - JS: onChangeDivSessionData()
*               o Restore session data if asked (Button "Rétablir les données d'origine")
*                   - JS: onclick="up_sessionRestor()"
*               o Modify the data of the Session-Quiz link of a quiz already associated: duration, opening date.
*                   - JS: updateSessionUpdateQuiz(num)
*               o Propose quizzes except those already associated (Button "Ajouter un quiz")
*                   - JS:   buttonAddUpdateSessionCreateQuiz()
*                           $("#addCreateSessionQuiz option").prop('selected', false);
*                           selectQuizConsistency()
*                           carnationAlternationForClass("quiz-list")
*               o Filter the quizzes proposed on the status, inline or draft (Button "Filtre sur les quiz")
*                   - JS:   selectFilterQuiz()
*                           carnationAlternationForClass("quiz-list")
*               o Add a quiz and collect Session-Quiz link data (Click on one of the quizzes offered)
*                   - JS:   $("#select-filter-quiz").change(function(){ selectQuizConsistency(); });
*                           <select onchange="selectAddUpdateSessionCreateQuiz()"
*               o Remove a quiz (click on the cross)
*                   - JS:  o onclick="up_supUpdateSessionCreateQuiz(…): supp. an old binded quiz
*                          o onclick="supNewBind(divid): supp. a new binded quiz
*               o Restore original quizzes (Button "Rétablir les quiz d'origine")
*                   - JS: onclick="up_sessionQuizRestor()
*               o Propose accounts except those already associated (Button "Ajouter un compte")
*                   - JS:   onclick="buttonAddUpdateSessionCreateAccount()
*                           selectAccountsConsistency()
*                           carnationAlternationForClass("accounts-list") 
*               o Filter the accounts offered on the company (Button "Filtre par société")
*                   - JS:   selectFilterAccounts()
*                           carnationAlternationForClass("accounts-list")
*               o Add an account (Click on one of the accounts offered)
*                   - JS:   selectAddUpdateSessionCreateAccount()
*                           $("#select-filter-accounts").change(function(){selectAccountsConsistency();});
*                           carnationAlternationForClass("accounts-list")
*               o Remove an account (Click on the cross)
*                   - JS:   onclick="up_supUpdateSessionCreateAccount(...) //account already present
*                           onclick="supNewBind(…) //new account
*               o Restore original accounts (Button "Rétablir les comptes d'origine")
*                   - JS: onclick="up_sessionAccountsRestor()
*               o Abort update (Button "Abandonner la Maj")
*               o Submit changes (Button "Envoyer toutes les modifications de la page") : form_update_session
*                 >> Next processing : Save changes: 
*                   - index.php/form_update_session /modelfunctions.php : 
*                       updateSession(…)
*                       bindQuizToSession(…)
*                       unbindSessionQuiz(…)
*                       updateSessionQuiz(…)
*                       bindAccountsToSession(…)
*                       unbindSessionAccounts(…)
*******************************************************************************************/

global $message;
/*
echo"<br>The session :";
var_dump($session);
echo"<br>The session accounts :";
var_dump($sessionAccounts);
echo"<br>All the accounts :";
var_dump($allAccounts);
echo"<br>The session quiz(s) :";
var_dump($sessionQuiz);
echo"<br>All the quiz :";
var_dump($allQuiz);
echo"<br>All the companies :";
var_dump($allCompanies);
*/

if($session !=null){
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The button : /////////////////////////////////////////////////////////////////////////////////-->

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <a class="button button-wide mb-2" type="button" href="index.php?controller=session&action=list&from=bt-update-session">Abandonner la Maj</a>      
        </div>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> 
    <?php echo $message ?>
</div>

<!--window to update a session (prefix 'up' for 'update'):///////////////////////////////////////////////////////////////////////-->

<!--
//class_session - div_session :
    private const SESSIONID = 0, SSUBTITLE=1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
    private const LOGO=5, BGIMAGE=6; //new

    private const QUIZID = 0, TITLE= 1, STATUS = 2;
    private const DURATION=3; //new
    private const SUBTITLE = 4, SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6;
    private const QSUBTITLE=3; //new
  
    private const LOGIN=0, NAME=2, FIRSTNAME=3, COMPANY=4;
    private const AEMAIL = 1;//new
    private const ACOMPANY=1;//new
-->

<div class="row center mb-2" id="div-form-update-session"> <!--only used for keyword-->
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p id="up_p-session-maj" class="text-center h6"><span class="font-weight-bold"><?php echo $session[STITLE] ?></span></p> <!--id not used-->
        <br>
        <form class="px-2" id="form_update_session" name="form_update_session" action="index.php" method="POST">  <!--not used by JS-->
            
            <!--session : ///////////////////-->
            <div class="row mb-2 mt-3">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold">SESSION</span></p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" id="up_session-restor" onclick="up_sessionRestor();">Rétablir les données d'origine</button> <!--id not used--> 
                </div>
            </div>
            <!--data-->
            <div onchange="onChangeDivSessionData()">
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_title">Titre*</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_session_title" name="session_title" type="text" value="<?php echo $session[STITLE] ?>" required></div>
                    <input id="up_session_title_old" name="session_title_old" type="hidden" value="<?php echo $session[STITLE] ?>">                    
                </div>    
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_subtitle">Sous-titre</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_session_subtitle" name="session_subtitle" type="text" value="<?php echo $session[SSUBTITLE] ?>"></div>
                    <input id="up_session_subtitle_old" name="session_subtitle_old" type="hidden" value="<?php echo $session[SSUBTITLE] ?>"> 
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_startdate">Date de début</label></div>
                    <div class="col-12 col-md-10"><input class="input-small" id="up_session_startdate" name="session_startdate" type="date" value="<?php echo $session[SSTARTDATE] ? date('Y-m-d',$session[SSTARTDATE]) : "" ?>" ></div>
                    <input id="up_session_startdate_old" name="session_startdate_old" type="hidden" value="<?php echo $session[SSTARTDATE] ? date('Y-m-d',$session[SSTARTDATE]) : "" ?>">
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_enddate">Date de fin</label></div>
                    <div class="col-12 col-md-10"><input class="input-small" id="up_session_enddate" name="session_enddate" type="date" value="<?php echo $session[SENDDATE] ? date('Y-m-d',$session[SENDDATE]) : "" ?>" ></div>
                    <input id="up_session_enddate_old" name="session_enddate_old" type="hidden" value="<?php echo $session[SENDDATE] ? date('Y-m-d',$session[SENDDATE]) : "" ?>">
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_logolocation">Logo (chemin)</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_session_logolocation" name="session_logolocation" type="text" value="<?php echo $session[LOGO] ?>"></div>
                    <input id="up_session_logolocation_old" name="session_logolocation_old" type="hidden" value="<?php echo $session[LOGO] ?>"> 
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_session_bgimagelocation">Image de fond (chemin)</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_session_bgimagelocation" name="session_bgimagelocation" type="text" value="<?php echo $session[BGIMAGE] ?>"></div>
                    <input id="up_session_bgimagelocation_old" name="session_bgimagelocation_old" type="hidden" value="<?php echo $session[BGIMAGE] ?>"> 
                </div>
            </div> 
            
            <!--Quiz : //////////////////-->

            <!--Button "Ajouter un quiz"-->
            
            <div class="row mb-2 mt-3">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold">QUIZ</span></p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" id="button-quiz" type="button" onclick="up_sessionQuizRestor()">Rétablir les quiz d'origine</button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="buttonAddUpdateSessionCreateQuiz();">Ajouter un quiz</button>
                </div>
            </div>
            <div id="div-select-quiz">
                <!--Button to filter the quiz"-->
                <div class="row">
                    <div class="col-12 offset-md-2 col-md-10 pb-2">
                        <p class="d-inline">Filtre sur les quiz<br><!--d-inline not used ?-->
                            <select id="select-filter-quiz" name="status" class="text-center"> <!--name="keyword"-->
                                <option value="0">Aucun</option>
                                <option value="inline">inline</option>
                                <option value="draft">draft</option>
                            </select>
                        </p>
                    </div>   
                </div>
                <!--filterable quiz select list-->
                <?php 
                if ($allQuiz != null){ // null when the table is empty ?>
                    <div class="row">
                        <div class="col-12 offset-md-2 col-md-10">
                            <p><span class="responsive-show">Quiz (cliquer pour afficher la liste)<br></span>
                                <select size="<?php echo min(count($allQuiz), SIZEQUIZ) ?>" name="addCreateSessionQuiz[]" id="addCreateSessionQuiz" onchange="selectAddUpdateSessionCreateQuiz()"><?php
                                    $i=0;
                                    foreach($allQuiz as $oneQuiz){  ?>
                                        <option id="option-select-quiz_<?php echo $i ?>" class="text-wrap quiz-list <?php echo ($oneQuiz[STATUS]=='draft' ? ' draft' : ' inline') ?>" value="<?php echo $oneQuiz[QUIZID] ?>"><?php echo $oneQuiz[STATUS] ?> : <?php echo $oneQuiz[TITLE] ?><?php echo $oneQuiz[QSUBTITLE] ? ' ('.$oneQuiz[QSUBTITLE].')' : "" ?></option>    <?php
                                        $i++;
                                    } 
                                    $nbquizdb = $i; ?>
                                </select>
                            </p>
                        </div>
                    </div>  <?php
                }
                else $nbquizdb = 0; ?>
            </div>
            <!--Bound quiz-->

            <!--columns titles-->
            <div class="row mt-3 responsive-hide" id="div-titleUpdateSessionCreateQuiz">
                <div class="col-12 col-md-2">
                    
                </div>
                <div class="col-12 col-md-4">
                    <p><span class="font-weight-bold">Statut - Titre</span></p>
                </div>
                <div class="col-12 col-md-1">
                    <p><span class="font-weight-bold">Durée<br>(h:min)</span></p>
                </div>
                <div class="col-12 col-md-2 ml-md-4">
                    <p><span class="font-weight-bold">Ouverture</span></p>
                </div>
                <div class="col-12 col-md-1 ml-md-4">
                    <p><span class="font-weight-bold">Fermeture</span></p>
                </div>
            </div>

            <!--Existing quiz--> <?php
            if($sessionQuiz != null){
                $i=0;                      
                foreach($sessionQuiz as $oneQuiz){  ?>  
                    <div class="row py-2" id="up_quiz_<?php echo $i ?>">  
                        <!--button 'X' (supp.)-->          
                        <div class="col-12 col-md-2">
                            <button class="mr-2 border-0 bg-danger text-white rounded-circle" type="button" onclick="up_supUpdateSessionCreateQuiz('<?php echo $i ?>');">X</button>
                            Quiz              
                        </div>
                        <!--data-->
                        <div class="col-12 col-md-10">
                            <div class="row" onchange="updateSessionUpdateQuiz(<?php echo $i ?>);">
                                <div class="col-12 col-md-4">
                                    <span class="font-weight-bold responsive-show">Statut - Titre<br></span>                        
                                    <input disabled="disabled" class="input-quiz" id="quiz_quiz_<?php echo $i ?>" name="quiz_quiz_<?php echo $i ?>" type="text" value="<?php echo $oneQuiz[STATUS]." - ".$oneQuiz[TITLE] ?>">   
                                    <input id="quiz_quiz_<?php echo $i ?>_old" name="quiz_quiz_<?php echo $i ?>_old" type="hidden" value="<?php echo $oneQuiz[STATUS]." - ".$oneQuiz[TITLE] ?>">
                                    <input id="quiz_id_<?php echo $i ?>" name="quiz_id_<?php echo $i ?>" type="hidden" value="<?php echo $oneQuiz[QUIZID] ?>">
                                    <input id="up_quiz_action_<?php echo $i ?>" name="up_quiz_action_<?php echo $i ?>" type="hidden" value="">
                                </div>
                                <div class="col-12 col-md-2 text-md-right">   
                                    <span class="font-weight-bold responsive-show">Durée (heures:minutes)<br></span>                        
                                    <input class="session_quiz_minutesduration" id="session_quiz_minutesduration<?php echo $i ?>" name="session_quiz_minutesduration<?php echo $i ?>" type="time" value="<?php echo $oneQuiz[DURATION] ? gmdate('H:i',60 * $oneQuiz[DURATION]) : '' ?>">
                                    <input id="session_quiz_minutesduration<?php echo $i ?>_old" name="session_quiz_minutesduration<?php echo $i ?>_old" type="hidden" value="<?php echo $oneQuiz[DURATION] ? gmdate('H:i',60 * $oneQuiz[DURATION]) : '' ?>">
                                </div>
                                <div class="col-12 col-md-3 text-md-center">   
                                    <span class="font-weight-bold responsive-show">Date d'ouverture<br></span>                        
                                    <input class="session_quiz_openingdate" id="session_quiz_openingdate<?php echo $i ?>" name="session_quiz_openingdate<?php echo $i ?>" type="datetime-local" value="<?php echo $oneQuiz[SQZOPENINGDATE] ? str_replace(' ','T',date('Y-m-d H:i',$oneQuiz[SQZOPENINGDATE])) :"" ?>" >
                                    <input id="session_quiz_openingdate<?php echo $i ?>_old" name="session_quiz_openingdate<?php echo $i ?>_old" type="hidden" value="<?php echo $oneQuiz[SQZOPENINGDATE] ? str_replace(' ','T',date('Y-m-d H:i',$oneQuiz[SQZOPENINGDATE])) :"" ?>">
                                </div>
                                <div class="col-12 col-md-3 text-left">   
                                    <span class="font-weight-bold responsive-show">Date de fermeture<br></span>                        
                                    <input class="session_quiz_closingdate" id="session_quiz_closingdate<?php echo $i ?>" name="session_quiz_closingdate<?php echo $i ?>" type="datetime-local" value="<?php echo $oneQuiz[SQZCLOSINGDATE] ? str_replace(' ','T',date('Y-m-d H:i',$oneQuiz[SQZCLOSINGDATE])) :"" ?>" >
                                    <input id="session_quiz_closingdate<?php echo $i ?>_old" name="session_quiz_closingdate<?php echo $i ?>_old" type="hidden" value="<?php echo $oneQuiz[SQZCLOSINGDATE] ? str_replace(' ','T',date('Y-m-d H:i',$oneQuiz[SQZCLOSINGDATE])) :"" ?>">
                                </div>
                            </div>
                        </div>
                    </div> <?php
                    $i++;
                }
                $nbOldQuiz = $i;
            }
            else $nbOldQuiz = 0; ?>

            <!--ACCOUNTS-->

            <!--Accounts : //////////////////-->

            <!--Button "Ajouter un compte"-->
            <div class="row mb-2 mt-3" id="div-addUpdateSessionCreateAccount">
                <div class="col-12 col-md-2 pb-2">
                    <p><span class="font-weight-bold">COMPTES</span></p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" id="button-account" type="button" onclick="up_sessionAccountsRestor()">Rétablir les comptes d'origine</button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="buttonAddUpdateSessionCreateAccount();">Ajouter un compte</button>
                </div>
            </div>

            <div id="div-select-account">
                <!--Button to filter the accounts by company-->
                <div class="row">
                    <div class="col-12 col-md-2 pb-2">
                        <br>
                    </div>
                    <div class="col-12 col-md-10 pb-2">
                        <p class="d-inline">Filtre par société<br><!--d-inline not used ?-->
                            <select id="select-filter-accounts" name="company" class="text-center"> <!--name="keyword"--> <?php
                                foreach($allCompanies as $company) {echo '<option value="'.($company=="Aucun" ? "0" : className($company)).'">'.$company.'</option>';} ?>
                            </select>
                        </p>
                    </div>   
                </div>
                <!--filterable accounts select list-->
                <?php 
                if ($allAccounts != null){ // null when the table is empty ?>
                    <div class="row">
                        <div class="col-12 offset-md-2 col-md-10">
                            <p><span class="responsive-show">Comptes (cliquer pour afficher la liste)<br></span>    
                                <select size="<?php echo min(count($allAccounts), SIZEACCOUNTS) ?>" name="addCreateSessionAccounts[]" id="addCreateSessionAccounts" onchange="selectAddUpdateSessionCreateAccount()"><?php
                                    $i=0;
                                    foreach($allAccounts as $account){ ?>
                                        <option id="option-select-account_<?php echo $i ?>" class="text-wrap accounts-list <?php echo className($account[ACOMPANY]) ?>" value="<?php echo $account[LOGIN] ?>"><?php echo $account[LOGIN] ?> (<?php echo $account[NAME] ?> <?php echo $account[FIRSTNAME] ?>)<?php echo $account[ACOMPANY] ? " - ".$account[ACOMPANY] : "" ?></option>    <?php
                                        $i++;
                                    } 
                                    $nbaccountsdb = $i; ?>
                                </select>
                            </p>
                        </div>
                    </div>  <?php
                } ?>
            </div>

            <!--Old bound accounts--><?php

            if($sessionAccounts != null){
                $i=0;                      
                foreach($sessionAccounts as $oneAccount){  ?>  
                    <div class="row py-2" id="up_account_<?php echo $i ?>">  
                        <!--button 'X' (supp.)-->          
                        <div class="col-12 col-md-2">
                            <button class="mr-2 border-0 bg-danger text-white rounded-circle" type="button" onclick="up_supUpdateSessionCreateAccount('<?php echo $i ?>');">X</button>
                            Compte               
                        </div>
                        <!--data-->
                        <div class="col-12 col-md-10">
                            <div class="row" onchange="updateSessionUpdateAccount(<?php echo $i ?>);"><!--updateSessionUpdateAccount not used ?-->
                                <div class="col-12 col-md-12">
                                    <input disabled="disabled" class="input-account text-wrap" id="account_acount_<?php echo $i ?>" name="account_account_<?php echo $i ?>" type="text" value="<?php echo $oneAccount[LOGIN] ?> (<?php echo $oneAccount[NAME] ?> <?php echo $oneAccount[FIRSTNAME] ?>)<?php echo $oneAccount[ACOMPANY] ? " - ".$oneAccount[ACOMPANY] : "" ?>">                                  
                                    <input id="account_id_<?php echo $i ?>" name="account_id_<?php echo $i ?>" type="hidden" value="<?php echo $oneAccount[LOGIN] ?>">  <!--id et name account_login_-->
                                    <input id="up_account_action_<?php echo $i ?>" name="up_account_action_<?php echo $i ?>" type="hidden" value="">
                                </div>
                            </div>
                        </div>
                    </div> <?php
                    $i++;
                }
                $nbOldAccounts = $i;
            }
            else $nbOldAccounts = 0; ?>



            
            <!--METADATA-->
            <!--session-->
            <input type="hidden" id="up_session" name="up_session" value="0"> <!-- 1 means at least one change in the data session-->
            <input type="hidden" id="updatedsessiondid" name="updatedsessiondid" value="<?php echo $session[SESSIONID] ?>">
            <input type="hidden" id="updatedsession" name="updatedsession" value="<?php echo $session[STITLE] ?>">
            <!--quiz-->
            <input type="hidden" id="up_session-quiz_click" name="up_session-quiz_click" value="0"><!--click on the select : 0 means no modification... used ??-->
            <input type="hidden" id="up_session-quiz" name="up_session-quiz" value=""><!--the new id quiz: 2,5,9 --> 
            <input id="nb-max-quiz-new" type="hidden" name="nb-max-quiz-new" value="0">
            <input id="nb-quiz_original" type="hidden" name="nb-quiz_original" value="<?php echo $nbOldQuiz ?>"><!--number of existing original quiz-->
            <input id="nb-quiz-db" type="hidden" name="nb-quiz-db" value="<?php echo $nbquizdb ?>"><!--number of quiz in the DB (select)-->

            <!--accounts-->
            <input type="hidden" id="up_session-account_click" name="up_session-account_click" value="0"><!--click on the select : 0 means no modification... used ??-->
            <input type="hidden" id="up_session-account" name="up_session-account" value=""><!--the new login account : chr,aaa...--> 
            <input id="nb-max-accounts-new" type="hidden" name="nb-max-accounts-new" value="0">
            <input id="nb-accounts_original" type="hidden" name="nb-accounts_original" value="<?php echo $nbOldAccounts ?>"><!--number of existing original accounts-->
            <input id="nb-accounts-db" type="hidden" name="nb-accounts-db" value="<?php echo $nbaccountsdb ?>"><!--number of accounts in the DB (select)-->

            <!--submit-->
            <input type="hidden" name="form_update_session" value="1">
            <div class="text-center pb-2">
                <!--<input type="submit" value="Envoyer toutes les modifications de la page" class="button button-max mt-md-4">-->
                <button type="submit" class="button button-max mt-md-4">Envoyer toutes les modifications de la page</button>
            </div>
        </form>
    </div>
</div> <?php
} //if($session !=null)