<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/', function() use ($app) {
    return $app['twig']->render('home.html.twig');
})
->bind('home');

$app->get('/about', function() use ($app) {
    return $app['twig']->render('about.html.twig', array(
        'title' => 'About Dr. Kobros FoundationSSSI'
    ));     
})
->bind('about');

$app->run();
