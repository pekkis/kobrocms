<?php

$autoloader = require_once __DIR__.'/../vendor/autoload.php';
$autoloader->add('Service', __DIR__.'/../');

$app = new Silex\Application();
$app['debug'] = true;

// Register providers
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'host' => 'smtp.metropolia.fi',
);

// Configure DI
$app['config'] = parse_ini_file(__DIR__ . "/../config/config.ini");
$app['db'] = $app->share(function() use($app) {
    return new PDO("mysql:host={$app['config']['db_host']};dbname={$app['config']['db_schema']}", 
            $app['config']['db_user'], $app['config']['db_password']);
});
$app['service.news'] = $app->share(function() use($app) {
    return new Service\News($app['db']);
});
$app['service.contact'] = $app->share(function() use($app) {
    return new Service\Contact($app['mailer'], $app['config']['contact_email'], 'Feedback from dem feedbacks form');
});
$app['service.employ'] = $app->share(function() use($app) {
    return new Service\Employ();
});

// Configure routes
$app->get('/', function() use ($app) {
    $stmt = $app['db']->query("SELECT content FROM html WHERE block_id = 1 AND page_id = 1");
    $content = $stmt->fetchColumn();
    
    return $app['twig']->render('home.html.twig', array (
        'content' => $content
    ));
})
->bind('home');

$app->get('/about', function() use ($app) {
    $stmt = $app['db']->query("SELECT content FROM html WHERE block_id = 1 AND page_id = 2");
    $content = $stmt->fetchColumn();
    
    return $app['twig']->render('about.html.twig', array (
        'content' => $content
    ));     
})
->bind('about');

$app->get('/news', function() use ($app) {
    $news = $app['service.news']->getAllNews();

    return $app['twig']->render('news/default.html.twig', array (
        'news' => $news
    ));     
})
->bind('news');

$app->get('/news/view/{id}', function($id) use ($app) {
    $news = $app['service.news']->getNewsById($id);
    $comments = $app['service.news']->getNewsComments($id);

    return $app['twig']->render('news/view.html.twig', array (
        'news' => $news,
        'comments' => $comments
    ));     
})
->bind('news.view');

$app->post('/news/comment', function() use ($app) {
    $newsId = $app['request']->get('newsId');
    $comment = $app['request']->get('comment');
    
    $app['service.news']->addCommentToNews($newsId, $comment);

    return $app->redirect('/news/view/' . $newsId);
})
->bind('news.comment');

$app->get('/contact', function() use ($app) {
    return $app['twig']->render('contact/default.html.twig', array (
        'error' => false
    ));
})
->bind('contact');

$app->post('/contact/send', function() use ($app) {
    $fromEmail = $app['request']->get('from');
    $message = $app['request']->get('message');
    
    $error = !$app['service.contact']->sendContact($fromEmail, $message);
    
    return $app['twig']->render('contact/default.html.twig', array (
        'error' => $error
    ));
})
->bind('contact.send');

$app->get('/employ', function() use ($app) {
    return $app['twig']->render('employ/default.html.twig', array (
        'error' => false
    ));
})
->bind('employ');

$app->post('/employ/send', function() use ($app) {
    $cv = $app['request']->files->get('cv');

    $result = !$app['service.employ']->saveCV($cv);
    
    return $app['twig']->render('employ/default.html.twig', array (
        'error' => $result
    ));
})
->bind('employ.send');

$app->run();
