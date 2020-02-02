let fleurID = null;

$(document).ready(() => {

    $('.supprFleur').click(function () {
        fetch('supprFleur/' + $(this).attr("data-id")).then(() => {
           $($(this).parent().parent()).remove(); 
        })
    });

    $('#chercherFleur').click(() => {
        let fleur = $('#fleurAChercher').val();
        if (fleur !== "") {
            $('#fleurAChercher').val("");
            fetch("chercherFleur/" + fleur)
                .then((rep) => {
                    rep.json().then((rep) => {
                        if (!(rep.fleur === null) && fleurID === null) {
                            if (fleurID !== rep.fleur.fleur_id) {
                                fleurID = rep.fleur.fleur_id
                                ajouterFleurDiv(rep.fleur);
                            }
                        } else if(fleurID !== null){
                            alert("Un seule fleur à la fois")
                        } else {
                            alert("Fleur non trouvée !")
                        }
                    })
                })
        }
    });

    function ajouterFleurDiv(fleur) {
        $('.containerF')[0].innerHTML = `
            <div class="fleur">
            <b><label>Nom Latin:</label></b>
            <p>${fleur.nomLatin}</p>
            <b><label>Nom français :</label></b>
            <p>${fleur.nomFr}</p>
            <b><label>Pollen :</label></b>
            ${fleur.pollen}
            <b><label>Nectar :</label></b>
            ${fleur.nectar}
            <b><label>Hauteur :</label></b>
            ${fleur.hauteur}
            <b><label>Floraison :</label></b>
            ${fleur.floraison}</p>
            <b><label>Couleur :</label></b>
            ${fleur.couleur}</p>
            <div class="logo">
                <a href="{{ path_for('modifFleur', {'id' : fleur.fleur_id } ) }}" <li><i class="far fa-edit fa-2x"></i></li></a>
                <a href="#" class="supprFleur" data-id="{{fleur.fleur_id}}"><i class="far fa-trash-alt fa-2x"></i></a>
                <a data-toggle="modal" data-id="{{fleur.fleur_id}}" data-target="#exampleModal{{fleur.fleur_id}}" href=""><i class="far fa-eye fa-2x"></i></a>
            </div>
        `
    }

});