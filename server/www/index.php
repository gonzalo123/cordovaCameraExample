<?php

include __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig');
});

$app->post('/img', function(Request $request) use ($app) {
    $img = $request->get('img');

    $fp = fopen(__DIR__ . '/img.jpg', 'w+');
    fwrite($fp, base64_decode($img));
    fclose($fp);

    return $app->json(true);
});

$app->get('/apk', function() use ($app) {
    return $app->sendFile(__DIR__ . '/../../cordova/Camera/platforms/android/bin/HelloCordova-debug.apk');
});

$app->run();