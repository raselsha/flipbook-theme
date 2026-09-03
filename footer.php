<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<footer class="site-footer">
  <div class="u-container">
    <div class="footer-top">
      <div>
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <svg class="brand-mark" viewBox="0 0 26 26" aria-hidden="true"><path class="page" d="M3 5h13a2 2 0 0 1 2 2v14L3 21z"/><path class="fold" d="M18 7v14l5-2V9z"/></svg>
          <span>Flipbook PDF</span>
        </a>
        <p class="muted" style="max-width:34ch;margin-top:10px;font-size:0.92rem;">A WordPress plugin for turning PDFs into realistic, interactive 3D flipbooks — free on WordPress.org.</p>
      </div>
      <div class="footer-cols">
        <div class="footer-col">
          <h4>Product</h4>
          <a href="<?php echo esc_url( home_url( '/#features' ) ); ?>">Features</a>
          <a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>">Pricing</a>
          <a href="<?php $d = get_page_by_path( 'demo' ); echo esc_url( $d ? get_permalink( $d ) : home_url( '/#formats' ) ); ?>">Live demo</a>
        </div>
        <div class="footer-col">
          <h4>Resources</h4>
          <a href="https://wordpress.org/plugins/pdf-embed-viewer/">WordPress.org</a>
          <a href="https://github.com/raselsha/pdf-embed-viewer">GitHub</a>
          <a href="<?php echo esc_url( home_url( '/contact-support/' ) ); ?>">Support</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> Flipbook PDF. Built on the 3D Flipbook PDF Viewer &amp; Embedder plugin.</span>
      <span>GPLv2 or later.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
