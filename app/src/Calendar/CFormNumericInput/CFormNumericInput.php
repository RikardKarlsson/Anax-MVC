<?php
/**
 * A numeric form input element.
 * HTML code generated for the radio button group
 * 
 * The radio button group menu can be styled 
 * 
 * @author Rikard Karlsson
 * @version 14-04-22
 */
class CFormNumericInput extends ACStylableHtml{
    private static $noObjects = 0;//used to make unique get-index
    private $getIndexName;

    public function __construct() {
        ++self::$noObjects;
        $this->getIndexName = "num" . self::$noObjects;//TODO have to be unique on the current web page
    }  
    /**
     * @return the input value if set, otherwise null
     */
    public function getValue() {
        $value = isset($_GET[$this->getIndexName]) && !empty($_GET[$this->getIndexName]) ? $_GET[$this->getIndexName] : null;
        is_numeric($value) || !isset($value) or die('Check: Year must be numeric or not set.');
        return $value;
        
    }  
    
    public function getHtml() {
        $value = $this->getValue();
        $html = ""; 
        $html .= "<input type='text' name='{$this->getIndexName}' value='{$value}'/>";
        
        return $html;
    }
}
