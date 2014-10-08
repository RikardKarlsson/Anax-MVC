<?php
/**
 * A navigation menu
 * HTML code generated for the menu
 * 
 * The navigation menu can be styled as horizontal or vertical
 * 
 * @author Rikard Karlsson
 * @version 14-03-08
 */
class CNavigationMenu extends ACStylableHtml{
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
    /*
	public function addCssClass($cssClassName) {
		$this->cssClasses[] =  $cssClassName;
	}
    */
	/**
	 * @return a string i.e. className1 className2 ... classNameN
	 */
	/*
	private function cssClassesToString() {
		$classNameString = "";
		foreach ($this->cssClasses as  $className) {
			$classNameString .= $className . " ";
		}
        return $classNameString;
	}
     */
    //public function addItem($linkText, $url){
    public function addItem($array){
        $linkText = $array[0];
        $url = $array[1];
		$this->items[$this->noItems] = array('linkText' => $linkText, 'url' => $url);
		$this->noItems++;
	}

	protected function updateSelected() {
			for ( $itemIndex = 0; $itemIndex < $this->noItems; ++$itemIndex ) {
				if( basename($_SERVER['SCRIPT_FILENAME']) == $this->items[$itemIndex]['url']) {
					$this->indexSelected = $itemIndex;
					break; //if found there is no use to contiue the search, there is at most one
				}
			}

	}

	public function getHtml() {
		$this->updateSelected();
		$html = "<nav class='". $this->cssClassesToString() ."'>" .
				"<ul>";
		for ( $itemIndex = 0; $itemIndex < $this->noItems; ++$itemIndex ) {
			$html .= "<li>" . 
					"<a ";
			if($itemIndex == $this->indexSelected) {
				$html .= " class='is-selected' ";
			}
			$html .= " href='";
			$html .= $this->items[$itemIndex]['url'];
			$html .= "'>";
			$html .= $this->items[$itemIndex]['linkText'];
			$html .= "</a>\n";
			$html .= "</li>";
		}
		$html .= "</ul>" . 
				"</nav>";
		return $html;
	}
}
