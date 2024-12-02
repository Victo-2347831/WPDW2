// il faut laisser le temps à WordPress de charger la page et plus particulièrement le shortcode qui affiche le formulaire
document.addEventListener("DOMContentLoaded", function(event) {
    let formulaireContact = document.getElementById('formulaireContact');

    if (formulaireContact != null) {
        formulaireContact.onsubmit = validerFormulaire;
    }
});


function validerFormulaire(event) {
    event.preventDefault();
    let valide = true;


    let sujetMessage = document.getElementById('sujetMessage');

    if (sujetMessage == null) {
        valide = false;
    }
    else {
        if (sujetMessage.value == '') {
            valide = false;
        }
    }

    if (valide) {
        gererRecaptcha(event);
    }
    else {
        // identifier les champs invalides et afficher le ou les messages d'erreur
    }
}

function gererRecaptcha(event) {
    // note : ceci n'est pas du jQuery et fonctionnera avec en JavaScript pur
    grecaptcha.ready(function() {
        grecaptcha.execute('6LezfG8qAAAAAJ9X1nMccWkwMlF0a5VLrrETwcPl', {action: 'soumissioncontact'}).then(function(token) {
            // ajout de la réponse de Google reCAPTCHA dans le formulaire
            let input = document.createElement('input');
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "g-recaptcha-response");
            input.setAttribute("value", token);


            let formulaireContact = document.getElementById('formulaireContact');

            if (formulaireContact != null) {
                formulaireContact.appendChild(input);
                // soumission du formulaire
                formulaireContact.submit();   // ne cause pas de boucle sans fin puisqu'ici, aucun événement submit n'est déclenché (https://developer.mozilla.org/fr/docs/Web/API/HTMLFormElement/submit)
            }
        });
    });
}
