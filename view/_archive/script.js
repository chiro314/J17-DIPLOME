///////////////////////////////questions_list.php : filter////////////////////////////////////////////////////

$("#select-filter").change(function(){
    if($("#select-filter").val() ==0) $(".question-list").removeAttr('hidden'); //show all
    else {
        $(".question-list").prop('hidden', true); // hide all
        $( "."+$("#select-filter").val() ).removeAttr('hidden'); //show the selection
    }
});

///////////////////////////////div_keywords_list.php : create a keyword////////////////////////////////////////////////////
alert ("coucou");

$("#div_form_create_keyword").prop('hidden', true);
$("#bt-create-keyword").click(
    function(){
        if($("#div_form_create_keyword").prop('hidden')) {
            $("#div_form_create_keyword").prop('hidden', false);
            $("#bt-create-keyword").html("Abandonner la création");
        }
        else { 
            $("#div_form_create_keyword").prop('hidden', true);
            $("#bt-create-keyword").html("Créer un mot clé");
        }
        $(".div-alert").html("");
    }
);


///////////////////////////////div_keywords_list.php : Keyword Questions List////////////////////////////////////////////////////
$("#div-keyword-questions").prop('hidden', true);

$("#bt-update-keyword").prop('hidden', true);
$("#div-update-keyword").prop('hidden', true);

$("#bt-delete-keyword").prop('hidden', true);
$("#div-delete-keyword").prop('hidden', true);

/*
$(".a-countquestions").click(
    function(){
        $("#div-keyword-questions").prop('hidden', false);
        $(".div-alert").html("");
    }
);
*/
function displayKeywordQuestions($keywordid, $keyword, $countquestions){
    
    //$("#div-keyword-questions").prop('hidden', true); //hide the div
    //$("#div-keyword-questions").prop('hidden', false); // show the div
    
    $("#div-keyword-questions > div").prop('hidden', true); // hide all inside the div
    
    if($countquestions == 1) $("#div-keyword-questions-heading").html("La question du mot clé '"+$keyword+"'");
    else $("#div-keyword-questions-heading").html("Les "+$countquestions+" questions du mot clé '"+$keyword+"'");
    //$("#div-keyword-questions-heading").removeAttr('hidden'); //show the title
    $("#div-keyword-questions-heading").prop('hidden', false); //show the title

    //$("#div-keyword-questions > div."+$keywordid).removeAttr('hidden'); //show the questions with a class matching $keywordid  
    $("#div-keyword-questions > div."+$keywordid).prop('hidden', false); //show the questions with a class matching $keywordid  
}

function updateKeyword($keywordid, $keyword, $countquestions){
    //if()/////////////////////////////////////////////////////////////////????
    
    ///////////////
    if($("#div_form_create_keyword").prop('hidden')) {
        $("#div_form_create_keyword").prop('hidden', false);
        $("#bt-create-keyword").html("Abandonner la création");
    }
    else { 
        $("#div_form_create_keyword").prop('hidden', true);
        $("#bt-create-keyword").html("Créer un mot clé");
    }
    $(".div-alert").html("");

    //////////////////
    
    $("#div-keyword-questions > div").prop('hidden', true); // hide all inside the div
    
    if($countquestions == 1) $("#div-keyword-questions-heading").html("La question du mot clé '"+$keyword+"'");
    else $("#div-keyword-questions-heading").html("Les "+$countquestions+" questions du mot clé '"+$keyword+"'");
    //$("#div-keyword-questions-heading").removeAttr('hidden'); //show the title
    $("#div-keyword-questions-heading").prop('hidden', false); //show the title

    //$("#div-keyword-questions > div."+$keywordid).removeAttr('hidden'); //show the questions with a class matching $keywordid  
    $("#div-keyword-questions > div."+$keywordid).prop('hidden', false); //show the questions with a class matching $keywordid  
}
//updateKeyword(<?php echo $keyword[KEYWO

/*
const BT_CREATE_KEYWORD = 0, DIV_CREATE_KEYWORD = 1, DIV_KEYWORD_QUESTIONS = 2;
const HIDE = 0, DISPLAY = 1, NOMOVE = 2; 
$windowKeywordsList = [1, 0, 0];
function configureWindowKeywordsList(){
    if($windowKeywordsList[BT_CREATE_KEYWORD] == DISPLAY) $("#bt-create-keyword").prop('hidden', false);
    else if ($windowKeywordsList[BT_CREATE_KEYWORD] == HIDE) $("#bt-create-keyword").prop('hidden', true);

    if($windowKeywordsList[DIV_CREATE_KEYWORD] == DISPLAY) $("#div-create-keyword").prop('hidden', false);
    else if($windowKeywordsList[DIV_CREATE_KEYWORD] == HIDE) $("#div-create-keyword").prop('hidden', true);
   
    if($windowKeywordsList[DIV_KEYWORD_QUESTIONS] == DISPLAY) $("#div-keyword-questions").prop('hidden', false);
    else if($windowKeywordsList[DIV_KEYWORD_QUESTIONS] == HIDE) $("#div-keyword-questions").prop('hidden', true);
 
    $(".div-alert").html("");
}
*/

/*
$("#bt-giveup-create-keyword").click(function(){
    // HIDE, DISPLAY, NOMOVE
    $windowKeywordsList[BT_CREATE_KEYWORD] = DISPLAY;
    $windowKeywordsList[DIV_CREATE_KEYWORD] = HIDE;
    $windowKeywordsList[DIV_KEYWORD_QUESTIONS] = NOMOVE;
    configureWindowKeywordsList();
});

$("#xxxxxxx").click(function(){
    // HIDE, DISPLAY, NOMOVE
    $windowKeywordsList[BT_CREATE_KEYWORD] = xxxx;
    $windowKeywordsList[DIV_CREATE_KEYWORD] = xxxx;
    $windowKeywordsList[DIV_KEYWORD_QUESTIONS] = xxxx;
    configureWindowKeywordsList();
});
*/


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
//alert ("widget avant calcul : "+widget);
    switch(widget){
        case'radio':
            quizNbanswersaskedNames++;
        break;
        case'checkbox':
            var nbinputs = document.getElementsByClassName((numQuestion).toString()).length;
//alert ("nbinputs checkbox : "+nbinputs);
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
            break;

            case'last':
                hideQuestions();
                
                cumulateQuizNbanswersaskedNames(numQuestion);
                
                //udate information before submitting the form
                $("#quizMaxnbquest").val(nbQuestions);
                $("#quizNbquestasked").val(numQuestion+1);
                $("#quizEnddate").val(Math.round(Date.now()/1000)); //the curent date in seconds
                $("#quizNbanswersaskedNames").val(parseInt(quizNbanswersaskedNames));

                //submit the form
                $("#form_taken_quiz").submit();
                
            break;
        }
    }
);

