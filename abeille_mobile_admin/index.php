<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// use abeille_mobile\models\fleurs;

require __DIR__ . '/src/config/config.inc.php';
require __DIR__ . '/vendor/autoload.php';

// Create container
$container = array();


///////////
// TWIG //
//////////

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('src/views', ["debug" => true]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

  //  $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};


///////////////
// ELOQUENT //
//////////////
$container['settings'] = $config;
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

// Init Slim
$app = new \Slim\App($container);

//session_start
session_start();


//////////////
// ROUTAGE //
/////////////

//Page Accueil
$app->get('/','\\abeille_mobile_admin\\controllers\\Controller:afficherAccueil');

// Page des gestion de plante
$app->get('/fleurs','\\abeille_mobile_admin\\controllers\\Controller:voirFleurs')->setName("voirFleurs");

// Page d'ajout de plante + ajout
$app->get('/addFleur','\\abeille_mobile_admin\\controllers\\Controller:afficherAddFleur')->setName("addFleur");
$app->post('/addFleur','\\abeille_mobile_admin\\controllers\\Controller:addFleur');

// Supprimer une fleur
$app->get('/supprFleur/{id}','\\abeille_mobile_admin\\controllers\\Controller:supprFleur');

// Modifier une fleur
$app->get('/modifFleur{id}','\\abeille_mobile_admin\\controllers\\Controller:afficherModifFleur')->setName('modifFleur');
$app->post('/modifFleur{id}','\\abeille_mobile_admin\\controllers\\Controller:modifFleur');

// Recherche de fleur
$app->get('/chercherFleur/{critere}','\\abeille_mobile_admin\\controllers\\Controller:rechercherFleur');



/////////////
// RUN     //
/////////////
$app->run();
