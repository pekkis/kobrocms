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

// Configure DI
$app['config'] = parse_ini_file(__DIR__ . "/../config/config.ini");
$app['db'] = $app->share(function() use($app) {
    return new PDO("mysql:host={$app['config']['db_host']};dbname={$app['config']['db_schema']}", 
            $app['config']['db_user'], $app['config']['db_password']);
});
$app['service.news'] = $app->share(function() use($app) {
    return new Service\News();
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

$app->run();
