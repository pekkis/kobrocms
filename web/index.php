<?php

$autoloader = require_once __DIR__.'/../vendor/autoload.php';
$autoloader->add('Service', __DIR__.'/../');
$autoloader->add('Security', __DIR__.'/../');

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;
$app['config'] = parse_ini_file(__DIR__ . "/../config/config.ini");

// Register providers
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'host' => 'smtp.metropolia.fi',
);
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => $app['config']['db_host'],
        'user' => $app['config']['db_user'],
        'password' => $app['config']['db_password'],
        'password' => $app['config']['db_password'],
        'dbname' => $app['config']['db_schema']
    ),
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app['security.firewalls'] = array(
    'login' => array(
        'anonymous' => true,
        'pattern' => '^.*$',
        // Check path must be at the secured area
        'form' => array('login_path' => '/user/login', 'check_path' => '/user/login/check'),
        'logout' => array('logout_path' => '/user/logout'),
        'users' => $app->share(function() use ($app) {
            return new Security\UserProvider($app['db']);
        }),
    )
);
        
$app['security.access_rules'] = array(
    array('^/home/save', 'ROLE_ADMIN'),
    array('^/home/edit', 'ROLE_ADMIN'),
    array('^/about/save', 'ROLE_ADMIN'),
    array('^/about/edit', 'ROLE_ADMIN')
);

// Configure DI
$app['service.news'] = $app->share(function() use($app) {
    return new Service\News($app['db']);
});
$app['service.contact'] = $app->share(function() use($app) {
    return new Service\Contact($app['mailer'], $app['config']['contact_email'], 'Feedback from dem feedbacks form');
});
$app['service.employ'] = $app->share(function() {
    return new Service\Employ();
});
$app['service.poll'] = $app->share(function() use($app) {
    return new Service\Poll($app['db']);
});
$app['service.html'] = $app->share(function() use($app) {
    return new Service\Html($app['db']);
});

// Configure routes
$app->get('/', function() use ($app) {
    return $app['twig']->render('home/default.html.twig', array (
        'content' => $app['service.html']->getHome()
    ));
})
->bind('home');

$app->get('/home/edit', function() use ($app) {
    return $app['twig']->render('/home/edit.html.twig', array (
        'content' => $app['service.html']->getHome()
    ));
})
->bind('home.edit');

$app->post('/home/save', function() use ($app) {
    $app['service.html']->saveHome($app['request']->get('content'));
    
    return $app->redirect($app['url_generator']->generate('home.edit'));
})
->bind('home.save');

$app->get('/about', function() use ($app) {
    return $app['twig']->render('about/default.html.twig', array (
        'content' => $app['service.html']->getAbout()
    ));     
})
->bind('about');

$app->get('/about/edit', function() use ($app) {
    return $app['twig']->render('/about/edit.html.twig', array (
        'content' => $app['service.html']->getAbout()
    ));
})
->bind('about.edit');

$app->post('/about/save', function() use ($app) {
    $app['service.html']->saveAbout($app['request']->get('content'));
    
    return $app->redirect($app['url_generator']->generate('about.edit'));
})
->bind('about.save');

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

$app->get('/news/headlines/{count}', function($count) use ($app) {
    $news = $app['service.news']->getHeadlines($count);

    return $app['twig']->render('news/headlines.html.twig', array (
        'news' => $news
    ));     
})
->bind('news.headlines');

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

$app->get('/poll/{id}', function($id) use ($app) {
    $question = $app['service.poll']->getQuestion($id);
    $answers = $app['service.poll']->getAnswers($id);
    
    return $app['twig']->render('poll/default.html.twig', array (
        'question' => $question,
        'answers' => $answers
    ));
})
->bind('poll');

$app->get('/poll/vote/{questionId}/{answerId}', function($questionId, $answerId) use ($app) {
    $app['service.poll']->vote($questionId, $answerId);
    
    return $app->redirect('/');
})
->bind('poll.vote');

$app->get('/quicksearch', function() use($app) {
   return $app['twig']->render('search/quicksearch.html.twig'); 
})
->bind('quicksearch');

$app->post('/search', function() use($app) {
   return $app['twig']->render('search/search.html.twig', array(
       'searchString' => $app['request']->get('s')
   )); 
})
->bind('search');

$app->get('/user/login', function(Request $request) use($app) {
   return $app['twig']->render('user/login.html.twig', array(
       'error' => $app['security.last_error']($request)
   )); 
})
->bind('user.login');

$app->run();
