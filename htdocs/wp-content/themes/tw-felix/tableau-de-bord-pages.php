<?php
/**
* Charge les scripts et feuilles de style propres au thème.
* @author Christiane Lagacé <christiane.lagace@hotmail.com>
* Modifié par : Félix Dupras-Simard
*
* Utilisation : add_action('wp_enqueue_scripts', 'felix_charger_css_js_web');
*/
function felix_charger_css_js_web() {
wp_enqueue_style( 'css-theme-enfant', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'felix_charger_css_js_web' );
