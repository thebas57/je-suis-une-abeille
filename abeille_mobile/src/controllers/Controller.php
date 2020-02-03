<?php

namespace abeille_mobile\controllers;

use abeille_mobile\models\Fleur;
use abeille_mobile\models\Emplacement;

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
        $emplacement = new Emplacement();
        $tab = [];
        foreach ($fleurs as $key => $fleur) {
            $emplacement = Emplacement::find($fleur->emplacement_id);
            $tmp = ['emplacement' => $emplacement->nom];
            array_push($tab, $tmp);
        }
        unset($emplacement);
        unset($tmp);

        return $this->render($response, 'Fleurs.html.twig', ['fleurs' => $fleurs, 'emplacement' => $tab]);
    } //End of function afficherAccuei


    /**
     * Fonction permettant d'afficher les règles.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function voirRegles($request, $response)
    {

        return $this->render($response, 'Regles.html.twig');
    } //End of function voirRegles

        /**
     * Fonction permettant d'afficher le parcours.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function voirParcours($request, $response)
    {

        return $this->render($response, 'Parcours.html.twig');
    } //End of function voirParcours

            /**
     * Fonction permettant de commencer la partie.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function commencerPartie($request, $response)
    {

        return $this->render($response, 'Jouer.html.twig');
    } //End of function commencerPartie



    /**
     * Fonction permettant de Voir les scores.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function voirScores($request, $response)
    {

        return $this->render($response, 'Score.html.twig');
    } //End of function commencerPartie



    




}
