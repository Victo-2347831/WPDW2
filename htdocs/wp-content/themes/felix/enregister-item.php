<?php
// Chargement des différentes fonctions WordPress
require_once "../../../wp-load.php";

// Fonctions personnelle
function renvoiFormulaire() {
	// Renvoie au formulaire
	$url_retour = admin_url( "admin.php?page=felix_ajout");
	wp_redirect($url_retour);
}

// Protecion XSS
foreach ($_POST as $cle => $valeur) {
	$_POST[$cle] = htmlspecialchars($valeur, ENT_QUOTES);
}
$_POST = stripslashes_deep( $_POST );

// Vérification de la validité du nonce
if ( isset($_POST['itemEnregistre'] ) && wp_verify_nonce( $_POST['itemEnregistre'], 'enregister_item' ) ) {
	// Initialisation des variables
	$nomItem = $_POST['nomItem'];
	$descriptionItem = $_POST['descriptionItem'];

	// Validations Serveur
	$messageErreur = '';

	// Gestion Erreur : Champs Obligatoires
	if ('' == $nomItem){
		$messageErreur .= 'Le nom est requis.<br>';
	}
	if ('' == $descriptionItem){
		$messageErreur .= 'La description est requise.<br>';
	}

	// Affichage du/des message(s) d'erreur(s) si il y a lieu
	if ('' != $messageErreur) {
		$_SESSION['formulaire_reussi'] = $messageErreur;

		renvoiFormulaire();
	}
	// Enregistrement des données si il n'y a pas d'erreur
	else {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		// Insertion de l'item reçu par le formulaire
		$table_items = $wpdb->prefix.'felix_items';

		// Tente l'insertion
		$reussite = $wpdb->insert(
			$table_items,
			array(
				'nom' => $nomItem,
				'description' => $descriptionItem
			),
			array(
				'%s',
				'%s'
			)
		);

		if ( ! $reussite) {
			felix_log_debug( $wpdb->last_error);
		}

		$_SESSION['formulaire_reussi'] = "Envoi réussi !";
		renvoiFormulaire();
	}

}
// Traitement à effectuer si le nonce n'est pas valide
else {
	renvoiFormulaire();
}
