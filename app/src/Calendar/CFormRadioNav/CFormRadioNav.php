<?php
/**
 * A navigation menu
 * HTML code generated for the radio button group
 * 
 * The radio button group menu can be styled 
 * 
 * @author Rikard Karlsson
 * @version 14-04-22
 */
class CFormRadioNav extends ACStylableHtml{
    protected $labelTextArray;  
    protected $labelValueArray;  
    protected $checkedLabelValue; 
    private static $noObjects = 0;//used to make unique get-index
    protected $name; //used as index in $_GET
    private $checkedIndex;
    private $defaultIndex;
    private $noItems;
    //private $updateCheckedCalled;
    //private $checkedIndex;
    //private $noItems;
    
    public function __construct() {
        $this->labelTextArray = array();
        $this->labelValueArray = array();
        $this->checkedLabelValue = "*";
        //$this->checkedIndex = 0;
        $this->checkedIndex = 0;//-1;
        $this->defaultIndex = 0;//-1;
        ++self::$noObjects;
        $this->name = "radio" . self::$noObjects;  
        //$this->updateCheckedCalled = false; 
        $this->noItems = 0;
    }
    /**
     * @param array() i.e. labelValue, labelText, isDefault
     */
    public function addItem($array){
        $labelValue = $array[0];
        if ( isset( $array[1] ) ) {
            $labelText = $array[1];
        }
        else{
            $labelText = $labelValue;    
        }
        if ( isset( $array[2]) ) {
            $this->defaultIndex = $this->noItems;
            $this->checkedIndex = $this->noItems;
            $this->checkedLabelValue = $labelText;
        }
        $this->labelTextArray[] = $labelText;
        $this->labelValueArray[] = $labelValue;
        
        ++$this->noItems;
    }
    /**
     * @return name used as index in $_GET
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 
     */
    private function updateChecked() {
        if ( isset($_GET[$this->name]) ) {
            if ( in_array( $_GET[$this->name], $this->labelValueArray) ) { //check that incoming value is valid
                $this->checkedLabelValue = $_GET[$this->name];
                $this->checkedIndex = array_search($this->checkedLabelValue, $this->labelValueArray);
            }
            else {
                $this->checkedIndex = $this->defaultIndex;
                if ( count($this->labelValueArray) > 0) {
                    $this->checkedLabelValue = $this->labelValueArray[$this->checkedIndex];
                }
                
            }
        }
        else {
            //$this->checkedIndex = -1;
            $this->checkedIndex = $this->defaultIndex;
            if ( count($this->labelValueArray) > 0) {
                $this->checkedLabelValue = $this->labelValueArray[$this->checkedIndex];
            }
            //dump($this->checkedLabelValue);
            //$this->checkedIndex = 0;
            //$this->checkedLabelValue = $this->labelValueArray[$this->checkedIndex];
        }
        
    }
    public function getCheckedLabelValue() {
        $this->updateChecked();
        return $this->checkedLabelValue;
    }
    public function isDefaultChecked() {
        return $this->checkedIndex == $this->defaultIndex;
    }
        
    public function getHtml() {
        //$name = "radio" . $noObjects;
        $this->updateChecked();
        //$html = "<p>checked index: {$this->checkedIndex}</p>";
        $html = "";
        $index = 0;
        foreach($this->labelValueArray AS $value) {
            $checked = "";
            if ( $value == $this->checkedLabelValue) {
                $checked = "checked='checked'";
            }
            $id = $this->name . "_" . $index;
            //$value = $this->labelValueArray[$index];
            $labelText = $this->labelTextArray[$index];
            
            $html .= $this->getButtonHtml($id, $value, $labelText, $checked);
            ++$index;    
        }
        return $html;
    }
    /**
     * Used to split the buttons.
     * @param $index, index of selected button
     * @return html for the selected button
     */
    public function getHtmlOfButton($index) {
        $html = "";
        //dump($this->noItems, 'noItems');
        if ( $index >= 0 && $index < $this->noItems && $this->noItems > 0) {
            $this->updateChecked();
            $checked = "";
            if ( $index == $this->checkedIndex) {
                $checked = "checked='checked'";
            }
            $id = $this->name . "_" . $index;
            $labelText = $this->labelTextArray[$index];
            $value = $this->labelValueArray[$index];
            $html .= $this->getButtonHtml($id, $value, $labelText, $checked);
            
        }
        return $html;
    }
    /**
     * buttons like:
     * first, previous
     * <<, <, same as getHtml(), >, >>
     */
    public function getNavHtml() {
        if ( $this->noItems == 0) {
            return "";
        }
        $firstIndex = 0;
        $lastIndex = $this->noItems - 1;
        $html = "";
        $classesString = $this->cssClassesToString();
        
        //<<, select the first button
        $id = $this->name . "__0";
        $value = $this->labelValueArray[$firstIndex];
        $html .= $this->getButtonHtml($id, $value, "&lt;&lt;", "");
        
        //<, select the previous button
        $id = $this->name . "__1";
        $index = $this->checkedIndex - 1;
        if ( $index < $firstIndex ) {
            $index = $firstIndex;
        }
        $value = $this->labelValueArray[$index];
        $html .= $this->getButtonHtml($id, $value, "&lt;", "");
        
        //list of buttons
        $html .= $this->getHtml();
        
        //>, select next button
        $id = $this->name . "__2";
        $index = $this->checkedIndex + 1;
        if ( $index > $lastIndex ) {
            $index = $lastIndex;
        }
        $value = $this->labelValueArray[$index];
        $html .= $this->getButtonHtml($id, $value, "&gt;", "");
        
        //>>, select last button
        $id = $this->name . "__3";
        $value = $this->labelValueArray[$lastIndex];
        $html .= $this->getButtonHtml($id, $value, "&gt;&gt;", "");  
        
        return $html;              
    }
    private function getButtonHtml($id, $value, $labelText, $checked) {
        $html = "";
        $classesString = $this->cssClassesToString();
        $html .= "<input class='$classesString' 
                type='radio' 
                id='{$id}' 
                {$checked} 
                name='{$this->name}' 
                value = '{$value}' 
                onclick='form.submit();' />";
        $html .= "<label for='{$id}'>{$labelText}</label>";
        return $html;
    } 
}
