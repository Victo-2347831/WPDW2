<?php
require_once('tableau-de-bord-menus.php');
require_once('tableau-de-bord-tables.php');
require_once('tableau-de-bord-pages.php');
require_once('tableau-de-bord-messages.php');
require_once('shortcodes.php');

/**
 * Fonction de rappel du hook after_setup_theme, exécutée après que le thème ait été initialisé.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : add_action( 'after_setup_theme', 'felix_apres_initialisation_theme' );
 */
function felix_apres_initialisation_theme() {
	// Retirer la balise <meta name="generator">
	remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'after_setup_theme', 'felix_apres_initialisation_theme' );

/**
 * Change l'attribut ?ver des .css et des .js pour utiliser celui de la version de style.css.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : add_filter( 'style_loader_src', 'felix_attribut_version_style', 9999 );
 *               add_filter( 'script_loader_src', 'felix_attribut_version_style', 9999 );
 * Suppositions critiques : dans l'entête du fichier style.css du thème enfant, le numéro de version
 *                          à utiliser est inscrit à la ligne Version (ex : Version: ...)
 *
 * @return String Url de la ressource, se terminant par ?ver= suivi du numéro de version lu dans style.css
 *
 */
function felix_attribut_version_style( $src ) {
	$version = felix_version_style();
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version') ) ) {
		$src = remove_query_arg( 'ver', $src );
		$src = add_query_arg( 'ver', $version, $src );
	}
	return $src;
}

add_filter( 'style_loader_src', 'felix_attribut_version_style', 9999 );
add_filter( 'script_loader_src', 'felix_attribut_version_style', 9999 );

/**
 * Retrouve le numéro de version de la feuille de style.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : $version = felix_version_style();
 * Suppositions critiques : dans l'entête du fichier style.css du thème enfant, le numéro de version
 *                          à utiliser est inscrit à la ligne Version (ex : Version: ...)
 *
 * @return String Le numéro de version lu dans style.css ou, s'il est absent, le numéro 1.0
 *
 */
function felix_version_style() {
	$default_headers =  array( 'Version' => 'Version' );
	$fichier = get_stylesheet_directory() . '/style.css';
	$data = get_file_data( $fichier, $default_headers );
	if ( empty( $data['Version'] ) ) {
		return "1.0";
	}

	return $data['Version'];
}

/**
 * Active les variables de session.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action( 'init', 'monprefixe_session_start', 1 );
 */
function felix_session_start() {
	if ( ! session_id() ) {
		@session_start();
	}
}

add_action( 'init', 'felix_session_start', 1 );

/**
 * Configurer l'envoi de courriel par SMTP.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action( 'phpmailer_init', 'monprefixe_configurer_courriel' );
 * L'envoi de courriel ser fera comme suit :
 * wp_mail( "destinataire@sondomaine.com", "Sujet", "Message" );
 */
function felix_configurer_courriel( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host = SMTP_HOST;
	$phpmailer->SMTPAuth = SMTP_AUTH;
	$phpmailer->Port = SMTP_PORT;
	$phpmailer->SMTPSecure = SMTP_SECURE;
	$phpmailer->Username = SMTP_USERNAME;
	$phpmailer->Password = SMTP_PASSWORD;
	$phpmailer->From = SMTP_FROM;
	$phpmailer->FromName = SMTP_FROMNAME;
}

add_action( 'phpmailer_init', 'felix_configurer_courriel' );
