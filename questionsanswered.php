<?php
//http://localhost/exo/J17-DIPLOME/tests-v1-ok.php

/*
form_taken_quiz (3 questions en dur, idem BDD)

	<input type="hidden" name="quizMaxnbquest" value="3">
	<input type="hidden" name="quizNbquestasked" value="3"> <!--JS-->  Nb de fois qu'on a appuyé sur le bouton "Question suivante"
	<input type="hidden" name="quizMaxnbanswersNames" value="5">
	<input type="hidden" name="quizNbanswersaskedNames" value="5"> <!--JS-->   les name des réponses sont des num

if (isset($_POST['form_taken_quiz']) and $_POST['form_taken_quiz'] ==1)
	1) checked answers of answered questions (1) 						            : $questionsAnswersChecked (W - Q - A)
	2) Récupérer toutes les W-Q posées (2) 							                : $questionsasked (W - Q)
	3) En déduire les W-Q-0 sans réponses (=non cliqué) (2) - (1) = > (3) 			: $questionsaskedWithoutanswer (W - Q - 0)
	4)Constituer le tableau $questionsAnswersResults des W-Q-A/0 (1) + (3) = (4) 	: $questionsAnswers (W - Q - A/0)			var_dump

	
	1) liste des questions traitées								                    : $questionsAnswered (W - Q)
	2) BDD : SELECT liste des réponses correctes aux questions traitées		        : $select (W - Q - A)
	3) Se baser sur $select pour déterminer la justesse des réponses de 		    : $questionsAnswers (W - Q - A/0 - dqrOKKO)
	4) Built the questions okko array :								                : $questionsAnswered (W - Q - dqrOKKOQUESTION)
	5) For the ok questions, check there is not an additional answer in $select 
											                        witch is not in	: $questionsAnswered (W - Q - dqrOKKOQUESTION)    var_dump
*/

/*Define Questions Results
const dqrWIDGETID = 0, dqrQUESTIONID = 1, dqrANSWERID = 2, dqrOKKO = 3;
const dqrOKKOQUESTION = 2;
*/

/////////////////////////////////////////////////////////////////////////////////////
  
    //Récupérer toutes les W-Q-A cochées (1) : isset
    //Récupérer toutes les W-Q posées (2)
    //En déduire les W-Q-0 sans réponses (2) - (1) = > (3)
    //Constituer le tableau $questionsAnswersResults des W-Q-A/0 (1) + (3) = (4)

    //1) list the checked answers of the answered questions (1) :

    $questionsAnswersChecked = null;
    $ia=0;
    for($i=0;$i<$_POST['quizNbanswersaskedNames'];$i++){

        //Récupérer toutes les W-Q-A cochées (1) :
        if (isset($_POST[strval($i)])){  //$i : input name (radio or box)
            
            $questionsAnswersChecked[$ia][dqrWIDGETID] = prefix($_POST[strval($i)]);
            $questionsAnswersChecked[$ia][dqrQUESTIONID] = root($_POST[strval($i)]);
            $questionsAnswersChecked[$ia][dqrANSWERID] = suffix($_POST[strval($i)]);

            $ia++;
        }
    }

    //2) Récupérer toutes les W-Q posées (2)
    $questionsasked = null;
    for($i=0;$i<$_POST['quizNbquestasked'];$i++){
        $questionsasked[$i][dqrWIDGETID] = prefix($_POST['question-'.$i]);
        $questionsasked[$i][dqrQUESTIONID] = theEnd($_POST['question-'.$i]);
        $questionsasked[$i][dqrANSWERID] = strval(0);
    }

    if($questionsasked == null) $questionsAnswers = null;
    else{
        //3) En déduire les W-Q-0 sans réponses (2) - (1) = > (3)
        
        if($questionsAnswersChecked == null) $questionsAnswers = $questionsasked;
        else {
            $questionsaskedWithoutanswer = null;
            $iWa = 0;
            for($i=0;$i<$_POST['quizNbquestasked'];$i++){
                if( !inQuestionsAnswersChecked($questionsasked[$i][dqrQUESTIONID]) ){

                    $questionsaskedWithoutanswer[$iWa][dqrWIDGETID] = $questionsasked[$i][dqrWIDGETID];
                    $questionsaskedWithoutanswer[$iWa][dqrQUESTIONID] = $questionsasked[$i][dqrQUESTIONID];
                    $questionsaskedWithoutanswer[$iWa][dqrANSWERID] = strval(0);

                    $iWa++;
                }  
            }
            //4) Constituer le tableau $questionsAnswersResults des W-Q-A/0 (1) + (3) = (4)
            if($questionsaskedWithoutanswer == null) $questionsAnswers = $questionsAnswersChecked;
            else $questionsAnswers = array_merge($questionsAnswersChecked, $questionsaskedWithoutanswer);
        }
    }
    //var_dump($questionsAnswers);

    //BDD////////////////////////////////////////////////////////////////////
    //test:
    //$questionsAnswers = [['checkbox', '2', '4'],
    //                    ['radio', '1', '0']];
    // Pour trier : (abandonné)
    //  $widget  = array_column($questionsAnswers, 'volume');
    //  $edition = array_column($questionsAnswers, 'edition');
    // https://www.php.net/manual/fr/function.array-multisort.php
    

    //1)liste des questions traitées 
    //test :
    //$questionsAnswered = [
    //    ['checkbox', '2'],
    //    ['radio', '1',]
    //];
    
    function alreadyListed($questionid){
        global $questionsAnswered;
        for ($i=0;$i<count($questionsAnswered);$i++){
            if($questionsAnswered[$i][dqrQUESTIONID] == $questionid) return true;
        }
        return false;
    }
    $questionsAnswered=[];
    $iq=0;
    $iStop= $questionsAnswers == null ? 0 : count($questionsAnswers);///
    for ($i=0;$i<$iStop;$i++){ ///
        if (!alreadyListed ($questionsAnswers[$i][dqrQUESTIONID])) {
            $questionsAnswered[$iq][dqrWIDGETID] = $questionsAnswers[$i][dqrWIDGETID] ;
            $questionsAnswered[$iq][dqrQUESTIONID] = $questionsAnswers[$i][dqrQUESTIONID] ;
            $iq++;
        }
    }
  
    
    //1bis) => "1,2" => 
    //2)   SELECT question_idwidget, question_id , answer_id 
        // FROM question, answer WHERE answer_idquestion = question_id AND answer_status = 'inline' AND answer_ok = 1
        // AND question_id IN (1,2) SORT BY question_id , answer_id =>
    //test:
    //$select = [ 
    //    ['radio', 1, 1],
    //    ['checkbox', 2, 4],
    //    ['checkbox', 2, 5]
    //

    require "model/connexionbdd.php";

    $inQuestions = "";
    for($i=0;$i<count($questionsAnswered);$i++){
        $inQuestions.= $questionsAnswered[$i][dqrQUESTIONID].",";
    }
    $inQuestions = substr($inQuestions, 0, -1); //get the last ',' away

    //TEST:
    $select = null;

    $sql = "SELECT question_idwidget, question_id , answer_id FROM question, answer";
    $sql.= " WHERE answer_idquestion = question_id AND answer_status = 'inline' AND answer_ok = 1";
    $sql.= " AND question_id IN (".$inQuestions.") ORDER BY question_id , answer_id";
   
    $result = $conn->query($sql);
    if($result != null){ ///
        $i=0;
        while($row = $result->fetch_assoc()){
            $select[$i][dqrWIDGETID] = $row['question_idwidget'];
            $select[$i][dqrQUESTIONID] = $row['question_id'];
            $select[$i][dqrANSWERID] = $row['answer_id'];

            $i++;
        }
    }
    ////TEST: Si uniquement question(s) checkbox, sans « bonne réponse » définie
    if($select == null){
        for($i=0;$i<count($questionsAnswered);$i++){
            $select[$i][dqrWIDGETID] = 'checkbox';
            $select[$i][dqrQUESTIONID] = $questionsAnswered[$i][dqrQUESTIONID];
            $select[$i][dqrANSWERID] = '0';
        }
    }

    //3) Comparer les 2 listes pour déterminer la justesse des réponses
    //cible : $questionsOkko (W, Q, dqrOKKO) = [['radio', 1, 0], ['checkbox', 2, 0]]
    //$questionsAnswers = [['checkbox', '2', '4'], ['radio', '1', '0']];
    
    function compare($questionAnswer, $select){
        //$finded = false;
        for($i=0;$i<count($select);$i++){
            
            if( $select[$i][dqrQUESTIONID] == $questionAnswer[dqrQUESTIONID] and
                $select[$i][dqrANSWERID] == $questionAnswer[dqrANSWERID] ) {
                    return 'equal';
            }
        }
        return 'notfound';
    }
    $iStop= $questionsAnswers == null ? 0 : count($questionsAnswers);///
    for($i=0;$i<$iStop;$i++){ ///
        switch($questionsAnswers[$i][dqrWIDGETID]){
            case 'radio':
                switch(compare($questionsAnswers[$i], $select)){
                    case 'equal' : 
                        $questionsAnswers[$i][dqrOKKO]= strval(1);
                    break;
                    default : //'notfound'
                        $questionsAnswers[$i][dqrOKKO]= strval(0);
                    break;
                }
            break;
            case 'checkbox':
                switch(compare($questionsAnswers[$i], $select)){
                    case 'equal' : 
                        $questionsAnswers[$i][dqrOKKO]= strval(1);
                    break;
                    default: // 'notfound'
                        if ($questionsAnswers[$i][dqrANSWERID] == 0) {
                            $questionsAnswers[$i][dqrOKKO]=1;
                        }
                        else $questionsAnswers[$i][dqrOKKO]= strval(0);
                    break;
                }
            break;
        }
    }

    //4) Built the questions dqrOKKOQUESTION array :    
    for($i=0;$i<count($questionsAnswered);$i++){
        $questionsAnswered[$i][dqrOKKOQUESTION] = '1';
        for($j=0;$j<count($questionsAnswers);$j++){
            if($questionsAnswers[$j][dqrQUESTIONID] == $questionsAnswered[$i][dqrQUESTIONID] and $questionsAnswers[$j][dqrOKKO] == '0'){
                $questionsAnswered[$i][dqrOKKOQUESTION] = '0';
                break;
            }
        }
    }

    //5) For the checkbox ok questions, check there is not an additional answer in $select (witch is not in $questionsAnswers) :
    function answersForgotten($questionid){
        global $questionsAnswers, $select;

        for($i=0;$i<count($select);$i++){
            if($select[$i][dqrQUESTIONID] == $questionid and $select[$i][dqrWIDGETID] == 'checkbox'){
                $finded = false;
                for($j=0;$j<count($questionsAnswers);$j++){

                    if($questionsAnswers[$j][dqrQUESTIONID] ==  $select[$i][dqrQUESTIONID] and 
                       $questionsAnswers[$j][dqrANSWERID] ==  $select[$i][dqrANSWERID]  ){
                        $finded = true;
                        break;
                    }
                }
                if(!$finded) return true; //answer has been forgotten
            }
        }
        return false;
    }
    for($i=0;$i<count($questionsAnswered);$i++){
        if($questionsAnswered[$i][dqrOKKOQUESTION] == 1 and $questionsAnswered[$i][dqrWIDGETID] == 'checkbox'){
            if(answersForgotten($questionsAnswered[$i][dqrQUESTIONID])) {
                $questionsAnswered[$i][dqrOKKOQUESTION] =  '0';
            }
        }
    }

