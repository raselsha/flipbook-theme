<?php
/**
 * Single PDF page — theme override of pdf-embed-viewer's template/single.php
 * (the plugin looks for this file first). Uses the theme's own header block
 * (back link, title, meta row, download) instead of the plugin's
 * pdfev_template_single_header output, inside the framed content column.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$flipbook_theme_id    = get_the_ID();
$flipbook_theme_terms = function ( $tax ) use ( $flipbook_theme_id ) {
    $names = wp_get_post_terms( $flipbook_theme_id, $tax, array( 'fields' => 'names' ) );
    return is_wp_error( $names ) ? array() : $names;
};
$flipbook_theme_meta  = array_filter( array(
    implode( ', ', $flipbook_theme_terms( 'pdfev_author' ) ),
    ( $p = get_post_meta( $flipbook_theme_id, 'pdfev_meta_total_pages', true ) ) ? sprintf( _n( '%s page', '%s pages', (int) $p, 'flipbook-theme' ), number_format_i18n( (int) $p ) ) : '',
    ( $s = get_post_meta( $flipbook_theme_id, 'pdfev_meta_filesize', true ) ) && class_exists( 'PDFEV_Functions' ) ? PDFEV_Functions::convert_file_size( $s ) : '',
    get_post_meta( $flipbook_theme_id, 'pdfev_meta_published_year', true ),
    implode( ', ', $flipbook_theme_terms( 'pdfev_publisher' ) ),
) );
$flipbook_theme_desc  = get_option( 'pdfev_show_description' ) === 'yes' ? get_post_meta( $flipbook_theme_id, 'pdfev_meta_description', true ) : '';
$flipbook_theme_lang  = class_exists( 'PDFEV_Functions' ) && method_exists( 'PDFEV_Functions', 'item_lang_attrs' ) ? PDFEV_Functions::item_lang_attrs( $flipbook_theme_id ) : '';
$flipbook_theme_back  = get_page_by_path( 'demo/grid' );
$flipbook_theme_back  = $flipbook_theme_back ? get_permalink( $flipbook_theme_back ) : home_url( '/#formats' );
?>
<main class="content-page frame pdfev-single-page">
  <div class="u-container entry">
    <?php
    if ( ! ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) ) :
        ?>
    <header class="fb-single-head"<?php echo $flipbook_theme_lang; // phpcs:ignore WordPress.Security.EscapeOutput -- built with esc_attr() ?>>
      <a class="fb-single-back" href="<?php echo esc_url( $flipbook_theme_back ); ?>"><span aria-hidden="true">&larr;</span> <?php esc_html_e( 'All publications', 'flipbook-theme' ); ?></a>
      <div class="fb-single-row">
        <div class="fb-single-copy">
          <h1><?php the_title(); ?></h1>
          <?php if ( $flipbook_theme_desc ) : ?>
            <p class="fb-single-desc"><?php echo esc_html( $flipbook_theme_desc ); ?></p>
          <?php endif; ?>
          <?php if ( $flipbook_theme_meta ) : ?>
            <ul class="fb-single-meta">
              <?php foreach ( $flipbook_theme_meta as $flipbook_theme_item ) : ?>
                <li><?php echo esc_html( $flipbook_theme_item ); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <div class="fb-single-actions pdfev-embed-viewer">
          <?php if ( class_exists( 'PDFEV_Functions' ) ) { PDFEV_Functions::download_button_single_page_view( $flipbook_theme_id ); } ?>
        </div>
      </div>
    </header>

    <div class="pdfev-embed-viewer fb-single-viewer">
      <?php echo do_shortcode( '[pdfev_embed_viewer id="' . $flipbook_theme_id . '"]' ); ?>
    </div>

    <?php
    $flipbook_theme_prev = get_previous_post();
    $flipbook_theme_next = get_next_post();
    if ( $flipbook_theme_prev || $flipbook_theme_next ) :
        ?>
    <nav class="fb-single-pager" aria-label="<?php esc_attr_e( 'More publications', 'flipbook-theme' ); ?>">
      <?php if ( $flipbook_theme_prev ) : ?>
        <a class="fb-pager-link fb-pager-prev" href="<?php echo esc_url( get_permalink( $flipbook_theme_prev ) ); ?>">
          <span class="fb-pager-label"><span aria-hidden="true">&larr;</span> <?php esc_html_e( 'Previous', 'flipbook-theme' ); ?></span>
          <span class="fb-pager-title"><?php echo esc_html( get_the_title( $flipbook_theme_prev ) ); ?></span>
        </a>
      <?php else : ?><span></span><?php endif; ?>
      <?php if ( $flipbook_theme_next ) : ?>
        <a class="fb-pager-link fb-pager-next" href="<?php echo esc_url( get_permalink( $flipbook_theme_next ) ); ?>">
          <span class="fb-pager-label"><?php esc_html_e( 'Next', 'flipbook-theme' ); ?> <span aria-hidden="true">&rarr;</span></span>
          <span class="fb-pager-title"><?php echo esc_html( get_the_title( $flipbook_theme_next ) ); ?></span>
        </a>
      <?php endif; ?>
    </nav>
        <?php
    endif;
    endif;
    ?>
  </div>
</main>
<?php
get_footer();
