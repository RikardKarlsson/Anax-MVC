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
$app->theme->setVariable("htmlClassesStrTwo", "html--index");
//dump($app);
//navbar is added in argument file
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_grid.php');//set navbar to other than defaul

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
    $app->theme->addClassAttributeFor("body", "me");
    $app->theme->addClassAttributeFor("html", "html--circle");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $aside = $app->fileContent->get('me_aside.md');
    $aside = $app->textFilter->doFilter($aside, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('grid/typography-me', [
        'content' => $content,
        'byline' => $byline,
    ]);
    $app->views->add('grid/typography-me', [
        'content' => $aside,
    ], 'sidebar--left');
    $app->views->add('grid/typography-me', [
        'content' => $aside,
    ], 'sidebar--right');
    
    
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>[''],
    ]);
});$app->router->add('me', function() use ($app) {
    $app->theme->setTitle("Rikard Karlsson");
    $app->theme->addClassAttributeFor("body", "me");
    $app->theme->addClassAttributeFor("html", "html--circle");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $aside = $app->fileContent->get('me_aside.md');
    $aside = $app->textFilter->doFilter($aside, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('grid/typography-me', [
        'content' => $content,
        'byline' => $byline,
    ]);
    $app->views->add('grid/typography-me', [
        'content' => $aside,
    ], 'sidebar--left');
    $app->views->add('grid/typography-me', [
        'content' => $aside,
    ], 'sidebar--right');
    
    
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>[''],
    ]);
});

//content from file
$app->router->add('redovisning', function() use ($app) {
 
    $app->theme->setTitle("Redovisning");
 
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $menu = $app->fileContent->get('menu-report.md');
    $menu = $app->textFilter->doFilter($menu, 'shortcode, markdown');
    
    $app->views->add('grid/report', [
        'content' => $content,
        'byline' => $byline,
    ]);
    $app->views->add('grid/report-menu', [
        'content' => $menu,
    ], 'sidebar--right');
    
    //$app->views->add('comment/index');
    //dump($_POST);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params' =>['redovisning'],
    ]);
 
});
/*
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
    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown'); 
    include('incl/calendar.php');
    $content = $lark['main'];
    $app->views->add('me/calendar', [
        'content' => $content,
        'byline' => $byline,
    ]); 
});
*/
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
$app->router->add('regioner', function() use ($app) {
 
    //$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('sidebar--left', 'sidebar--left')
               ->addString('main', 'main')
               ->addString('sidebar--right', 'sidebar--right')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});
$app->router->add('regioner-left-main', function() use ($app) {
 
    //$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner left+main");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('sidebar--left', 'sidebar--left')
               ->addString('main', 'main')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});
$app->router->add('regioner-main-right', function() use ($app) {
 
    //$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner main-right");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar--right', 'sidebar--right')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});
$app->router->add('typografi',  function() use ($app) {
    $app->theme->setTitle("Typografi");
 
    $content = $app->fileContent->get('typography.html');
    //$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
    
    $app->views->add('grid/typografi', [
        'content' => $content,
    ]);
    $app->views->add('grid/typografi', [
        'content' => $content,
    ], 'sidebar--right');
    
});
$app->router->add('font-awesome',  function() use ($app) {
    $app->theme->setTitle("Font Awesome");
    //$app->theme->setVariable("bodyClassesStr", "font-awesome more");
    $app->theme->addClassAttributeFor("body", "font-awesome");
 
    $content = $app->fileContent->get('font-awesome.md');
    $contentAside = $app->fileContent->get('font-awesome-aside.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    $contentAside = $app->textFilter->doFilter($contentAside, 'shortcode, markdown');
 
    
    $app->views->add('grid/typografi', [
        'content' => $content,
    ]);
    $app->views->add('grid/typografi', [
        'content' => $contentAside,
    ], 'sidebar--left');
    
});
$app->router->add('source', function() use ($app) {
 
    $app->theme->addStylesheet('css/source.css');//TODO use less
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
//echo $app->getBaseUrl();
 
$app->router->handle();
$app->theme->render();