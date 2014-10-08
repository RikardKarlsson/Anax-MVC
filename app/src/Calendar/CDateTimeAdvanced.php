<?php
namespace RikardKarlsson\Calendar;
class CDateTimeAdvanced extends \DateTime {
    
    /**
     * @return 1, 2, ..., or 31
     */
    private function getDay() {
        return $this->format("j");
    }
    /**
     * @return 1, 2, ... or 7
     */
    private function getDayNo() {
        return $this->format("N");
    }
    /**
     * @return 1, 2, ... or 12
     */
    public function getMonth() {
        return $this->format("n");
    }
    /**
     * @return i.e. 1999 
     */
    public function getYear() {
        return $this->format("Y");
    }
    /**
     * @return 
     */
    public function getMonthName() {
        $array = array (1 => "Januari", 
                                2 => "Februari", 
                                3 => "Mars",
                                4 => "April",
                                5 => "Maj",
                                6 => "Juni",
                                7 => "Juli",
                                8 => "Augusti",
                                9 => "September",
                                10 => "Oktober",
                                11 => "November",
                                12 => "December");;
        return $array[$this->getMonth()];                
    }
    /**
     * @param $dayNo 1 is monday ... 7 is sunday
     */
    public function getDayName() {
        $array = array(1 => "Måndag", 
                            2 => "Tisdag", 
                            3 => "Onsdag", 
                            4 => "Torsdag", 
                            5 => "Fredag", 
                            6 => "Lördag", 
                            7 => "Söndag");
        return $array[$this->getDayNo()];  
    }
    /**
     * Med allmän helgdag avses i lag eller annan författning
     * 
     * söndagar, däribland påskdagen och pingstdagen,
     * 
     * nyårsdagen, trettondedag jul, första maj, juldagen och annandag jul, 
     * även när de inte infaller på en söndag,
     * 
     * långfredagen, annandag påsk, Kristi himmelsfärdsdag, nationaldagen, 
     * midsommardagen och alla helgons dag. Lag (2004:1320).  
     *
     *  * Allmänna helgdagar i Sverige (source: https://lagen.nu/1989:253)
     * nyårsdagen    den 1 januari
     * trettondedag jul     den 6 januari
     * långfredagen     fredagen närmast före påskdagen
     * påskdagen    söndagen närmast efter den fullmåne som infaller på eller närmast efter den 21 mars
     * annandag påsk    dagen efter påskdagen
     * Kristi himmelsfärdsdag   sjätte torsdagen efter påskdagen //4 + 5 * 7 = 39
     * pingstdagen  sjunde söndagen efter påskdagen
     * nationaldagen    den 6 juni
     * midsommardagen den 20-26 juni    den lördag som infaller under tiden
     * alla helgons dag     den lördag som infaller under tiden den 31 oktober-6 november
     * juldagen     den 25 december
     * annandag jul Lag (2004:1320).    den 26 december.
     * 
     */
     public function getRedDayName() {
         $year = $this->getYear();
         $month = $this->getMonth();
         $day = $this->getDay();
         $easterDate = new CDateTimeAdvanced();
         $easterDate->setDate($year, 3, 21);
         $daysForward = easter_days($year);
         $easterDate->modify("+{$daysForward} days");
         if ( $month == 1 ) {
             if ( $day == 1 ) {
                 return "Nyårsdagen";
             }
             else if ( $day == 6 ) {
                 return "Trettondedag jul";
             }
         }
         //var_dump($this->diff($easterDate)->d);
         $easterDate->modify("-2 days");
         if ( $this->getMonth() == $easterDate->getMonth() ) {
             if ( $this->getDay() == $easterDate->getDay() ) {
                 return "Långfredagen";
             }
         }
         $easterDate->modify("+2 days");
         if ( $this->getMonth() == $easterDate->getMonth() ) {
             if ( $this->getDay() == $easterDate->getDay() ) {                
                 return "Påskdagen";
             }
         }
         $easterDate->modify("+1 days");
         if ( $this->getMonth() == $easterDate->getMonth() ) {
             if ( $this->getDay() == $easterDate->getDay() ) {
                 return "Annandag påsk";
             }                      
         }
         $easterDate->modify("-1 days");
         $ascensionDate = $easterDate->modify("+39 days");
         if ( $this->getMonth() == $ascensionDate->getMonth() && $this->getDay() == $ascensionDate->getDay() ) {
             return "Kristi himmelsfärdsdag";
         }
         if ( $month == 5 && $day == 1) {
             return "Första maj";
         }
         $pentocostDate = $easterDate->modify("+10 days");
         if ( $this->getMonth() == $pentocostDate->getMonth() && $this->getDay() == $pentocostDate->getDay() ) {
             return "Pingstdagen";
         }
         
         if ( $month == 6 ) {
             if ( $day == 6 ) {
                 return "Nationaldagen";
             }
             if ( 20 <= $day && $day <= 26 && $this->getDayNo() == 6 ) {
                 return "Midsommardagen";
             }
         }
         if ( $month == 10 && $day == 31 && $this->getDayNo() == 6  ) {
             return "Alla helgons dag";
         }
         else if ( $month == 11 ) {
             if ( 1 <= $day && $day <= 6 &&  $this->getDayNo() == 6  ) {
                 return "Alla helgons dag";
             }
         }
         if ( $month == 12 ) {
             if ( $day == 25 ) {
                 return "Juldagen";
             }
             else if ( $day == 26 ) {
                 return "Annandag jul";
             }
         } 
         return "";
     }
    public function isRedDay() {
        if ( $this->getDayNo() == 7 ) {
            return TRUE;
        }
        if ( $this->getRedDayName() )    {
            return TRUE; //there is a name
        } 
        return FALSE; //there is no name
    }
    /**
     *  * Allmänna flaggdagar i Sverige (Source: https://lagen.nu/1982:270):
     * nyårsdagen 
     * den 28 januari; Konungens namnsdag 
     * den 12 mars; Kronprinsessans namnsdag 
     * påskdagen 
     * den 30 april; Konungens födelsedag 
     * den 1 maj 
     * pingstdagen 
     * den 6 juni; 
     * Sveriges nationaldag och svenska flaggans dag 
     * midsommardagen 
     * den 14 juli; Kronprinsessans födelsedag 
     * den 8 augusti; Drottningens namnsdag 
     * dag för val i hela riket till riksdagen 
     * den 24 oktober; FN-dagen 
     * den 6 november; Gustav Adolfsdagen 
     * den 10 december; Nobeldagen 
     * den 23 december; Drottningens födelsedag 
     * juldagen.  
     * 
     */
     public function isFlagDay() {
         $year = $this->getYear();
         $month = $this->getMonth();
         $day = $this->getDay();
         $easterDate = new CDateTimeAdvanced();
         $easterDate->setDate($year, 3, 21);
         $daysForward = easter_days($year);
         $easterDate->modify("+{$daysForward} days");
         
         if ( $month == 1 ) {
             //Nyårsdagen
             if ( $day == 1 ) {
                 return TRUE;
             }
             //den 28 januari; Konungens namnsdag
             else if ( $day == 28 ) {
                 return TRUE;
             }
         }
         //den 12 mars; Kronprinsessans namnsdag
         if( $month == 3 && $day == 12 ) {
             return TRUE;
         }
         //Påskdagen;
         if ( $this->getMonth() == $easterDate->getMonth() && $this->getDay() == $easterDate->getDay() ) {
             return TRUE;    
         }
         //den 30 april; Konungens födelsedag
         if( $month == 4 && $day == 30 ) {
             return TRUE;
         }

         //Första maj
         if ( $month == 5 && $day == 1) {
             return TRUE;
         }
         $pentocostDate = $easterDate->modify("+49 days");
         //$testDate = new DateTime();
         //$testDate->setDate($year, $month, $day);
         //var_dump($testDate->diff($pentocostDate)->s);
         //Pingstdagen
         if ( $this->getMonth() == $pentocostDate->getMonth() && $this->getDay() == $pentocostDate->getDay() ) {
             return TRUE;
         }
         
         if ( $month == 6 ) {
             //Nationaldagen
             if ( $day == 6 ) {
                 return TRUE;
             }
             //Midsommardagen
             if ( 20 <= $day && $day <= 26 && $this->getDayNo() == 6 ) {
                 return TRUE;
             }
         }
         //den 14 juli; Kronprinsessans födelsedag
         if ( $month == 7 && $day == 14) {
             return TRUE;
         }
         //den 8 augusti; Drottningens namnsdag
         if ( $month == 8 && $day == 8) {
             return TRUE;
         }
         //den 24 oktober; FN-dagen 
         if ( $month == 10 && $day == 24) {
             return TRUE;
         }
         //den 6 november; Gustav Adolfsdagen 
         if ( $month == 11 && $day == 6) {
             return TRUE;
         }
         //den 10 december; Nobeldagen 
         if ( $month == 12 && $day == 10) {
             return TRUE;
         }
         //den 23 december; Drottningens födelsedag 
         if ( $month == 12 && $day == 23) {
             return TRUE;
         }
         //juldagen.         
         if ( $month == 12 && $day == 25) {
             return TRUE;
         } 
         return "";
         
     }
     
    /**
     * synodic month length: 29.530588853 days source: http://en.wikipedia.org/wiki/Month
     *  29 days + 12 hours +44 min +2.8678992 sec
     *  29 days + 45842.8769 sec
     *  2551442.877 sec
     * 
     * full moon time: Thursday, 16 January 2014, 05:52:12 am in Central European
     * Time (CET) or Central European Summer Time (CEST), same time as in Sweden.
     * 
     */
     public function isFullMoon() {         
         $moonTurnSec = 2551443;
         $date = new CDateTimeAdvanced();
         $date ->setDate(2014, 1, 16);
         $date ->setTime(5, 52, 12);     
         return $this->isSameMoonPhase($date);
     }
     public function isFirstQuaterMoon() {
         $moonTurnSec = 2551443; //TODO constant
         $quaterMoonTurnSec = 637861;//TODO constant
         $date = new CDateTimeAdvanced();
         $date ->setDate(2014, 1, 16);
         $date ->setTime(5, 52, 12);    
         $date->modify("-{$quaterMoonTurnSec} seconds"); 
         return $this->isSameMoonPhase($date);        
     }
     
     public function isLastQuaterMoon() {
         $moonTurnSec = 2551443;
         $quaterMoonTurnSec = 637861;
         $date = new CDateTimeAdvanced();
         $date ->setDate(2014, 1, 16);
         $date ->setTime(5, 52, 12);     
         $date->modify("+{$quaterMoonTurnSec} seconds"); 
         return $this->isSameMoonPhase($date);         
     }
     /**
      * @param $date i.e. the date of full moon or first quater moon ...
      */
     private function isSameMoonPhase(CDateTimeAdvanced $date) {
         $moonTurnSec = 2551443;
         if ( $this->isSameDate($date) ) {
             return TRUE;
         }
         while ( $this->isEarlierDateThan( $date ) ) {
             $date->modify("-{$moonTurnSec} seconds");
             //var_dump($date);
             if ( $this->isSameDate($date) ) {
                 return TRUE;
             }
         }
         while ( $date->isEarlierDateThan( $this ) ) {
             $date->modify("+{$moonTurnSec} seconds");
             //var_dump($date);
             if ( $this->isSameDate($date) ) {
                 return TRUE;
             }             
         }
         return FALSE;                    
     }
     /**
     private function isSameDate(DateTime $otherDate) {
         $diffDate = $this->diff($otherDate);
         var_dump($diffDate->d);
         if ( $diffDate->y == 0 && 
             $diffDate->m == 0 &&
             $diffDate->d == 0 ) {
             return TRUE;          
         }
         return FALSE;
     }*/
     private function isSameDate(CDateTimeAdvanced $date) {
         if ( $this->getYear() == $date->getYear() &&
             $this->getMonth() == $date->getMonth() &&
             $this->getDay() == $date->getDay() ) {
             return TRUE;
         }
         return FALSE;
     }
     

     public function isEarlierDateThan(CDateTimeAdvanced $date) {
         if ( $this->getYear() < $date->getYear() ) {
             return TRUE;
         }
         if ( $this->getYear() == $date->getYear() && 
                $this->getMonth() < $date->getMonth()) {
             return TRUE;
         }
         if ( $this->getMonth() == $date->getMonth() &&
                $this->getDay() < $date->getDay() ) {
            return TRUE;      
         }
         return FALSE;
     }
     
     
     public function getNameDay() {
             $nameDay = array(
        array('',"", "Svea", "Alfred Alfrida", "Rut", "Hanna Hannele", "Kasper Melker Baltsar", "August Augusta", "Erland", "Gunnar Gunder", "Sigurd Sigbritt", "Jan Jannike", "Frideborg Fridolf", "Knut", "Felix Felicia", "Laura Lorentz", "Hjalmar Helmer", "Anton Tony", "Hilda Hildur", "Henrik", "Fabian Sebastian", "Agnes Agneta", "Vincent Viktor", "Frej Freja", "Erika", "Paul Pål", "Bodil Boel", "Göte Göta", "Karl Karla", "Diana", "Gunilla Gunhild", "Ivar Joar"),
        array('',"Max Maximilian", "Kyndelsmässodagen", "Disa Hjördis", "Ansgar Anselm", "Agata Agda", "Dorotea Doris", "Rikard Dick", "Berta Bert", "Fanny Franciska", "Iris", "Yngve Inge", "Evelina Evy", "Agne Ove", "Valentin", "Sigfrid", "Julia Julius", "Alexandra Sandra", "Frida Fritiof", "Gabriella Ella", "Vivianne", "Hilding", "Pia", "Torsten Torun", "Mattias Mats", "Sigvard Sivert", "Torgny Torkel", "Lage", "Maria", "Skottdagen"),
        array('',"Albin Elvira", "Ernst Erna", "Gunborg Gunvor", "Adrian Adriana", "Tora Tove", "Ebba Ebbe", "Camilla", "Siv", "Torbjörn Torleif", "Edla Ada", "Edvin Egon", "Viktoria", "Greger", "Matilda Maud", "Kristoffer Christel", "Herbert Gilbert", "Gertrud", "Edvard Edmund", "Josef Josefina", "Joakim Kim", "Bengt", "Kennet Kent", "Gerda Gerd", "Gabriel Rafael", "Marie bebådelsedag", "Emanuel", "Rudolf Ralf", "Malkolm Morgan", "Jonas Jens", "Holger Holmfrid", "Ester"),
        array('',"Harald Hervor", "Gudmund Ingeund", "Ferdinand Nanna", "Marianne Marlene", "Irene Irja", "Vilhelm Helmi", "Irma Irmelin", "Nadja Tanja", "Otto Ottilia", "Ingvar Ingvor", "Ulf Ylva", "Liv", "Artur Douglas", "Tiburtius", "Olivia Oliver", "Patrik, Patricia", "Elias Elis", "Valdemar, Volmar", "Olaus Ola", "Amalia Amelie", "Anneli Annika", "Allan Glenn", "Georg Göran", "Vega", "Markus", "Teresia Terese", "Engelbrekt", "Ture Tyra", "Tyko", "Mariana"),
        array('',"Valborg", "Filip Filippa", "John Jane", "Monika Mona", "Gotthard Erhard", "Marit Rita", "Carina Carita", "Åke", "Reidar Reidun", "Esbjörn Styrbjörn", "Märta Märit", "Charlotta Lotta", "Linnea Linn", "Halvard Halvar", "Sofia Sonja", "Ronald Ronny", "Rebecka Ruben", "Erik", "Maj, Majken", "Karolina Carola", "Konstantin Conny", "Hemming Henning", "Desideria Desiree", "Ivan Vanja", "Urban", "Vilhelmina Vilma", "Beda Blenda", "Ingeborg Borghild", "Yvonne Jeanette", "Vera Veronika", "Petronella Pernilla"),
        array('',"Gun Gunnel", "Rutger Roger", "Ingemar Gudmar", "Solbritt Solveig", "Bo", "Gustav Gösta", "Robert Robin", "Eivor Majvor", "Börje Birger", "Svante Boris", "Bertil Berthold", "Eskil", "Aina Aino", "Håkan Hakon", "Margit Margot", "Axel Axelina", "Torborg Torvald", "Björn Bjarne", "Germund Görel", "Linda", "Alf Alvar", "Paulina Paula", "Adolf Alice", "Johannes Döparens dag", "David Salomon", "Rakel Lea", "Selma Fingal", "Leo", "Peter Petra", "Elof Leif"),
        array('',"Aron Mirjam", "Rosa Rosita", "Aurora", "Ulrika Ulla", "Laila Ritva", "Esaias Jessika", "Klas", "Kjell", "Jörgen Örjan", "Andre Andrea", "Eleonora Ellinor", "Herman Hermine", "Joel Judit", "Folke", "Ragnhild Ragnvald", "Reinhold Reine", "Bruno", "Fredrik Fritz", "Sara", "Margareta Greta", "Johanna", "Magdalena Madeleine", "Emma", "Kristina Kerstin", "Jakob", "Jesper", "Marta", "Botvid Seved", "Olof", "Algot", "Helena Elin"),
        array('',"Per", "Karin Kajsa", "Tage", "Arne Arnold", "Ulrik Alrik", "Alfons Inez", "Dennis Denise", "Silvia Sylvia", "Roland", "Lars", "Susanna", "Klara", "Kaj", "Uno", "Stella Estelle", "Brynolf", "Verner Valter", "Ellen Lena", "Magnus Måns", "Bernhard Bernt", "Jon Jonna", "Henrietta Henrika", "Signe Signhild", "Bartolomeus", "Lovisa Louise", "Östen", "Rolf Raoul", "Gurli Leila", "Hans Hampus", "Albert Albertina", "Arvid Vidar"),
        array('',"Samuel", "Justus Justina", "Alfhild Alva", "Gisela", "Adela Heidi", "Lilian Lilly", "Regina Roy", "Alma Hulda", "Anita Annette", "Tord Turid", "Dagny Helny", "Åsa Åslög", "Sture", "Ida", "Sigrid Siri", "Dag Daga", "Hildegard Magnhild", "Orvar", "Fredrika", "Elise Lisa", "Matteus", "Maurits Moritz", "Tekla Tea", "Gerhard Gert", "Tryggve", "Enar Einar", "Dagmar Rigmor", "Lennart Leonard", "Mikael Mikaela", "Helge"),
        array('',"Ragnar Ragna", "Ludvig Love", "Evald Osvald", "Frans Frank", "Bror", "Jenny Jennifer", "Birgitta Britta", "Nils", "Ingrid Inger", "Harry Harriet", "Erling Jarl", "Valfrid Manfred", "Berit Birgit", "Stellan", "Hedvig Hillevi", "Finn", "Antonia Toini", "Lukas", "Tore Tor", "Sibylla", "Ursula Yrsa", "Marika Marita", "Severin Sören", "Evert Eilert", "Inga Ingalill", "Amanda Rasmus", "Sabina", "Simon Simone", "Viola", "Elsa Isabella", "Edit Edgar"),
        array('',"Allhelgonadagen", "Tobias", "Hubert Hugo", "Sverker", "Eugen Eugenia", "Gustav Adolf", "Ingegerd Ingela", "Vendela", "Teodor Teodora", "Martin Martina", "Mårten,", "Konrad Kurt", "Kristian Krister", "Emil Emilia", "Leopold", "Vibeke Viveka", "Naemi Naima", "Lillemor Moa", "Elisabet Lisbet", "Pontus Marina", "Helga Olga", "Cecilia Sissela", "Klemens", "Gudrun Rune", "Katarina Katja", "Linus", "Astrid Asta", "Malte", "Sune", "Andreas Anders"),
        array('',"Oskar Ossian", "Beata Beatrice", "Lydia", "Barbara Barbro", "Sven", "Nikolaus Niklas", "Angela Angelika", "Virginia", "Anna", "Malin Malena", "Daniel Daniela", "Alexander Alexis", "Lucia", "Sten Sixten", "Gottfrid", "Assar", "Stig", "Abraham", "Isak", "Israel Moses", "Tomas", "Natanael Jonatan", "Adam", "Eva", "", "Stefan Staffan", "Johannes Johan", "Benjamin", "Natalia Natalie", "Abel Set", "Sylvester")
   );
        return $nameDay[$this->getMonth() - 1][$this->getDay()];
         
     }
     
    
}
