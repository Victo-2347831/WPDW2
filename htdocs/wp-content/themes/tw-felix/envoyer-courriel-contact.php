<?php
// chargement des fonctionnalités WordPress nécessaires au traitement
require_once "../../../wp-load.php";

// *** protection XSS ******************************************************************
foreach ( $_POST as $cle => $valeur ) {
	$_POST[$cle] = esc_attr( stripslashes_deep( $valeur ) );
}

// *** initialisation des variables pour clarifier le code *****************************
$email = $_POST['email'];
$sujetMessage = $_POST['sujetMessage'];
$message = $_POST['message'];

// *** validations côté serveur ********************************************************
$messageErreur = '';

// format attendu : champs obligatoires
if ('' == $email) {
	$messageErreur .= "L'adresse courriel est requise.<br>";
}

if ('' == $sujetMessage) {
	$messageErreur .= "Le sujet du message est requis.<br>";
}

if ('' == $message) {
	$messageErreur .= "Le message est requis.<br>";
}

// format attendu : courriel
$email = filter_var($email, FILTER_SANITIZE_EMAIL);   // on commence par enlever les caractères non acceptés
if (!filter_var( $email, FILTER_VALIDATE_EMAIL)) {
	$messageErreur .= 'Le courriel n\'est pas valide.<br>&nbsp;&nbsp;- Il doit être au format unnom@undomaine.uneextension.<br>&nbsp;&nbsp;- Il doit comporter un seul caractère @.<br>&nbsp;&nbsp;- Ce caractère doit être suivi d\'un nom de domaine qui contient au moins un point puis une extension.<br>&nbsp;&nbsp;- Les caractères spéciaux ne sont pas acceptés.<br>';
}

// Envoi du formulaire dans la base de données si il n'y a pas d'erreur
if ($messageErreur == ''){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	// Insertions des données
	date_default_timezone_set('America/Montreal'); // Utile pour la donnée sur la date et l'heure de l'envoi

	$table_contacts = $wpdb->prefix . 'felix_contacts';
	$reussite = $wpdb->insert(
		$table_contacts,
		array(
			'courriel' => $email,
			'sujetMessage'  => $sujetMessage,
			'message'  => $message,
			'dateEnvoi' => date("Y-m-d H:i:s"),
			'ipClient' => $_SERVER['REMOTE_ADDR']
		),
		array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		)
	);

	if ( ! $reussite ) {
		// réagir en cas de problème
		monprefixe_log_debug( $wpdb->last_error );
	}
}

// Retour à la page d'accueil
$_SESSION['formulaire_reussi'] = $messageErreur;
$url_retour = get_site_url();
wp_redirect( $url_retour );
