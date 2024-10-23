<?php

/**
 * Enregistre une information de débogage dans le fichier debug.log, seulement si WP_DEBUG est à true.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Inspiré de http://wp.smashingmagazine.com/2011/03/08/ten-things-every-wordpress-plugin-developer-should-know/
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : felix_log_debugW( 'test' );
 */
function felix_log_debug($message) {
	if ( WP_DEBUG === true ) {
		if ( is_array( $message ) || is_object( $message ) ) {
			error_log( 'Message de débogage: ' . print_r( $message, true ) );
		} else {
			error_log( 'Message de débogage: ' . $message );
		}
	}
}

/**
 * Affiche une information de débogage à l'écran, seulement si WP_DEBUG est à true.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : felix_echo_debug( 'test' );
 * Suppositions critiques : le style .debug doit définir l'apparence du texte
 */
function felix_echo_debug( $message ) {
	if ( WP_DEBUG === true ) {
		if ( ! empty( $message ) ) {
			echo '<span class="debug">';
			if ( is_array( $message ) || is_object( $message ) ) {
				echo '<pre>';
				print_r( $message ) ;
				echo '</pre>';
			} else {
				echo $message ;
			}
			echo '</span>';
		}
	}
}

/**
 * Avertir l'usager qu'une maintenance du site est prévue prochainement.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action( 'loop_start', 'monprefixe_avertir_maintenance' );
 */
function felix_avertir_maintenance( $message ) {
	// on pourrait aussi travailler avec la base de données pour savoir quand un message doit être affiché ou non et pour retrouver le message à afficher.
	echo '<div class="messagegeneral">Attention : le 15 juin à 11h, des travaux d\'entretien seront effectués. Le site ne sera pas disponible pendant deux heures.</div>';
}

//add_action( 'wp_body_open', 'felix_avertir_maintenance' );

function felix_verification_message_session( $message ) {
	// Détecte si il y a un erreur
	if ($_SESSION['formulaire_reussi'] != ""){
		// Affiche le code d'erreur
		echo "<div class='messagegeneral'>";
		echo $_SESSION['formulaire_reussi'];
		echo "</div>";

		// Réinitialise la variable de session
		$_SESSION['formulaire_reussi'] = "";
	}
}

add_action( 'wp_body_open', 'felix_verification_message_session' );
