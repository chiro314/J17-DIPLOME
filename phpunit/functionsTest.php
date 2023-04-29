<?php
//require "functions.php";
require "../Users/chris/OneDrive/Documents/GitHub/J17-DIPLOME/functions.php";
use PHPUnit\Framework\TestCase;
class functionsTest extends TestCase{
    
    //1
    public function testTimeusedpercent(){
        //return (100 * round($durationInSec / (60 * $quizMaxDuration), 2));
        $result = timeusedpercent(60, 2);
        $this->assertEquals(50, $result);
        $this->assertNotEquals(60, $result);
        $result = timeusedpercent(181, 3);
        $this->assertEquals(101, $result);
    }
    //2
    public function testSec_into_h_m_s(){
        //sec_into_h_m_s($format, $sec); //'h:m:s' et default
        $result = sec_into_h_m_s('h:m:s', 60);
        $this->assertEquals('0:1:0', $result);
        $result = sec_into_h_m_s('', 60);
        $this->assertEquals('00:01:00', $result);
        $result = sec_into_h_m_s('h:m:s', 61);
        $this->assertEquals('0:1:1', $result);
        $result = sec_into_h_m_s('', 3600);
        $this->assertEquals('01:00:00', $result);
    }
    //3
    public function testSecHoursMinSec(){
        //secondes into secondes or into minutes + secondes or into hours + minutes + secondes
        $result = secHoursMinSec(59);
        $this->assertEquals('59 secondes', $result);
        $result = secHoursMinSec(60);
        $this->assertEquals('1 minute', $result);
        $result = secHoursMinSec(61);
        $this->assertEquals('1 minute et 1 seconde', $result);
        /*
        1) functionsTest::testSecHoursMinSec
        Failed asserting that two strings are equal.
        --- Expected
        +++ Actual
        @@ @@
        -'1 minute et 1 seconde'
        +'1 minute et 1 secondes' //singular needed
        */
        $result = secHoursMinSec(3661);
        $this->assertEquals('1 heure 1 minute et 1 seconde', $result);
        /*
        1) functionsTest::testSecHoursMinSec
        Failed asserting that two strings are equal.
        --- Expected
        +++ Actual
        @@ @@
        -'1 heure et 1 minute et 1 seconde'
        +'1 heure et 1 minutes et 1 seconde'
        */
        $result = secHoursMinSec(7261);
        $this->assertEquals('2 heures 1 minute et 1 seconde', $result);
        $result = secHoursMinSec(7321);
        $this->assertEquals('2 heures 2 minutes et 1 seconde', $result);
        $result = secHoursMinSec(7322);
        $this->assertEquals('2 heures 2 minutes et 2 secondes', $result);
    }
    //4
    public function testTestNotEmpty(){
        $strsTransmises = ["", "coucou", 3];
        $result = testNotEmpty('Mon opération', $strsTransmises);
        $this->assertEquals("La 1ère zone obligatoire était vide. Mon opération n'a pas eu lieu.", $result);

        /*
        There was 1 failure:
        1) functionsTest::testTestNotEmpty
        Failed asserting that two strings are equal.
        --- Expected
        +++ Actual
        @@ @@
        -'La 1ère zone obligatoire était vide. Mon opération n'a pas eu lieu.'
        +'La  1ère zone obligatoire était vide. Mon opération n'a pas eu lieu.'
        */

        //$strsTransmises = ["coucou", "0"];
        $strsTransmises = ["coucou", "tout sauf '0'"];
        $result = testNotEmpty('Mon opération', $strsTransmises);
        $this->assertEquals("", $result);
        /*
        There was 1 failure:
        1) functionsTest::testTestNotEmpty
        Failed asserting that two strings are equal.
        --- Expected
        +++ Actual
        @@ @@
        -''
        +'La 2e zone obligatoire était vide. Mon opération n'a pas eu lieu.'
        Keep in mind empty() does't accept 0 nor "0" : empty() is essentially the concise equivalent to !isset($var) || $var == false.
        '', "", null, array(), FALSE, NULL, '0', 0, are all empty.
        */

        $strsTransmises = [];
        $result = testNotEmpty('Mon opération0', $strsTransmises);
        $this->assertEquals("", $result);

        $strsTransmises = ["coucou"];
        $result = testNotEmpty('Mon opération1', $strsTransmises);
        $this->assertEquals("", $result);
        
        $strsTransmises = [""];
        $result = testNotEmpty('Mon opération2', $strsTransmises);
        $this->assertEquals("La 1ère zone obligatoire était vide. Mon opération2 n'a pas eu lieu.", $result);
        /*
        --- Expected
        +++ Actual
        @@ @@
        -'La 1ère zone obligatoire était vide. Mon opération2 n'a pas eu lieu.'
        +'La  zone obligatoire était vide. Mon opération2 n'a pas eu lieu.'
        */
    }
    //5
    public function testTestStrsOnly(){
        $strsTransmises = ["coucou", "<br", 3];
        $result = testStrsOnly('Mon opération', $strsTransmises);
        $this->assertEquals("L'information de la 2e zone n'était pas valide.<br>Mon opération n'a pas eu lieu.", $result);
        
        $strsTransmises = ["coucou", "<br", ""];
        $result = testStrsOnly('Mon opération', $strsTransmises);
        $this->assertEquals("L'information de la 2e zone n'était pas valide.<br>Mon opération n'a pas eu lieu.", $result);
        
        $strsTransmises = ["", "coucou", 3];
        $result = testStrsOnly('Mon opération', $strsTransmises);
        $this->assertEquals("", $result);
        
        $strsTransmises = [""];
        $result = testStrsOnly('Mon opération3', $strsTransmises);
        $this->assertEquals("", $result);

        $strsTransmises = ["coucou", "br>", 3];
        $result = testStrsOnly('Mon opération', $strsTransmises);
        $this->assertEquals("", $result);
    }  
    //6
    public function testTestStrs(){
        $strsTransmises = ["coucou", "<br", 3];
        $result = testStrs('Mon opération', $strsTransmises);
        $this->assertEquals("L'information de la 2e zone n'était pas valide.<br>Mon opération n'a pas eu lieu.", $result);
        
        $strsTransmises = ["", "<br", 3];
        $result = testStrs('Mon opération', $strsTransmises);
        $this->assertEquals("L'information de la 2e zone n'était pas valide.<br>Mon opération n'a pas eu lieu.", $result);
        
        $strsTransmises = ["<", "coucou", 3];
        $result = testStrs('Mon opération', $strsTransmises);
        $this->assertEquals("L'information de la 1ère zone n'était pas valide.<br>Mon opération n'a pas eu lieu.", $result);
        
        $strsTransmises = ["coucou", "br>", 3];
        $result = testStrs('Mon opération', $strsTransmises);
        $this->assertEquals("", $result);

        $strsTransmises = ["", "br", 3];
        $result = testStrs('Mon opération5', $strsTransmises);
        $this->assertEquals("La 1ère zone obligatoire était vide. Mon opération5 n'a pas eu lieu.", $result);
        /*
        --- Expected
        +++ Actual
        @@ @@
        -'La 1ère zone obligatoire était vide. Mon opération5 n'a pas eu lieu.'
        +'La 1ère zone était vide. Mon opération5 n'a pas eu lieu.'
        */

        $strsTransmises = [""];
        $result = testStrs('Mon opération6', $strsTransmises);
        $this->assertEquals("La 1ère zone obligatoire était vide. Mon opération6 n'a pas eu lieu.", $result);
        /*
        --- Expected
        +++ Actual
        @@ @@
        -'La 1ère zone obligatoire était vide. Mon opération6 n'a pas eu lieu.'
        +'La  zone obligatoire était vide. Mon opération6 n'a pas eu lieu.'
        */

        $strsTransmises = ["<"];
        $result = testStrs('Mon opération7', $strsTransmises);
        $this->assertEquals("L'information de la 1ère zone n'était pas valide.<br>Mon opération7 n'a pas eu lieu.", $result);
        
    }    
    //7
    public function testClassName(){
        //Keep only the characters a-z, A-Z et 0-9 (else replace by '_') 
        $result = className(" 1_2-3>4 5$6a7z8A9Z   ");
        $this->assertEquals('c_1_2_3_4_5_6a7z8A9Z', $result);
    }
    //8
    public function testPrefix(){
        $result = prefix("préfixe-racine");
        $this->assertEquals("préfixe", $result);

        $result = prefix("-préfixe-racine");
        $this->assertEquals("", $result);
    }
    //9
    public function testTheEnd(){
        $result = theEnd("préfixe-racine-suffixe-");
        $this->assertEquals("racine-suffixe-", $result);
    }
    //10
    public function testRoot(){
        //always returns only the field after the prefix
        $result = root("préfixe-racine-suffixe-");
        $this->assertEquals("racine", $result);

        $result = root("-préfixe-racine-suffixe-");
        $this->assertEquals("préfixe", $result);
    }
    public function testSuffix(){
        //always returns all after the root
        $result = suffix("préfixe-racine-suffixe1-suffixe2-");
        $this->assertEquals("suffixe1-suffixe2-", $result);

        $result = suffix("-préfixe-racine-suffixe1-suffixe2-");
        $this->assertEquals("racine-suffixe1-suffixe2-", $result);
    }
}