<?php
// Chargement des différentes fonctions WordPress
require_once "../../../wp-load.php";

// Fonctions personnelle
function renvoiFormulaire() {
	// Renvoie au formulaire
	$url_retour = admin_url( "admin.php?page=felix_gestion");
	wp_redirect($url_retour);
}

// Vérification de la validité du nonce
if ( isset($_POST['itemModification'] ) && wp_verify_nonce( $_POST['itemModification'], 'modifier_item_$id' ) ) {


}
// Traitement à effectuer si le nonce n'est pas valide
else {
	renvoiFormulaire();
}
