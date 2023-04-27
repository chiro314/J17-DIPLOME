<?php
/*****************************************************************************************
* Object:      class class_questions_list
* admin/user:  admin
* Scope:	   question
* 
* Feature (maquette): Consult the list of your questions (maq-24) : get data for each question, with Supp. and Maj Links for each question.
* Trigger 1 : index.php/$_REQUEST: "question/list" / class class_questions_list_controller (class_questions_list_controller.php)
* Trigger 2 : index.php/$_REQUEST: "quiz/update" / class_quiz_controller (class_quiz_controller.php)
*
* Major DB operations:  get data of all the questions, 
*                       get the keywords used by these questions (to filter on keywords)
*                       get all the keywords for the creation part of the div
*******************************************************************************************/

//https://fr.tuto.com/blog/2021/01/php-foreach-tableau.htm# 

class class_questions_list {

    private $questions_list;
    private $keywords_list;
    private $all_keywords_list;
  
    /*private const QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4, qKEYWORDID = 5;
    private const GUIDELINE = 6, EXPLANATIONTITLE = 7, EXPLANATION = 8;
    private const KEYWORDID = 0, KEYWORD = 1;
    */

    private const QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4,     qKEYWORDID = 8;
    private const GUIDELINE = 5, EXPLANATIONTITLE = 6, EXPLANATION = 7;
    private const KEYWORDID = 0, KEYWORD = 1;

    public function __construct($login){

        global $conn;
        
        $sql = "SELECT question_id, question_question, question_status, question_lastmodificationdate, question_idwidget,";
        $sql.= " question_keyword_idkeyword,";
        $sql.= " question_guideline, question_explanationtitle, question_explanation";
        $sql.= " FROM question LEFT JOIN question_keyword ON question_keyword_idquestion = question_id";
        $sql.= " WHERE question_loginadmin = '$login'";
        $sql.= " ORDER BY question_id DESC"; 

        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
           
            $questionId = 0;
            $iq=-1; //question index
            while($row = $result->fetch_assoc()){
                if($row['question_id'] != $questionId){ //new question
                    $questionId = $row['question_id'];

                    $iq++;
                    $this->questions_list[$iq][self::QUESTIONID] = $row['question_id'];
                    $this->questions_list[$iq][self::QUESTION] = $row['question_question'];
                    $this->questions_list[$iq][self::STATUS] = $row['question_status'];
                    $this->questions_list[$iq][self::LMDATE] = $row['question_lastmodificationdate'];
                    $this->questions_list[$iq][self::WIDGETID] = $row['question_idwidget'];

                    $this->questions_list[$iq][self::GUIDELINE] = $row['question_guideline'];
                    $this->questions_list[$iq][self::EXPLANATIONTITLE] = $row['question_explanationtitle'];
                    $this->questions_list[$iq][self::EXPLANATION] = $row['question_explanation'];
                }
                $this->questions_list[$iq][self::qKEYWORDID][] = $row['question_keyword_idkeyword'];   
            }

            //keywords for questions above
            $sql = "SELECT DISTINCT keyword_id , keyword_word";
            $sql.= " FROM question_keyword INNER JOIN keyword ON question_keyword_idkeyword = keyword_id";
            $sql.= " WHERE keyword_loginadmin = '$login'";
            $sql.= " ORDER BY keyword_word ASC"; 
            $result0 = $conn->query($sql);

            $this->keywords_list[0][self::KEYWORDID] = 0;
            $this->keywords_list[0][self::KEYWORD] = 'Aucun';

            if($result0 != null){
                $i=1;
                while($row = $result0->fetch_assoc()){ 
                    $this->keywords_list[$i][self::KEYWORDID] = $row['keyword_id'];
                    $this->keywords_list[$i][self::KEYWORD] = $row['keyword_word'];

                    $i++;
                }
            }
        }

        //Get all keywords for the question creation window :
        $sql = "SELECT keyword_id , keyword_word FROM keyword";
        $sql.= " WHERE keyword_loginadmin = '$login'";
        $sql.= " ORDER BY keyword_word ASC"; 
        $result0 = $conn->query($sql);

        if($result0 != null){
            $i=1;
            while($row = $result0->fetch_assoc()){ 
                $this->all_keywords_list[$i][self::KEYWORDID] = $row['keyword_id'];
                $this->all_keywords_list[$i][self::KEYWORD] = $row['keyword_word'];

                $i++;
            }
        }
    }

    public function getQuestions() 
    {
        return $this->questions_list;
    }
    public function getKeywords() 
    {
        return $this->keywords_list;
    }
    public function getAllKeywords() 
    {
        return $this->all_keywords_list;
    }

}

