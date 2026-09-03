<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="content-page">
  <div class="u-container entry">
    <?php while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</main>
<?php
get_footer();
