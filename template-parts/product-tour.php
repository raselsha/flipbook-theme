<?php
/**
 * Product tour (ThriveDesk-style "virtual tutorial") in the hero: a scaled
 * mock of the plugin's screens and the reader's view, with a spotlight that
 * walks through the workflow step by step (assets/js/tour.js, tour.css).
 * Covers, titles and counts come from the site's real PDFs.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$tour_docs = get_posts( array(
    'post_type'   => 'pdfev_embed_viewer',
    'post_status' => 'publish',
    'numberposts' => 24,
    'meta_key'    => '_thumbnail_id', // phpcs:ignore WordPress.DB.SlowDBQuery -- small, front page only
) );
$ltr = array();
$rtl = array();
foreach ( $tour_docs as $d ) {
    $item = array(
        'id'    => $d->ID,
        'title' => get_the_title( $d ),
        'short' => trim( preg_replace( '/\s+[—–-]\s+.*$/u', '', get_the_title( $d ) ) ),
        'cover' => get_the_post_thumbnail_url( $d, 'medium' ),
        'pages' => (int) get_post_meta( $d->ID, 'pdfev_meta_total_pages', true ),
        'views' => (int) get_post_meta( $d->ID, 'pdfev_meta_views_count', true ),
        'size'  => (int) get_post_meta( $d->ID, 'pdfev_meta_filesize', true ),
        'slug'  => $d->post_name,
    );
    if ( 'yes' === get_post_meta( $d->ID, 'pdfev_meta_rtl', true ) ) {
        $rtl[] = $item;
    } else {
        $ltr[] = $item;
    }
}
$featured = null;
foreach ( $ltr as $item ) {
    if ( 'concrete-light-and-structure' === $item['slug'] ) { $featured = $item; break; }
}
if ( ! $featured ) {
    $featured = $ltr ? $ltr[0] : array( 'id' => 215, 'title' => 'Annual Report 2026', 'short' => 'Annual Report', 'cover' => '', 'pages' => 48, 'views' => 128, 'size' => 2400000, 'slug' => 'annual-report' );
}
// The RTL pages carry Arabic text, so prefer a book whose title is Arabic.
$rtl_doc = null;
foreach ( $rtl as $item ) { // an Arabic-category book first (Urdu shares the script)
    if ( has_term( 'arabic', 'pdfev_category', $item['id'] ) ) { $rtl_doc = $item; break; }
}
foreach ( $rtl_doc ? array() : $rtl as $item ) {
    if ( preg_match( '/\p{Arabic}/u', $item['title'] ) ) { $rtl_doc = $item; break; }
}
if ( ! $rtl_doc && $rtl ) {
    $rtl_doc = $rtl[0];
}
// Real page renders (assets/img/tour/) for the demo's own books; any other
// book falls back to drawn pages.
$tour_img = get_template_directory_uri() . '/assets/img/tour/';
$real_ltr = ( 'concrete-light-and-structure' === $featured['slug'] ) ? 'concrete' : '';
$real_rtl = ( $rtl_doc && 'kalila-asad-thawr' === $rtl_doc['slug'] ) ? 'arabic' : '';
$page_img = function ( $set, $n ) use ( $tour_img ) {
    return '<img class="tour-pimg" src="' . esc_url( $tour_img . $set . '-0' . (int) $n . '.webp' ) . '" alt="" loading="lazy" decoding="async">';
};
// The Pro viewer chrome's icons (pdf-embed-viewer-pro/assets/js/flipa-toolbar.js).
$ico = array(
    'first'  => '<path d="M18 6l-6 6 6 6"/><path d="M12 6l-6 6 6 6"/>',
    'prev'   => '<path d="M14 6l-6 6 6 6"/>',
    'next'   => '<path d="M10 6l6 6-6 6"/>',
    'last'   => '<path d="M6 6l6 6-6 6"/><path d="M12 6l6 6-6 6"/>',
    'up'     => '<path d="M6 10l6-6 6 6"/>',
    'down'   => '<path d="M6 14l6 6 6-6"/>',
    'side'   => '<path d="M9 8l-3.5 4 3.5 4"/><path d="M15 8l3.5 4-3.5 4"/>',
    'grid'   => '<rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><rect x="13" y="13" width="7" height="7" rx="1"/>',
    'search' => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/>',
    'chev'   => '<path d="M6 9l6 6 6-6"/>',
    'expand' => '<path d="M8 3H5a2 2 0 0 0-2 2v3M16 3h3a2 2 0 0 1 2 2v3M8 21H5a2 2 0 0 1-2-2v-3M16 21h3a2 2 0 0 0 2-2v-3"/>',
    'more'   => '<circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/>',
    'play'   => '<path d="M8 5l11 7-11 7z"/>',
    'share'  => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/>',
    'print'  => '<path d="M6 9V3h12v6M6 18H4v-6h16v6h-2"/><rect x="8" y="14" width="8" height="7" rx="1"/>',
    'dl'     => '<path d="M12 3v12M7 11l5 5 5-5M5 21h14"/>',
    'sun'    => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
    'close'  => '<path d="M18 6L6 18M6 6l12 12"/>',
    'lock'   => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
);
$svg = function ( $name ) use ( $ico ) {
    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . $ico[ $name ] . '</svg>';
};

$size_mb = $featured['size'] ? number_format_i18n( $featured['size'] / 1048576, 1 ) . ' MB' : '2.4 MB';
$file    = $featured['slug'] . '.pdf';
$code    = '[pdfev_embed_viewer id="' . (int) $featured['id'] . '"]';
$pages   = max( 2, (int) $featured['pages'] );

/** A cover tile: the real thumbnail, or a drawn stand-in. */
$cover = function ( $doc, $class = '' ) {
    if ( ! empty( $doc['cover'] ) ) {
        return '<span class="tour-cover ' . esc_attr( $class ) . '" style="background-image:url(' . esc_url( $doc['cover'] ) . ')"></span>';
    }
    return '<span class="tour-cover tour-cover--drawn ' . esc_attr( $class ) . '"><b>' . esc_html( $doc['short'] ) . '</b></span>';
};

$steps = array(
    array( 'add',      'library',  'add-btn',  3200, 'Add a PDF',               'Upload anything from a two-page menu to a 300-page catalogue.' ),
    array( 'upload',   'editor',   'dropzone', 4200, 'Upload once',             'Pages, file size and a cover are read from the PDF for you.' ),
    array( 'cover',    'editor',   'covers',   3800, 'Pick the cover',          'Any page can be the cover your readers see first.' ),
    array( 'copy',     'editor',   'code',     3400, 'Copy the shortcode',      'One line, ready for any post, page or widget.' ),
    array( 'paste',    'page',     'block',    4200, 'Paste it anywhere',       'Block editor, Classic editor or the Elementor widget.' ),
    array( 'flip',     'site',     'book',     4600, 'Your PDF, as a real book', 'Pages turn like paper. Drag a corner or tap the arrows.' ),
    array( 'toolbar',  'site',     'stage',    4600, 'Everything readers need', 'Page slider, thumbnails, zoom, dark mode and full screen.' ),
    array( 'layouts',  'settings', 'layouts',  4200, 'Four archive layouts',    'Grid, list, newsletter or an e-book shelf.' ),
    array( 'shelf',    'shelf',    'shelf',    3800, 'A library, not a list',   'Covers, read counts and buttons for every PDF.' ),
    array( 'rtl',      'rtl',      'rtl-book', 4600, 'Right-to-left books',     'Arabic, Urdu and Hebrew turn from right to left.' ),
    array( 'protect',  'pro-protect', 'protect', 4600, 'Protect your PDFs',     'Choose how files reach readers: a hidden link, or full Lockdown.', true ),
    array( 'lock',     'site',     'lock',     4200, 'Lockdown',                'Readers flip every page. Nobody can download, print or save the file.', true ),
    array( 'viewer',   'pro-viewer', 'viewer', 4800, 'Viewer controls',         'Switch print, download and sharing on or off, and pick a skin.', true ),
    array( 'studio',   'site',     'stage',    4600, 'Your brand colors',       'The Studio Light skin with your own stage and toolbar colors.', true ),
    array( 'license',  'pro-license', 'license', 4400, 'Activate your license', 'Paste your license key and Pro switches on, instantly.', true ),
);
$urls = array(
    'library'  => 'yoursite.com/wp-admin/edit.php?post_type=pdf',
    'editor'   => 'yoursite.com/wp-admin/post.php?post=' . (int) $featured['id'] . '&action=edit',
    'page'     => 'yoursite.com/wp-admin/post-new.php?post_type=page',
    'site'     => 'yoursite.com/' . $featured['slug'],
    'settings' => 'yoursite.com/wp-admin/admin.php?page=pdf-settings',
    'pro-protect' => 'yoursite.com/wp-admin/admin.php?page=pdf-settings#protection',
    'pro-viewer'  => 'yoursite.com/wp-admin/admin.php?page=pdf-settings#flipbook',
    'pro-license' => 'yoursite.com/wp-admin/admin.php?page=pdf-settings#license',
    'shelf'    => 'yoursite.com/library',
    'rtl'      => 'yoursite.com/' . ( $rtl_doc ? $rtl_doc['slug'] : 'kalila-wa-dimna' ),
);

/** WordPress admin chrome shared by the admin screens. */
$admin_menu = function ( $active ) {
    $sub = array( 'list' => 'All PDF', 'new' => 'New PDF', 'cats' => 'Categories', 'settings' => 'Settings' );
    $out = '<div class="tour-wpbar"><span class="tour-wplogo">W</span><span>Your Site</span><span class="tour-wpbar-new">+ New</span><span class="tour-wpbar-me">Howdy, admin</span></div>';
    $out .= '<nav class="tour-wpmenu"><span>Dashboard</span><span>Posts</span><span class="is-open">PDF Embed</span><div class="tour-wpsub">';
    foreach ( $sub as $k => $label ) {
        $out .= '<span' . ( $k === $active ? ' class="is-active"' : '' ) . '>' . esc_html( $label ) . '</span>';
    }
    $out .= '</div><span>Media</span><span>Pages</span><span>Elementor</span><span>Appearance</span><span>Plugins</span><span>Settings</span></nav>';
    return $out;
};

/** One page's content: $n is the page number, $is_rtl the script direction. */
$page_html = function ( $n, $is_rtl, $doc ) use ( $cover ) {
    if ( $is_rtl ) {
        // Public-domain text: Kalila wa Dimna, "the lion and the bull".
        $ar = array(
            2 => '',
            3 => 'قال دبشليم الملك لبيدبا الفيلسوف: اضرب لي مثل المتحابين يقطع بينهما الكذوب المحتال، حتى يحملهما على العداوة والبغضاء.',
            4 => 'قال بيدبا: إذا ابتلي المتحابان بأن يدخل بينهما الكذوب المحتال، لم يلبثا أن يتقاطعا ويتدابرا.',
            5 => 'ومن أمثال ذلك أنه كان بأرض دستاوند رجل شيخ، وكان له ثلاثة بنين، فلما بلغوا أشدهم أسرفوا في مال أبيهم.',
        );
        $num  = array( 2 => '٢', 3 => '٣', 4 => '٤', 5 => '٥' );
        $html = '<span class="tour-k' . ( 2 === $n || 4 === $n ? ' tour-k--r' : '' ) . '">' . $num[ $n ] . '</span>';
        if ( 2 === $n ) {
            return $html . '<span class="tour-rtl-title">' . esc_html( $doc ? $doc['short'] : 'كليلة ودمنة' ) . '</span><span class="tour-ar tour-ar--sub">باب الأسد والثور</span><span class="tour-orn">❦</span>';
        }
        return $html . '<p class="tour-ar">' . esc_html( $ar[ $n ] ) . '</p><p class="tour-ar tour-ar--dim">' . esc_html( $ar[ 3 === $n ? 4 : 3 ] ) . '</p>';
    }
    switch ( $n ) {
        case 2:
            return '<span class="tour-k">Inside this issue</span><span class="tour-h">Light &amp; <em>structure</em></span>' . $cover( $doc, 'tour-photo' )
                . '<p class="tour-p">How glass roofs changed public space, and the rooms we never want to leave.</p>';
        case 3:
            return '<span class="tour-k tour-k--r">Page 3</span><span class="tour-h tour-h--xs">The arch <em>returns</em></span>'
                . '<p class="tour-p">Vaulted ceilings are back in new civic buildings: libraries, stations and markets that feel far bigger than they are.</p>'
                . '<span class="tour-stats"><span><b>04</b><small>Under the glass roof</small></span><span><b>08</b><small>Stations as cathedrals</small></span></span>'
                . '<p class="tour-p">Every building is an argument about light.</p>';
        case 4:
            return '<span class="tour-k">Page 4</span><span class="tour-h tour-h--sm">Under the <em>glass roof</em></span>'
                . '<p class="tour-p">A lattice of steel and glass can turn a forgotten courtyard into the most popular room in a city.</p>'
                . '<p class="tour-p">We spent a week in three of them, from opening time to the last train home.</p>';
        default:
            return '<span class="tour-k tour-k--r">Page 5</span>' . $cover( $doc, 'tour-photo tour-photo--tall' )
                . '<span class="tour-cap">The great court, photographed at eight in the morning.</span>';
    }
};

/** The plugin's settings page around one section ($nav = active item). */
$settings_shell = function ( $nav, $inner ) use ( $admin_menu ) {
    $items = array(
        'archive' => array( 'Archive Page', false ), 'display' => array( 'Display &amp; Behavior', false ), 'colors' => array( 'Brand Colors', false ),
        'protect' => array( 'PDF URL Protection', true ), 'flipbook' => array( 'Flipbook', true ), 'license' => array( 'Manage License', true ),
    );
    $out = $admin_menu( 'settings' ) . '<div class="tour-wpmain"><div class="tour-sethead"><span class="tour-seticon">▤</span><b>PDF Embed Viewer</b><span class="tour-ver">v1.5.7</span><span class="tour-btn">Save Changes</span></div><div class="tour-setbody"><div class="tour-setnav">';
    foreach ( $items as $key => $item ) {
        $out .= '<span' . ( $key === $nav ? ' class="is-active"' : '' ) . '>' . $item[0] . ( $item[1] ? ' <em class="tour-pro">PRO</em>' : '' ) . '</span>';
    }
    return $out . '</div><div class="tour-setmain">' . $inner . '</div></div></div>';
};

/**
 * The reader's view of a book. The page on the "still" side stays put; the
 * leaf on the other side turns over it (front = page 3, back = page 4) and
 * uncovers page 5 underneath. LTR turns right-to-left, RTL the other way.
 */
$book = function ( $doc, $is_rtl ) use ( $page_html, $pages, $page_img, $svg, $real_ltr, $real_rtl ) {
    $total = (int) ( $doc && ! empty( $doc['pages'] ) ? $doc['pages'] : $pages );
    $set   = $is_rtl ? $real_rtl : $real_ltr;
    $ratio = $set ? ( 'arabic' === $set ? '0.667' : '0.7776' ) : '0.88';
    $page  = function ( $n ) use ( $set, $page_img, $page_html, $is_rtl, $doc ) {
        return $set ? $page_img( $set, $n ) : $page_html( $n, $is_rtl, $doc );
    };
    ob_start();
    ?>
    <span class="tour-arrow tour-arrow--l"><?php echo $svg( 'prev' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static icon ?></span>
    <span class="tour-arrow tour-arrow--r"><?php echo $svg( 'next' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
    <div class="tour-book tour-book--<?php echo $is_rtl ? 'rtl' : 'ltr'; ?><?php echo $set ? ' tour-book--real' : ''; ?>" style="--page-ratio:<?php echo esc_attr( $ratio ); ?>" data-tour-target="<?php echo $is_rtl ? 'rtl-book' : 'book'; ?>">
      <div class="tour-page tour-page--still"><?php echo $page( 2 ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped parts ?></div>
      <div class="tour-page tour-page--under"><?php echo $page( 5 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      <div class="tour-leaf">
        <div class="tour-leaf__face tour-leaf__front"><?php echo $page( 3 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
        <div class="tour-leaf__face tour-leaf__back"><?php echo $page( 4 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      </div>
      <i class="tour-spine" aria-hidden="true"></i>
    </div>
    <div class="tour-chrome2" data-tour-target="<?php echo $is_rtl ? 'rtl-toolbar' : 'toolbar'; ?>" data-total="<?php echo (int) $total; ?>">
      <div class="tour-slider"><i class="tour-slider__knob"></i></div>
      <div class="tour-fx">
        <span class="tour-fx-b" data-fx="first"><?php echo $svg( 'first' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b" data-fx="prev"><?php echo $svg( 'prev' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-page"><b data-page>2</b><i><?php echo $svg( 'up' ) . $svg( 'down' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></i></span>
        <span class="tour-fx-total">/ <?php echo (int) $total; ?></span>
        <span class="tour-fx-b"><?php echo $svg( 'next' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b"><?php echo $svg( 'last' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <i class="tour-fx-sep"></i>
        <span class="tour-fx-b is-on"><?php echo $svg( 'side' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b" data-fx="grid"><?php echo $svg( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-zoom"><?php echo $svg( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>100%<?php echo $svg( 'chev' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b"><?php echo $svg( 'sun' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b"><?php echo $svg( 'expand' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
        <span class="tour-fx-b" data-fx="more"><?php echo $svg( 'more' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
          <span class="tour-fx-menu">
            <span><?php echo $svg( 'play' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>Autoplay</span>
            <span><?php echo $svg( 'share' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>Share</span>
            <span class="tour-fx-lockable"><?php echo $svg( 'print' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>Print<em><?php echo $svg( 'lock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></em></span>
            <span class="tour-fx-lockable"><?php echo $svg( 'dl' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>Download<em><?php echo $svg( 'lock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></em></span>
          </span>
        </span>
      </div>
    </div>
    <?php if ( ! $is_rtl ) : ?>
      <aside class="tour-rail">
        <div class="tour-rail__head"><b>Thumbnails</b><?php echo $svg( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
        <div class="tour-rail__grid">
          <?php for ( $n = 1; $n <= 6; $n++ ) : ?>
            <span class="tour-rail__t<?php echo ( 4 === $n || 5 === $n ) ? ' is-cur' : ''; ?>"><?php echo $set ? $page_img( $set, $n ) : '<i></i>'; // phpcs:ignore WordPress.Security.EscapeOutput ?><small><?php echo (int) $n; ?></small></span>
          <?php endfor; ?>
        </div>
      </aside>
    <?php endif; ?>
    <?php
    return ob_get_clean();
};
?>
<div class="tour reveal" data-tour data-urls="<?php echo esc_attr( wp_json_encode( $urls ) ); ?>">
  <div class="tour-frame" role="img" aria-label="<?php esc_attr_e( 'Product tour: add a PDF, pick a cover, copy the shortcode, paste it, and readers get a real flipbook.', 'flipbook-theme' ); ?>">
    <div class="tour-chrome">
      <span class="tour-dots" aria-hidden="true"><i></i><i></i><i></i></span>
      <span class="tour-url" data-tour-url><?php echo esc_html( $urls['library'] ); ?></span>
    </div>
    <div class="tour-app" aria-hidden="true">

      <!-- 1. All PDFs -->
      <section class="tour-screen tour-admin is-on" data-screen="library">
        <?php echo $admin_menu( 'list' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        <div class="tour-wpmain">
          <div class="tour-wphead"><h4>PDF Embed</h4><span class="tour-btn tour-btn--outline" data-tour-target="add-btn">Add New PDF</span></div>
          <div class="tour-table">
            <div class="tour-tr tour-th"><span></span><span>Title</span><span>Pages</span><span>Reads</span><span>Shortcode</span></div>
            <?php foreach ( array_slice( $ltr ? $ltr : array( $featured ), 0, 6 ) as $doc ) : ?>
              <div class="tour-tr">
                <?php echo $cover( $doc, 'tour-cover--row' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <span class="tour-td-title"><b><?php echo esc_html( $doc['title'] ); ?></b><small>Published</small></span>
                <span><?php echo (int) $doc['pages']; ?></span>
                <span><?php echo (int) $doc['views']; ?></span>
                <span class="tour-chip-code">[pdfev_embed_viewer id="<?php echo (int) $doc['id']; ?>"]</span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- 2-4. Edit PDF -->
      <section class="tour-screen tour-admin" data-screen="editor">
        <?php echo $admin_menu( 'new' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        <div class="tour-wpmain tour-wpmain--editor">
          <div class="tour-wphead"><h4>Edit PDF</h4></div>
          <div class="tour-editor">
            <div class="tour-titlefield"><?php echo esc_html( $featured['title'] ); ?></div>
            <div class="tour-metabox">
              <div class="tour-tabs"><span class="is-active">⚙ General</span><span>▤ E-Book Info</span><span>◐ Template</span></div>
              <div class="tour-mbody">
                <div class="tour-drop is-done" data-tour-target="dropzone">
                  <span class="tour-drop__icon">⤒</span>
                  <span class="tour-drop__text">Drop a PDF here or <u>choose a file</u></span>
                  <span class="tour-drop__bar"><i></i></span>
                  <span class="tour-drop__file"><b>▣</b> <?php echo esc_html( $file ); ?> <small><?php echo esc_html( $size_mb ); ?> · <?php echo (int) $pages; ?> pages</small><em>✓</em></span>
                </div>
                <div class="tour-coverpick" data-tour-target="covers">
                  <div class="tour-coverbig"><?php echo $cover( $featured, 'tour-cover--big' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="tour-coverbig__alt"><?php echo $real_ltr ? $page_img( $real_ltr, 3 ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?></span><small>Book Cover</small></div>
                  <div class="tour-thumbs">
                    <?php if ( $real_ltr ) : ?>
                      <?php for ( $n = 1; $n <= 4; $n++ ) : ?>
                        <span class="tour-thumb tour-thumb--real<?php echo 1 === $n ? ' is-sel' : ''; ?>"><?php echo $page_img( $real_ltr, $n ); // phpcs:ignore WordPress.Security.EscapeOutput ?><small>Page <?php echo (int) $n; ?></small></span>
                      <?php endfor; ?>
                    <?php else : ?>
                      <span class="tour-thumb is-sel"><?php echo $cover( $featured ); // phpcs:ignore WordPress.Security.EscapeOutput ?><small>Page 1</small></span>
                      <span class="tour-thumb tour-thumb--text"><i></i><small>Page 2</small></span>
                      <span class="tour-thumb tour-thumb--photo"><i></i><small>Page 3</small></span>
                      <span class="tour-thumb tour-thumb--text"><i></i><small>Page 4</small></span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="tour-code" data-tour-target="code">
                  <small>SHORTCODE</small>
                  <code><?php echo esc_html( $code ); ?></code>
                  <span class="tour-copy" data-copy-label="Copy" data-copied-label="Copied ✓">Copy</span>
                </div>
              </div>
            </div>
          </div>
          <aside class="tour-side">
            <div class="tour-box"><b>Publish</b><span>Status: Published</span><span class="tour-btn">Update</span></div>
            <div class="tour-box"><b>Categories</b><span>☑ Magazine</span><span>☐ Catalogue</span><span>☐ Report</span></div>
          </aside>
        </div>
      </section>

      <!-- 5. Page editor -->
      <section class="tour-screen tour-gb" data-screen="page">
        <div class="tour-gbbar"><span class="tour-wplogo tour-wplogo--sq">W</span><span class="tour-gb-plus">+</span><span class="tour-gb-ico">↶ ↷</span><span class="tour-gb-title">Annual Report</span><span class="tour-btn">Publish</span></div>
        <div class="tour-gbbody">
          <div class="tour-gbcanvas">
            <h3><?php echo esc_html( $featured['short'] ); ?></h3>
            <span class="tour-lines tour-lines--gb"><i></i><i style="width:84%"></i><i style="width:70%"></i></span>
            <div class="tour-block" data-tour-target="block">
              <small>[/] Shortcode</small>
              <code><span data-type="<?php echo esc_attr( $code ); ?>"></span><b class="tour-caret"></b></code>
            </div>
            <span class="tour-lines tour-lines--gb"><i style="width:90%"></i><i style="width:60%"></i></span>
          </div>
          <aside class="tour-gbside"><b>Block</b><span>Shortcode</span><span class="tour-gbside__hint">Or use the Flipbook PDF widget in Elementor.</span></aside>
        </div>
      </section>

      <!-- 6, 7, 11. The reader's view -->
      <section class="tour-screen tour-site" data-screen="site">
        <div class="tour-sitebar"><b>◆ Your Site</b><span>Home</span><span>Library</span><span>About</span></div>
        <div class="tour-sitehead"><small>MAGAZINE · <?php echo (int) $pages; ?> PAGES</small><h3><?php echo esc_html( $featured['title'] ); ?></h3>
          <span class="tour-lockbadge" data-tour-target="lock">🔒 Lockdown <small>No download · file link hidden</small></span></div>
        <div class="tour-stage" data-tour-target="stage"><?php echo $book( $featured, false ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      </section>

      <!-- 8. Settings: archive layout -->
      <section class="tour-screen tour-admin" data-screen="settings">
        <?php
        echo $settings_shell( 'archive', '<b>Archive Template</b><small>How your PDF library is laid out.</small>'
            . '<div class="tour-layouts" data-tour-target="layouts">'
            . '<span class="tour-layout is-sel"><i class="tour-lo tour-lo--grid"></i>Grid</span>'
            . '<span class="tour-layout"><i class="tour-lo tour-lo--list"></i>List</span>'
            . '<span class="tour-layout"><i class="tour-lo tour-lo--news"></i>Newsletter</span>'
            . '<span class="tour-layout"><i class="tour-lo tour-lo--shelf"></i>E-Book</span></div>' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static markup
        ?>
      </section>

      <!-- Pro: PDF URL Protection -->
      <section class="tour-screen tour-admin" data-screen="pro-protect">
        <?php
        echo $settings_shell( 'protect', '<b>PDF URL Protection</b><small>Control how PDF files are delivered to visitors.</small>'
            . '<div class="tour-radios" data-tour-target="protect">'
            . '<span class="tour-radio is-sel"><i></i><span><b>Direct URL</b><small>The file link sits in the page, as in the free plugin.</small></span></span>'
            . '<span class="tour-radio"><i></i><span><b>Hide File URL <em class="tour-pro">PRO</em></b><small>No file path in the page; the viewer fetches a short-lived link.</small></span></span>'
            . '<span class="tour-radio"><i></i><span><b>Lockdown — no downloads <em class="tour-pro">PRO</em></b><small>Locked folder, single-use links, scrambled bytes. No download, print or save.</small></span></span>'
            . '</div>' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static markup
        ?>
      </section>

      <!-- Pro: Flipbook viewer options -->
      <section class="tour-screen tour-admin" data-screen="pro-viewer">
        <?php
        $toggles = array( 'Page-flip sound' => 1, 'Autoplay' => 0, 'Print' => 1, 'Full screen' => 1, 'Download' => 1, 'Share' => 1 );
        $t_html  = '';
        foreach ( $toggles as $label => $on ) {
            $t_html .= '<span class="tour-toggle' . ( $on ? ' is-on' : '' ) . '" data-toggle="' . esc_attr( strtolower( strtok( $label, ' -' ) ) ) . '"><i></i>' . esc_html( $label ) . '</span>';
        }
        echo $settings_shell( 'flipbook', '<b>Flipbook</b><small>Fine-tune how the 3D flipbook viewer looks and behaves.</small>'
            . '<div class="tour-viewer" data-tour-target="viewer">'
            . '<div class="tour-toggles">' . $t_html . '</div>'
            . '<div class="tour-field"><span>Theme / Skin</span><span class="tour-select" data-skin data-skin-to="Premium — Studio Light">Dark, Compact Toolbar</span></div>'
            . '<div class="tour-field"><span>Page Mode</span><span class="tour-seg"><i>Single Page</i><i class="is-sel">Two-Page Spread</i></span></div>'
            . '<div class="tour-field"><span>Book Style</span><span class="tour-select">Volume</span></div>'
            . '</div>' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
        ?>
      </section>

      <!-- Pro: license -->
      <section class="tour-screen tour-admin" data-screen="pro-license">
        <?php
        echo $settings_shell( 'license', '<b>Manage License</b><small>Activate, deactivate, or refresh your Pro license key.</small>'
            . '<div class="tour-license" data-tour-target="license">'
            . '<span class="tour-license__label">License Key</span>'
            . '<div class="tour-keyrow"><code data-key="A1F4C9E2-7B3D5E61-C08A92F4-3E7D1B56"></code><span class="tour-btn tour-btn--ui" data-activate>Activate</span></div>'
            . '<span class="tour-status"><i></i>Active <small>· Expires ' . esc_html( gmdate( 'Y-m-d', strtotime( '+1 year' ) ) ) . '</small></span>'
            . '</div>' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
        ?>
      </section>

      <!-- 9. Library shelf -->
      <section class="tour-screen tour-site" data-screen="shelf">
        <div class="tour-sitebar"><b>◆ Your Site</b><span>Home</span><span class="is-active">Library</span><span>About</span></div>
        <div class="tour-sitehead"><small>ALL PUBLICATIONS</small><h3>Library</h3></div>
        <div class="tour-shelf" data-tour-target="shelf">
          <?php foreach ( array_slice( array_merge( $ltr ? $ltr : array( $featured ), $rtl ), 0, 12 ) as $doc ) : ?>
            <div class="tour-shelfitem">
              <?php echo $cover( $doc, 'tour-cover--shelf' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              <b><?php echo esc_html( $doc['short'] ); ?></b>
              <span class="tour-read">👁 Read <small><?php echo (int) $doc['views']; ?></small></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- 10. Right-to-left -->
      <section class="tour-screen tour-site" data-screen="rtl">
        <div class="tour-sitebar"><b>◆ Your Site</b><span>Home</span><span>Library</span><span>About</span></div>
        <div class="tour-sitehead" dir="rtl"><small>RTL</small><h3><?php echo esc_html( $rtl_doc ? $rtl_doc['title'] : 'كليلة ودمنة' ); ?></h3></div>
        <div class="tour-stage"><?php echo $book( $rtl_doc, true ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      </section>

      <div class="tour-spot" aria-hidden="true"><i class="tour-spot__dot"></i></div>
      <div class="tour-tip" aria-hidden="true"><b data-tip-title></b><span data-tip-text></span></div>
    </div>
  </div>

  <div class="tour-steps" role="tablist" aria-label="<?php esc_attr_e( 'Tour steps', 'flipbook-theme' ); ?>">
    <?php foreach ( $steps as $i => $s ) : ?>
      <button type="button" class="tour-step" role="tab" data-step="<?php echo esc_attr( $s[0] ); ?>" data-screen="<?php echo esc_attr( $s[1] ); ?>" data-target="<?php echo esc_attr( $s[2] ); ?>" data-ms="<?php echo (int) $s[3]; ?>" data-title="<?php echo esc_attr( $s[4] . ( empty( $s[6] ) ? '' : ' (Pro)' ) ); ?>" data-text="<?php echo esc_attr( $s[5] ); ?>">
        <span class="tour-step__n"><?php echo (int) $i + 1; ?></span><span class="tour-step__t"><?php echo esc_html( $s[4] ); ?></span><?php if ( ! empty( $s[6] ) ) : ?><em class="tour-pro">PRO</em><?php endif; ?><i class="tour-step__bar"></i>
      </button>
    <?php endforeach; ?>
  </div>
</div>
