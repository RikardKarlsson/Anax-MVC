<?php
/**
 * @author Rikard Karlsson
 * @version 2014-04-17  
 */
class CGetNavigationMenu extends CNavigationMenu {
    
     /**
     * used to create a submenu using GET['p'] or url: ?p=all
     */
    //public function addGetItem($linkText, $urlStart, $urlGetPart){
    public function addItem($array){
        $linkText = $array[0];
        $urlStart = $array[1];
        $urlGetPart = $array[2];
        $this->items[$this->noItems] = array('linkText' => $linkText, 
                'url' => $urlStart . '?p=' . $urlGetPart,
                'urlGetPart' => $urlGetPart);
        $this->noItems++;
    }
    /**
     * @return the value of $_GET['p'] if it exists otherwise null
     */
    public function getSelectedUrlGetPart() {
        $this->updateSelected();
        if ( $this->indexSelected != -1 ) {
            //indexSelected is set
            return $this->items[$this->indexSelected]['urlGetPart'];
                    }
        else {
            //indexSelected is not set
            return null;
        }
        //return $this->items[$this->indexSelected]['urlGetPart'];
        if ( isset($_GET['p']) ) {
            return $_GET['p'];
        }
        return null;
    }
    protected function updateSelected() {
        if ( isset ($_GET['p']) ) {
            for ( $itemIndex = 0; $itemIndex < $this->noItems; ++$itemIndex ) {
                if( $_GET['p']== $this->items[$itemIndex]['urlGetPart']) {
                    $this->indexSelected = $itemIndex;
                    break; //if found there is no use to contiue the search, there is at most one
                }
            }  
        }
        else {
            $this->indexSelected = 0;
        }

    }

}
