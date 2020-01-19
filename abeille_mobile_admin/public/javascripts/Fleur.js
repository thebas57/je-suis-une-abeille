$(document).ready(() => {

    $('.supprFleur').click(function () {
        fetch('supprFleur/' + $(this).attr("data-id")).then(() => {
           $($(this).parent().parent()).remove(); 
        })
    });

});