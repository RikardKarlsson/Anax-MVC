<?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential settings.
require __DIR__.'/config.php'; 
//require __DIR__.'/config_with_app.php'; 



// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new \Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');//set navbar to other than defaul



// Home route
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Guestbook");
    $app->views->add('comment/index');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);
    $content = null;
    $saveAction = 'doCreate';
    $id = null;
    if ( isset($_GET['id']) ) {
//TODO use other form width
//onClick="this.form.action = '<?=$this->url->create('comment/edit') done
//add function editAction in the class CommentController.
//add function getCommentWithId($id) to CommentsInSession.
//<input class='button button--smaller' type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add')'"/>
//replace name='doCreate' width doEdit, on line above
//and $this->url->create('comment/add')
// replace /add with /edit
        is_numeric($_GET['id']) or die ("id is not a number");
        $content = "innehåll från session ";
        $saveAction = 'doEdit';
        $id = $_GET['id'];
        
    }
    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => $content,
        'output'    => null,
        'saveAction' => $saveAction,
        'id' => $id,
    ]);
});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();
