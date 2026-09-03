<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="u-container">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <svg class="brand-mark" viewBox="0 0 26 26" aria-hidden="true"><path class="page" d="M3 5h13a2 2 0 0 1 2 2v14L3 21z"/><path class="fold" d="M18 7v14l5-2V9z"/></svg>
      <span>Flipbook PDF</span>
    </a>
    <button class="nav-toggle" aria-label="Toggle menu"><span></span></button>
    <?php
    $flipbook_theme_demo_page = get_page_by_path( 'demo' );
    $flipbook_theme_demo_url  = $flipbook_theme_demo_page ? get_permalink( $flipbook_theme_demo_page ) : home_url( '/#formats' );
    $flipbook_theme_demo_subs = array(
        'flipbook'   => 'Flipbook',
        'grid'       => 'Grid',
        'list'       => 'List',
        'newsletter' => 'Newsletter',
        'ebook'      => 'Ebook',
    );
    ?>
    <nav class="nav-links primary-nav">
      <a href="<?php echo esc_url( home_url( '/#features' ) ); ?>">Features</a>
      <a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>">How It Works</a>
      <a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>">Pricing</a>
      <div class="nav-has-sub">
        <a href="<?php echo esc_url( $flipbook_theme_demo_url ); ?>">Demo <svg class="nav-caret" viewBox="0 0 12 8" aria-hidden="true"><path d="M1 1l5 5 5-5"/></svg></a>
        <div class="nav-submenu">
          <?php foreach ( $flipbook_theme_demo_subs as $slug => $label ) :
              $sub_page = get_page_by_path( 'demo/' . $slug );
              if ( ! $sub_page ) {
                  continue;
              }
              ?>
            <a href="<?php echo esc_url( get_permalink( $sub_page ) ); ?>"><?php echo esc_html( $label ); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <a class="btn btn--primary" href="https://wordpress.org/plugins/pdf-embed-viewer/">Get the plugin</a>
    </nav>
  </div>
</header>
