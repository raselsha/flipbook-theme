<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<section class="hero">
  <div class="u-container">
    <div class="hero-copy">
      <h1>Turn any PDF into a book people actually <em>flip</em> through.</h1>
      <p class="lede">Drop in a PDF and get a realistic, page-turning 3D flipbook &mdash; no design work, no code, just a shortcode.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="https://wordpress.org/plugins/pdf-embed-viewer/">Get the plugin</a>
        <a class="btn btn--ghost" href="#formats">See every format</a>
      </div>
    </div>
    <div class="hero-demo reveal" id="demo">
      <div class="hero-demo-frame">
        <div class="hero-demo-bar"><span class="dot"></span> Live demo — actual plugin output</div>
        <div class="hero-demo-viewer">
          <?php echo do_shortcode( '[pdfev_embed_viewer id="215" show_author="yes" show_year="yes"]' ); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="u-container">
    <div class="section-head reveal">
      <h2>A dimensional book, not a thumbnail.</h2>
      <p class="lede">Hover any cover to peek inside before opening it &mdash; the plugin's own ebook shortcode, unstyled by us.</p>
    </div>
    <?php echo do_shortcode( '[pdfev_viewer template="ebook" limit="4"]' ); ?>
  </div>
</section>

<section class="section" id="formats">
  <div class="u-container">
    <div class="section-head reveal">
      <span class="eyebrow">One plugin, every layout</span>
      <h2>Every way readers want to browse</h2>
      <p class="lede">The plugin's own shortcode output, unstyled by us &mdash; this is exactly what you get.</p>
    </div>
    <div class="format-stack">
      <div class="format-block reveal">
        <div class="format-block-head">
          <h3>Grid</h3>
          <p>A tiled shelf of covers &mdash; built for a catalog, a lookbook, or a library of reports.</p>
        </div>
        <div class="format-demo"><?php echo do_shortcode( '[pdfev_viewer template="grid" limit="4"]' ); ?></div>
      </div>
      <div class="format-block reveal">
        <div class="format-block-head">
          <h3>List</h3>
          <p>A scannable line-up with description and metadata &mdash; built for documentation and manuals.</p>
        </div>
        <div class="format-demo"><?php echo do_shortcode( '[pdfev_viewer template="list" limit="4"]' ); ?></div>
      </div>
      <div class="format-block reveal">
        <div class="format-block-head">
          <h3>Newsletter</h3>
          <p>A compact digest row &mdash; built for recurring issues, reports, or bulletins.</p>
        </div>
        <div class="format-demo"><?php echo do_shortcode( '[pdfev_viewer template="newsletter" limit="4"]' ); ?></div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="u-container">
    <div class="cta-band reveal">
      <div>
        <h2>Ready to make your PDFs flip?</h2>
        <p class="muted">Free on WordPress.org. Set up a shortcode in minutes.</p>
      </div>
      <div class="btn-row">
        <a class="btn btn--primary" href="https://wordpress.org/plugins/pdf-embed-viewer/">Get the plugin</a>
        <a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/contact-support/' ) ); ?>">Contact support</a>
      </div>
    </div>
  </div>
</section>
<?php
get_footer();