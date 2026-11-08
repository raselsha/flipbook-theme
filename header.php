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
<?php
$flipbook_theme_ebook     = get_page_by_path( 'demo/ebook' );
$flipbook_theme_demo_subs = array(
    'flipbook'   => 'Flipbook',
    'grid'       => 'Grid',
    'list'       => 'List',
    'newsletter' => 'Newsletter',
    'ebook'      => 'Ebook',
);
?>
<div class="announce">
  <div class="u-container announce-inner">
    <div class="announce-main">
      <span class="announce-tag">New release</span>
      <strong>Flipbook PDF 1.5 — Ebook layout with a live next-page preview</strong>
      <a href="<?php echo esc_url( $flipbook_theme_ebook ? get_permalink( $flipbook_theme_ebook ) : home_url( '/#formats' ) ); ?>">See it &rarr;</a>
    </div>
    <div class="announce-side">
      <span class="announce-status"><span class="status-dot" aria-hidden="true"></span>Free on WordPress.org</span>
      <a href="https://wordpress.org/plugins/pdf-embed-viewer/">Plugin page</a>
    </div>
  </div>
</div>
<header class="site-header">
  <div class="u-container">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <svg class="brand-mark" viewBox="0 0 32 32" aria-hidden="true"><rect class="tile" x="1" y="1" width="30" height="30" rx="8"/><path class="page" d="M8 10.5c2.6-1 5.3-1 8 .6v11.4c-2.7-1.6-5.4-1.6-8-.6V10.5Z"/><path class="fold" d="M24 10.5c-2.6-1-5.3-1-8 .6v11.4c2.7-1.6 5.4-1.6 8-.6V10.5Z"/></svg>
      <span>Flipbook PDF</span>
    </a>
    <button class="nav-toggle" aria-label="Toggle menu"><span></span></button>
    <nav class="nav-links primary-nav" aria-label="Main">
      <a href="<?php echo esc_url( home_url( '/#features' ) ); ?>">Features</a>
      <a href="<?php echo esc_url( home_url( '/#formats' ) ); ?>">Layouts</a>
      <a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>">How it works</a>
      <a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>">Pricing</a>
      <div class="nav-has-sub">
        <a href="#" aria-haspopup="true">Live Demo <svg class="nav-caret" viewBox="0 0 12 8" aria-hidden="true"><path d="M1 1l5 5 5-5"/></svg></a>
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
      <a class="btn btn--primary btn--sm" href="https://lieusoft.com/pdf-embed-viewer/#pricing">Buy now <span aria-hidden="true">&rarr;</span></a>
    </nav>
  </div>
</header>
