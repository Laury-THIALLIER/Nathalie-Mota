<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<?php wp_body_open(); ?>

	<header id="masthead" class="site-header">
        <?php
            if ( has_custom_logo() ) {
                echo get_custom_logo();
            } else {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
            }
        ?>
		<nav id="site-navigation" class="main-navigation">

		<button id="burger-menu" aria-controls="primary-menu" aria-expanded="false">
			<img id="burgerImg" src="<?php echo get_template_directory_uri(); ?>/assets/images/burger.svg" alt="Menu">
			<img id="crossImg" src="<?php echo get_template_directory_uri(); ?>/assets/images/cross.svg" alt="Fermer">
		</button>

		<div id="fullscreenMenu">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
					)
				);
			?>
		</div>

        <div class="desktop-menu">
			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
					)
				);
			?>
		</div>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
