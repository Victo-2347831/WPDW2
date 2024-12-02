<?php
function felix_creer_page_ajout() {
    require_once('tableau-de-bord-messages.php');

    global $title;   // titre de la page du menu, tel qu'initialisé dans la fonction de rappel de add_submenu_page

    // Obtention de l'url du fichier PHP qui traites le formulaire
    $url_action = get_stylesheet_directory_uri() . '/enregister-item.php';

    // Vérification si le formulaire a réussi
    $messageErreur = array_key_exists('formulaire_reussi', $_SESSION);
    felix_verification_message_session($messageErreur);
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo $title; ?></h1>
    </div>

    <!-- Formulaire enregistrement d'un item dans la base de données-->
    <form action="<?php echo $url_action; ?>" method="post">
        <?php wp_nonce_field('enregister_item', 'itemEnregistre', false, true) ?>

        <label for="nomItem">Nom de l'item:</label><br>
        <input type="text" id="nomItem" name="nomItem"><br>
        <label for="descriptionItem">Description de l'item:</label><br>
        <input type="text" id="descriptionItem" name="descriptionItem"><br>

        <input type="submit" value="Soumettre l'item">
    </form>
    <?php
}

function felix_creer_page_edition( int $id ) {
    $url_update = get_stylesheet_directory_uri() . '/mettre-a-jour-item.php';

    echo "<form method='post' action=$url_update>";
    global $wpdb;

    // Création du nonce
    wp_nonce_field( "modifier_item_$id", 'itemModification', false, true );

    // Sélection des items actuels dans la base de données
    $table_items = $wpdb -> prefix . 'felix_items';
    $requete = "SELECT id, nom, description, quantite FROM $table_items WHERE id = $id";
    $resultat   = $wpdb -> get_results( $requete );

    foreach ($resultat as $enreg){
        echo "<input type='hidden' id='id' name='id' value=$id>";

        echo "<label for='nomItem'>Nom de l'item:</label><br>";
        echo "<input type='text' id='nomItem' name='nomItem' value = $enreg->nom><br>";

        echo "<label for='descriptionItem'>Description de l'item:</label><br>";
        echo "<input type='text' id='descriptionItem' name='descriptionItem' value = $enreg->description ><br>";

        echo "<label for='quantiteItem'>Quantité de l'item:</label><br>";
        echo "<input type='text' id='quantiteItem' name='quantiteItem' value = $enreg->quantite><br>";

        echo "<input type='submit' value='Envoyer la modification'>";
    }

    echo "</form>";
}

/**
 * Crée la page de gestion du thème dans le tableau de bord.
 * @author Christiane Lagacé <christiane.lagace@hotmail.com>
 *
 * Utilisation : add_menu_page(..., ..., ..., ..., "monprefixe_creer_page_gestion");
 */
function felix_creer_page_gestion()
{
    global $title;   // titre de la page du menu, tel qu'initialisé dans la fonction de rappel de add_menu_page

    // Lien vers le formulaire d'ajout d'un item
    $url_ajout = admin_url( "admin.php?page=felix_ajout" );
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo $title; ?></h1>
        <a href="<?php echo $url_ajout; ?>" class="page-title-action"><?php _e( "Ajouter", "felix" ) ?></a>
        <hr class="wp-header-end">
    </div>
    <?php

    global $wpdb;

    // Sélection des items actuels dans la base de données
    $table_items = $wpdb -> prefix . 'felix_items';
    $requete = "SELECT id, nom, description, quantite FROM $table_items ORDER BY nom";
    $resultat   = $wpdb -> get_results( $requete );

    // Vérifie si la sélection est correcte
    $erreur_sql = $wpdb -> last_error;
    if ( "" == $erreur_sql )
    {
        // Si le nombre de résultat est supérieur à 0
        if ( $wpdb -> num_rows > 0 )
        {
            //Affiche chaque items
            echo '<table class="tab_items">';
            foreach ( $resultat as $enreg )
            {
                // echo "<tr><td><strong>$enreg->nom</strong></td><td></td></tr>";
                echo "<tr><td class='title column-title has-row-actions column-primary'>";
                echo "<strong>$enreg->nom ($enreg->quantite)</strong> ";
                echo "<div class='row-actions'>";

                // Bouton de modification de l'item
                $url_edition = admin_url("admin.php?page=felix_modification&id=$enreg->id&action=edit");
                echo "<span class='edit'><a href='$url_edition'>";
                _e( "Modifier", "felix" );
                echo "</a></span> |";


                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
            echo '</table>';
        }
        // Si le nombre de résultat est égal à 0
        else
        {
            echo '<div class="message-avertissement">Aucune donnée !</div>';
        }
    }
    else
    {
        felix_echo_debug($erreur_sql);
    }

    echo '<hr class="wp-header-end"></div>';
}
