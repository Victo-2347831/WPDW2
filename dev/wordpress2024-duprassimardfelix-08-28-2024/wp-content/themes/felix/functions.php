<?php
/**
 * Fonction de rappel du hook after_setup_theme, exécutée après que le thème ait été initialisé.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
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
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
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
	} else {
		return $data['Version'];
	}
}

/**
 * Charge les scripts et feuilles de style propres au thème.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action('wp_enqueue_scripts', 'felix_charger_css_js_web');
 */
function felix_charger_css_js_web() {
    wp_enqueue_style( 'css-theme-enfant', get_stylesheet_uri() );
}


add_action( 'wp_enqueue_scripts', 'felix_charger_css_js_web' );

