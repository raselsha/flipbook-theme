<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function flipbook_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'automatic-feed-links' );
    add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'flipbook_theme_setup' );

function flipbook_theme_assets() {
    $ver = wp_get_theme()->get( 'Version' );
    wp_enqueue_style( 'flipbook-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), $ver );
    wp_enqueue_style( 'flipbook-main', get_template_directory_uri() . '/assets/css/main.css', array( 'flipbook-fonts' ), $ver );
    wp_enqueue_script( 'flipbook-main', get_template_directory_uri() . '/assets/js/main.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'flipbook_theme_assets' );

/**
 * The homepage no longer calls do_shortcode() itself — every live embed now
 * lives on its own page under /demo/ (Flipbook, Grid, List, Newsletter,
 * Ebook), each with the shortcode saved in that page's real post_content.
 * The plugin's own asset-loading check (PDFEV\Enque_Style::frontend_style(),
 * which scans has_shortcode() on the current post) finds it there natively,
 * so nothing needs enqueuing from the theme any more. An earlier version of
 * this file duplicated the plugin's whole frontend asset chain here to work
 * around the homepage embedding shortcodes directly from PHP — that's gone
 * now that the embeds themselves moved.
 */
