<?php
/*****************************************************************************************
* Screen:       view/div_account.php
* admin/user:   admin
* Scope:	    account
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): screen to modify one account (maq-17)
* Trigger: Link "Maj" in div_accounts_list.php / index.php/$_REQUEST: "account/update" / class class_up_account_controller (class_up_account_controller.php)
* 
* Major tasks:  o Show data account (Links Maj in the list of accounts)
*                   - JS: onchange="onChangeDivAccountData()" 
*               o Restore account data if asked (Button "Rétablir les données du compte")
*                   - JS: onclick="up_accountRestor()"
*               o show the sessions of the account  
*               o show the open sessions to associate with the account (Button Ajouter une session)
*                   - JS: addUpdateAccountCreatesessionShowSessions, selectSessionConsistency(), carnationAlternation()
*               o Add a session, old or new (click on one of the available sessions)
*                   - JS: onchange="addUpdateAccountCreatesession()
*               o Remove a session, old or new (click on the cross)
*                   - JS:  o up_supUpdateAccountExistingSession(num): supp. an old binded session
*                          o crea_supUpdateAccountCreateSession(divid): supp. a new binded session
*               o Abort update (Button "Abandonner la Maj")
*               o Restore all data (Button "Abandonner la Maj")
*               o Submit changes (Button "Envoyer toutes les modifications de la page") : form_update_account
* Next processing:
*               o update DB
*                  - index.php/form_update_account / modelfunctions.php : updateAccount(…), bindAccountSessions(…), unbindSessions(…).
*******************************************************************************************/

global $message;
//TEST INPUT DATA
/*
echo "<br>account :";
var_dump($account);
echo "<br>accountsessions :";
var_dump($accountsessions);
echo "<br>opensessions :";
var_dump($opensessions);
*/
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <a class="button button-wide mb-2" id="bt-update-account" type="button" href="index.php?controller=account&action=list&from=bt-update-account">Abandonner la Maj</a>      
            <a class="button button-wide mb-2" id="bt-reset-account" type="button" href="index.php?controller=account&action=update&id=<?php echo $account[LOGIN] ?>&from=bt-reset-account">Rétablir les données</a>      
        </div>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> 
    <?php echo $message ?>
</div>

<!--window to update an account (prefix 'up' for 'update'):///////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2" id="div-form-update-account">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p id="up_p-account-maj" class="text-center h6"><span class="font-weight-bold"><?php echo $account[PROFILE]." ".$account[LOGIN]." (".$account[FIRSTNAME]." ".$account[NAME].")" ?></span></p>

        <form id="form_update_account" name="form_update_account" action="index.php" method="POST">
            
            <!--Account : ///////////////////-->

            <div class="row mb-2 mt-3">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold">Compte</span></p>
                </div>

                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="up_accountRestor()">Rétablir les données du compte</button>
                </div>           
            </div>

            <!--data-->
            <div onchange="onChangeDivAccountData()">
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_account_name">Nom*</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_account_name" name="account_name" type="text" value="<?php echo $account[NAME] ?>" required></div>
                    <input id="up_account_name_old" name="account_name_old" type="hidden" value="<?php echo $account[NAME] ?>">                           
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_account_firstname">Prénom*</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_account_firstname" name="account_firstname" type="text" value="<?php echo $account[FIRSTNAME] ?>" required></div>
                    <input id="up_account_firstname_old" name="account_firstname_old" type="hidden" value="<?php echo $account[FIRSTNAME] ?>">                           
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_account_company">Société</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_account_company" name="account_company" type="text" value="<?php echo $account[COMPANY] ?>"></div>
                    <input id="up_account_company_old" name="account_company_old" type="hidden" value="<?php echo $account[COMPANY] ?>">                           
                </div>
                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_account_email">Email</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_account_email" name="account_email" type="email" value="<?php echo $account[EMAIL] ?>"></div>
                    <input id="up_account_email_old" name="account_email_old" type="hidden" value="<?php echo $account[EMAIL] ?>">                           
                </div>

                <div class="row">
                    <div class="col-12 col-md-2"><label class="label" for="up_account_psw">RAZ mot de passe</label></div>
                    <div class="col-12 col-md-10 text-left"><input id="up_account_psw" name="account_psw" type="checkbox"></div>
                </div>   
            </div> 
            
            <!--Sessions : //////////////////-->

            <!--Already binded sessions (already created)-->

            <div class="row mb-2 mt-3" id="div-addUpdateAccountCreatesession">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold">Sessions du compte</p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="addUpdateAccountCreatesessionShowSessions();">Ajouter une session ouverte</button>
                </div>
            </div>

            <!--Already binded sessions"--> <?php
            if($accountsessions != null){  
                $i=0;                      
                foreach($accountsessions as $session){  ?>  
                    <div class="row" id="up_session_<?php echo $i ?>">            
                        <div class="col-12 col-md-2">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <button class="border-0 bg-danger text-white rounded-circle" type="button" onclick="up_supUpdateAccountExistingSession('<?php echo $i ?>');">X</button>
                                </div>
                                <div class="col-12 col-md-9">
                                    <label class="label" for="session_session_<?php echo $i ?>">Session</label>
                                </div>
                            </div>               
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="row"> <!--onchange="updateQuizUpdateQuestion(<?php //echo $i ?>);">-->
                                <div class="col-12">
                                    <input class="input" id="session_session_<?php echo $i ?>" name="session_session_<?php echo $i ?>" type="text" value="<?php echo ($session[ENDDATE]==0 ? "Pas de fin" : date("d/m/y", $session[ENDDATE]))." : ".$session[TITLE] ?>">
                                    <input id="session_id_<?php echo $i ?>" name="session_id_<?php echo $i ?>" type="hidden" value="<?php echo $session[SESSIONID] ?>">
                                    <input id="up_session_action_<?php echo $i ?>" name="up_session_action_<?php echo $i ?>" type="hidden" value="">
                                </div>
                            </div>
                        </div>
                    </div> <?php
                    $i++;
                }
                $nbsessions = $i;
            } 
            else $nbsessions = 0;
            ?>

            <!--Select list of open sessions, to add one session or more :-->

            <div id="div-addUpdateAccountCreatesessionShowSessions"><?php
                 
                if ($opensessions != null){ // null when the table is empty ?>
                    <div class="row">
                        <div class="col-12 offset-md-2 col-md-10">
                            <select name="addCreateAccountSessions[]" id="addCreateAccountSessions" onchange="addUpdateAccountCreatesession()" size="<?php echo min(count($opensessions), SIZESESSIONS) ?>"><?php 
                                $i=0;
                                $session=[];
                                foreach($opensessions as $session){ ?>
                                    <option id="option-select-session_<?php echo $i ?>" class="text-wrap question-list" value="<?php echo $session[SESSIONID]."_" ?>"><?php echo ($session[ENDDATE]==0 ? "Pas de fin" : date("d/m/y", $session[ENDDATE]))." : ".$session[TITLE] ?></option>    <?php
                                    $i++;
                                }
                                $nbsessionsdb = $i ?>
                            </select>
                        </div>
                    </div>  <?php
                }
                else $nbsessionsdb = 0 ?>
            </div>

            <!--update or not-->
            <input type="hidden" id="up_account" name="up_account" value="0"> <!-- 1 means at least one change in the data account-->
             
            <input id="nb-max-sessions-new" type="hidden" name="nb-max-sessions-new" value="0"><!--number of new sessions-->
            <input id="nb-sessions_original" type="hidden" name="nb-sessions_original" value="<?php echo $nbsessions ?>"><!--number of existing original sessions-->
            <input id="nb-sessions-db" type="hidden" name="nb-sessions-db" value="<?php echo $nbsessionsdb ?>"><!--number of open sessions in the DB (select)-->

            <!--Account ref.-->
            <input type="hidden" id="updatedaccountdid" name="updatedaccountdid" value="<?php echo $account[LOGIN] ?>">
            <input type="hidden" id="updatedaccount" name="updatedaccount" value="<?php echo $account[LOGIN] ?>">
            
            <!--submit-->
            <input type="hidden" name="form_update_account" value="1">
            <div class="text-center pb-2">
                <!--<input type="submit" value="Envoyer toutes les modifications de la page" class="button button-max mt-md-4">-->
                <button type="submit" class="button button-max mt-md-4">Envoyer toutes les modifications de la page</button>
            </div>
        </form>
    </div>
</div>