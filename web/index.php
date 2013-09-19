<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';

use Beervana\JsonUserPersister;
use Beervana\User;

$app['user.persist_path'] = '/storage/users';
$app['user.persister'] = $app->share(function ($app) {
    return new JsonUserPersister($app['user.persist_path']);
});

$app->get('/register', function(Request $request) use($app) {
    $username = $request->get('username');
    $email = $request->get('email');
    $attributes = array(
        "username" => $username,
        "email" => $email
    );
    $user = new User($attributes);
    return $app['user.persister']->persist($user);
});

$app->run();