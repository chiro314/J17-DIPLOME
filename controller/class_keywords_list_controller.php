<?php
/*****************************************************************************************
* Object:      class class_keywords_list_controller
* admin/user:  admin
* Scope:	   keywords
* 
* Feature 1 (maquette): Consult the list of your keywords (maq-27) : View each keyword and the number of questions using it, with Supp. And Maj links for each keyword.
* Trigger:              index.php/$_REQUEST: "keyword/list"
*
* Feature 2 (maquette): Delete a keyword (maq-28)
* Trigger:              div_keywords_list.php/div to Delete a keyword/button "Envoyer"/form_delete_keyword
*
* Feature 3 (maquette): Create a keyword (maq-29)
* Trigger:              div_keywords_list.php/div to Create a keyword/button "Envoyer"/form_creaate_keyword
*
* Feature 4 (maquette): Update a keyword (maq-30)
* Trigger:              div_keywords_list.php/div to Update a keyword/button "Envoyer"/form_update_keyword
*
* Major tasks:  get data to display all the keywords, 
*               get keywords questions lists to know the questions using a keyword,
*               check exists, delete, create, update a keyword.
* Use:  class class_keywords_list (cf. class_keywords_list.php)
*       and the screen view/div_keywords_list.php
*******************************************************************************************/

class class_keywords_list_controller {

    private $keywords_list;  

    public function __construct($login)
    {
        $this->keywords_list = new class_keywords_list($login);
    }

    public function displayAll(){
        $keywordsList = $this->keywords_list->getKeywords();
        $KeywordsQuestionsList = $this->keywords_list->getKeywordsQuestionsList();
        $title = "Liste de vos mots clés";
        include "view/div_keywords_list.php";
    }
    public function checkExists($keyword, $login){
        return $this->keywords_list->checkExists($keyword, $login);
    }
    
    public function create($keyword, $login){
        $this->keywords_list->create($keyword, $login);
    }
    public function deleteKeyword($keywordid){
    
        $this->keywords_list->deleteKeyword($keywordid);
    }
    public function updateKeyword($keywordid, $newkeyword){
    
        $this->keywords_list->updateKeyword($keywordid, $newkeyword);
    }


    public function getKeywordsQuestionsList() 
    {
        return $this->keywords_list->getKeywordsQuestionsList();
    }
}