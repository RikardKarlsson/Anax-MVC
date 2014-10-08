<?php
namespace RikardKarlsson\Calendar;
class CDateUtil  {
    public static function isValidMonth($month) {
        if ( is_numeric($month) && 0 < $month && $month < 13) {
            return TRUE;
        }
        return FALSE;
    }    
    public static function isValidYear($year) {
        if ( is_numeric($year) ) {
            return TRUE;
        }
        return FALSE;
    }
    public static function isValidDayNo($dayNo) {
        if ( is_numeric($dayNo) && 0 < $dayNo && $dayNo < 8) {
            return TRUE;
        }
        return FALSE;
        
    }
    public static function isValidDayOfMonth($year, $month) {
        
    }
    public static function noDaysInMonth($year, $month) {
        if ( isValidYear($year) && isValidMonth($month) ) {
            $dateInMonth = mktime(0, 0, 0, $month, 1, $year);
            $noDaysInMont = date('t', $dateInMonth);
            return $noDaysInMonth;
        }
        else {
            throw new DomainException("DomainException, improper arument");
        }
    }
    public static function getMonthName($month) {
        if ( self::isValidMonth($month) ) {
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
            return $array[$month];           
        }
        throw new DomainException("DomainException, invalid parameter $month");       
    }
    /**
     * @param $dayNo 1 is monday ... 7 is sunday
     */
    public static function getDayName($dayNo) {
        if ( self::isValidDayNo($dayNo) ) {
            $array = array(1 => "Måndag", 
                                2 => "Tisdag", 
                                3 => "Onsdag", 
                                4 => "Torsdag", 
                                5 => "Fredag", 
                                6 => "Lördag", 
                                7 => "Söndag");
            return $array[$dayNo];
        }
        throw new Exception("DomainException, invalid paramete, $dayNo");        
    }
    /**
     *  * Allmänna helgdagar i Sverige (source: https://lagen.nu/1989:253)
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
     */
     public static function getRedDayName($year, $month, $day) {
         if ( $month == 1 ) {
             if ( $day == 1 ) {
                 return "Nyårsdagen";
             }
             else if ( $day == 6 ) {
                 return "Trettondedag jul";
             }
         }
         if ( $month == 6 ) {
             if ( $day == 6 ) {
                 return "Nationaldagen";
             }
         }
         if ( $month == 12 ) {
             if ( $day == 25 ) {
                 return "Juldagen";
             }
             else if ( $day = 26 ) {
                 return "Annandag jul";
             }
         }
         easter_date();
         easter_days();
         
         return "";
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
     public static function isFlagDay($year, $month, $day) {
         
     }
     
    /**
     *  * synodic month length: 29.530588853 days source: http://en.wikipedia.org/wiki/Month
     *
     * full moon time: Thursday, 16 January 2014, 05:52:12 am in Central European
     * Time (CET) or Central European Summer Time (CEST), same time as in Sweden.
     * 
     */
     public static function isFullMoon($year, $month, $day) {
         
     }
     
     public static function isFirstQuaterMoon($year, $month, $day) {
         
     }
     
     public static function isLastQuaterMoon($year, $month, $day) {
         
     }
     
}
