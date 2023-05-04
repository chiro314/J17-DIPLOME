const NBRESPONSESMAX = 20, NBQUESTIONSMAX = 100, NBQUIZMAX = 30, NBACCOUNTSMAX= 50 ; 

///////////////////////////////header.php : help////////////////////////////////////////////////////

$("#div-help-user").prop('hidden', true);
$("#div-help-admin").prop('hidden', true);
$("#div-help-connection").prop('hidden', true);
$('#div-demo').prop('hidden', true);

function showDivHelpConnection(){
    $('#div-demo').prop('hidden', true);
    $('#form_login').prop('hidden', true);
    $('#form_createadmin').prop('hidden', true);
    showDiv('div-help-connection');
}
function showCarouselDemo(){
    if($('#div-demo').prop('hidden')==true) {

        $('#form_login').prop('hidden', true);
        $('#form_createadmin').prop('hidden', true);
        $("#div-help-connection").prop('hidden', true);

        $('#div-demo').prop('hidden', false);
    }
    else $('#div-demo').prop('hidden', true);
}

/////////////////////////////// Carousel ////////////////////////////////////////////////////

if($('#form_login').is(":visible") ||
   $('#form_createadmin').is(":visible")  ) {

    //$('#div-demo').remove();
    $('#div-demo').prop('hidden', true);
}

function onclickbtshowtimers(divTimer, btShowTimer){
    if($("#"+divTimer).prop('hidden')==true) {
        $("#"+divTimer).prop('hidden', false);
        $("#"+btShowTimer).html("Masquer l'avancement")
    }
    else{
        $("#"+divTimer).prop('hidden', true);
        $("#"+btShowTimer).html("Afficher l'avancement");
    }
}
/*
$('#carousel-index').on('slid', function() {
    $(".bt_takenquiz").click();
});​
*/
//const carouselIndex = document.getElementById('carousel-index');



///////////////////////////////form_password.php : change password////////////////////////////////////////////////////
//https://forum.alsacreations.com/topic-1-41199-1-Interdire-le-copier--coller-dans-un-input.html

if(document.getElementById('confirmpsw') !== null){
    document.getElementById('confirmpsw').onpaste = function(){
        alert('La ressaisie est demandée pour vous éviter les mauvaises surprises, merci de ne pas copier/coller');        // on prévient
        return false;        // on empêche
    }
}

///////////////////////////////div_sessions.php : update a session////////////////////////////////////////////////////

//SESSION :

//On change on question data :
function onChangeDivSessionData(){
    $("#up_session").val('1');
}

//Restor Session data//////////////////////////

function up_sessionRestor(){

    $("#up_session_title").val($("#up_session_title_old").val());
    $("#up_session_subtitle").val($("#up_session_subtitle_old").val());
    $("#up_session_startdate").val($("#up_session_startdate_old").val());
    $("#up_session_enddate").val($("#up_session_enddate_old").val());
    $("#up_session_logolocation").val($("#sup_ession_logolocation_old").val());
    $("#up_session_bgimagelocation").val($("#sup_ession_bgimagelocation_old").val());

    $("#up_session").val('0');
}

//QUIZ

//button "Ajouter un quiz": 
$("#div-select-quiz").prop('hidden', true);
function buttonAddUpdateSessionCreateQuiz(){
    //if the all quiz list is visible then hide it 
    if($("#div-select-quiz").prop('hidden') == false){
        $("#div-select-quiz").prop('hidden', true);
    }
    else{
        //show the all quiz list 
        $("#div-select-quiz").prop('hidden', false);
        //and hide other lists
        $("#div-select-account").prop('hidden', true);
        //and get all the options of the select unselected
        $("#addCreateSessionQuiz option").prop('selected', false); ///!!!!!!!!!!!!!!!
        //!!!!!!!!à corriger au moins pour le menu Quiz

        selectQuizConsistency();
    }
}

function carnationAlternationForClass(myClass){
    //white-grey alternation
    var lines = document.getElementsByClassName(myClass);
    var iWhite = 2;
    for(i=0;i<lines.length;i++) {
        if(lines[i].hidden == false){ 

            if(iWhite % 2 == 0) lines[i].style.background = "white";
            else lines[i].style.background = "lightgrey";

            iWhite++;
        }  
    }
}
carnationAlternationForClass("quiz-list");

//Quiz filtering
function selectFilterQuiz(){
    if($("#select-filter-quiz").val() ==0) { //'Aucun' (None)
        $(".quiz-list").prop('hidden', false); //show all
    }
    else {
        $(".quiz-list").prop('hidden', true); // hide all
        $( "."+$("#select-filter-quiz").val() ).prop('hidden', false); //show the selection  
    }
    //white-grey alternation
    carnationAlternationForClass("quiz-list"); 
}
    $("#select-filter-quiz").change(function(){
        selectQuizConsistency();
    });

function selectQuizConsistency(){
    //Hide the options of the select quiz, already choosen :

    var iStop = $("#nb-quiz-db").val(); //all the quiz from DB in the select
    var jStop = $("#nb-quiz_original").val(); //quiz already choosen
    var kStop = $("#nb-max-quiz-new").val();  //new quiz added

    //init = show all :
    for(i=0;i<iStop;i++){ //quiz in the select
        $("#option-select-quiz_"+i).prop('hidden', false);
    }

    //apply filter :
    selectFilterQuiz();

    //Hide the options already choosen :
    for(i=0;i<iStop;i++){ //quiz in the select
        var idquiz = $("#option-select-quiz_"+i).val();
        //idquiz = idquiz.slice(0, -1);
        var goon = true;
        for(j=0;j<jStop;j++){  //quiz already choosen
            if(!$('#up_quiz_'+j).is(":hidden") && $('#quiz_id_'+j).val() == idquiz) {
                $("#option-select-quiz_"+i).prop('hidden', true);
                goon = false;
                break;
            }
        }
        if(goon){
            for(k=0;k<kStop;k++){  //new quiz added
                if($('#quiz_id_'+k+'_new')[0] && $('#quiz_id_'+k+'_new').val() == idquiz) {
                    $("#option-select-quiz_"+i).prop('hidden', true);
                    break;
                }
            }
        }
    }
    carnationAlternationForClass("quiz-list"); 
}

//init 
var numSelectSessionQuiz =  parseInt($("#nb-max-quiz-new").val() - 1);
//on change in the select of the all quiz list :
function selectAddUpdateSessionCreateQuiz(){

    //hide the select list of quiz :
    //$("#div-addUpdateSessionCreateQuiz").prop('hidden', true);
    $("#div-select-quiz").prop('hidden', true);

    //get the quiz data :

    var idquiz = $("#addCreateSessionQuiz").val(); //boucle à prévoir pour multiple
    var quiz = $('option[value="'+idquiz+'"]').html();
    //idquiz = idquiz.slice(0, -1); //get the last caracter '_' away (added to have unique id)
    
    //If the same old quiz has been hidden, then show it again :
    var stop = false;
    var iStop = $("#nb-quiz_original").val();
    
    for(i=0;i<iStop;i++){

        if($('#quiz_id_'+i).val() == idquiz) {
            $("#up_quiz_"+i).show();
            $("#up_quiz_action_"+i).val(""); // !!!!
            stop = true;
            break;
        }
    }
    if((!stop) && (numSelectSessionQuiz < NBQUIZMAX)){ //built the div of the quiz to be added :
    
        numSelectSessionQuiz++; //index of the new quiz

        div = '<div class="row" id="quiz_'+numSelectSessionQuiz+'_new">'; //no 'up_' but '_new'
        div+= '<div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        div+= '<button class="border-0 bg-danger text-white rounded-circle" type="button"';
        div+= ' onclick="supNewBind(\'quiz_'+numSelectSessionQuiz+'_new\');"';
        div+= ' >X</button></div><div class="col-12 col-md-9">'; 
        div+= '<label class="label" for="quiz_quiz_'+numSelectSessionQuiz+'_new">Quiz</label></div></div></div>';

        div+= '<div class="col-12 col-md-10">';
        div+= '<div class="row" onchange="updateSessionUpdateQuiz('+numSelectSessionQuiz+')">';
        div+= '<div class="col-12 col-md-4">';
        div+= '<input disabled="disabled" class="input-quiz" id="quiz_quiz_'+numSelectSessionQuiz+'_new"';
        div+= ' name="quiz_quiz_'+numSelectSessionQuiz+'_new" type="text" value="'+quiz+'">';
        div+= '<input id="quiz_id_'+numSelectSessionQuiz+'_new"';
        div+= ' name="quiz_id_'+numSelectSessionQuiz+'_new" type="hidden" value="'+idquiz+'">';
        div+= '</div>'; 

        div+= '<div class="col-12 col-md-2 text-right">';  
        div+= '<input class="session_quiz_minutesduration" id="session_quiz_minutesduration'+numSelectSessionQuiz+'_new" name="session_quiz_minutesduration'+numSelectSessionQuiz+'_new" type="time" value=""></div>';                   

        div+= '<div class="col-12 col-md-3 text-center">';   
        div+= '<input class="session_quiz_openingdate" id="session_quiz_openingdate'+numSelectSessionQuiz+'_new" name="session_quiz_openingdate'+numSelectSessionQuiz+'_new" type="datetime-local" value=""></div>';

        div+= '<div class="col-12 col-md-3 text-left">';
        div+= '<input class="session_quiz_closingdate" id="session_quiz_closingdate'+numSelectSessionQuiz+'_new" name="session_quiz_closingdate'+numSelectSessionQuiz+'_new" type="datetime-local" value=""></div>';
    
        div+= '</div></div></div>';
        div+= '</div>'; //I don't understand why this closing div is needed to align on the right !?

        //Add the div (string div) after the div title with id='div-titleUpdateSessionCreateQuiz'
        $(div).insertAfter("#div-titleUpdateSessionCreateQuiz");

        $('#nb-max-quiz-new').val(numSelectSessionQuiz + 1); //number of new quiz
    }
}

function supNewBind(divid){ 
    $("#"+divid).remove();
}

function up_supUpdateSessionCreateQuiz(num){ //existing quiz to unbind 

    $("#up_quiz_action_"+num).val("delete");

    $("#up_quiz_"+num).hide();

    //hide the select list of quiz
    //$("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);
    $("#div-select-quiz").prop('hidden', true);
}

//Restore original quiz :
function up_sessionQuizRestor(){

    //supress all the new bound quiz :
    iStop= $("#nb-max-quiz-new").val();
    for(i=0;i<iStop;i++){
        supNewBind("quiz_"+i+"_new");
    }

    //Display all the original quiz :
    
    if($("#nb-quiz_original").val() == 0){       
        //metadata
        $("#nb-max-quiz-new").val(0);
        numSelectSessionQuiz = - 1;
    }
    else{
        for(i=0;i<$("#nb-quiz_original").val();i++){

            //Recover the data and the HMI in case a modification has been made :

            //quiz
            $("#quiz_quiz_"+i).val($("#quiz_quiz_"+i+"_old").val());
            $("#session_quiz_minutesduration"+i).val($("#session_quiz_minutesduration"+i+"_old").val());
            $("#session_quiz_openingdate"+i).val($("#session_quiz_openingdate"+i+"_old").val());
            $("#session_quiz_closingdate"+i).val($("#session_quiz_closingdate"+i+"_old").val());

            //metadata
            $("#up_quiz_action_"+i).val("");

            //show the quiz
            $("#up_quiz_"+i).show();
        }
        //metadata
        $("#nb-max-quiz-new").val(0); 
        numSelectSessionQuiz = - 1;
    }
}

function updateSessionUpdateQuiz(num){ //existing quiz : onchange
    $("#up_quiz_action_"+num).val("update");
}

//ACCOUNTS/////////////////

//button "Ajouter un compte": 
$("#div-select-account").prop('hidden', true);
function buttonAddUpdateSessionCreateAccount(){
    //if the all accounts list is visible then hide it 
    if($("#div-select-account").prop('hidden') == false){
        $("#div-select-account").prop('hidden', true);
    }
    else{
        //show the all accounts list 
        $("#div-select-account").prop('hidden', false);
        //and hide other lists
        $("#div-select-quiz").prop('hidden', true);
        //and get all the options of the select unselected
        $("#addCreateSessionAccounts option").prop('selected', false);

        selectAccountsConsistency();
    }
}

carnationAlternationForClass("accounts-list");

//Accounts filtering
function selectFilterAccounts(){
    if($("#select-filter-accounts").val() ==0) { //'Aucun' (None)
        $(".accounts-list").prop('hidden', false); //show all
    }
    else {
        $(".accounts-list").prop('hidden', true); // hide all
        $( "."+$("#select-filter-accounts").val() ).prop('hidden', false); //show the selection  
    }
    //white-grey alternation
    carnationAlternationForClass("accounts-list"); 
}
$("#select-filter-accounts").change(function(){
    selectAccountsConsistency();
});

function selectAccountsConsistency(){
    //Hide the options of the select accounts, already choosen :

    var iStop = $("#nb-accounts-db").val(); //all the accounts from DB in the select
    var jStop = $("#nb-accounts_original").val(); //accounts already choosen
    var kStop = $("#nb-max-accounts-new").val();  //new accounts added

    //init = show all :
    for(i=0;i<iStop;i++){ //accounts in the select
        $("#option-select-account_"+i).prop('hidden', false);
    }

    //apply filter :
    selectFilterAccounts();

    //Hide the options already choosen :
    for(i=0;i<iStop;i++){ //accounts in the select
        var idaccount = $("#option-select-account_"+i).val();
        //idquiz = idquiz.slice(0, -1); not more used
        var goon = true;
        for(j=0;j<jStop;j++){  //accounts already choosen
            if(!$('#up_account_'+j).is(":hidden") && $('#account_id_'+j).val() == idaccount) {  //account_login_
                $("#option-select-account_"+i).prop('hidden', true);
                goon = false;
                break;
            }
        }
        if(goon){
            for(k=0;k<kStop;k++){  //new account added
                if($('#account_id_'+k+'_new')[0] && $('#account_id_'+k+'_new').val() == idaccount) {
                    $("#option-select-account_"+i).prop('hidden', true);
                    break;
                }
            }
        }
    }
    carnationAlternationForClass("accounts-list"); 
}

//init 
var numSelectSessionAccount =  parseInt($("#nb-max-accounts-new").val() - 1);
//on change in the select of the all accounts list :
function selectAddUpdateSessionCreateAccount(){

    //hide the select list of accounts :
    $("#div-select-account").prop('hidden', true);

    //get the account data :

    var idaccount = $("#addCreateSessionAccounts").val(); //boucle à prévoir pour multiple
    var account = $('option[value="'+idaccount+'"]').html();
    //idquiz = idquiz.slice(0, -1); //get the last caracter '_' away (added to have unique id)

    //If the same old account has been hidden, then show it again :
    var stop = false;
    var iStop = $("#nb-accounts_original").val();
    
    for(i=0;i<iStop;i++){

        if($('#account_id_'+i).val() == idaccount) {
            $("#up_account_"+i).show();
            $("#up_account_action_"+i).val(""); // !!!!
            stop = true;
            break;
        }
    }
    if((!stop) && (numSelectSessionAccount < NBACCOUNTSMAX)){ //built the div of the quiz to be added :
    
        numSelectSessionAccount++; //index of the new account

        div = '<div class="row" id="account_'+numSelectSessionAccount+'_new">'; //no 'up_' but '_new'
        div+= '<div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        div+= '<button class="border-0 bg-danger text-white rounded-circle" type="button"';
        div+= ' onclick="supNewBind(\'account_'+numSelectSessionAccount+'_new\');"';
        div+= ' >X</button></div><div class="col-12 col-md-9">'; 
        div+= '<label class="label" for="account_account_'+numSelectSessionAccount+'_new">Compte</label></div></div></div>';

        div+= '<div class="col-12 col-md-10">';
        div+= '<div class="row" onchange="updateSessionUpdateAccount('+numSelectSessionAccount+')">';
        div+= '<div class="col-12 col-md-12">';
        div+= '<input disabled="disabled" class="input-account" id="account_account_'+numSelectSessionAccount+'_new"';
        div+= ' name="account_account_'+numSelectSessionAccount+'_new" type="text" value="'+account+'">';
        div+= '<input id="account_id_'+numSelectSessionAccount+'_new"';
        div+= ' name="account_id_'+numSelectSessionAccount+'_new" type="hidden" value="'+idaccount+'">';
        div+= '</div>'; 

        div+= '</div></div></div>';
        div+= '</div>'; //I don't understand why this closing div (a priori supernumerary) is needed to align on the right !?

        //Add the div (string div) after the div of the 2 buttons with id='div-addUpdateSessionCreateAccount'
        $(div).insertAfter("#div-addUpdateSessionCreateAccount");

        $('#nb-max-accounts-new').val(numSelectSessionAccount + 1); //number of the next new account
    }
}

function up_supUpdateSessionCreateAccount(num){ //existing quiz to unbind 

    $("#up_account_action_"+num).val("delete");

    $("#up_account_"+num).hide();

    //hide the select list of accounts
    //$("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);
    $("#div-select-account").prop('hidden', true);
}

//Restore original accounts :
function up_sessionAccountsRestor(){

    //supress all the new bound accounts :
    iStop= $("#nb-max-accounts-new").val();
    for(i=0;i<iStop;i++){
        supNewBind("account_"+i+"_new");
    }

    //Display all the original accounts :
    
    if($("#nb-accounts_original").val() == 0){       
        //metadata
        $("#nb-max-accounts-new").val(0);
        numSelectSessionAccount = - 1;
    }
    else{
        for(i=0;i<$("#nb-accounts_original").val();i++){

            //Recover the data and the HMI in case a modification has been made :

            //account
            $("#account_account_"+i).val($("#account_account_"+i+"_old").val());
            
            //metadata
            $("#up_account_action_"+i).val("");

            //show the quiz
            $("#up_account_"+i).show();
        }
        //metadata
        $("#nb-max-accounts-new").val(0); 
        numSelectSessionAccount = - 1;
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////div_sessions_list.php : delete a session////////////////////////////////////////////////////
$("#bt-delete-session").prop('hidden', true);
$("#div-form-delete-session").prop('hidden', true);

//link "Supp." :
//deleteAccount('<?php echo $account[LOGIN] ?>', '<?php echo $account[PROFILE] ?>', '<?php echo $account[NAME] ?>', '<?php echo $account[FIRSTNAME] ?>', '<?php echo $account[COMPANY] ?>')

function deleteSession(sessionId, sessionTitle, sessionSubtitle, sessionEnddate){

    if( $("#div-form-delete-session").prop('hidden')==true && //true
        $("#div-form-create-session").prop('hidden')==true) { //true

        $("#bt-delete-session").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-delete-session").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-session").prop('hidden', true);

        //display the existing session to be deleted
        //$("#p-session-supp").html(sessionTitle+(sessionSubtitle != "" ? " - "+sessionSubtitle : "")+"<br>"+(sessionEnddate == 0 ? "(pas de date de fin)" : "(date de fin : "+Date(sessionEnddate*1000).toLocaleDateString()+")")); 
        
        let endDate = new Date(sessionEnddate*1000);
        endDate = endDate.toLocaleDateString();
        $("#p-session-supp").html(sessionTitle+(sessionSubtitle != "" ? " - "+sessionSubtitle : "")+"<br>"+(sessionEnddate == 0 ? "(pas de date de fin)" : "(date de fin : "+endDate+")")); 
        
        //update the supp form
        $("#deletedsessionid").val(sessionId); 
        $("#deletedsessiontitle").val(sessionTitle); 
    }
} 

//button :
$("#bt-delete-session").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-delete-session").prop('hidden', true);
        $("#bt-delete-session").prop('hidden', true);
        $("#bt-create-session").prop('hidden', false);
        $(".div-alert").html("Aucune suppression n'a été effectuée.");
    }
);

///////////////////////////////div_sessions_list.php : create a session////////////////////////////////////////////////////

$("#div-form-create-session").prop('hidden', true);
$("#bt-create-session").click(
    function(){
        if($("#div-form-create-session").prop('hidden')) {
            $("#div-form-create-session").prop('hidden', false);
            $("#bt-create-session").html("Abandonner la création");
        }
        else { 
            $("#div-form-create-session").prop('hidden', true);
            $("#bt-create-session").html("Créer un compte");
        }
        $(".div-alert").html("");
    }
);


///////////////////////////////div_accounts_list.php : delete an account////////////////////////////////////////////////////
$("#bt-delete-account").prop('hidden', true);
$("#div-form-delete-account").prop('hidden', true);

//link "Supp." :
function deleteAccount($accountLogin, $profile, $name, $firstname, $company){

    if( $("#div-form-delete-account").prop('hidden')==true && //true
        $("#div-form-create-account").prop('hidden')==true) { //true

        $("#bt-delete-account").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-delete-account").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-account").prop('hidden', true);

        //display the existing quiz to be deleted
        $("#p-account-supp").html($profile+" '"+$accountLogin+"' ("+$name+" "+$firstname+($company == "" ? "" : ' de '+$company)+")"); 
        
        switch($profile){
            case'user':
                $('#p-account-supp-subtitle').html("ainsi que tous ses résultats.");
            break;
            case'admin':                
                $('#p-account-supp-subtitle').html("ainsi que toutes ses sessions, élèves et résultats, et tous ses quiz, questions et mots-clés.");  
            break;
        }
        
        //update the supp form
        $("#deletedaccountlogin").val($accountLogin); 
        $("#deletedaccount").val($name+" "+$firstname); 
    }
} 

//button :
$("#bt-delete-account").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-delete-account").prop('hidden', true);
        $("#bt-delete-account").prop('hidden', true);
        $("#bt-create-account").prop('hidden', false);
        $(".div-alert").html("Aucune suppression n'a été effectuée.");
    }
);

///////////////////////////////div_accounts_list.php : create an account////////////////////////////////////////////////////

$("#div-form-create-account").prop('hidden', true);
$("#bt-create-account").click(
    function(){
        if($("#div-form-create-account").prop('hidden')) {
            $("#div-form-create-account").prop('hidden', false);
            $("#bt-create-account").html("Abandonner la création");
            $(".div-alert").html("");
        }
        else { 
            $("#div-form-create-account").prop('hidden', true);
            $("#bt-create-account").html("Créer un compte");
            $(".div-alert").html("Aucune création n'a été effectuée.");
        }
        
    }
);



///////////////////////////////div_quiz_list.php : delete a quiz////////////////////////////////////////////////////
$("#bt-delete-quiz").prop('hidden', true);
$("#div-form-delete-quiz").prop('hidden', true);

//link "Supp." :
function deleteQuiz($quizid, $quiz, $status){

    if( $("#div-form-delete-quiz").prop('hidden')==true && //true
        $("#div-form-create-quiz").prop('hidden')==true) { //true

        $("#bt-delete-quiz").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-delete-quiz").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-quiz").prop('hidden', true);

        //display the existing quiz to be deleted
        $("#p-quiz-supp").html("'"+$quiz+"'"); 
        $("#p-quiz-status-supp").html("("+$status+")"); 

        //update the supp form
        $("#deletedquizid").val($quizid); 
        $("#deletedquiz").val($quiz); 
    }
} 

//button :
$("#bt-delete-quiz").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-delete-quiz").prop('hidden', true);
        $("#bt-delete-quiz").prop('hidden', true);
        $("#bt-create-quiz").prop('hidden', false);
        $(".div-alert").html("Aucune suppression n'a été effectuée.");
    }
);

///////////////////////////////div_quiz_list.php : create a quiz////////////////////////////////////////////////////

$("#div-form-create-quiz").prop('hidden', true);
$("#bt-create-quiz").click(
    function(){
        if($("#div-form-create-quiz").prop('hidden')) {
            $("#div-form-create-quiz").prop('hidden', false);
            $("#bt-create-quiz").html("Abandonner la création");
            $(".div-alert").html("");
        }
        else { 
            $("#div-form-create-quiz").prop('hidden', true);
            $("#bt-create-quiz").html("Créer un quiz");
            $(".div-alert").html("Aucune création n'a été effectuée.");
        }
    }
);

///////////////////////////////div_questions_list.php : filter////////////////////////////////////////////////////

function carnationAlternation(){
    //white-grey alternation
    var lines = document.getElementsByClassName("question-list");
    var iWhite = 2;
    for(i=0;i<lines.length;i++) {
        if(lines[i].hidden == false){ 

            if(iWhite % 2 == 0) lines[i].style.background = "white";
            else lines[i].style.background = "lightgrey";

            iWhite++;
        }  
    }
}
///carnationAlternation();

//Questions filtering
function selectFilter(){
    if($("#select-filter").val() ==0) { //'Aucun' (None)
        $(".question-list").prop('hidden', false); //show all
    }
    else {
        $(".question-list").prop('hidden', true); // hide all
        $( "."+$("#select-filter").val() ).prop('hidden', false); //show the selection  
    }
    //white-grey alternation
    //carnationAlternation();  
}
$("#select-filter").change(function(){
    selectQuestionConsistency();
});
    
///////////////////////////////div_questions_list.php : create a question////////////////////////////////////////////////////

$("#div-form-create-question").prop('hidden', true);
$("#bt-create-question").click(
    function(){
        if($("#div-form-create-question").prop('hidden')) {
            $("#div-form-create-question").prop('hidden', false);
            $("#bt-create-question").html("Abandonner la création");
            $(".div-alert").html("");
        }
        else { 
            $("#div-form-create-question").prop('hidden', true);
            $("#bt-create-question").html("Créer une question");
            $(".div-alert").html("Aucune création n'a été effectuée.");
        }
    }
);

///////////////////////////////div_questions_list.php : delete a question////////////////////////////////////////////////////
$("#bt-delete-question").prop('hidden', true);
$("#div-form-delete-question").prop('hidden', true);

//link "Supp." :
function deleteQuestion($questionid, $question, $status, $widget){

    if( $("#div-form-delete-question").prop('hidden')==true && //true
        $("#div-form-create-question").prop('hidden')==true) { //true

        $("#bt-delete-question").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-delete-question").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-question").prop('hidden', true);

        //display the existing question to be deleted
        $("#p-question-supp").html("'"+$question+"'"); 
        $("#p-question-status-supp").html($status+" ("+$widget+")"); 
        //$("#p-question-widget-supp").html($widget); 
        
        //update the supp form
        $("#deletedquestionid").val($questionid); 
        $("#deletedquestion").val($question); 
    }
} 

//button :
$("#bt-delete-question").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-delete-question").prop('hidden', true);
        $("#bt-delete-question").prop('hidden', true);
        $("#bt-create-question").prop('hidden', false);
        $(".div-alert").html("Aucune suppression n'a été effectuée.");
    }
);

///////////////////////////////questions_list.php : create question : answers////////////////////////////////////////////////////

var numAddCreateQuestionCreateAnswer = 0; //index of the empty shell already displayed = 0 

function addCreateQuestionCreateAnswer(){  //create an empty shell
    //buil the div of the answer to be added
    if(numAddCreateQuestionCreateAnswer <NBRESPONSESMAX){
        numAddCreateQuestionCreateAnswer++; //index of the new answer

        divAnswer = '<div class="row" id="answer_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'"><div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        divAnswer+= '<button class="border-0 bg-danger text-white rounded-circle" type="button" onclick="supCreateQuestionCreateAnswer(\'';
        divAnswer+= 'answer_'+numAddCreateQuestionCreateAnswer + '\');">X</button></div><div class="col-12 col-md-9">'; 
        divAnswer+= '<label class="label" for="answer_answer_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'">Réponse</label></div></div></div>';

        divAnswer+= '<div class="col-12 col-md-10"><div class="row"><div class="col-12 col-md-7">';
        divAnswer+= '<input class="input-answer" id="answer_answer_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" name="answer_answer_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" type="text" value="" required></div>';
        divAnswer+= '<div class="col-12 col-md-2">';
        divAnswer+= '<label for="answer_ok_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'">Bonne réponse</label></div>';
        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<input class="text-left" id="answer_ok_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" name="answer_ok_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" type="checkbox"></div>';
        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<label class="label-answer" for="answer_status_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'">Publier</label></div>';
        divAnswer+= '<div class="col-12 col-md-1">';   
        divAnswer+= '<input id="answer_status_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" name="answer_status_';
        divAnswer+= numAddCreateQuestionCreateAnswer+'" type="checkbox"></div></div></div></div>';

        //Add the div after the div with id='div-addCreateQuestionCreateAnswer'
        $(divAnswer).insertAfter("#div-addCreateQuestionCreateAnswer");

        $('#nb-responses-max').val(numAddCreateQuestionCreateAnswer + 1); //number of new answers
    }
}

function supCreateQuestionCreateAnswer(divid){
    $("#"+divid).remove();
}

///////////////////////////////div_question.php : create an answer////////////////////////////////////////////////////

//init
var numAddUpdateQuestionCreateAnswer =  parseInt($("#nb-max-answers-new").val()) - 1; //index of the empty shell == 0 if existe (new answers)

function addUpdateQuestionCreateAnswer(){

    //built the div of the answer to be added
    if(numAddUpdateQuestionCreateAnswer <NBRESPONSESMAX){
        numAddUpdateQuestionCreateAnswer++; //index of the new answer

        divAnswer = '<div class="row" id="answer_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new"><div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        divAnswer+= '<button class="border-0 bg-danger text-white rounded-circle" type="button" onclick="supCreateQuestionCreateAnswer(\'';
        divAnswer+= 'answer_'+numAddUpdateQuestionCreateAnswer + '_new\');">X</button></div><div class="col-12 col-md-9">'; 
        divAnswer+= '<label class="label" for="answer_answer_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new">Réponse</label></div></div></div>';

        divAnswer+= '<div class="col-12 col-md-10"><div class="row"><div class="col-12 col-md-7">';
        divAnswer+= '<input class="input-answer" id="answer_answer_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" name="answer_answer_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" type="text" value="" required></div>'; //
        divAnswer+= '<div class="col-12 col-md-2">';
        divAnswer+= '<label for="answer_ok_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new">Bonne réponse</label></div>';
        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<input class="text-left" id="answer_ok_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" name="answer_ok_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" type="checkbox"></div>';
        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<label class="label-answer" for="answer_status_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new">Publier</label></div>';
        divAnswer+= '<div class="col-12 col-md-1">';   
        divAnswer+= '<input id="answer_status_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" name="answer_status_';
        divAnswer+= numAddUpdateQuestionCreateAnswer+'_new" type="checkbox"></div></div></div></div>';

        //Add the div after the div with id='div-addUpdateQuestionCreateAnswer'
        $(divAnswer).insertAfter("#div-addUpdateQuestionCreateAnswer");

        $('#nb-max-answers-new').val(numAddUpdateQuestionCreateAnswer + 1); //number of new answers
    }
}

function crea_supUpdateQuestionCreateAnswer(divid){ //new answer
    $("#"+divid).remove();
}

function up_supUpdateQuestionCreateAnswer(num){ //existing answers

    $("#up_answer_action_"+num).val("delete");

    $("#up_answer_"+num).hide();
}

function updateQuestionUpdateAnswer(num){ //existing answers : onchange
    $("#up_answer_action_"+num).val("update");
}

///////////////////////////////div_question.php : Restor////////////////////////////////////////////////////

//QUESTION :

//Restor question data :
function up_questionRestor(widget, status){

    $("#up_question_question").val($("#up_question_question_old").val());
    $("#up_question_guideline").val($("#up_question_guideline_old").val());
    $("#up_question_explanationtitle").val($("#up_question_explanationtitle_old").val());
    $("#up_question_explanation").val($("#up_question_explanation_old").val());
    $("#up_question_question").val($("#up_question_question_old").val());

    $("#up_question_idwidget-select").val(widget);

    if(status = 'inline') $("#up_question_status").prop('checked', true);
    else $("#up_question_status").prop('checked', false);

    $("#up_question").val('0');
}

//On change on question data :
function onChangeDivQuestionData(){
    $("#up_question").val('1');
}

//KEYWORDS :

//Restore original keywords :
function up_questionKeywordsRestor(strOriginals){

    var arrayOriginals = strOriginals.split(' ');

    var theSelect = document.querySelector("#up_addCreateQuestionKeywords");
    var arrayAllTheOptions = Array.from(theSelect.options);
    for (i = 0; i < arrayAllTheOptions.length; i++) {
        arrayAllTheOptions[i].selected = false;
        for(j=0;j<arrayOriginals.length;j++){
            if(arrayAllTheOptions[i].value == arrayOriginals[j]) { 
                arrayAllTheOptions[i].selected = true; 
                break;
            }
        }
    }
    $("#up_question-keywords").val(""); //no modification
}

//Click on the keyword select :
function up_questionKeywordClickSelect(){

    var theSelect = document.querySelector("#up_addCreateQuestionKeywords");
    var arrayAllTheOptions = Array.from(theSelect.options);

    var arrayNew = [];
    for (i = 0; i < arrayAllTheOptions.length; i++) {
        if (arrayAllTheOptions[i].selected) arrayNew.push(arrayAllTheOptions[i].value);
    }
    if(arrayNew != null) $("#up_question-keywords").val(arrayNew.toString());
    else $("#up_question-keywords").val("");

    $("#up_question-keywords_click").val('1');
}

//ANSWERS :

//Restore original answers :
function up_questionAnswersRestor(){

    //supress all the new answers :

    iStop= $("#nb-max-answers-new").val();
    for(i=0;i<iStop;i++){
        crea_supUpdateQuestionCreateAnswer("answer_"+i+"_new")
    }

    //Display the original answers :
    
    if($("#nb-answers_original").val() == 0){ 
        //afficher une coquille vide
        numAddUpdateQuestionCreateAnswer = 0;
        addUpdateQuestionCreateAnswer();

        //metadata
        $("#nb-max-answers-new").val(1); //the empty shell
    }
    else{

        for(i=0;i<$("#nb-answers_original").val();i++){

            //Recover the data and the HMI in case a modification has been made :

            //answer
            $("#answer_answer_"+i).val($("#answer_answer_"+i+"_old").val());
            //answer_ok
            if($("#nb-answers_ok"+i+"_old").val() == 1) $("#nb-answers_ok"+i).prop('checked', true);
            else $("#nb-answers_ok"+i).prop('checked', false);
            //answer_status
            if($("#nb-answers_status"+i+"_old").val() == 'inline') $("#nb-answers_status"+i).prop('checked', true);
            else $("#nb-answers_status"+i).prop('checked', false);

            //metadata
            $("#up_answer_action_"+i).val("");

            //show the answer
            $("#up_answer_"+i).show();
        }
        //metadata
        $("#nb-max-answers-new").val(0); //no empty shell displayed
        numAddUpdateQuestionCreateAnswer = -1;
    }
}

///??????????????????????????????????????????????????????????????????????????????????????????

///////////////////////////////div_account.php////////////////////////////////////////////////////////
//ACCOUNT :

//Restor account data :
function up_accountRestor(){

    $("#up_account_name").val($("#up_account_name_old").val());
    $("#up_account_firstname").val($("#up_account_firstname_old").val());
    $("#up_account_company").val($("#up_account_company_old").val());
    $("#up_account_email").val($("#up_account_email_old").val());

    $("#up_account_psw").prop('checked', false);

    //?/$("#up_question").val('0');
}

//On change on quiz data :
function onChangeDivAccountData(){ 
    $("#up_account").val('1');
}

function crea_supUpdateAccountCreateSession(divid){ //supp. a new binded session
    $("#"+divid).remove();
}

function up_supUpdateAccountExistingSession(num){ //supp. an old binded session 

    $("#up_session_action_"+num).val("delete");

    $("#up_session_"+num).hide();

    //hide the select list of sessions (update account)
    $("#div-addUpdateAccountCreatesessionShowSessions").prop('hidden', true);
}
//?/ not used
/*
function updateQuizUpdateQuestion(num){ //existing session : onchange
    $("#up_question_action_"+num).val("update");
}
*/

/////Add a new session///////////
//init :
$("#div-addUpdateAccountCreatesessionShowSessions").prop('hidden', true);

$("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);

//Show the list of all the sessions (button 'Ajouter une session'):
function selectSessionConsistency(){
    //Hide the sessions of the select session, already choosen :

    var iStop = $("#nb-sessions-db").val(); //all the session from DB in the select
    var jStop = $("#nb-sessions_original").val(); //sessions already choosen
    var kStop = $("#nb-max-sessions-new").val();  //new sessions added

    //init = show all :
    for(i=0;i<iStop;i++){ //sessions in the select
        $("#option-select-session_"+i).prop('hidden', false);
    }

    //apply filter :

    //Hide the options already choosen :
    for(i=0;i<iStop;i++){ //sessions in the select
        var idsession = $("#option-select-session_"+i).val();
        idsession = idsession.slice(0, -1);
        var goon = true;
        for(j=0;j<jStop;j++){  //sessions already choosen
            if(!$('#up_session_'+j).is(":hidden") && $('#session_id_'+j).val() == idsession) {
                $("#option-select-session_"+i).prop('hidden', true);
                goon = false;
                break;
            }
        }
        if(goon){
            for(k=0;k<kStop;k++){  //new sessions added
                if($('#session_id_'+k+'_new')[0] && $('#session_id_'+k+'_new').val() == idsession) {
                    $("#option-select-session_"+i).prop('hidden', true);
                    break;
                }
            }
        }
    }

    carnationAlternation();
}



function addUpdateAccountCreatesessionShowSessions(){
    //show or mask the list (button 'Ajouter une session')
    if($("#div-addUpdateAccountCreatesessionShowSessions").is(":hidden"))
        $("#div-addUpdateAccountCreatesessionShowSessions").prop('hidden', false);
    else $("#div-addUpdateAccountCreatesessionShowSessions").prop('hidden', true);

    selectSessionConsistency();
}

//init
var numAddUpdateAccountCreatesession =  parseInt($("#nb-max-sessions-new").val() - 1);

function addUpdateAccountCreatesession(){

    //hide the select list of sessions (update quiz) :
    $("#div-addUpdateAccountCreatesessionShowSessions").prop('hidden', true);

    //get the session data :

    var idsession = $("#addCreateAccountSessions").val();
    var session = $('option[value="'+idsession+'"]').html();
    idsession = idsession.slice(0, -1); //get the last caracter '_' away (added to have unique id)

    //If the same old session has been hidden, then show it again :
    var stop = false;
    var iStop = $("#nb-sessions_original").val();
  
    for(i=0;i<iStop;i++){
        if($('#session_id_'+i).val() == idsession) {
            $("#up_session_"+i).show();
            $("#up_session_action_"+i).val(""); // !!!!
            stop = true;
            break;
        }
    }
    if(stop) return false;
    //built the div of the session to be added :
    
    if(numAddUpdateAccountCreatesession < NBQUESTIONSMAX){
        numAddUpdateAccountCreatesession++; //index of the new session

        divAnswer = '<div class="row" id="session_'+numAddUpdateAccountCreatesession+'_new">';
        divAnswer+= '<div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        divAnswer+= '<button class="border-0 bg-danger text-white rounded-circle" type="button"';
        divAnswer+= ' onclick="crea_supUpdateAccountCreateSession(\'session_'+numAddUpdateAccountCreatesession+'_new\');"';
        divAnswer+= ' >X</button></div><div class="col-12 col-md-9">'; 
        divAnswer+= '<label class="label" for="session_session_'+numAddUpdateAccountCreatesession+'_new">Session</label></div></div></div>';

        divAnswer+= '<div class="col-12 col-md-10"><div class="row"><div class="col-12">';  //class="col-12 col-md-7"
        divAnswer+= '<input disabled="disabled" class="input" id="session_session_'+numAddUpdateAccountCreatesession+'_new"';
        divAnswer+= ' name="session_session_'+numAddUpdateAccountCreatesession+'_new" type="text" value="'+session+'">';
        divAnswer+= '<input id="session_id_'+numAddUpdateAccountCreatesession+'_new"';
        divAnswer+= ' name="session_id_'+numAddUpdateAccountCreatesession+'_new" type="hidden" value="'+idsession+'">';
        divAnswer+= '</div></div></div></div>';

        //Add the div after the div with id='div-addUpdateAccountCreatesession'
        $(divAnswer).insertAfter("#div-addUpdateAccountCreatesession");

        $('#nb-max-sessions-new').val(numAddUpdateAccountCreatesession + 1); //number of new sessions
    }
}







/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////div_quiz.php////////////////////////////////////////////////////////

//SESSIONS (info) :
function whiteGreyForClass(myClass, whiteFirst){
    //white-grey alternation
    var lines = document.getElementsByClassName(myClass);
    var iWhite = whiteFirst ? 0 : 1 ;
    for(i=0;i<lines.length;i++) {
        if(lines[i].hidden == false){
            if(iWhite % 2 == 0) lines[i].style.background = "white";
            else lines[i].style.background = "lightgrey";

            iWhite++;
        }
    };
}
whiteGreyForClass("sessions-list", true);


//QUIZ :

//Restor quiz data :
function up_quizRestor(status){

    $("#up_quiz_title").val($("#up_quiz_title_old").val());
    $("#up_quiz_subtitle").val($("#up_quiz_subtitle_old").val());

    if(status == 'inline') $("#up_quiz_status").prop('checked', true);
    else $("#up_quiz_status").prop('checked', false);

    $("#up_question").val('0');
}

//On change on quiz data :
function onChangeDivQuizData(){
    $("#up_quiz").val('1');
}

function crea_supUpdateQuizCreateQuestion(divid){ //new answer (à coder)
    $("#"+divid).remove();
}

function up_supUpdateQuizExistingQuestion(num){ //existing question 

    $("#up_question_action_"+num).val("delete");

    $("#up_question_"+num).hide();

    //hide the select list of questions (update quiz)
    $("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);
}

function updateQuizUpdateQuestion(num){ //existing question : onchange
    $("#up_question_action_"+num).val("update");
}

/////Add a new question///////////?????????
//init :
$("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);

//Show the list of all the not selected questions (button 'Ajouter une question') :
function selectQuestionConsistency(){

    var iStop = $("#nb-questions-db").val(); //all the question from DB in the select
    var jStop = $("#nb-questions_original").val(); //questions already choosen
    var kStop = $("#nb-max-questions-new").val();  //new questions added

    //init = show all :
    for(i=0;i<iStop;i++){ //questions in the select
        $("#option-select-question_"+i).prop('hidden', false);
    }

    //apply filter :
    selectFilter();

    //Hide the options already choosen :
    for(i=0;i<iStop;i++){ //questions in the select
        var idquestion = $("#option-select-question_"+i).val();
        idquestion = idquestion.slice(0, -1);
        var goon = true;
        for(j=0;j<jStop;j++){  //questions already choosen
            if(!$('#up_question_'+j).is(":hidden") && $('#question_id_'+j).val() == idquestion) {
                $("#option-select-question_"+i).prop('hidden', true);
                goon = false;
           
                break;
            }
        }
        if(goon){
            for(k=0;k<kStop;k++){  //new questions added
                if($('#question_id_'+k+'_new')[0] && $('#question_id_'+k+'_new').val() == idquestion) {
                    $("#option-select-question_"+i).prop('hidden', true);
                    break;
                }
            }
        }
    }
    carnationAlternationForClass("question-list"); //class of the options in the select of questions
    ///carnationAlternation();
}



function addUpdateQuizCreatequestionShowQuestions(){
    //show or mask the list (button 'Ajouter une question')
    if($("#div-addUpdateQuizCreatequestionShowQuestions").is(":hidden"))
        $("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', false);
    else $("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);

    selectQuestionConsistency();
}

//init
var numAddUpdateQuizCreatequestion =  parseInt($("#nb-max-questions-new").val() - 1);

function addUpdateQuizCreatequestion(){ //div_quiz.php
    
    $("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);

    //hide the select list of questions (update quiz) :
    $("#div-addUpdateQuizCreatequestionShowQuestions").prop('hidden', true);

    //get the question data :

    var idquestion = $("#addCreateQuizQuestions").val();

    var question = $('option[value="'+idquestion+'"]').html();

    idquestion = idquestion.slice(0, -1); //get the last caracter '_' away (added to have unique id)
    
    //If the same old question has been hidden, then show it again :
    var stop = false;
    var iStop = $("#nb-questions_original").val();
   
    for(i=0;i<iStop;i++){

        if($('#question_id_'+i).val() == idquestion) {
            $("#up_question_"+i).show();
            $("#up_question_action_"+i).val(""); // !!!!
            stop = true;
         
            break;
        }
    }
    if(stop) return false;

    //built the div of the question to be added :
    
    if(numAddUpdateQuizCreatequestion < NBQUESTIONSMAX){
        numAddUpdateQuizCreatequestion++; //index of the new question

        divAnswer = '<div class="row" id="question_'+numAddUpdateQuizCreatequestion+'_new">';
        divAnswer+= '<div class="col-12 col-md-2"><div class="row"><div class="col-12 col-md-3">';
        divAnswer+= '<button class="border-0 bg-danger text-white rounded-circle" type="button"';
        divAnswer+= ' onclick="crea_supUpdateQuizCreateQuestion(\'question_'+numAddUpdateQuizCreatequestion+'_new\');"';
        divAnswer+= ' >X</button></div><div class="col-12 col-md-9">'; 
        divAnswer+= '<label class="label" for="question_question_'+numAddUpdateQuizCreatequestion+'_new">Question</label></div></div></div>';

        divAnswer+= '<div class="col-12 col-md-10"><div class="row"><div class="col-12 col-md-7">';
        divAnswer+= '<input disabled="disabled" class="input-question" id="question_question_'+numAddUpdateQuizCreatequestion+'_new"';
        divAnswer+= ' name="question_question_'+numAddUpdateQuizCreatequestion+'_new" type="text" value="'+question+'">';
        divAnswer+= '<input id="question_id_'+numAddUpdateQuizCreatequestion+'_new"';
        divAnswer+= ' name="question_id_'+numAddUpdateQuizCreatequestion+'_new" type="hidden" value="'+idquestion+'">';
        divAnswer+= '</div>'; 

        divAnswer+= '<div class="col-12 col-md-1 ml-md-3">';
        divAnswer+= '<label for="quiz_question_numorder_'+numAddUpdateQuizCreatequestion+'_new">Ordre</label></div>';

        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<select name="quiz_question_numorder_'+numAddUpdateQuizCreatequestion+'_new" id="quiz_question_numorder_'+numAddUpdateQuizCreatequestion+'_new" value="0">';
        divAnswer+= '<option value="0" selected>0</option>';
        divAnswer+= '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>';
        divAnswer+= '</select></div>';

        divAnswer+= '<div class="col-12 col-md-1 ml-md-3">';
        divAnswer+= '<label for="quiz_question_weight_'+numAddUpdateQuizCreatequestion+'_new">Poids</label></div>';

        divAnswer+= '<div class="col-12 col-md-1">';
        divAnswer+= '<select name="quiz_question_weight_'+numAddUpdateQuizCreatequestion+'_new" id="quiz_question_weight_'+numAddUpdateQuizCreatequestion+'_new" value="1">';
        divAnswer+= '<option value="1" selected>1</option>';
        divAnswer+= '<option value="2">2</option><option value="3">3</option>';
        divAnswer+= '</select></div></div></div></div>';

        //Add the div after the div with id='div-addUpdateQuizCreatequestion'
        $(divAnswer).insertAfter("#div-addUpdateQuizCreatequestion");

        $('#nb-max-questions-new').val(numAddUpdateQuizCreatequestion + 1); //number of new answers
    }
}




//////////////////////////////div_keywords_list.php : update a Keyword////////////////////////////////////////////////////

$("#bt-update-keyword").prop('hidden', true); //'Abandonner...' (give up)
$("#div-form-update-keyword").prop('hidden', true);

//link "Maj" :
function updateKeyword($keywordid, $keyword, $countquestions){
    if( $("#div-form-update-keyword").prop('hidden')==true &&
        $("#div-form-delete-keyword").prop('hidden')==true &&
        $("#div-form-create-keyword").prop('hidden')==true) {

        $("#bt-update-keyword").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-update-keyword").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-keyword").prop('hidden', true);

        //display the existing keyword to be updated
        $("#p-keyword-maj").html("'"+$keyword+"'"); 
        $("#newkeyword").val($keyword); 
        
        //Display the questions involved
        displayKeywordQuestions($keywordid, $keyword, $countquestions);

        //update the form
        $("#updatedkeywordid").val($keywordid); 
        $("#updatedkeyword").val($keyword); 
    }
} 

//button :
$("#bt-update-keyword").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-update-keyword").prop('hidden', true);
        $("#bt-update-keyword").prop('hidden', true);
        $("#bt-create-keyword").prop('hidden', false);
        $(".div-alert").html("Aucune modification n'a été effectuée.");
    }
);

///////////////////////////////div_keywords_list.php : delete a Keyword////////////////////////////////////////////////////
$("#bt-delete-keyword").prop('hidden', true);
$("#div-form-delete-keyword").prop('hidden', true);

//link "Supp." :
function deleteKeyword($keywordid, $keyword, $countquestions){

    if( $("#div-form-update-keyword").prop('hidden')==true &&
        $("#div-form-delete-keyword").prop('hidden')==true &&
        $("#div-form-create-keyword").prop('hidden')==true) {

        $("#bt-delete-keyword").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-delete-keyword").prop('hidden', false);
        $(".div-alert").html("");
        $("#bt-create-keyword").prop('hidden', true);

        //display the existing keyword to be deleted
        $("#p-keyword-supp").html("'"+$keyword+"'"); 
        
        //Display the questions involved
        displayKeywordQuestions($keywordid, $keyword, $countquestions);

        //update the form
        $("#deletedkeywordid").val($keywordid); 
        $("#deletedkeyword").val($keyword); 
    }
} 

//button :
$("#bt-delete-keyword").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-delete-keyword").prop('hidden', true);
        $("#bt-delete-keyword").prop('hidden', true);
        $("#bt-create-keyword").prop('hidden', false);
        $(".div-alert").html("Aucune suppression n'a été effectuée.");
    }
);

///////////////////////////////div_keywords_list.php : create a keyword////////////////////////////////////////////////////

$("#div-form-create-keyword").prop('hidden', true);
$("#bt-create-keyword").click(
    function(){
        if($("#div-form-create-keyword").prop('hidden')) {
            $("#div-form-create-keyword").prop('hidden', false);
            $("#bt-create-keyword").html("Abandonner la création");
            $(".div-alert").html("");
        }
        else { 
            $("#div-form-create-keyword").prop('hidden', true);
            $("#bt-create-keyword").html("Créer un mot clé");
            $(".div-alert").html("Aucune création n'a été effectuée.");
        }
    }
);

////////////////////////////////div_keywords_list.php : Keyword Questions List////////////////////////////////////////////////////

$("#div-keyword-questions").prop('hidden', true);
function displayKeywordQuestions($keywordid, $keyword, $countquestions){
    
    $("#div-keyword-questions > div").prop('hidden', true); // hide all inside the div
    
    if($countquestions == 0) {
        $("#div-keyword-questions-heading").html("Le mot clé '"+$keyword+"'"+" n'est associé à aucune question");
    }
    else {
        if($countquestions == 1) $("#div-keyword-questions-heading").html("La question du mot clé '"+$keyword+"'");
        else $("#div-keyword-questions-heading").html("Les "+$countquestions+" questions du mot clé '"+$keyword+"'");

        //$("#div-keyword-questions > div."+$keywordid).removeAttr('hidden'); //show the questions with a class matching $keywordid  
        $("#div-keyword-questions > div."+$keywordid).prop('hidden', false); //show the questions with a class matching $keywordid  
    }
    //$("#div-keyword-questions-heading").removeAttr('hidden'); //show the title
    $("#div-keyword-questions-heading").prop('hidden', false); //show the title

    $("#div-keyword-questions").prop('hidden', false); // show the div
}

///////////////////////////////div_takenquiz.php////////////////////////////////////////////////////

function hideQuestions(){
    for(i=0;i<nbQuestions;i++){
        $("#div-"+i).hide();
    }
}
function displayQuestion(numquest){
    hideQuestions();
    $("#div-"+numquest).show();
}
function displayButtonWording(what){
    switch(what) {
        case'nextQuestion':
            $("#bt-taken-quiz").html("Question suivante ("+(numQuestion+2)+"/"+nbQuestions+")"); 
        break;

        case'lastQuestion':
            $("#bt-taken-quiz").html("Répondez à la dernière question ci-dessous puis cliquez ici pour valider"); 
        break;
    }
}

function cumulateQuizNbanswersaskedNames(numQuestion){
    //Maj quizNbanswersaskedNames avec les données de la question précédente : sommer le (radio) ou les (box) réponses qui ont été proposées :
                  
    var widget = document.getElementById('question-'+(numQuestion)).value;
    widget = widget.substring(0, widget.indexOf("-"));

    switch(widget){
        case'radio':
            quizNbanswersaskedNames++;
        break;
        case'checkbox':
            var nbinputs = document.getElementsByClassName((numQuestion).toString()).length;

            quizNbanswersaskedNames+=nbinputs;
        break;
        default:
            alert ("<br>cumulateQuizNbanswersaskedNames : case inconnu.");
        break;
    } 
}

let nbQuestions = $("#div-quiz > div").length; //3
let click = "first";
let numQuestion = -1;
quizNbanswersaskedNames = 0;

hideQuestions();
//clic on the button "Commencer" and "Question suivante"
$("#bt-taken-quiz").click(
    function(){

        switch(click) {

            case'first':
                //Update quizStartdate
                $("#quizStartdate").val(Math.round(Date.now()/1000)); //the curent date (in seconds)

                numQuestion++;
                displayQuestion(numQuestion);

                if(numQuestion == nbQuestions - 1) { //this is the last question
                    displayButtonWording ("lastQuestion");
                    click = "last";
                }
                else {
                    displayButtonWording ("nextQuestion");
                    click = "ongoing";
                }
            break;

            case'ongoing':
        
                nowDate = Date.now();
                progressTime = (nowDate - beginDate) / (duration * 1000 * 60);
                progressTime = Math.min(100, Math.round(progressTime*100));
            
                if(progressTime == 100){
                    updateInfoBeforeSubmit();
                    $("#form_taken_quiz").submit();
                }
                else{ 
                    updateDivProgress();

                    cumulateQuizNbanswersaskedNames(numQuestion);
                
                    numQuestion++;
                    displayQuestion(numQuestion);           

                    if(numQuestion == nbQuestions - 1) { //this is the last question
                        displayButtonWording ("lastQuestion");
                        click = "last";
                    }
                    else {
                        displayButtonWording ("nextQuestion");
                        click = "ongoing";
                    }
                }
            break;
            
            case'last':

                nowDate = Date.now();
                progressTime = (nowDate - beginDate) / (duration * 1000 * 60);
                progressTime = Math.min(100, Math.round(progressTime*100));
            
                if(progressTime == 100){

                    updateInfoBeforeSubmit();
                        
                    //submit the form
                    $("#form_taken_quiz").submit();
                }
                else {
                    //updateDivProgress();

                    //hideQuestions();
                    
                    cumulateQuizNbanswersaskedNames(numQuestion);
                  
                    //udate information before submitting the form
                    $("#quizMaxnbquest").val(nbQuestions);
                    $("#quizNbquestasked").val(numQuestion+1);
                    $("#quizEnddate").val(Math.round(Date.now()/1000)); //the curent date in seconds
                    $("#quizNbanswersaskedNames").val(parseInt(quizNbanswersaskedNames));

                    //submit the form
                    $("#form_taken_quiz").submit();
                }
            break;
        }
    }
);

//////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////div_quiz_userlist.php////////////////////////////////////////////////////
$("#bt-lock-quiz").prop('hidden', true);
$("#div-form-lock-quiz").prop('hidden', true);

//link "Commencer" :
function lockQuiz($sessionid, $quizid, $duration, $title){

    if( $("#div-form-lock-quiz").prop('hidden')==true){ 

        $("#bt-lock-quiz").prop('hidden', false); //'Abandonner...' (give up)
        $("#div-form-lock-quiz").prop('hidden', false);

        //display the existing quiz to be locked
        $("#p-quiz-lock").html("'"+$title+"'"); 
        $("#p-quiz-duration").html("("+$duration+" minutes)"); 

        //update the lock form
        $("#lockedquizid").val($quizid); 
        $("#quizduration").val($duration); 
        $("#quizsessionid").val($sessionid); 
    }
} 
//button :
$("#bt-lock-quiz").click( //'Abandonner...' (give up)
    function(){
        $("#div-form-lock-quiz").prop('hidden', true);
        $("#bt-lock-quiz").prop('hidden', true);
    }
);
//////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////div_takenquiz.php////////////////////////////////////////////////////
$("#div-timer").prop('hidden', false);

function onclickbtshowtimer(){
    if($("#div-timer").prop('hidden')==true) {
        $("#div-timer").prop('hidden', false); //show the progress
        $("#bt-show-timer").html("Masquer l'avancement");
    }
    else{
        $("#div-timer").prop('hidden', true); //hide the progress
        $("#bt-show-timer").html("Afficher l'avancement");
    }
}

function updateDivProgress(){
    progressTime = progressTime.toString();

    elt1 = document.getElementById("div-progress-time");
    elt1.setAttribute("aria-valuenow", progressTime);
    elt1.setAttribute("style", "width: "+progressTime+"%");
        
    progressQuestions = Math.max(0, numQuestion+1) / nbQuestions;
    progressQuestions = Math.min(100, Math.round(progressQuestions*100));
    progressQuestions = progressQuestions.toString();
        
    elt2 = document.getElementById("div-progress-questions");
    elt2.setAttribute("aria-valuenow", progressQuestions);
    elt2.setAttribute("style", "width: "+progressQuestions+"%");
}
function updateInfoBeforeSubmit(){ //case time over
    //update information before submitting the form (case time over)
    $("#quizMaxnbquest").val(nbQuestions);
    $("#quizNbquestasked").val(numQuestion); //case time over
    $("#quizEnddate").val(Math.round(Date.now()/1000)); //the curent date in seconds
    $("#quizNbanswersaskedNames").val(parseInt(quizNbanswersaskedNames));
}

duration = 0;
if(document.getElementById('bt-taken-quiz') && $("#quizMaxDuration").val() !=0){
    //init
    var duration = $("#quizMaxDuration").val();
    var beginDate = Date.now();

    var nowDate = Date.now();
    var progressTime = (nowDate - beginDate) / (duration * 1000 * 60);
    progressTime = Math.min(100, Math.round(progressTime*100));
    progressTime = progressTime.toString();

    var elt1 = document.getElementById("div-progress-time");
    elt1.setAttribute("aria-valuenow", progressTime);
    elt1.setAttribute("style", "width: "+progressTime+"%");
     
    var progressQuestions = Math.max(0, numQuestion) / nbQuestions;
    progressQuestions = Math.min(100, Math.round(progressQuestions*100));
    progressQuestions = progressQuestions.toString();
    
    var elt2 = document.getElementById("div-progress-questions");
    elt2.setAttribute("aria-valuenow", progressQuestions);
    elt2.setAttribute("style", "width: "+progressQuestions+"%");

    //https://openclassrooms.com/forum/sujet/modification-dune-class
    //https://web-eau.net/blog/trucs-et-astuces-bootstrap


} 

///////////////////////////////div_stat_account_session_quiz.php////////////////////////////////////////////////////

$("#div-stat-account-explanations").prop('hidden', true);
function showDiv(div){
    if( $("#"+div).prop('hidden') == true){
        $("#"+div).prop('hidden', false);
//https://www.developpez.net/forums/d1335790/javascript/general-javascript/positionner-automatiquement-curseur-fin-d-texte-textarea/
    } 
    else{
        $("#"+div).prop('hidden', true);
    }
}


///////////////////////////////div_stat_account_session_quiz.php////////////////////////////////////////////////////

function btFormUpdateResults(){

    //Get the quizzes to be unblocked: if the checked checkbox has been unchecked, this bocked quiz has to be unblocked

    var unblocked_quizzes = document.getElementsByClassName("blockedquiz");
    let list = "";
    for(i=0;i<unblocked_quizzes.length;i++) {
        if(!unblocked_quizzes[i].checked) list+= unblocked_quizzes[i].value+",";
    };
    if(list != ""){
        list = list.slice(0, -1);
        $("#unblocked_quizzes").val(list);
    }

    //Get the quizzes witch results must be deleted:

    var resultsToBeDeleted = document.getElementsByClassName("resultsToBeDeleted");
    list = "";
    for(i=0;i<resultsToBeDeleted.length;i++) {
        if(resultsToBeDeleted[i].checked) list+= resultsToBeDeleted[i].value+",";
    };  
    if(list != ""){
        list = list.slice(0, -1);
        $("#deleted_results").val(list);
    }

    //submit:
    $("#form_update_results").submit();
}

