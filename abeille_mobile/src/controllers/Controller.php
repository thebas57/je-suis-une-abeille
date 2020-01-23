<?php

namespace abeille_mobile\controllers;

use abeille_mobile\models\Fleur;
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
     * Fonction permettant d'afficher les fleurs.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function voirFleurs($request, $response)
    {
        $fleurs = Fleur::all();

        return $this->render($response, 'Fleurs.html.twig', ['fleurs' => $fleurs]);
    } //End of function afficherAccuei

    




}
