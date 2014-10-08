<?php
namespace RikardKarlsson\Dice100;

class CPlayer implements \Serializable {
    private $name;
    private $savedScore;
    private $unsavedScore; 
    private $isHuman;  
    
    const WINNER_LIMIT = 100;
    
    public function __construct($name, $isHuman) {
        $this->name = $name;
        $this->reset();
        $this->isHuman = $isHuman;

    }
    public function reset() {
        $this->savedScore = 0;
        $this->unsavedScore = 0;
    }
    
    public function serialize() {
        return serialize(array('name' => $this->name,
                            'savedScore' => $this->savedScore,
                            'unsavedScore' => $this->unsavedScore,
                            'isHuman' => $this->isHuman
        ));
    }
    public function unserialize($serializedData) {
        $data = unserialize($serializedData);
        $this->name = $data['name'];
        $this->savedScore = $data['savedScore'];
        $this->unsavedScore = $data['unsavedScore']; 
        $this->isHuman = $data['isHuman'];
        
    }
    public function getName() {
        return $this->name;
    }
    public function getSavedScore() {
        return $this->savedScore;
    }
    public function getUnsavedScore() {
        return $this->unsavedScore;
    }
    public function getTotalScore() {
        return $this->savedScore + $this->unsavedScore;
    }
    public function isWinner() {
        //var_dump($this->savedScore);
        return $this->savedScore >= self::WINNER_LIMIT;
    }
    public function incUnsavedScoreWith($number) {
        $this->unsavedScore += $number;
    }
    public function resetUnsavedScore() {
        $this->unsavedScore = 0;
    }
    public function saveScore() {
        $this->savedScore +=$this->unsavedScore;
        $this->resetUnsavedScore();
    }
    public function isHuman() {
        return $this->isHuman;
    }
}
