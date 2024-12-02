<?php
/**
 * Ajoute l'option principale du menu pour gérer le thème dans le tableau de bord.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_action( "admin_menu", "monprefixe_ajouter_menu_tableau_de_bord" );
 */
function felix_ajouter_menu_tableau_de_bord() {
	add_menu_page(
		__( "felix - Gestion Inventaire", "felix" ), // texte de la balise <title>, initialisera $title
		__( "Gestion Inventaire", "felix" ),  // titre de l'option de menu
		"manage_options", // droits requis pour voir l'option de menu
		"felix_gestion", // slug
		"felix_creer_page_gestion" // fonction de rappel pour créer la page
	);

	// première option du sous-menu : redéfinit les mêmes critères que le menu
	add_submenu_page(
		"felix_gestion",  // slug du menu parent
		__( "felix - Ajout Produits Inventaire", "felix" ),  // texte de la balise <title> - même que dans add_menu_page()
		__( "Ajouter", "felix" ),   // titre de l'option de sous-menu
		"manage_options",  // droits requis pour voir l'option de menu
		"felix_ajout", // slug
		"felix_creer_page_ajout"  // fonction de rappel pour créer la page - même que dans add_menu_page()
	);

	add_submenu_page(
		"",  // slug du menu parent
		__( "felix - Modification", "felix" ),  // texte de la balise <title> - même que dans add_menu_page()
		__( "Modifier", "felix" ),   // titre de l'option de sous-menu
		"manage_options",  // droits requis pour voir l'option de menu
		"felix_modification", // slug
		function (){
			$idModification = $_GET["id"];

			// Si il n'y a pas d'erreur
			if ( isset($idModification) && is_numeric($idModification)){
				felix_creer_page_edition($idModification);
			}
			// En cas d'erreur
			else {

			}
		}  // fonction de rappel pour créer la page
	);
}

add_action( "admin_menu", "felix_ajouter_menu_tableau_de_bord" );
