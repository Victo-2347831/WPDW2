<?php
/**
 * Crée les tables personnalisées pour mon thème enfant.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 * Modifié par : Félix Dupras-Simard
 *
 * Utilisation : add_action( "after_switch_theme", "felix_creer_tables" );
 */
function felix_creer_tables() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	// TABLE ITEMS
	// CRÉATION TABLE ITEMS
	$table_items = $wpdb->prefix . 'felix_items';
	$sql = "CREATE TABLE $table_items (
        id bigint(20) unsigned NOT NULL auto_increment,
       	nom varchar(50) NOT NULL,
        description varchar(100) NOT NULL,
        quantite bigint(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$taches_realisees = dbDelta( $sql );
	felix_log_debug($taches_realisees);

	$erreur_sql = $wpdb->last_error;

	if ('' != $erreur_sql) {
		// réagir en cas de problème
		felix_log_debug("Erreur lors de la création de la table $table_items.");
		felix_log_debug($erreur_sql);

		$_SESSION['felix_erreur_creation_table'] = true;
	}

	// INSERTION DONNÉES TABLE ITEMS
	$donnees = [
		[ 'Pomme', 'Sac de pommes', 3 ],    // données du premier enregistrement
		[ 'Orange', "Sac d'oranges", 6 ],    // données du deuxième enregistrement
	];

	foreach( $donnees as $donnee ) {
		// à chaque boucle, va chercher les informations pour un enregistrement dans le tableau de données
		$reussite = $wpdb->insert(
			$table_items,
			[
				'nom' => $donnee[0],
				'description' => $donnee[1],
				'quantite' => $donnee[2]
			],
			[
				'%s',
				'%s',
				'%d',
			]
		);

		if ( ! $reussite ) {
			// réagir en cas de problème
			felix_log_debug( $wpdb->last_error );
		}
	}

	// TABLE FORMULAIRE CONTACTS
	// CRÉATION TABLE CONTACTS
	$table_contacts = $wpdb->prefix . 'felix_contacts';
	$sql = "CREATE TABLE $table_contacts (
        id bigint(20) unsigned NOT NULL auto_increment,
       	courriel varchar(100) NOT NULL,
        sujetMessage varchar(100) NOT NULL,
        message varchar(250) NOT NULL,
        dateEnvoi datetime NOT NULL,
        ipClient varchar(20) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$taches_realisees = dbDelta( $sql );
	felix_log_debug($taches_realisees);

	$erreur_sql = $wpdb->last_error;

	if ('' != $erreur_sql) {
		// réagir en cas de problème
		felix_log_debug("Erreur lors de la création de la table $table_contacts.");
		felix_log_debug($erreur_sql);

		$_SESSION['felix_erreur_creation_table'] = true;
	}
}

add_action( "after_switch_theme", "felix_creer_tables" );
