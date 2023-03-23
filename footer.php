	<?php get_template_part( 'template-parts/contact-modal' ); ?>
    
    <footer id="colophon" class="site-footer">
		<nav id="footer-navigation" class="footer-navigation">
        <?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_id'        => 'footer-menu',
				)
			);
		?>
        </nav>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
