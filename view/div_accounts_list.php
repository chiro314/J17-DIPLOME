<?php
/*****************************************************************************************
* Screen:       view/div_accounts_list.php
* admin/user:   admin
* Scope:	    account
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature 1 (maquette): Consult the list of your accounts (maq-13), create(maq-16)/delete(maq-15) an account.
* Trigger: Menu "Vos comptes" / index.php/$_REQUEST: "account/list" / class class_accounts_list_controller (class_accounts_list_controller.php)
* 
* Major tasks:  o Show data for each account, with Supp. and Maj links for each account
*               o Show data of account sessions, with links to account results for each session
*
*               o Create an account (Button "Créer un compte") :
*                 >>Collect account data
*                   - JS: $("#bt-create-account").click( function(){…
*                 >>Associate the account with 0, 1 or more sessions whose end date has not passed
*                   - DB: class_accounts_list.php
*                 >>Send data (form_create_account)
*                   - index.php/modelfunctions.php/createAccount(account data, $addCreateAccountSessions)
*
*               o Delete an account (Links Supp. in the list of the accounts)
*                 >>Display the confirmation div with a reminder of the data of the account (user or admin) and specifying the deleted elements
*                   - JS: deleteAccount(...)
*                 >>Abort deletion (Button "Abandonner la supp.") 
*                   - JS: $("#bt-delete-account").click(  function(){…
*                 >>Submit deletion request (Button Envoyer/form_delete_account)
*                 o Next processing: update DB
*                 >>Delete a user account and its results (index.php/form_delete_account) :
*                   - index.php/form_delete_account: modelfunctions.php/deleteAccount($deletedaccountlogin, $login)
*                   - DB/CIR: account <- quizresult ; account <- session_user
*                 >>Delete an admin account and all its DB elements) (index.php/form_delete_account):
*                   - index.php/form_delete_account: modelfunctions.php/deleteAccount($deletedaccountlogin, $login)
*                   - DB/CIR:   keyword <- question_keyword
*                               question <- answer
*                               question <- questionstat
*                               question <- quizresult_ questionko
*                               question <- quiz_question
*                               session <- session_quiz
*                               session <- session_user
*                               account <- quizresut
*
* Feature 2 (maquette): Consult the quizzes results of one session, one user (account) and their quizzes (maq-14)
* Trigger: Link to the account results for this session (Sessions and results column of div_accounts_list.php)
*
* Major tasks:  o Display :
*                   >>the cross-functional session indicators 
*                   >>the cross-functional account indicators
*                   >>the cross-functional indicators for each quiz carried out by the account, with the quiz results of the session next to it
*                   >>the quizzes not carried out by the account, with their cross-functional indicators.
*               o Display the definition of each indicator (Button "Explications")
*                   - JS: showDiv(div)
*******************************************************************************************/

//var_dump($accountsList);
?>
<br>
<p class="text-center h4 mt-2 mx-2"><?php echo $title ?></p>

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-create-account" type="button">Créer un compte</button>
    </div>
</div></div>

<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="mx-2 mb-2" id="bt-delete-account" type="button"><span class="d-block">Abandonner la Supp.</span></button>
    </div>
</div></div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<!--window to delete an account (and its quiz results) ://////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2 px-2" id="div-form-delete-account">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" >
        <br>
        <p id="p-account-supp-title" class="text-center h5">Supprimer le compte</p>   
        <p id="p-account-supp" class="text-center h6"></p>
        <p id="p-account-supp-subtitle" class="text-center h5"></p>   

        <form class="text-center" id="form_delete_account" name="form_delete_account" action="index.php" method="POST">
            <input type="hidden" id="deletedaccountlogin" name="deletedaccountlogin">
            <input type="hidden" id="deletedaccount" name="deletedaccount">
            <input type="hidden" name="form_delete_account" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="input-basic button button-small">
            </div>
        </form>
    </div>
</div>

<!--window to create an account : ///////////////////////////////////////////////////////////////////////-->

<div class="row mb-2" id="div-form-create-account">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Créer un compte</p>

        <form class="pl-2" id="form_create_account" name="form_create_account" action="index.php" method="POST">
            
            <!--Account-->
            <div class="row">
                <div class="col-12 col-md-2 "><label class="label " for="account_login">login*</label></div>
                <div class="col-12 col-md-10"><input class="input" id="account_login" name="account_login" type="text" maxlength="SECURITY" value="" required></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="account_name">Nom*</label></div>
                <div class="col-12 col-md-10"><input class="input" id="account_name" name="account_name" type="text" maxlength="IDENTIFY" value="" required></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="account_firstname">Prénom*</label></div>
                <div class="col-12 col-md-10"><input class="input" id="account_firstname" name="account_firstname" type="text" maxlength="IDENTIFY" value="" required></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="account_company">Société</label></div>
                <div class="col-12 col-md-10"><input class="input" id="account_company" name="account_company" type="text" maxlength="IDENTIFY" value=""></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="account_email">Email</label></div>
                <div class="col-12 col-md-10"><input class="input" id="account_email" name="account_email" type="email" maxlength="ADDRESS" value=""></div>
            </div>
            
            <!--Open Sessions-->
            <?php 
            if ($allOpenSessions != null){ // null when the table is empty ?>
                <div class="row mb-2 mt-3">
                    <div class="col-12">
                        <span class="font-weight-bold">Associer le compte à 0, 1 ou plusieurs sessions dont la date de fin n'est pas dépassée</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-2 "></div>
                    <div class="col-12 col-md-10 d-flex flex-wrap" id="select-allOpenSessions">
                        <select  size="<?php echo count($allOpenSessions) ?>" multiple name="addCreateAccountSessions[]" id="addCreateAccountSessions"><?php
                            foreach($allOpenSessions as $session){ ?>
                                <option  value="<?php echo $session[SESSIONID] ?>"><?php echo ($session[ENDDATE] == 0 ? "Pas de date" : date("d-m-Y", $session[ENDDATE]))." : ".$session[TITLE] ?></option><?php    
                            } 
                            //Get the values : https://forum.phpfrance.com/php-debutant/recuperer-valeurs-select-multiple-t4448.html#:~:text=%24keywords%20%3D%20%24_POST%5B'keywords'%5D%3B
                            ?>
                        </select>
                    </div>
                </div>
                <?php
            } ?>
            <!--Send the form-->
            <!--<input id="nb-responses-max" type="hidden" name="nb-responses-max" value="1">      new answers (one empty shell already displayed)-->
            <!--<input id="nb-responses-up" type="hidden" name="nb-responses-up" value="">         existing answers (already displayed)-->

            <input type="hidden" name="form_create_account" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="button">
            </div>
        </form>
    </div>
</div>

<!--THE ACCOUNTS LIST : ////////////////////////////////////////////////////////////////////////////////:-->
<div class="row">
    <div class="col-12 div-of-rows">
        <!--Column headings :-->
        <div class="row font-weight-bold responsive-hide">
            <div class="col-12 col-md-1"></div> <!--supp-->
            <div class="col-12 col-md-1"></div> <!--Maj-->
            <div class="col-12 col-md-1">Login</div> <!--draft, inline-->
            <div class="col-12 col-md-1">Profil</div>
            <div class="col-12 col-md-2">Nom</div> <!--radio, checkbox-->
            <div class="col-12 col-md-2">prénom</div> 
            <div class="col-12 col-md-4">Sessions et résultats</div>
        </div><?php

        //The list :

        if ($accountsList != null){ // null when the table is empty
            $i=0;
            foreach($accountsList as $account){ ?>

                <div class="row account-list">
                    <!--link 'delete'-->
                    <div class="col-12 col-md-1">
                        <div class="px-2 px-md-0">
                            <a class="text-danger a-supp" onclick="deleteAccount('<?php echo $account[LOGIN] ?>', '<?php echo $account[PROFILE] ?>', '<?php echo $account[NAME] ?>', '<?php echo $account[FIRSTNAME] ?>', '<?php echo $account[COMPANY] ?>')">Supp.</a>      
                        </div>
                    </div>
                    <!--link 'update'-->
                    <div class="col-12 col-md-1">
                        <div class="px-2 px-md-0">
                            <a class="text-info a-update" href="<?php echo 'index.php?controller=account&action=update&id='.$account[LOGIN] ?>">Maj</a>       
                        </div>
                    </div>
                    <div class="col-12 col-md-1">
                        <span class="px-2 font-weight-bold responsive-show">Login<br></span>
                        <div class="px-2 px-md-0"><?php echo $account[LOGIN] ?></div>
                    </div>
                    <div class="col-12 col-md-1">
                        <span class="px-2 font-weight-bold responsive-show">Profil<br></span>            
                        <div class="px-2 px-md-0"><?php echo $account[PROFILE] ?></div>
                    </div>    
                    <div class="col-12 col-md-2">
                        <span class="px-2 font-weight-bold responsive-show">Nom<br></span>            
                        <div class="px-2 px-md-0"><?php echo $account[NAME] ?></div>
                    </div>
                    <div class="col-12 col-md-2">
                        <span class="px-2 font-weight-bold responsive-show">Prénom<br></span>            
                        <div class="px-2 px-md-0"><?php echo $account[FIRSTNAME] ?></div>
                    </div>
                    <!--sessions-->
                    <div class="col-12 col-md-4">
                        <span class="px-2 font-weight-bold responsive-show">Sessions et résultats<br></span>            
                        <div class="px-2 px-md-0">
                            <?php foreach($account[ACCOUNTSESSIONS] as $accountSession){ ?>   
                                <li>Du <?php echo ($accountSession[SSTARTDATE] == 0 ? "-" : date('d/m/y',$accountSession[SSTARTDATE])) ?> au <?php echo ($accountSession[ENDDATE] == 0 ? "-" : date('d/m/y', $accountSession[ENDDATE])) ?> : 
                                <?php echo ($accountSession[TITLE] == 0 ? "pas de session" : '<a class="text-info a-update" href="index.php?controller=account&action=reporting&ida='.$account[LOGIN].'&ids='.$accountSession[SESSIONID].'">'.$accountSession[TITLE].'</a>') ?></li><?php
                            } ?> 
                        </div>
                    </div>
                </div><?php 
                $i++;
            }
        } ?>
    </div>
</div>