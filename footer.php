<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<footer class="site-footer">
  <div class="u-container">
    <div class="footer-top">
      <div class="footer-about">
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <svg class="brand-mark" viewBox="0 0 32 32" aria-hidden="true"><rect class="tile" x="1" y="1" width="30" height="30" rx="8"/><path class="page" d="M8 10.5c2.6-1 5.3-1 8 .6v11.4c-2.7-1.6-5.4-1.6-8-.6V10.5Z"/><path class="fold" d="M24 10.5c-2.6-1-5.3-1-8 .6v11.4c2.7-1.6 5.4-1.6 8-.6V10.5Z"/></svg>
          <span>Flipbook PDF</span>
        </a>
        <p>A WordPress plugin for turning PDFs into realistic, interactive 3D flipbooks — free on WordPress.org.</p>
        <a class="footer-whatsapp" href="https://wa.me/8801521255463" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="#25D366" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.81L2 22l5.42-1.36a9.9 9.9 0 0 0 4.62 1.15h.01c5.46 0 9.9-4.45 9.9-9.9C21.95 6.45 17.5 2 12.04 2Zm5.79 14.05c-.24.68-1.4 1.3-1.94 1.36-.5.06-1.13.08-1.82-.11-.42-.12-.96-.3-1.66-.6-2.92-1.26-4.83-4.2-4.98-4.4-.15-.19-1.19-1.58-1.19-3.02s.75-2.14 1.02-2.43c.27-.29.58-.36.78-.36h.55c.18 0 .41-.02.64.49.24.55.81 1.94.88 2.08.07.14.12.31.02.5-.1.19-.15.3-.29.46-.15.16-.31.36-.44.48-.15.14-.3.3-.13.58.17.28.75 1.24 1.62 2.01 1.11.99 2.05 1.3 2.33 1.44.28.14.44.12.6-.07.17-.19.71-.83.9-1.11.19-.28.38-.24.64-.14.26.1 1.65.78 1.93.92.28.14.47.21.54.33.07.12.07.68-.17 1.36Z"/></svg>
          <span><?php echo esc_html( '+880 1521-255463' ); ?></span>
        </a>
      </div>
      <div class="footer-cols">
        <div class="footer-col">
          <h4>Product</h4>
          <a href="<?php echo esc_url( home_url( '/#features' ) ); ?>">Features</a>
          <a href="<?php echo esc_url( home_url( '/#formats' ) ); ?>">Layouts</a>
          <a href="<?php echo esc_url( home_url( '/#pricing' ) ); ?>">Pricing</a>
          <a href="<?php echo esc_url( home_url( '/#compare' ) ); ?>">Free vs Pro</a>
          <a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">FAQ</a>
          <a href="https://lieusoft.com/pdf-embed-viewer/#pricing">Buy Pro</a>
          <a href="<?php $d = get_page_by_path( 'demo/flipbook' ); echo esc_url( $d ? get_permalink( $d ) : home_url( '/#live-demo' ) ); ?>">Live demo</a>
        </div>
        <div class="footer-col">
          <h4>Resources</h4>
          <a href="https://wordpress.org/plugins/pdf-embed-viewer/">WordPress.org</a>
          <a href="https://github.com/raselsha/pdf-embed-viewer">GitHub</a>
          <a href="mailto:hello@lieusoft.com">Support</a>
          <a href="https://lieusoft.com/">Lieusoft</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> Flipbook PDF. Built on the Flipbook PDF Viewer &amp; Embedder plugin.</span>
      <span>GPLv2 or later.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
