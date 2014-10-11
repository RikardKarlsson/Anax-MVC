<?php
require __DIR__.'/config_with_app.php'; 

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
 
});
$app->router->add('kasta-tarning', function() use ($app) {
 
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