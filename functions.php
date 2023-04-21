<?php

// Récupération des scripts et styles
function mota_scripts() {
	wp_enqueue_style( 'mota-style', get_stylesheet_uri() );
  wp_enqueue_style('single-style', get_template_directory_uri() . '/css/single.css');
  wp_enqueue_script( 'mota-script', get_stylesheet_directory_uri() . '/js/script.js', array(), "1.0", true );
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
  add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'theme_support_setup' );

// Rajoute le bouton de contact à la fin du menu principal
function mota_contact_nav($items, $args) {
  if ( $args->theme_location == 'primary' ) {
    $items .= '<li class="contact-nav"><p>Contact</p></li>';
  }
  return $items;  
}

add_filter('wp_nav_menu_items', 'mota_contact_nav', 10, 2);

// Rajoute Tous droits réservés à la fin du menu du footer
function mota_footer_nav($items, $args) {
  if ( $args->theme_location == 'footer' ) {
    $items .= '<li><p>Tous droits réservés</p></li>';
  }
  return $items;  
}

add_filter('wp_nav_menu_items', 'mota_footer_nav', 10, 2);

// Charger plus
add_action("wp_ajax_nopriv_load_more_images", "load_more_images");
add_action("wp_ajax_load_more_images", "load_more_images");

function load_more_images() {
    $offset = intval($_GET["offset"]);
    $categorie = isset($_GET["categorie"]) ? sanitize_text_field($_GET["categorie"]) : "";
    $format = isset($_GET["format"]) ? sanitize_text_field($_GET["format"]) : "";
    $date = isset($_GET["date"]) ? sanitize_text_field($_GET["date"]) : "";
    if ($offset == 0) {
      $postperpage = 8;
    }
    else {
      $postperpage = 12;
    }
    $args = array(
        "post_type" => "photo",
        "posts_per_page" => $postperpage,
        "offset" => $offset,
        "tax_query" => array(),
        "orderby" => "date",
        "order" => $date
    );

    if (!empty($categorie)) {
        $args["tax_query"][] = array(
            "taxonomy" => "categorie",
            "field" => "slug",
            "terms" => $categorie,
        );
    }

    if (!empty($format)) {
        $args["tax_query"][] = array(
            "taxonomy" => "format",
            "field" => "slug",
            "terms" => $format,
        );
    }

    $query = new WP_Query( $args );
					
					while ( $query->have_posts() ) {
						$query->the_post();
						$cat_names = array();
						$categories = get_the_terms( get_the_ID(), "categorie" );
						$format_names = array();
						$formats = get_the_terms( get_the_ID(), "format" );
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$cat_names[] = $category->slug;
							}
						}
						if ( $formats ) {
							foreach ( $formats as $format ) {
								$format_names[] = $format->slug;
							}
						}
						?>
						<a class="photoLink home item" href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
								<span class="photoOverlay">
									<span class="fullscreen">
										<img class="fullscreenImg" src="<?php echo get_template_directory_uri() ?>/assets/images/fullscreen.svg">
									</span>
									<span class="eye">
										<img src="<?php echo get_template_directory_uri() ?>/assets/images/eye.svg">
									</span>
									<span class="infosOverlay">
										<p><?php the_title(); ?></p>
										<?php 
											if ( $categories ) {
												foreach ( $categories as $category ) {
												  echo "<p>" . $category->name . "</p>";
												}
											  }
										?>
									</span>
								</span>
							</a>
						<?php
					}
    wp_reset_postdata();
    die();
}
