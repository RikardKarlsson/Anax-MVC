<?php
namespace RikardKarlsson\Calendar;
abstract class ACStylableHtml {
    private $cssClasses;
    
    public function addCssClass($cssClassName) {
        $this->cssClasses[] =  $cssClassName;
    }
    /**
     * @return a string i.e. className1 className2 ... classNameN
     */
    protected function cssClassesToString() {
        $classNameString = "";
        if ( count($this->cssClasses) != 0 ) {
            foreach ($this->cssClasses as  $className) {
                $classNameString .= $className . " ";
            }
            
        }
        return $classNameString;
    }
    
}
