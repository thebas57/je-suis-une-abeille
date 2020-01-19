<?php

namespace abeille_mobile\controllers;

// use abeille_mobile\models\Fleurs;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


class Controller extends BaseController
{

    /**
     * Fonction permettant d'afficher la page d'accueil.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function afficherAccueil($request, $response)
    {
        return $this->render($response, 'Accueil.html.twig');
    } //End of function afficherAccueil

    /**
     * Fonction permettant d'afficher la liste des fleurs.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function voirFleurs($request, $response)
    {
        return $this->render($response, 'Fleurs.html.twig');
    } //End of function voirFleurs

    




}
