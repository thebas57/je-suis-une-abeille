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
            $nomFr = (!empty($_POST['nomFr'])) ? $_POST['nomFr'] : null;
            $nomL = (!empty($_POST['nomL'])) ? $_POST['nomL'] : null;
            $nectar = (!empty($_POST['nectar'])) ? $_POST['nectar'] : null;
            $pollen = (!empty($_POST['pollen'])) ? $_POST['pollen'] : null;
            $floraison = (!empty($_POST['floraison'])) ? $_POST['floraison'] : null;
            $couleur = (!empty($_POST['couleur'])) ? $_POST['couleur'] : null;
            $hauteur = (!empty($_POST['hauteur'])) ? $_POST['hauteur'] : null;
            $emplacement = (!empty($_POST['emplacement'])) ? $_POST['emplacement'] : null;

            //on verifie que les champs sont tous remplis
            if (!isset($nomFr) || !isset($nomL) || !isset($nectar) || !isset($emplacement) || !isset($pollen) || !isset($floraison) || !isset($couleur) || !isset($hauteur))
                throw new \Exception("un champs requis n'a pas été rempli");

            //on filtre les données
            $nomFr = filter_var($nomFr, FILTER_SANITIZE_STRING);
            $nomL = filter_var($nomL, FILTER_SANITIZE_STRING);
            $floraison = filter_var($floraison, FILTER_SANITIZE_STRING);
            $couleur = filter_var($couleur, FILTER_SANITIZE_STRING);
            $nectar = filter_var($nectar, FILTER_SANITIZE_NUMBER_INT);
            $pollen = filter_var($pollen, FILTER_SANITIZE_NUMBER_INT);
            //$hauteur = filter_var($pts, FILTER_SANITIZE_NUMBER_INT);
            $emplacement = filter_var($emplacement, FILTER_SANITIZE_NUMBER_INT);

            //on les insère en bdd
            $fleur = new Fleur();
            $fleur->nomFr = $nomFr;
            $fleur->nomLatin = $nomL;
            $fleur->nectar = $nectar;
            $fleur->pollen = $pollen;
            $fleur->hauteur = $hauteur;
            $fleur->couleur = $couleur;
            $fleur->floraison = $floraison;
            $fleur->emplacement_id = $emplacement;

            $fleur->save();

            //libération des variables
            unset($nomFr);
            unset($nomL);
            unset($nectar);
            unset($emplacement);
            unset($hauteur);
            unset($couleur);
            unset($pollen);
            unset($floraison);

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
        $fleur->nomFr = $_POST['nomFr'];
        $fleur->nomLatin = $_POST['nomL'];
        $fleur->pollen = $_POST['pollen'];
        $fleur->nectar = $_POST['nectar'];
        $fleur->floraison = $_POST['floraison'];
        $fleur->couleur = $_POST['couleur'];
        $fleur->hauteur = $_POST['hauteur'];
        $fleur->emplacement_id = $_POST['emplacement'];

        $fleur->save();

        //redirection
        $fleurs = Fleur::all();
        return $this->redirect($response, 'voirFleurs');
    } //end of function modifFleur

    /**
     * Fonction permettant de rechercher unefleur.
     * @param $request
     * @param $response
     * @param $args
     * @return false|string
     */
    public function rechercherFleur($request,$response,$args){
        $critere = $args['critere'];
        $fleur = null;
        if (is_numeric($critere)){
            $fleur = Fleur::find($critere);
        } else {
            $fleur = Fleur::where('nomLatin','LIKE',$critere)->first();
        }
        return json_encode(['fleur' => $fleur]);
    }//End of function rechercherFleur

}
