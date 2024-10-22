<?php
/**
* Exécute une boucle dans un tableau et resort les résultats sous format HTML
* @author Félix Dupras-Simard
*
* Utilisation : [felixaffichageBD]
* Suppositions critiques : le style .textespecial doit définir l'apparence du texte
*
* @return String Code html généré par le shortcode
*
*/
function felix_affichage_tableBD() {
	global $wpdb;

	// !! Vérifier internationalisation
	$code_html = "";

	$table_items = $wpdb->prefix . 'felix_items';
	$requete = "SELECT id, nom, description FROM $table_items ORDER BY nom";

	$resultat = $wpdb->get_results( $requete );
	$erreur_sql = $wpdb->last_error;


	if ( "" == $erreur_sql ) {
		if ( $wpdb->num_rows > 0 ) {
			$code_html .= '<table class="tab_items">';
			foreach( $resultat as $enreg ) {
				$code_html .= "<tr>";
				$code_html .= "<td>$enreg->nom</td>";
				$code_html .= "<td>$enreg->description</td>";
				$code_html .= "</tr>";
			}
			$code_html .= '</table>';
		}
		else {
			$code_html .= '<div class="message-avertissement">';
			$code_html .= "Aucune donnée !";
			$code_html .= '</div>';
		}
	}
	else {
		felix_echo_debug($erreur_sql);
	}

	return $code_html;
}

add_shortcode( 'felixaffichageBD', 'felix_affichage_tableBD' );
