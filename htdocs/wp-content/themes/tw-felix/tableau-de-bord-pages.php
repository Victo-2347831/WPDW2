<?php
/**
* Charge les scripts et feuilles de style propres au thème.
* @author Christiane Lagacé <christiane.lagace@hotmail.com>
* Modifié par : Félix Dupras-Simard
*
* Utilisation : add_action('wp_enqueue_scripts', 'felix_charger_css_js_web');
*/
function felix_charger_css_js_web() {
	global $post;

	wp_enqueue_style( 'css-theme-enfant', get_stylesheet_uri() );

	// charge Google reCAPTCHA seulement si on est sur le formulaire de contact
	if ( has_shortcode( $post->post_content, 'felixaffichagecontact') ) {
		// charge l'API de Google reCAPTCHA
		wp_enqueue_script( 'apigooglerecaptcha', 'https://www.google.com/recaptcha/api.js?render=6LezfG8qAAAAAJ9X1nMccWkwMlF0a5VLrrETwcPl' );

		// charge le code JavaScript pour gérer Google reCAPTCHA
		wp_enqueue_script( 'googlerecaptcha', get_stylesheet_directory_uri() . '/js/google-recaptcha.js' );
	}
}

add_action( 'wp_enqueue_scripts', 'felix_charger_css_js_web' );
