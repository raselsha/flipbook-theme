<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
// /demo/<slug> pages get a "demo-<slug>" class so a single demo can be styled.
$flipbook_theme_page   = get_queried_object_id();
$flipbook_theme_parent = wp_get_post_parent_id( $flipbook_theme_page );
$flipbook_theme_class  = ( $flipbook_theme_parent && 'demo' === get_post_field( 'post_name', $flipbook_theme_parent ) )
    ? ' demo-' . sanitize_html_class( get_post_field( 'post_name', $flipbook_theme_page ) )
    : '';
?>
<main class="content-page frame<?php echo esc_attr( $flipbook_theme_class ); ?>">
  <div class="u-container entry">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php
      // /demo/* pages carry their own section headings, so skip the page title there.
      $flipbook_theme_parent = wp_get_post_parent_id( get_the_ID() );
      if ( ! $flipbook_theme_parent || 'demo' !== get_post_field( 'post_name', $flipbook_theme_parent ) ) :
          ?>
      <h1><?php the_title(); ?></h1>
      <?php endif; ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
