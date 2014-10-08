<?php
namespace RikardKarlsson\Dice100;

class CDice implements \Serializable{
    private $number; 
    private $noSides;
    
    public function __construct($numberOfSides = 6) {
        if ( is_numeric($numberOfSides) && $numberOfSides > 1 ) {
            $this->noSides = $numberOfSides;
        }
        else {
            $this->numberOfSides = 6;
        }
        $this->number = $this->noSides;
        
    }
    public function serialize() {
        return serialize(array('number' => $this->number,
                                'noSides' => $this->noSides
                         ));
    }
    public function unserialize($serializedData) {
        $data = unserialize($serializedData);
        $this->number = $data['number'];
        $this->noSides = $data['noSides']; 
    }
    
    public function roll() {
        $this->number = rand(1, $this->noSides);
        return $this->number;
    }
    public function getNumber() {
        return $this->number;
    }
    public function getHtml() {
        $number = $this->number;
        $diceHtml = "<div class='dice'>";
        $diceHtml .= "<!-- OBS! use hidden to hide dots -->";
        //is odd
        if ( $number % 2 == 1 ) {
            $diceHtml .= "<div class='dice__dot dice__dot--0'></div>";
        }
        if ( $number >= 2 ) {
            $diceHtml .= "<div class='dice__dot dice__dot--1'></div>";
            $diceHtml .= "<div class='dice__dot dice__dot--2'></div>";
        }
        if ( $number >= 4) {
            $diceHtml .= "<div class='dice__dot dice__dot--3'></div>";
            $diceHtml .= "<div class='dice__dot dice__dot--4'></div>";                
        }
        if ( $number >= 6) {
            $diceHtml .= "<div class='dice__dot dice__dot--5'></div>";
            $diceHtml .= "<div class='dice__dot dice__dot--6'></div>";                
        }
    
        $diceHtml .= "</div>";
        return $diceHtml;
    }
}
