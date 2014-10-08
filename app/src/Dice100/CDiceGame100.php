<?php
namespace RikardKarlsson\Dice100;

//include('CPlayer.php');
/**
 * @author Rikard Karlsson
 * @version 2014-02-15
 */
class CDiceGame100 implements \Serializable {
    private $players; //an array containing objects of Player
    private $noPlayers;
    private $dice;
    private $activePlayerIndex;
    private $state;
      
    const ADD_PLAYER_STATE = 0;
    const PLAY_GAME_STATE = 1;
    const DISPLAY_WINNER_STATE = 2;
    const PLAY_GAME_NR_1_STATE = 3;
    const MAX_NO_PLAYERS = 4;
    const COMPUTER_STAY_LIMIT = 22;
    
    public function __construct() {
        $this->players = array();
        $this->dice = new CDice();
        $this->dice->roll();
        $this->noPlayers = 0;
        $this->activePlayerIndex = 0;
        $this->state = self::ADD_PLAYER_STATE;       
    }
    public function restart() {
        $this->dice->roll();
        $this->activePlayerIndex = 0;
        $this->state = self::PLAY_GAME_STATE;
        foreach ($this->players as $player) {
            $player->reset();
        }
    }
    public function serialize() {
        $players = array();
        foreach ($this->players as $key => $player) {
            $players[$key] = serialize($player);
        }
        return serialize(array('players' => $players,
                            'noPlayers' => $this->noPlayers,
                            'dice' => serialize($this->dice),
                            'activePlayerIndex' => $this->activePlayerIndex,
                            'state' => $this->state
        ));
    }
    public function unserialize($serializedData) {
        $data = unserialize($serializedData);
        $this->dice = unserialize($data['dice']);
        //$this->players = $data['players'];
        $this->players = array();
        foreach ($data['players'] as $key => $serialPlayer) {
            $this->players[$key] = unserialize($serialPlayer);
        }
        $this->noPlayers = $data['noPlayers'];
        $this->activePlayerIndex = $data['activePlayerIndex'];
        $this->state = $data['state'];
    }
    public function addPlayer(CPlayer $player) {
        $this->players[] = $player;
        ++$this->noPlayers;
    }
    private function getActivePlayer() {
        //dump($this->players[$this->activePlayerIndex]);
        //var_dump($this->activePlayerIndex);
        //dump($this->players);
        return $this->players[$this->activePlayerIndex];
    }
    public function run() {
        //dump($this->players[0], "in function run");
        //$this->dice->roll();
        //var_dump($this->state);
        //var_dump(self::PLAY_GAME_STATE);
        if ( $this->state == self::ADD_PLAYER_STATE ) {
            
        }
        if ( $this->state == self::PLAY_GAME_STATE || $this->state == self::PLAY_GAME_NR_1_STATE) {
            //dump($_GET);
            //$this->dice->roll();
            $activePlayer = $this->getActivePlayer();

            if (isset($_GET['do']) && $_GET['do'] == 'next'){
                $this->nextPlayer();
                $activePlayer = $this->getActivePlayer();
                $this->state = self::PLAY_GAME_STATE;
            }
            
            if (isset($_GET['do']) && $_GET['do'] == 'save'){
                $activePlayer->saveScore();
                if ( $activePlayer->isWinner()) {
                    $this->state = self::DISPLAY_WINNER_STATE;
                }
                else {
                    $this->nextPlayer();
                    $activePlayer = $this->getActivePlayer();
                }
            }
            if ( !$activePlayer->isWinner() ) {               
                $this->dice->roll();
                //echo "roll";
                if ( $this->dice->getNumber() == 1) {
                    //next player turn
                    $activePlayer->resetUnsavedScore();
                    
                    $this->state = self::PLAY_GAME_NR_1_STATE;
                }
                else {
                    $activePlayer->incUnsavedScoreWith($this->dice->getNumber());
                    /*
                    if ( $activePlayer->isWinner() ) {
                        //is winner
                        $activePlayer->saveScore();
                    }*/
                }    
            }
        }
    }
    private function nextPlayer() {
        $this->activePlayerIndex++;
        $this->activePlayerIndex %= $this->noPlayers;
    }
    public function getHtml() {
        if ( $this->state == self::ADD_PLAYER_STATE ) 
        {
            //Display the names of choosen players
            $htmlPlayerNames = "";
            foreach ($this->players as $player) {
                //$playerNames .="($playerNo)" . $player->getName() . " ";
                //++$playerNo;
                $htmlPlayerNames .= "<section class='dice-game-100__display-result__player'>";
                $htmlPlayerNames .= "<p>" . $player->getName() . "</p>";
                $htmlPlayerNames .= "</section>";
            }
            $html = "<h2>Lägg till en spelare och spela eller lägg till fler spelare</h2>";
            $html .= "<form class='form' method='post'>";
            $html .= "<p>";
            $html .= "<label>Spelarens namn</label><br />";
            $html .= "<input type='text' name='player_name'/>";
            $html .= "</p>";
            $html .= "<p>";
            $html .= "<label>Välj mellan datorspelare och mänsklig spelare</label>";
            $html .= "</p>";
            $html .= "<p>";
            $html .= "<select name='is_human_player'>";
            $html .= "<option value='human'>Människa</option>";
            $html .= "<option value='computer'>Dator</option>";
            $html .= "</select>";            
            $html .= "</p>";
            $html .= "<p>";
            $html .= "<input  class='button button--smaller' type='submit' name='play_game' value = 'Spela'/>";
            $html .= "</p>";
            if ( $this->noPlayers < self::MAX_NO_PLAYERS - 1 ) {
                $html .= "<p>";
                $html .= "<input class='button button--smaller' type='submit' name='add_player' value = 'Lägg till fler spelare'/>";                
                $html .= "</p>";
            }
            $html .= "</form>";
            $html .= $htmlPlayerNames;
            $html .= "";
            
        }
        else {

            $html = "<section class='dice-game-100__display-result'>";
            //$html .= "<p><a class='button' href='?do=restart'>Start om</a></p>";
            $html .= "<form method='post'>";
            $html .= "<p><input class='button button--smaller' type='submit' name='restart' value = 'Starta om med nya spelare' /></p>"; 
            $html .= "</form>";
            
            $activePlayer = $this->players[$this->activePlayerIndex];
            //($activePlayer, "\$activePlayer");
            foreach ($this->players as $key => $player) {
                
            
                $html .= "<section class='dice-game-100__display-result__player'>";
                $html .= "<p>" . $player->getName() . "</p>";
                //$html .= "<hr />";                
                $html .= "<p>Sparad poäng: " . $player->getSavedScore() . "</p>";
                if ( $key == $this->activePlayerIndex ) {
                    
                
                    $html .= "<p>Ej sparad poäng: " . $activePlayer->getUnsavedScore() . "</p>";
                    //$html .= "<p>Antal ögon: " . $this->dice->getNumber() . "</p>";
                    $html .= $this->dice->getHtml();
                    if ( $this->state == self::PLAY_GAME_NR_1_STATE ) {
                        $html .= "<p><a class='button button--smaller' href='?do=next'>Nästa spelare</a></p>";
                    }
                    else if ( $this->state == self::PLAY_GAME_STATE )
                    {
                        if ( $activePlayer->isHuman() ) {
                            $html .= "<p><a class='button button--smaller' href='?do=roll'>Kasta</a> 
                                    <a class='button button--smaller' href='?do=save'>Spara</a></p>";
                        }
                        else { //is computer
                            //$html .= "<input type='hidden' name='do' value='roll' />";
                            $computerChoice = $this->getComputerChoice();
                            $html .= "<p><a class='button button--smaller' href='?do={$computerChoice}'>
                                    Låt datorn välja</a></p>";
                        }
                    }
                    else if ( $this->state == self::DISPLAY_WINNER_STATE) {
                        $html .= "<p>WINNER!</p>";
                        $html .= "<form method='post'>";//"<p><a class='button' href='?do=new-game'>Spela igen</a></p>";
                        $html .= "<input class='button button--smaller' type='submit' name='new_game' value = 'Spela igen med samma spelare'  />"; 
                        $html .= "</form>";
                    }
                }
                $html .= "</section>";
            }
            $html .= "</section>";
        }
        return $html;
    }
    private function getComputerChoice() {
        $activePlayer = $this->getActivePlayer();
        if ( $activePlayer->getUnsavedScore() < self::COMPUTER_STAY_LIMIT ) {
            return "roll";
        }
        return "save";
    }
    public function setPlayGameState() {
        $this->state = self::PLAY_GAME_STATE;
    }
}
