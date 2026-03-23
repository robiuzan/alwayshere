<?php
/**
 * Footer template — overrides GeneratePress footer.php.
 *
 * Closes GP's page wrappers, renders custom footer sections, fires wp_footer().
 *
 * @package alwayshere-child
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .site-content -->

<?php
// Newsletter bar appears on every page except the front page,
// which already has its own full-width newsletter section.
if ( ! is_front_page() ) {
	get_template_part( 'template-parts/footer/newsletter-bar' );
}

get_template_part( 'template-parts/footer/main-footer' );

do_action( 'generate_after_footer' );

wp_footer();
?>

</body>
</html>
