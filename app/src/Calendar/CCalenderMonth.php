<?php
namespace RikardKarlsson\Calendar;
class CCalenderMonth {
    private $year;
    private $month;
    private $date; //DateTime
    
    public function __construct($year = 2014, $month = 1) {
        if ( CDateUtil::isValidYear($year) ) {
            $this->year = $year;
        }
        else {
            throw new DomainException("DomainException, invalid parameter $year");
        }
        if ( CDateUtil::isValidYear($month) ) {
            $this->month = $month;
        }
        else {
            throw new DomainException("DomainException, invalid parameter $month");
        }
        $this->date = new CDateTimeAdvanced();
        $this->date->setDate($year, $month, 1);
        $this->date->setTime(0,0,1);
    }
    private function setDayToFirstDayToDisplay() {
        $day = $this->date->format("N") - 1;
        $this->date->modify("-{$day} days");
    }
    /**
     * @return A html format string. To be styled with css to show
     * first quater moon, full moon, or last quater moon.
     */
    private function getMoonHtml() {
        // first quater moon 
        if ( $this->date->isFirstQuaterMoon() ) {
            return "<div class='t-right'><div class='moon moon__left '></div><div class='moon moon__right moon--full'></div></div>";
        }
        
        // full moon
        if ( $this->date->isFullMoon() ) {
            return "<div class='t-right'><div class='moon moon--full moon__left'></div><div class='moon moon--full moon__right'></div></div>";
        }
            
        // last quater moon 
        if ( $this->date->isLastQuaterMoon() ) {
            return "<div class='t-right'><div class='moon moon--full moon__left'></div><div class='moon moon__right'></div></div>";
        }
        return "";
    }
    
    public function getHtml($isSmall) {
        $noDaysInMonth = $this->date->format("t");
        $weekNr = $this->date->format("W") + 0;
        $year = $this->date->getYear();
        $month = $this->date->getMonth();
        $monthName = $this->date->getMonthName();
        $this->setDayToFirstDayToDisplay();
        $day = $this->date->format("j");
        $html = "";//"<div class='calender-wrapper'>";
        //$html .= "<{$tagType} class = 't-text-center calender-title'>{$this->date->getYear()} {$this->date->getMonthName()}</{$tagType}>";
        if ( $isSmall ) {
            $html .= "<table class='calender calender--small'>"; 
        }
        else {
           $html .= "<table class='calender calender--big'>"; 
        }
        $tagType = "h1";
        if ( $isSmall ) {
            $tagType = "p";
        }
        $html .= "<thead><tr><td colspan='8'><{$tagType} class = 't-text-center calender-title'>{$year} {$monthName}</{$tagType}></td></tr></thead>";
        //$html .= "<thead><td colspan='8'><{$tagType} class = 't-text-center calender-title'>{$year} {$monthName}</{$tagType}></td></thead>";
                
        $row = 1;
        $html .= "<tbody><tr><td></td>";
        for( $col = 1; $col < 8; ++$col ) {
            $html .= "<td class = 'calender-day-cell calender-label'>";
            //cell content
            $dayName = $dayName = CDateUtil::getDayName($col);;
            if ( $isSmall ) {
                $dayName = substr($dayName, 0, 1);
            }

            $html .= "" . $dayName;
            $html .= "</td>";
        }
        $html .= "</tr>";
        $isLastRow = FALSE;
        do{
            $html .= "<tr><td class='calender-label'>{$weekNr}</td>";
            for( $col = 1; $col < 8; ++$col ) {
                $otherMonthClass ="";
                if ( $month != $this->date->getMonth() ) {
                    $otherMonthClass ="calender-other-month"; 
                }
                $html .= "<td class = 'calender-day-cell {$otherMonthClass}'>";
                //cell content
                if ( $this->date->isRedDay() ) {
                    $isRedDayClass = "t-red-day";
                    $redDayText = "";
                }
                else {
                    $isRedDayClass = "";
                    $redDayText = "";
                }
                $flagImgOnFlagDay = "";
                if ( $this->date->isFlagDay() ) {
                    $flagImgOnFlagDay = "<img src='img/swe_flag30.png' alt='' />";
                }
                $moonHtml = $this->getMoonHtml();
                $redDayNameHtml = $this->date->getRedDayName();
                $nameDayNameHtml = $this->date->getNameDay();
                //hide some things when calender is small
                if ( $isSmall ) {
                    $moonHtml="";
                    $flagImgOnFlagDay="";
                    $redDayNameHtml="";
                    $nameDayNameHtml="";
                }
                $html .= $moonHtml;
                $html .= "<p class='calender-day-text {$isRedDayClass}'>{$day}{$redDayText}
                            {$flagImgOnFlagDay}
                        </p>" ;
                $html .= "<p>{$redDayNameHtml}</p>";
                $html .= "<p>{$nameDayNameHtml}</p>";
                $html .= "</td>";
                if ( $noDaysInMonth == $day && $row > 2) {
                    $isLastRow = TRUE;
                }
                $this->date->modify("+1 days");
                $day = $this->date->format("j");
            }
            $html .= "</tr>";
            ++$row;
            $weekNr = $this->date->format("W") + 0;
        }
        while ( !$isLastRow );
        $html .="</tbody></table>";
        //$html .="</div>";
        return $html;
    }
}
