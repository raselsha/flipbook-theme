<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="content-page frame">
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
