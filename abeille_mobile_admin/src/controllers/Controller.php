<?php

namespace abeille_mobile_admin\controllers;


use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use abeille_mobile_admin\models\Fleur;
use abeille_mobile_admin\models\Emplacement;


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
     * Fonction permettant d'afficher le formulaire d'ajout de fleur.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function afficherAddFleur($request, $response, $args)
    {
        $emplacement = Emplacement::all();
        return $this->render($response, 'AddFleur.html.twig', ['emplacements' => $emplacement]);
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
            $emplacement = (!empty($_POST['emplacement'])) ? $_POST['emplacement'] : null;

            //on verifie que les champs sont tous remplis
            if (!isset($nom) || !isset($desc) || !isset($pts) || !isset($emplacement))
                throw new \Exception("un champs requis n'a pas été rempli");

            //on filtre les données
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $desc = filter_var($desc, FILTER_SANITIZE_STRING);
            $pts = filter_var($pts, FILTER_SANITIZE_NUMBER_INT);
            $emplacement = filter_var($emplacement, FILTER_SANITIZE_NUMBER_INT);

            //on les insère en bdd
            $fleur = new Fleur();
            $fleur->nom = $nom;
            $fleur->description = $desc;
            $fleur->points = $pts;
            $fleur->emplacement_id = $emplacement;
            $fleur->save();

            //libération des variables
            unset($nom);
            unset($desc);
            unset($pts);
            unset($emplacement);

            //redirection
            $fleur = Fleur::all();
            return $this->redirect($response, 'voirFleurs');
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    } //end of function addFleur

    /**
     * Fonction permettant d'afficher la modif des fleurs.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function afficherModifFleur($request, $response, $args)
    {
        $id = Fleur::find(intVal($args['id']));
        $emplacement = Emplacement::all();
        return $this->render($response, 'ModifFleur.html.twig', ['fleur' => $id, 'emplacements' => $emplacement]);
    } //End of function afficherModifFleur

    /**
     * Fonction permettant de modifier des fleurs.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function modifFleur($request, $response,$args)
    {

        $fleur = Fleur::find(intVal($args['id']));

        //on les insère en bdd
        $fleur->nom = $_POST['nom'];
        $fleur->description = $_POST['desc'];
        $fleur->points = $_POST['pts'];
        $fleur->emplacement_id = $_POST['emplacement'];
        $fleur->save();

        //redirection
        $fleurs = Fleur::all();
        return $this->redirect($response, 'voirFleurs');
    } //end of function modifFleur

}
