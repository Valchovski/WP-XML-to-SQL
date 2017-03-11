<?php
/**
 * Plugin Name:   Sqlifier
 * Description:   The ultimate xml parser used to import the data into SQL Database
 * Author:        Bojidar Valchovski
 * Version:       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'admin_menu', 'mt_add_pages');

function mt_add_pages() {

    add_menu_page('custom menu title', 'Sqlifier', 'manage_options', 'sqlifier.php', 'mt_render');
}

function mt_render() {

    include ( 'index.php' );
}


?>
