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
	if (isset($_SESSION['formulaire_reussi']) && $_SESSION['formulaire_reussi'] != ""){
		// Affiche le code d'erreur
		echo "<div class='messagegeneral'>";
		echo $_SESSION['formulaire_reussi'];
		echo "</div>";

		// Réinitialise la variable de session
		$_SESSION['formulaire_reussi'] = "";
	}

}

add_action( 'wp_body_open', 'felix_verification_message_session' );

/**
 * Logue les erreurs en cas de problème si WP_DEBUG est à true.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action('wp_mail_failed', 'monprefixe_erreur_courriel', 10, 1);
 * Ceci appellera automatiquement cette fonction en cas d'erreur après avoir fait
 * wp_mail( "destinataire@sondomaine.com", "Sujet", "Message" );
 */
function felix_erreur_courriel( $wp_error ) {
	felix_log_debug( $wp_error );
}

add_action( 'wp_mail_failed', 'felix_erreur_courriel', 10, 1 );

/**
 * Affiche un message indiquant que l'item a été ajouté avec succès, seulement si la variable de session existe.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action( 'admin_notices', 'monprefixe_message_ajout_item_reussi' );
 */
function felix_message_ajout_item_reussi() {
	if ( isset( $_SESSION['felix_erreur_creation_table'] ) && $_SESSION['felix_erreur_creation_table'] == true ) {

		echo '<div class="notice notice-error is-dismissible"><p>';
		echo"Un problème a empêché la création des tables requises dans la base de données.";
		echo '</p></div>';

		// supprime la variable de session pour ne pas que le message soit affiché à nouveau
		$_SESSION['felix_erreur_creation_table'] = null;

	}
}

add_action( 'admin_notices', 'felix_message_ajout_item_reussi' );
