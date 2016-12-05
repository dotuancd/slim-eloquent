<?php

require_once __DIR__  . '/../vendor/autoload.php';

use Slim\App as Application;

$app = new Application();
require_once __DIR__ . '/../app/routes.php';

$container = new \Illuminate\Container\Container();
$serviceProvider = new \Illuminate\Database\DatabaseServiceProvider($container);
$serviceProvider->register();

$finder = \Symfony\Component\Finder\Finder::create();

$finder->files()->name('*.php')->in(__DIR__ . '/../config');

$config = new Illuminate\Config\Repository();
$configFiles = $finder->getIterator();

foreach($configFiles as $key => $file) {
    $key = basename($file->getRealPath(), '.php');
    $config->set($key, require($file->getRealPath()));
}

$container->instance('config', $config);

\Illuminate\Database\Eloquent\Model::setConnectionResolver($container['db']);
//$serviceProvider->boot();

$user = \App\Models\User::first();

\App\Models\User::observe(\App\Observers\User::class);

//$user->email = 'tuanda@ominext.com';
//$user->save();

//dd(\App\Models\User::all());
//dd($container['db']->table('users')->get());

$app->run();