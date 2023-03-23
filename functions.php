<?php

// Récupération des scripts et styles
function mota_scripts() {
	wp_enqueue_style( 'mota-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'mota_scripts' );

// Rajoute les menus dans WP
register_nav_menus(
  array(
    'primary' => esc_html__( 'Menu principal', 'nathaliemota' ),
    'footer' => esc_html__( 'Menu footer', 'nathaliemota' )
  )
);

// Rajoute la selection de logo dans le menu Personnaliser
function theme_support_setup() {
  add_theme_support( 'custom-logo' );
}

add_action( 'after_setup_theme', 'theme_support_setup' );

// Rajoute le bouton de contact à la fin du menu principal
function mota_contact_nav($items, $args) {
  if ( $args->theme_location == 'primary' ) {
    $items .= '<li id="contact-nav"><a href="#">Contact</a></li>';
  }
  return $items;  
}

add_filter('wp_nav_menu_items', 'mota_contact_nav', 10, 2);

// Rajoute Tous droits réservés à la fin du menu du footer
function mota_footer_nav($items, $args) {
  if ( $args->theme_location == 'footer' ) {
    $items .= '<li id="contact-nav"><p>Tous droits réservés</p></li>';
  }
  return $items;  
}

add_filter('wp_nav_menu_items', 'mota_footer_nav', 10, 2);