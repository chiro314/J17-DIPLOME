<?php
/*****************************************************************************************
* Object:      class class_keywords_list
* admin/user:  admin
* Scope:	   keywords
* 
* Feature 1 (maquette): Consult the list of your keywords (maq-27) : View each keyword and the number of questions using it, with Supp. And Maj links for each keyword.
* Trigger:              index.php/$_REQUEST: "keyword/list" / class class_keywords_list_controller (class_keywords_list_controller.php)
*
* Feature 2 (maquette): Delete a keyword (maq-28)
* Trigger:              div_keywords_list.php/div to Delete a keyword/button "Envoyer"/form_delete_keyword / class class_keywords_list_controller (class_keywords_list_controller.php)
*
* Feature 3 (maquette): Create a keyword (maq-29)
* Trigger:              div_keywords_list.php/div to Create a keyword/button "Envoyer"/form_creaate_keyword / class class_keywords_list_controller (class_keywords_list_controller.php)
*
* Feature 4 (maquette): Update a keyword (maq-30)
* Trigger:              div_keywords_list.php/div to Update a keyword/button "Envoyer"/form_update_keyword / class class_keywords_list_controller (class_keywords_list_controller.php)
*
* Major DB operations :  get data of all the keywords, 
*               get keywords questions lists to know the questions using a keyword,
*               check exists, delete, create, update a keyword.
*******************************************************************************************/

//https://fr.tuto.com/blog/2021/01/php-foreach-tableau.htm# 

class class_keywords_list {

    private $keywords_list;

    private $keywords_questions_list;
  

    private const KEYWORDID = 0, KEYWORD = 1, COUNTQUESTIONS = 2; 
    //private const QUESTION = 1;
    private const kqQUESTION  =0, kqKEYWORDID = 1;

    public function __construct($login){

        global $conn;
        
        //$keywords_questions_list :

        $sql = "(SELECT y.keyword_id, y.keyword_word, COUNT(*) AS count FROM";
        $sql.= " (SELECT keyword_id, keyword_word, question_keyword_idkeyword";
        $sql.= " FROM keyword LEFT JOIN question_keyword ON question_keyword_idkeyword = keyword_id";
        $sql.= " WHERE keyword_loginadmin = '$login' AND question_keyword_idkeyword IS NOT NULL) AS y";
        $sql.= " GROUP BY y.keyword_id )";
        $sql.= " UNION";
        $sql.= " (SELECT keyword_id, keyword_word, question_keyword_idkeyword";
        $sql.= " FROM keyword LEFT JOIN question_keyword ON question_keyword_idkeyword = keyword_id";
        $sql.= " WHERE keyword_loginadmin = '$login' AND question_keyword_idkeyword IS NULL )";

        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
            
            $i=0;
            while($row = $result->fetch_assoc()){
                    $this->keywords_list[$i][self::KEYWORDID] = $row['keyword_id'];
                    $this->keywords_list[$i][self::KEYWORD] = $row['keyword_word'];
                    
                    if($row['count'] == null) $this->keywords_list[$i][self::COUNTQUESTIONS] = '0';
                    else $this->keywords_list[$i][self::COUNTQUESTIONS] = $row['count'];

                    $i++;
            }

            $this->constructKeywordsQuestionsList($login);

            return $this->keywords_list;
        }
        else return null;
    }

    private function constructKeywordsQuestionsList($login){  //construct $keywords_questions_list :

        global $conn;

        $sql = "SELECT question_question, question_id, question_keyword_idkeyword";
        $sql.= " FROM question_keyword";
        $sql.= " LEFT JOIN question ON question_id = question_keyword_idquestion";
        $sql.= " LEFT JOIN keyword ON keyword_id = question_keyword_idkeyword";
        $sql.= " WHERE keyword_loginadmin = '$login'";
        $sql.= " ORDER BY question_id"; //question_lastmodificationdate DESC";

        $result = $conn->query($sql);

        if($result != null){ // null when the table is empty
            
            //$keywords_questions_list = [ [Q1, [K1, K2]], [Q2, [K2, K4, K7]]... ]
            $questionId = 0;
            $iq=-1; //question index
            while($row = $result->fetch_assoc()){
                if($row['question_id'] != $questionId){ //new question
                    $questionId = $row['question_id'];
                    $iq++;
                    $this->keywords_questions_list[$iq][self::kqQUESTION] = $row['question_question'];
                }
                $this->keywords_questions_list[$iq][self::kqKEYWORDID][] = $row['question_keyword_idkeyword']; 
            }
        }
    }

    public function getKeywords() 
    {
        return $this->keywords_list;
    }
    public function checkExists($keyword, $login){
        global $conn;
        $sql = "SELECT COUNT(keyword_word) AS compteur FROM keyword";
        $sql.= " WHERE keyword_loginadmin = '$login' AND keyword_word = '$keyword'";
        $result = $conn->query($sql); 
        $row = $result->fetch_assoc();
        return $row["compteur"];
    }
    public function create($keyword, $login){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO keyword (keyword_loginadmin, keyword_word) VALUES (?, ?)");
        $stmt -> bind_param("ss", $login, $keyword); 
        $stmt ->execute();
        $stmt -> close();
    }
    public function updateKeyword($keywordid, $newkeyword){
        global $conn, $login;
        
        $stmt = $conn->prepare("UPDATE keyword SET keyword_word=? WHERE keyword_id =?");
        $stmt -> bind_param("si", $newkeyword, $keywordid); 
        $stmt ->execute();
        $stmt -> close();
    }
    public function deleteKeyword($id){
        global $conn;
        $sql = "DELETE from keyword WHERE keyword_id = $id";
        $conn->query($sql);
    }
    public function getKeywordsQuestionsList() 
    {
        return $this->keywords_questions_list;
    }
}