<?php 
/**
 * @author Rikard Karlsson
 * @version 2014-02-15
 */

 /**
 * This is a Lark pagecontroller.
 *
 */
//un-comment unset to restart 
//unset($_SESSION['dice100_serial']);
 // Include the essential config-file which also creates the $lark variable with its defaults.

//echo "_POST";
//dump($_POST);
//restart game
//dump($_SESSION);
if ( isset($_POST['restart']) ) {

    unset($_SESSION['dice100_serial']);
    unset($_POST['restart']);

}

//unserialize if there is something to unserialize, otherwise make a new game
if ( isset($_SESSION['dice100_serial']) ) {
    $game = unserialize( $_SESSION['dice100_serial'] );
}
else {
    $game = new RikardKarlsson\Dice100\CDiceGame100();
}
if ( isset($_POST['new_game']) ) {
    $game->restart();
    unset($_POST['new_game']);
}
//add player
if ( isset($_POST['play_game']) || isset($_POST['add_player']) ) {
    //add player
    if ( isset($_POST['is_human_player']) && $_POST['is_human_player'] == 'human' ) {
        //human player
        $playerName = "Spelare";    
        if ( isset($_POST['player_name']) && $_POST['player_name'] != '' ) {
            $playerName = $_POST['player_name'];
        }
        $game->addPlayer( new RikardKarlsson\Dice100\CPlayer($playerName, TRUE) );
    }
    else {
        //computer player
        $playerName = "Dator";    
        if ( isset($_POST['player_name']) && $_POST['player_name'] != '' ) {
            $playerName = $_POST['player_name'];
        }
        $game->addPlayer( new RikardKarlsson\Dice100\CPlayer($playerName, FALSE) );   
    }  
}
if ( isset($_POST['play_game']) ) {
    $game->setPlayGameState();
}

/*
else {
    $game = new DiceGame100();
    $game->addPlayer( new Player("Spelare 1", TRUE) );    
    $game->addPlayer( new Player("Spelare 2", TRUE) );    
    $game->addPlayer( new Player("computer", FALSE) );    
    $game->addPlayer( new Player("computer 2", FALSE) );    
}
 * */
//$game = new DiceGame100();
//dump($game);
//dump($_GET);
//$ser = 

/*
//test serialize player 
$player = new Player("name of player", new Dice(4));
dump($player);
$serPlayer = serialize($player);
$player = unserialize($serPlayer);
dump($player);
 */

$game->run();
$gameViewHtml = $game->getHtml();

//dump($_SESSION);
$_SESSION['dice100_serial'] = serialize($game);
//unset($_SESSION['dice100_serial']);
//dump(new Player("spelare namn"));
// Do it and store it all in variables in the Lark container.
$lark['title'] = "Tärningsspelet 100";



$lark['main'] = <<<EOD
<article class='page-dice100'>
    <div class='t-clearfix'>
        <h1>Tärningsspelet 100</h1>
            {$gameViewHtml}
    </div>
</article>
EOD;

$content = $lark['main'];
//echo $title;
