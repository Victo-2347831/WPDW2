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

// Retour à la page d'accueil
$_SESSION['formulaire_reussi'] = $messageErreur;
$url_retour = get_site_url();
wp_redirect( $url_retour );
