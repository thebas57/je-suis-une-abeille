<?php

namespace abeille_mobile_admin\controllers;


use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use abeille_mobile_admin\models\Fleur;

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
    } //End of function afficherAccuei

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

    /**
     * Fonction permettant d'afficher le formulaire d'ajout de fleur.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function afficherAddFleur($request, $response, $args)
    {
        return $this->render($response, 'AddFleur.html.twig');
    } //End of function addEmission

    /**
     * Fonction permettant de supprimer une fleur
     * @param $request
     * @param $response
     * @return mixed
     */
    public function supprFleur($request, $response, $args)
    {
        $id = $args['id'];
        $fleur = Fleur::find(intVal($id));
        $fleur->delete();
    } //End of function supprFleur

    /**
     * Fonction permettant l'ajout d'une fleur en BDD
     * @param $request
     * @param $response
     * @return mixed
     */
    public function addFleur($request, $response)
    {
        try {
            //on récupère les données du formulaire
            $nom = (!empty($_POST['nom'])) ? $_POST['nom'] : null;
            $desc = (!empty($_POST['desc'])) ? $_POST['desc'] : null;
            $pts = (!empty($_POST['pts'])) ? $_POST['pts'] : null;

            //on verifie que les champs sont tous remplis
            if (!isset($nom) || !isset($desc) || !isset($pts))
                throw new \Exception("un champs requis n'a pas été rempli");

            //on filtre les données
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $desc = filter_var($desc, FILTER_SANITIZE_STRING);
            $pts = filter_var($pts, FILTER_SANITIZE_NUMBER_INT);

            //on les insère en bdd
            $fleur = new Fleur();
            $fleur->nom = $nom;
            $fleur->description = $desc;
            $fleur->points = $pts;
            $fleur->save();

            //libération des variables
            unset($nom);
            unset($desc);
            unset($pts);

            //redirection
            $fleur = Fleur::all();
            return $this->redirect($response, 'voirFleurs');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    } //end of function addFleur

}
