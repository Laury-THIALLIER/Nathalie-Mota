<?php get_header(); ?>
	
	<main id="portfolio">

		<div id="lightbox">
			<img id="closeLightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/lightbox-cross.svg" alt="Fermer">
		</div>

		<?php 
		
		$photos = get_posts( array(
			"post_type" => "photo",
			"posts_per_page" => -1
		) );

		$random = rand( 0, count( $photos ) - 1 );
		$random_photo = $photos[ $random ];
		
		?>

		<section class="hero" style="background-image: url(<?php echo get_the_post_thumbnail_url( $random_photo ); ?>)">
			<h1>Photographe Event</h1>
		</section>

		<section>
			<div class="filters">
				<div>
					<div class="column">
						<label for="category-select">Catégories</label>
						<select id="category-select">
							<option value="">Voir tout</option>
							<?php
							$categories = get_terms( array(
								"taxonomy" => "categorie",
								"hide_empty" => false,
							) );
							foreach ( $categories as $category ) {
								echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
							}
							?>
						</select>
					</div>
					<div class="column">
						<label for="format-select">Formats</label>
						<select id="format-select">
							<option value="">Voir tout</option>
							<?php
							$formats = get_terms( array(
								"taxonomy" => "format",
								"hide_empty" => false,
							) );
							foreach ( $formats as $format ) {
								echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="column">
					<label for="date-select">Trier par</label>
					<select id="date-select">
						<option value="DESC">Nouveautés</option>
						<option value="ASC">Les plus anciennes</option>
					</select>
				</div>
			</div>
			<div class="imagesGrid">
				<?php
					$args = array(
					"post_type" => "photo",
					"posts_per_page" => 8
					);

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
				?>
			</div>
			<div class="moreButton">
				<a id="show-more">Charger plus</a>
			</div>
		</section>

	</main>

	<script>
		const photoLink = document.querySelectorAll(".photoLink");
		const showMoreButton = document.querySelector("#show-more");
		const imagesContainer = document.querySelector(".imagesGrid");
		const categorySelect = document.getElementById("category-select");
		const formatSelect = document.getElementById("format-select");
		const dateSelect = document.getElementById("date-select");
		let offset = 8;
		let categoryValue = "";
		let formatValue = "";
		let dateValue = "";

		function loadMoreImages(addOffset) {
			const xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				// Si la requête AJAX est un succès
				if (this.readyState === 4 && this.status === 200) {
					const newImages = this.responseText;
					imagesContainer.innerHTML += newImages;
					offset += addOffset;
					showMoreButton.style.display = "inline";
					if (newImages.length == 0) {
						showMoreButton.style.display = "none";
					}
				lightboxMota();
				}
			};
			xhr.open("GET", "<?php echo get_site_url() ?>/wp-admin/admin-ajax.php?action=load_more_images&offset=" + offset + "&categorie=" + categoryValue + "&format=" + formatValue + "&date=" + dateValue);
			xhr.send();
		}

		showMoreButton.addEventListener("click", () => {
			loadMoreImages(12);
		});

		categorySelect.addEventListener("change", () => {
			categoryValue = categorySelect.value;
			offset = 0;
			imagesContainer.innerHTML = "";
			loadMoreImages(8);
		});

		formatSelect.addEventListener("change", () => {
			formatValue = formatSelect.value;
			offset = 0;
			imagesContainer.innerHTML = "";
			loadMoreImages(8);
		});

		dateSelect.addEventListener("change", () => {
			dateValue = dateSelect.value;
			offset = 0;
			imagesContainer.innerHTML = "";
			loadMoreImages(8);
		});
	</script>

<?php get_footer(); ?>