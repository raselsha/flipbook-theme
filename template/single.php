<?php
/**
 * Single PDF page — theme override of pdf-embed-viewer's template/single.php
 * (the plugin looks for this file first). Same content as the plugin's own
 * template, placed inside the theme's framed content column so it lines up
 * with every other page instead of running edge to edge.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<main class="content-page frame pdfev-single-page">
  <div class="u-container entry">
    <?php
    if ( ! ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) ) :
        ?>
    <div class="pdfev-embed-viewer">
        <?php do_action( 'pdfev_template_single_header' ); ?>
        <?php echo do_shortcode( '[pdfev_embed_viewer id="' . get_the_ID() . '"]' ); ?>
        <?php do_action( 'pdfev_template_single_footer' ); ?>
    </div>
        <?php
    endif;
    ?>
  </div>
</main>
<?php
get_footer();
