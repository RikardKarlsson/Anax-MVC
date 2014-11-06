<?php
//require __DIR__.'/config_with_app.php'; 
require __DIR__.'/config.php'; 
// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new \Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);
//dump($app);
//navbar is added in argument file
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');//set navbar to other than defaul

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
/*
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Jag");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/index', [
        'content' => $content,
        'byline' => $byline,
    ]);
});
*/

$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Rikard Karlsson");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $aside = $app->fileContent->get('me_aside.md');
    $aside = $app->textFilter->doFilter($aside, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/me', [
        'content' => $content,
        'aside' => $aside,
        'byline' => $byline,
    ]);
    
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>[''],
    ]);
});
 /*
$app->router->add('redovisning', function() use ($app) {
    $app->theme->setTitle("Redovisning");
    $app->views->add('me/redovisning');
});
*/
//content from file
$app->router->add('redovisning', function() use ($app) {
 
    $app->theme->setTitle("Redovisning");
 
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/report', [
        'content' => $content,
        'byline' => $byline,
    ]);
    //$app->views->add('comment/index');
    //dump($_POST);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>['redovisning'],
    ]);
 
});
$app->router->add('kasta-tarning', function() use ($app) {
    $app->session();//start session 
    $app->theme->setTitle("Kasta tärning");
 

include('incl/dice.php');
    $app->views->add('me/calendar', [
        'content' => $content,
    ]);
 
});
$app->router->add('tarningsspel', function() use ($app) {
 
    $app->theme->setTitle("Tärningsspelet 100");
 
    include('incl/dice100.php'); //sets $content
    $app->views->add('me/calendar', [
        'content' => $content,
    ]);
 
});
$app->router->add('kalender', function() use ($app) {
 
    $app->theme->setTitle("Kalender");
 /*
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 */
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 
    include('incl/calendar.php');
    $content = $lark['main'];
    $app->views->add('me/calendar', [
        'content' => $content,
        'byline' => $byline,
    ]);
 
});
$app->router->add('comment', function() use ($app) {

    $app->theme->setTitle("Guestbook");
    //$app->views->add('comment/index');
    //dump($_POST);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>['comment'],
    ]);
    //empty comment
    /*
    $comment = array(
        'content' => null,
        'name' => null,
        'web' => null,
        'mail' => null
    );
    $saveAction = 'doCreate';
    $id = null;
    if ( isset($_GET['id']) ) {
        is_numeric($_GET['id']) or die ("id is not a number");
        $id = $_GET['id'];
        //dump($_SESSION);
        if ( $app->session->has('comments') ) {//TODO replace 'comments', instead read it from where it is stored
            $comments = $app->session->get('comments');
            $comment = $comments[$id];
        }
        $saveAction = 'doEdit';        
    }
    $app->views->add('comment/form', [
        'mail'      => $comment['mail'], //TODO check that mail exists in $comment
        'web'       => $comment['web'],
        'name'      => $comment['name'],
        'content'   => $comment['content'],
        'output'    => null,
        'saveAction' => $saveAction,
        'id' => $id,
    ]);*/
}); 

$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
 
}); 

 
$app->router->handle();
$app->theme->render();