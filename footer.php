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
        <a class="footer-whatsapp" href="https://wa.me/8801737266685" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;margin-top:14px;color:var(--ink);text-decoration:none;font-size:0.92rem;font-weight:600;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="#25D366" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.81L2 22l5.42-1.36a9.9 9.9 0 0 0 4.62 1.15h.01c5.46 0 9.9-4.45 9.9-9.9C21.95 6.45 17.5 2 12.04 2Zm5.79 14.05c-.24.68-1.4 1.3-1.94 1.36-.5.06-1.13.08-1.82-.11-.42-.12-.96-.3-1.66-.6-2.92-1.26-4.83-4.2-4.98-4.4-.15-.19-1.19-1.58-1.19-3.02s.75-2.14 1.02-2.43c.27-.29.58-.36.78-.36h.55c.18 0 .41-.02.64.49.24.55.81 1.94.88 2.08.07.14.12.31.02.5-.1.19-.15.3-.29.46-.15.16-.31.36-.44.48-.15.14-.3.3-.13.58.17.28.75 1.24 1.62 2.01 1.11.99 2.05 1.3 2.33 1.44.28.14.44.12.6-.07.17-.19.71-.83.9-1.11.19-.28.38-.24.64-.14.26.1 1.65.78 1.93.92.28.14.47.21.54.33.07.12.07.68-.17 1.36Z"/></svg>
          <span><?php echo esc_html( '+880 1737-266685' ); ?></span>
        </a>
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
