<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newspack
 */

// Get sponsors for this taxonomy archive.
if ( function_exists( 'newspack_get_all_sponsors' ) ) {
	$all_sponsors         = newspack_get_all_sponsors(
		get_the_id(),
		null,
		'post',
		[
			'maxwidth'  => 150,
			'maxheight' => 100,
		]
	);
	$native_sponsors      = newspack_get_native_sponsors( $all_sponsors );
	$underwriter_sponsors = newspack_get_underwriter_sponsors( $all_sponsors );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">

		<?php
		if ( ! empty( $underwriter_sponsors ) ) :
			newspack_sponsored_underwriters_info( $underwriter_sponsors );
		endif;
		?>

		<!-- IS SUBSCRIBED TO SITE (ACTIVE SUBSCRIPTION IS AVAILABLE) -->
		<?php if ( newspack_is_amp() ) : ?>
			<section amp-access="isSubscribedToSite" amp-access-hide>

				<?php // <p><a on="tap:amp-access.login-sign-out">Log Out</a></p> ?>
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newspack' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'newspack' ),
						'after'  => '</div>',
					)
				);

				if ( is_active_sidebar( 'article-2' ) && is_single() ) {
					dynamic_sidebar( 'article-2' );
				}
				?>
			</section>

			<section amp-access="NOT isSubscribedToSite" amp-access-hide>
				<?php the_excerpt(); ?>
				<p class="pelcro-subscribe">You do not have an active subscription. Please subscribe or login. <a>Subscribe</a> | <a on="tap:amp-access.login-sign-in">Login</a></p>
			</section>
		<?php else : ?>
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newspack' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'newspack' ),
						'after'  => '</div>',
					)
				);

				if ( is_active_sidebar( 'article-2' ) && is_single() ) {
					dynamic_sidebar( 'article-2' );
				}
				?>
			<?php endif; ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php newspack_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php
	if ( ! empty( $native_sponsors ) ) :
		newspack_sponsor_footer_bio( $native_sponsors );
	elseif ( ! is_singular( 'attachment' ) ) :
		get_template_part( 'template-parts/post/author', 'bio' );
	endif;
	?>

</article><!-- #post-${ID} -->
