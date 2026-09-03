<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="content-page">
  <div class="u-container entry">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; else : ?>
      <p>Nothing found.</p>
    <?php endif; ?>
  </div>
</main>
<?php
get_footer();
