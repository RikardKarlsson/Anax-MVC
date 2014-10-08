<?php
/**
 * @author Rikard Karlsson
 * @version 2014-03-08
 */
class CTable extends ACStylableHtml{
    private $table;//[row][colum]
    private $cssClasses;
        
    public function __construct() {
        $this->table = array();
    }
    /**
     * @param $row an array containing a row of the table
     */
    public function addRow($row) {
        $this->table[] = $row;
    }
    /**
     * The table will equal the passed array
     * @param $array, is a 2D array with [rows][columns]
     */
    public function fromArray($array) {
        $this->table = $array;
    }
    
    public function getHtml() {
        $html = "<table class='" . $this->cssClassesToString() . "'>";
        foreach ($this->table as $row) {
            $html .= "<tr>";
            foreach ($row as $cell) {
                $html .= "<td>";
                $html .= $cell;
                $html .= "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }

}
