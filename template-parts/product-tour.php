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
$rtl_doc = $rtl ? $rtl[0] : null;
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
    array( 'toolbar',  'site',     'toolbar',  3400, 'Everything readers need', 'Zoom, table of contents, full screen and a page counter.' ),
    array( 'layouts',  'settings', 'layouts',  4200, 'Four archive layouts',    'Grid, list, newsletter or an e-book shelf.' ),
    array( 'shelf',    'shelf',    'shelf',    3800, 'A library, not a list',   'Covers, read counts and buttons for every PDF.' ),
    array( 'rtl',      'rtl',      'rtl-book', 4600, 'Right-to-left books',     'Arabic, Urdu and Hebrew turn from right to left.' ),
    array( 'lock',     'site',     'lock',     4200, 'Lockdown (Pro)',          'Readers flip every page. Nobody can download the file.' ),
);
$urls = array(
    'library'  => 'yoursite.com/wp-admin/edit.php?post_type=pdf',
    'editor'   => 'yoursite.com/wp-admin/post.php?post=' . (int) $featured['id'] . '&action=edit',
    'page'     => 'yoursite.com/wp-admin/post-new.php?post_type=page',
    'site'     => 'yoursite.com/' . $featured['slug'],
    'settings' => 'yoursite.com/wp-admin/admin.php?page=pdf-settings',
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

/**
 * The reader's view of a book. The page on the "still" side stays put; the
 * leaf on the other side turns over it (front = page 3, back = page 4) and
 * uncovers page 5 underneath. LTR turns right-to-left, RTL the other way.
 */
$book = function ( $doc, $is_rtl ) use ( $page_html, $pages ) {
    $total = (int) ( $doc && ! empty( $doc['pages'] ) ? $doc['pages'] : $pages );
    ob_start();
    ?>
    <div class="tour-book tour-book--<?php echo $is_rtl ? 'rtl' : 'ltr'; ?>" data-tour-target="<?php echo $is_rtl ? 'rtl-book' : 'book'; ?>">
      <div class="tour-page tour-page--still"><?php echo $page_html( 2, $is_rtl, $doc ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts ?></div>
      <div class="tour-page tour-page--under"><?php echo $page_html( 5, $is_rtl, $doc ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      <div class="tour-leaf">
        <div class="tour-leaf__face tour-leaf__front"><?php echo $page_html( 3, $is_rtl, $doc ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
        <div class="tour-leaf__face tour-leaf__back"><?php echo $page_html( 4, $is_rtl, $doc ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      </div>
      <i class="tour-spine" aria-hidden="true"></i>
    </div>
    <div class="tour-toolbar" data-tour-target="<?php echo $is_rtl ? 'rtl-toolbar' : 'toolbar'; ?>">
      <span class="tour-tb" title="Zoom">⌕</span><span class="tour-tb" title="Contents">☰</span><span class="tour-tb">‹</span>
      <span class="tour-count" data-count data-total="<?php echo (int) $total; ?>">2–3 / <?php echo (int) $total; ?></span>
      <span class="tour-tb">›</span><span class="tour-tb" title="Full screen">⤢</span><span class="tour-tb tour-tb--dl" title="Download">⤓</span>
    </div>
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
                  <div class="tour-coverbig"><?php echo $cover( $featured, 'tour-cover--big' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span class="tour-coverbig__alt"></span><small>Book Cover</small></div>
                  <div class="tour-thumbs">
                    <span class="tour-thumb is-sel"><?php echo $cover( $featured ); // phpcs:ignore WordPress.Security.EscapeOutput ?><small>Page 1</small></span>
                    <span class="tour-thumb tour-thumb--text"><i></i><small>Page 2</small></span>
                    <span class="tour-thumb tour-thumb--photo"><i></i><small>Page 3</small></span>
                    <span class="tour-thumb tour-thumb--text"><i></i><small>Page 4</small></span>
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
        <div class="tour-stage"><?php echo $book( $featured, false ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
      </section>

      <!-- 8. Settings -->
      <section class="tour-screen tour-admin" data-screen="settings">
        <?php echo $admin_menu( 'settings' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
        <div class="tour-wpmain">
          <div class="tour-sethead"><span class="tour-seticon">▤</span><b>PDF Embed Viewer</b><span class="tour-ver">v1.5.7</span><span class="tour-btn">Save Changes</span></div>
          <div class="tour-setbody">
            <div class="tour-setnav"><span class="is-active">Archive Page</span><span>Elementor</span><span>Display &amp; Behavior</span><span>Book Details</span><span>Brand Colors</span></div>
            <div class="tour-setmain">
              <b>Archive Template</b><small>How your PDF library is laid out.</small>
              <div class="tour-layouts" data-tour-target="layouts">
                <span class="tour-layout is-sel"><i class="tour-lo tour-lo--grid"></i>Grid</span>
                <span class="tour-layout"><i class="tour-lo tour-lo--list"></i>List</span>
                <span class="tour-layout"><i class="tour-lo tour-lo--news"></i>Newsletter</span>
                <span class="tour-layout"><i class="tour-lo tour-lo--shelf"></i>E-Book</span>
              </div>
            </div>
          </div>
        </div>
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
      <button type="button" class="tour-step" role="tab" data-step="<?php echo esc_attr( $s[0] ); ?>" data-screen="<?php echo esc_attr( $s[1] ); ?>" data-target="<?php echo esc_attr( $s[2] ); ?>" data-ms="<?php echo (int) $s[3]; ?>" data-title="<?php echo esc_attr( $s[4] ); ?>" data-text="<?php echo esc_attr( $s[5] ); ?>">
        <span class="tour-step__n"><?php echo (int) $i + 1; ?></span><span class="tour-step__t"><?php echo esc_html( $s[4] ); ?></span><i class="tour-step__bar"></i>
      </button>
    <?php endforeach; ?>
  </div>
</div>
