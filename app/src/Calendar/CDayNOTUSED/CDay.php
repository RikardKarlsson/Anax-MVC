<?php
/**
 * Represents a day
 *
 * facts:
 * synodic month length: 29.530588853 days source: http://en.wikipedia.org/wiki/Month
 *
 * full moon time: Thursday, 16 January 2014, 05:52:12 am in Central European
 * Time (CET) or Central European Summer Time (CEST), same time as in Sweden.
 * 
 * Allmänna flaggdagar i Sverige (Source: https://lagen.nu/1982:270):
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
 * Allmänna helgdagar i Sverige (source: https://lagen.nu/1989:253)
 * nyårsdagen    den 1 januari
 * trettondedag jul     den 6 januari
 * långfredagen     fredagen närmast före påskdagen
 * påskdagen    söndagen närmast efter den fullmåne som infaller på eller närmast efter den 21 mars
 * annandag påsk    dagen efter påskdagen
 * Kristi himmelsfärdsdag   sjätte torsdagen efter påskdagen
 * pingstdagen  sjunde söndagen efter påskdagen
 * nationaldagen    den 6 juni
 * midsommardagen den 20-26 juni    den lördag som infaller under tiden
 * alla helgons dag     den lördag som infaller under tiden den 31 oktober-6 november
 * juldagen     den 25 december
 * annandag jul Lag (2004:1320).    den 26 december.
 *
 * @author Rikard Karlsson
 * @version
 */
class CDay implements IDateConstants{
    private $year;
    private $month;
    private $day;
    /**
     * 
     */
    function __construct($year = 2014, $month = 1, $day = 1) {
        //TODO add indata controll - cast an error
        if ( is_int($year) ) {
            $this -> year = $year;
        }
        else {
            throw new DomainException("Error: invalid value passed to the parameter $year");           
        }
        if ( is_int($month) && 0 < $month && $month < 13 ) {
            $this -> month = $month;            
        }
        else {
            throw new DomainException("Error: invalid value passed to the parameter $month");           
            
        }
        if ( is_int($day) && isValidDay($year, $month, $day) ) {
            $this -> day = $day;
        }
        
    }
    private static function isValidDay($year, $month, $day) {
        $isValidDay = FALSE;
        $date = mktime(0, 0, 0, $month, 1, $year);
        if ($day < 1 || 31 < $day) {
            return FALSE;
        }
        switch($month) {
            case 1:
                $isValidDay = $day < 32 ? TRUE : FALSE;
            break;
            case 2:
                $date = new DateTime();
                $date->setDate($year, 1, 1);
       
        }
    }
    /**
     * @return $day the day of the month i.e. 1, 2, ..., 31
     */
    public function getDayNr() {
        return $this->day;
    }

    public function getMonthNr() {
        return $this->month;
    }

    public function getMonthName() {
        $array = NR_TO_MONTH_NAME;
        return $array[$this->month];
    }
    public function isRedDay() {
        $isRed = FALSE;
        if ( $day == 7 ) {//TODO wrong
            //sunday
            $isRed = TRUE;
        }
        return $isRed;
    }
    public function getRedDayDescription() {
        if ( $this->isRedDay() ) {
            return "TODO description ";
        }
        return "";
        
    } 
    public function isFullMoonDay() {
        
    }
    public function isFirstQuaterMoon() {
        
    }
    public function isThirdQuaterMoon() {
        
    }
    public function isFlagDay() {
        
    }
    public function getFlagDayDescription() {
        
    }
    public function getNameDayNames() {
        $array = MONTH_DAY_TO_NAME_DAY;
        return $array[$this->month][$this->day];
    }
    /**
     * Monday = 1, ...
     */
    public function getDayName() {
        $array =  NR_TO_DAY_NAME;
        return  $arry[$this->day];
    }
    /**
     * problem leap years
     * different number of days in different years
     */
    public function getWeekNr() {
        //$noMonthsSince1970Jan01 = $this->year * 12 + $this->month;
        //$noDaysSince1970Jan01 = $noMonthsSince1970Jan01 
        $weekNr = date("W", $noSecondsSince1070Jan01);
        return $weekNr;
    }

}
