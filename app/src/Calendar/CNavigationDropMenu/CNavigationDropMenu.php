<?php
/**
 * A navigation menu with drop down sub menues
 * HTML code generated for the menu
 * 
 * The navigation menu can be styled as horizontal or vertical
 * 
 * @author Rikard Karlsson
 * @version 14-04-15
 */
class CNavigationDropMenu extends ACStylableHtml{
    protected $items;
    protected $noItems;
    //private $cssClasses;
    protected $indexSelected;
    
    public function __construct() {
        $this->items = array();
        $this->noItems = 0;
        $this->cssClasses = array(); //TODO move to ACStylableHtml constructor
        $this->indexSelected = -1; 
        
    }

    /**
     * @param array containing: String $linkText, String $url, CNavigationDropMenu $dropdownMenu
     */
    public function addItem($array){
        $linkText = $array[0];
        $url = $array[1];
        if ( isset($array[2]) ) {
            $dropdownMenu = $array[2];
            
            $this->items[$this->noItems] = array('linkText' => $linkText, 'url' => $url, 'dropdownMenu' => $dropdownMenu);
        }
        else {
            $this->items[$this->noItems] = array('linkText' => $linkText, 'url' => $url);
            
        }
        $this->noItems++;
    }
    //TODO change, any of the adresses in the dropdown menu have to make the item in the main menu selected
    protected function updateSelected() {
        $indexSelectedIsSet = false;
            for ( $itemIndex = 0; $itemIndex < $this->noItems; ++$itemIndex ) {
                //dump(basename($_SERVER['SCRIPT_FILENAME']));
                //dump($_SERVER);
                if( basename($_SERVER['SCRIPT_FILENAME']) == $this->items[$itemIndex]['url']) {
                    $this->indexSelected = $itemIndex;
                    $indexSelectedIsSet = true;
                    break; //if found there is no use to contiue the search, there is at most one
                }
                //has drop down menu
                
                if( isset($this->items[$itemIndex]['dropdownMenu'])) {
                    
                    $dropdownMenu = $this->items[$itemIndex]['dropdownMenu'];
                    //dump($dropdownMenu);
                    if($dropdownMenu->indexSelectedIsSet()) {
                         //print('dropdown');
                        $this->indexSelected = $itemIndex;
                        $indexSelectedIsSet = true;
                        //dump($dropdownMenu);
                        break; //if found there is no use to contiue the search, there is at most one                        
                    }
                    
                }
            }
            if ( !$indexSelectedIsSet ) {
                $this->indexSelected = -1; //none selected
            }
    }
    public function indexSelectedIsSet() {
        $this->updateSelected();
        return ! ($this->indexSelected == - 1);
    }

    public function getHtml() {
        //dump($this->items);
        $this->updateSelected();
        $html = "<nav class='". $this->cssClassesToString() ."'>" .
                "<ul>";
        for ( $itemIndex = 0; $itemIndex < $this->noItems; ++$itemIndex ) {
            $html .= "<li>" . 
                    "<a ";
            if($itemIndex == $this->indexSelected) {
                $html .= " class='is-selected' ";
                //dump($itemIndex);
            }
            $html .= " href='";
            $html .= $this->items[$itemIndex]['url'];
            $html .= "'>";
            $html .= $this->items[$itemIndex]['linkText'];
            $html .= "</a>\n";
            if ( isset($this->items[$itemIndex]['dropdownMenu'])) {
                $dropdownMenu = $this->items[$itemIndex]['dropdownMenu'];
                //dump($dropdownMenu);
                $html .= $dropdownMenu->getHtml();
            }
            $html .= "</li>";
        }
        $html .= "</ul>" . 
                "</nav>";
        return $html;
    }
}

