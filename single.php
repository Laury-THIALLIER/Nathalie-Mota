<?php get_header(); ?>
	
	<main>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			
			<article class="post">
				<div id="lightbox">
					<img id="closeLightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/lightbox-cross.svg" alt="Fermer">
				</div>
				<section class="infosSection">
					<div class="singleTop">
						<div class="singleInfos">
							<h1 class="singleTitle"><?php the_title(); ?></h1>
							<p>Référence : <?php the_field( 'reference' ); ?></p>
							<p>Catégorie : <?php the_terms( get_the_ID() , 'categorie' ); ?></p>
							<p>Format : <?php the_terms( get_the_ID() , 'format' ); ?></p>
							<p>Type : <?php the_field( 'type' ); ?></p>
							<p>Année : <?php the_date('Y'); ?></p>
						</div>
						<div class="singleImg">
							<?php the_post_thumbnail(); ?>
							<span class="photoOverlay">
								<span class="fullscreen">
									<img class="fullscreenImg" src="<?php echo get_template_directory_uri() ?>/assets/images/fullscreen.svg">
								</span>
							</span>
						</div>
					</div>
					<div class="singleContact">
						<div class="leftContact">
							<p>Cette photo vous intéresse ?</p>
							<a class="contact-nav">Contact</a>
						</div>
							<div class="rightNavigation">
								<?php 
									the_post_navigation(array(
										'next_text' => '<span>' . __('<img src="'.get_template_directory_uri().'/assets/images/right-arrow.svg">') . '</span>' . 
										get_the_post_thumbnail(get_next_post()->ID,'thumbnail'),
										'prev_text' => '<span>' . __('<img src="'.get_template_directory_uri().'/assets/images/left-arrow.svg">') . '</span> '
									));
								?>
							</div>
					</div>
				</section>

				<section class="likeToo">
					<h2>Vous aimerez aussi</h2>
					<div class="images">
					<?php
						// Récupère la catégorie de la photo affichée
						$category = get_the_terms( get_the_ID(), 'categorie' )[0]->term_id;

						$args = array(
							'post_type' => 'photo',
							'posts_per_page' => 2,
							'tax_query' => array(
								array(
									'taxonomy' => 'categorie',
									'field'    => 'term_id',
									'terms'    => $category,
								),
							),
							'post__not_in' => array( get_the_ID() ), // Ne reprend pas la photo affichée
						);

						$related_query = new WP_Query( $args );

						while ( $related_query->have_posts() ) {
							$related_query->the_post();
							$cat_names = array();
							?>
							<a class="photoLink" href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
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
											$categories = get_the_terms( get_the_ID() , 'categorie' );
											foreach ( $categories as $category ) {
												$cat_names[] = $category->name;
											}
											echo '<p>' . implode( ', ', $cat_names ) . '</p>';
										?>
									</span>
								</span>
							</a>
							<?php
						}
						wp_reset_postdata();
					?>
					</div>
					<div class="moreButton">
						<a href="<?php echo get_site_url(); ?>">Toutes les photos</a>
					</div>
				</section>

			</article>

		<?php endwhile; endif; ?>

	</main>

<script>
	// Si "?ref=" n'est pas dans l'URL
	if (window.location.href.indexOf('?ref=') === -1) {
		// Recharge la page
		window.location.replace(window.location.href + "?ref=<?php the_field( 'reference' ); ?>");
	}
</script>

<?php get_footer(); ?>