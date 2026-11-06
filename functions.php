<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once get_template_directory() . '/inc/seo.php';

function flipbook_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'automatic-feed-links' );
    add_editor_style( array( 'assets/css/fonts.css', 'assets/css/editor-style.css' ) );
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
 * Favicon: the theme's own brand mark, overriding whatever Site Icon is set
 * in Settings → General. Filtering get_site_icon_url (rather than printing
 * separate <link> tags) keeps WP's own wp_site_icon() output and its
 * /favicon.ico redirect both pointing at these files.
 */
function flipbook_theme_site_icon_url( $url, $size ) {
    $base = get_template_directory_uri() . '/assets/img/';
    if ( 180 === (int) $size ) {
        return $base . 'apple-touch-icon.png';
    }
    if ( $size <= 32 ) {
        return $base . 'favicon-32.png';
    }
    return $size <= 192 ? $base . 'favicon-192.png' : $base . 'favicon-270.png';
}
add_filter( 'get_site_icon_url', 'flipbook_theme_site_icon_url', 10, 2 );

function flipbook_theme_svg_favicon() {
    printf( '<link rel="icon" href="%s" type="image/svg+xml" />' . "\n", esc_url( get_template_directory_uri() . '/assets/img/favicon.svg' ) );
}
add_action( 'wp_head', 'flipbook_theme_svg_favicon', 98 );

/**
 * front-page.php calls do_shortcode() directly (the hero's mock preview
 * links out to /demo/ pages, but the "Live flipbook" section embeds the
 * real shortcode inline) — that's a shortcode used outside any post's saved
 * post_content, which pdf-embed-viewer's own has_shortcode()-based
 * asset-loading check can't see ahead of time. That gap is handled on the
 * plugin's side (PDFEV\Enque_Style::late_frontend_style(), a wp_footer
 * fallback keyed off Shortcode::$shortcode_used), not here — nothing needs
 * enqueuing from the theme for it.
 */

/**
 * Customizer: container width. Everything else in main.css reads
 * var(--container) (see :root), so this is the whole control surface —
 * changing it changes every .u-container-based section at once.
 */
function flipbook_theme_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'flipbook_theme_layout', array(
        'title'    => __( 'Layout', 'flipbook-theme' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'flipbook_container_width', array(
        'default'           => 1240,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'flipbook_container_width', array(
        'type'        => 'number',
        'section'     => 'flipbook_theme_layout',
        'label'       => __( 'Container Width (px)', 'flipbook-theme' ),
        'description' => __( 'Max width of the page content — the hero, sections, and the Live flipbook window all share this.', 'flipbook-theme' ),
        'input_attrs' => array( 'min' => 720, 'max' => 1600, 'step' => 10 ),
    ) );
}
add_action( 'customize_register', 'flipbook_theme_customize_register' );

function flipbook_theme_customize_css() {
    $width = absint( get_theme_mod( 'flipbook_container_width', 1240 ) );
    if ( $width === 1240 ) {
        return;
    }
    printf( '<style>:root{--container:%dpx;}</style>' . "\n", $width );
}
add_action( 'wp_head', 'flipbook_theme_customize_css', 20 );

function flipbook_theme_customize_preview_js() {
    if ( ! is_customize_preview() ) {
        return;
    }
    wp_add_inline_script( 'customize-preview', "
        (function(){
            wp.customize('flipbook_container_width', function(value){
                value.bind(function(newval){
                    var id = 'flipbook-container-width-preview';
                    var el = document.getElementById(id);
                    if (!el) {
                        el = document.createElement('style');
                        el.id = id;
                        document.head.appendChild(el);
                    }
                    el.textContent = ':root{--container:' + newval + 'px;}';
                });
            });
        })();
    " );
}
add_action( 'customize_preview_init', 'flipbook_theme_customize_preview_js' );
