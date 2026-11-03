<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

/**
 * Every live shortcode embed except the "See it live" window lives on its
 * own /demo/ sub-page (each page's real post_content has the shortcode, so
 * the plugin's own has_shortcode() asset-loading check finds it natively —
 * see functions.php). The homepage links out to them.
 */
$demo_flipbook   = get_page_by_path( 'demo/flipbook' );
$demo_grid       = get_page_by_path( 'demo/grid' );
$demo_list       = get_page_by_path( 'demo/list' );
$demo_newsletter = get_page_by_path( 'demo/newsletter' );
$demo_ebook      = get_page_by_path( 'demo/ebook' );

$demo_flipbook_url   = $demo_flipbook ? get_permalink( $demo_flipbook ) : '#';
$demo_grid_url       = $demo_grid ? get_permalink( $demo_grid ) : '#';
$demo_list_url       = $demo_list ? get_permalink( $demo_list ) : '#';
$demo_newsletter_url = $demo_newsletter ? get_permalink( $demo_newsletter ) : '#';
$demo_ebook_url      = $demo_ebook ? get_permalink( $demo_ebook ) : '#';

$download_url = 'https://downloads.wordpress.org/plugin/pdf-embed-viewer.zip';
$reviews_url  = 'https://wordpress.org/support/plugin/pdf-embed-viewer/reviews/';
$purchase_url = 'https://lieusoft.com/pdf-embed-viewer/#pricing';
$contact_url  = 'mailto:hello@lieusoft.com';
?>
<main class="frame">

<!-- ===== Hero ===== -->
<section class="hero">
  <div class="hero-grid" aria-hidden="true"></div>
  <div class="paint paint--left" aria-hidden="true"></div>
  <div class="paint paint--right" aria-hidden="true"></div>

  <div class="hero-copy animate-fade-up">
    <h1 class="hero-title">
      Turn any PDF
      <span class="icon-stack" aria-hidden="true">
        <span class="icon-tile icon-tile--red"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/></svg></span>
        <span class="icon-tile icon-tile--ink"><svg viewBox="0 0 24 24"><path d="M2 5c3-1.2 6.5-1.2 10 .8v14c-3.5-2-7-2-10-.8z"/><path d="M22 5c-3-1.2-6.5-1.2-10 .8v14c3.5-2 7-2 10-.8z"/></svg></span>
        <span class="icon-tile icon-tile--accent"><svg viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/><path d="M4 12c4-3 8-3 16 0"/></svg></span>
      </span>
      into a <span class="serif-i">book</span> people actually <span class="serif-i">flip</span> through.
    </h1>
    <p class="hero-lede">A WordPress plugin that turns a PDF into a realistic, page-turning 3D flipbook. Upload the file, paste one shortcode, and it's live — no design work, no conversion step, no code.</p>
    <div class="btn-row">
      <a class="btn btn--primary btn--lg" href="<?php echo esc_url( $download_url ); ?>">Download free plugin</a>
      <a class="btn btn--outline btn--lg" href="#live-demo">See the live demo</a>
    </div>
    <p class="hero-note">Free forever · WordPress 6.0+ · No coding required</p>
  </div>

  <!-- Decorative product frame — a CSS mock, not the real viewer (that's #live-demo below). -->
  <div class="product reveal">
    <div class="product-bar">
      <span class="product-dots" aria-hidden="true"><i></i><i></i><i></i></span>
      <span class="product-url">yoursite.com/annual-report</span>
    </div>
    <div class="product-body">
      <div class="product-rail">
        <div class="rail-label">PDF library</div>
        <div class="rail-item is-active"><strong>Annual Report</strong><span>48 pages · flipbook</span></div>
        <div class="rail-item"><strong>Spring Catalogue</strong><span>32 pages · grid</span></div>
        <div class="rail-item"><strong>Product Manual</strong><span>96 pages · list</span></div>
        <div class="rail-item"><strong>Monthly Bulletin</strong><span>12 pages · newsletter</span></div>
        <div class="rail-item"><strong>Field Guide</strong><span>64 pages · ebook</span></div>
      </div>

      <div class="product-stage">
        <a class="mock-book" href="<?php echo esc_url( $demo_flipbook_url ); ?>" aria-label="Open the live flipbook demo">
          <span class="mock-page mock-page--left">
            <span class="mock-kicker">Section 02</span>
            <span class="mock-title">A year in<br><em>review</em></span>
            <span class="mock-photo"></span>
            <span class="mock-lines"><i style="width:92%"></i><i style="width:78%"></i><i style="width:85%"></i></span>
          </span>
          <span class="mock-page mock-page--right">
            <span class="mock-kicker mock-kicker--right">Page 15</span>
            <span class="mock-lines"><i></i><i style="width:88%"></i><i style="width:95%"></i><i style="width:70%"></i></span>
            <span class="mock-stats"><span><b>Charts</b><small>render crisp</small></span><span><b>Zoom</b><small>stays sharp</small></span></span>
            <span class="mock-lines"><i style="width:90%"></i><i style="width:60%"></i></span>
            <span class="mock-curl"></span>
          </span>
          <span class="mock-highlight" aria-hidden="true"></span>
          <span class="mock-pin" aria-hidden="true"></span>
        </a>
        <div class="mock-tip">
          <strong>Drag a corner to turn</strong>
          <span>The page curls with your cursor — on desktop and touch.</span>
        </div>
        <div class="mock-toolbar" aria-hidden="true">
          <span class="tb-btn"><svg viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg></span>
          <span class="tb-count">14–15 / 48</span>
          <span class="tb-btn"><svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg></span>
          <span class="tb-sep"></span>
          <span class="tb-btn"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5M11 8v6M8 11h6"/></svg></span>
          <span class="tb-btn"><svg viewBox="0 0 24 24"><path d="M4 9V4h5M20 9V4h-5M4 15v5h5M20 15v5h-5"/></svg></span>
          <span class="tb-btn"><svg viewBox="0 0 24 24"><path d="M12 4v11M7 10l5 5 5-5M5 20h14"/></svg></span>
        </div>
      </div>

      <div class="product-panel">
        <div class="rail-label">Shortcode</div>
        <code class="panel-code">[pdfev_embed_viewer<br>&nbsp;id="<b>215</b>"<br>&nbsp;show_author="<b>yes</b>"]</code>
        <div class="rail-label">Display</div>
        <div class="panel-row"><span>Layout</span><span>Double spread</span></div>
        <div class="panel-row"><span>View counter</span><span>On</span></div>
        <div class="panel-row"><span>Download counter</span><span>On</span></div>
        <div class="panel-row"><span>Download button</span><span class="toggle" aria-hidden="true"><i></i></span></div>
        <div class="panel-row"><span>Elementor widget</span><span>Ready</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Trust strip — real WordPress.org numbers (Nov 2026). ===== -->
<div class="trust">
  <span>Publishing flipbooks on 300+ WordPress sites</span>
  <a href="<?php echo esc_url( $reviews_url ); ?>"><span class="stars" aria-hidden="true">★★★★★</span> 5.0 / 5 · 6 reviews on WordPress.org</a>
</div>

<!-- ===== Live demo — the plugin's real output ===== -->
<section class="section live-demo" id="live-demo">
  <div class="section-head centered reveal">
    <div class="eyebrow">[ See it live ]</div>
    <h2>A real flipbook, <span class="serif-i">right here.</span></h2>
    <p class="lede">This is the plugin's own live output — drag a page corner to turn it. No mockup.</p>
  </div>
  <div class="live-demo-window reveal">
    <div class="live-demo-titlebar">
      <span class="product-dots" aria-hidden="true"><i></i><i></i><i></i></span>
      <span class="live-demo-caption">Live flipbook · drag a page corner to turn · double-spread view</span>
    </div>
    <div class="live-demo-body">
      <?php echo do_shortcode( '[pdfev_embed_viewer id="215" show_author="no" show_year="no" show_download="no"]' ); ?>
    </div>
  </div>
</section>

<!-- ===== Maker's note ===== -->
<section class="section note-section">
  <div class="eyebrow eyebrow--center">—— A note from the maker</div>
  <h2 class="centered-title">Does this sound familiar?</h2>
  <article class="letter reveal">
    <span class="tape tape--left" aria-hidden="true"></span>
    <span class="tape tape--right" aria-hidden="true"></span>
    <header class="letter-head"><span>Note no. <strong>0001</strong></span><span>From Lieusoft</span></header>
    <div class="letter-body">
      <p>You spent weeks on a catalogue, a report or a magazine. Then it went on your site as a PDF link, and almost nobody opened it.</p>
      <p>Flat PDF viewers feel like paperwork. Most flipbook tools want you to convert files on someone else's server and pay per page.</p>
      <p>So we built Flipbook PDF as a plain WordPress plugin. Your PDF stays in your media library, renders right in the browser, and turns like a real book. One shortcode, nothing else to learn.</p>
      <p>If your readers don't stay longer, it isn't doing its job.</p>
    </div>
    <div class="letter-sign">Shahadat Hossain</div>
    <div class="letter-person">
      <span class="avatar" aria-hidden="true">SH</span>
      <div><strong>Shahadat Hossain</strong><span>Maker, Lieusoft</span></div>
    </div>
    <footer class="letter-foot">
      <div class="letter-checks"><span>✓ live in 5 minutes</span><span>✓ free forever</span><span>✓ no account needed</span></div>
      <a class="btn btn--primary btn--sm" href="<?php echo esc_url( $download_url ); ?>">Try it on your site</a>
    </footer>
  </article>
</section>

<!-- ===== Features ===== -->
<section class="section" id="features">
  <div class="eyebrow">[ What it does ]</div>
  <h2 class="section-title">The flipbook plugin built for WordPress</h2>
  <p class="section-lede">Nothing extra, nothing missing. Every feature your readers expect, managed from the WordPress admin you already know.</p>

  <div class="feature-split reveal">
    <ol class="feature-list">
      <li><span class="num">01</span><div><h3>Realistic page-turn</h3><p>A physics-based curl that feels like turning a real page, so readers stay immersed.</p></div></li>
      <li><span class="num">02</span><div><h3>One-shortcode embed</h3><p>Upload a PDF, drop <code>[pdfev_embed_viewer]</code> anywhere, and it's live. No conversion step.</p></div></li>
      <li><span class="num">03</span><div><h3>Four archive layouts</h3><p>List, Grid, Newsletter and Ebook shortcodes for browsing a whole library.</p></div></li>
      <li><span class="num">04</span><div><h3>Read &amp; download counters</h3><p>Every document counts its own views and downloads automatically.</p></div></li>
      <li><span class="num">05</span><div><h3>Elementor widgets</h3><p>Drag-and-drop Archive View and Single View widgets with every shortcode option.</p></div></li>
      <li><span class="num">06</span><div><h3>Drag-and-drop ordering</h3><p>Reorder your library right from the admin list, not by upload date.</p></div></li>
    </ol>

    <div class="scene scene--violet feature-scene">
      <div class="scene-card">
        <span class="flow-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/></svg></span>
        <span class="flow-line" aria-hidden="true"></span>
        <code class="flow-code">[pdfev_embed_viewer id="215"]</code>
        <span class="flow-branch" aria-hidden="true"></span>
        <div class="flow-layouts">
          <a href="<?php echo esc_url( $demo_grid_url ); ?>"><span class="ico ico--grid" aria-hidden="true"><i></i><i></i><i></i><i></i></span>Grid</a>
          <a href="<?php echo esc_url( $demo_list_url ); ?>"><span class="ico ico--list" aria-hidden="true"><i></i><i></i><i></i><i></i></span>List</a>
          <a class="is-active" href="<?php echo esc_url( $demo_ebook_url ); ?>"><span class="ico ico--ebook" aria-hidden="true"><i></i><i></i></span>Ebook</a>
          <a href="<?php echo esc_url( $demo_newsletter_url ); ?>"><span class="ico ico--news" aria-hidden="true"><i></i><i></i><i></i></span>Newsletter</a>
        </div>
      </div>
      <div class="scene-badge">
        <span class="badge-check" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12 5 5 9-10"/></svg></span>
        <div><small>Published</small><strong>Live, no conversion</strong></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Formats ===== -->
<section class="section" id="formats">
  <h2 class="section-title">One plugin.<br>The <span class="accent-word">whole</span> library.</h2>
  <div class="format-grid">
    <a class="format-card reveal" href="<?php echo esc_url( $demo_flipbook_url ); ?>">
      <div class="format-kicker">01 — Single flipbook</div>
      <h3>One PDF, turned into a book.</h3>
      <p>Embed a single document as a page-turning 3D book with zoom, fullscreen and an optional download button.</p>
      <div class="format-tags"><span>Reports</span><span>Magazines</span><span>Brochures</span></div>
      <div class="scene scene--lake">
        <span class="hill hill--a"></span><span class="hill hill--b"></span>
        <span class="scene-book"><span>Field<br><em>notes</em></span><span><i></i><i></i><i></i></span></span>
        <span class="scene-chip">Page 14 of 48</span>
      </div>
    </a>
    <a class="format-card reveal" href="<?php echo esc_url( $demo_grid_url ); ?>">
      <div class="format-kicker">02 — Grid &amp; list</div>
      <h3>A shelf for your whole catalogue.</h3>
      <p>Tile your covers in a grid, or line them up in a scannable list with descriptions and metadata.</p>
      <div class="format-tags"><span>Catalogues</span><span>Manuals</span><span>Lookbooks</span></div>
      <div class="scene scene--desert">
        <span class="hill hill--c"></span>
        <span class="scene-shelf"><i></i><i></i><i></i><i></i></span>
        <span class="scene-row"><i></i><span><strong>Product Manual</strong><small>96 pages · PDF</small></span><b>Read</b></span>
      </div>
    </a>
    <a class="format-card reveal" href="<?php echo esc_url( $demo_ebook_url ); ?>">
      <div class="format-kicker">03 — Ebook &amp; newsletter</div>
      <h3>Covers that open on hover.</h3>
      <p>Each cover swings open to preview the real next page. Or publish issues as a compact newsletter digest.</p>
      <div class="format-tags"><span>Ebooks</span><span>Bulletins</span><span>Issues</span></div>
      <div class="scene scene--meadow">
        <span class="tree" aria-hidden="true"></span>
        <span class="scene-bubble">Which issue should I read first?</span>
        <span class="scene-covers">
          <span><b class="c-ink">No. 12</b>October</span>
          <span class="is-lifted"><b class="c-accent">No. 11</b>September</span>
          <span><b class="c-gold">No. 10</b>August</span>
        </span>
      </div>
    </a>
  </div>
  <div class="format-links">
    <span>All demos:</span>
    <a href="<?php echo esc_url( $demo_flipbook_url ); ?>">Flipbook</a>
    <a href="<?php echo esc_url( $demo_grid_url ); ?>">Grid</a>
    <a href="<?php echo esc_url( $demo_list_url ); ?>">List</a>
    <a href="<?php echo esc_url( $demo_newsletter_url ); ?>">Newsletter</a>
    <a href="<?php echo esc_url( $demo_ebook_url ); ?>">Ebook</a>
  </div>
</section>

<!-- ===== How it works ===== -->
<section class="steps-band" id="how-it-works">
  <div class="steps-tab"><span>3</span>Steps</div>
  <div class="steps-inner">
    <div class="steps-copy">
      <h2>Live in minutes,<br>not a project.</h2>
      <p>Install, upload, paste. The PDF renders in the reader's browser, so there's nothing to convert and nothing hosted elsewhere.</p>
    </div>
    <div class="steps-grid">
      <div class="step"><div class="step-num">Step 01</div><h3>Install the plugin</h3><p>Search “Flipbook PDF Viewer” in Plugins → Add New, or grab it from WordPress.org.</p></div>
      <div class="step"><div class="step-num">Step 02</div><h3>Upload your PDF</h3><p>Add a new PDF entry and attach the file. It renders live in the browser.</p></div>
      <div class="step"><div class="step-num">Step 03</div><h3>Paste the shortcode</h3><p>Drop it on any page, or use the Elementor widget instead.</p></div>
    </div>
  </div>
  <div class="code-bar">
    <code id="fb-shortcode"><span class="cm">// embed anywhere →</span> [pdfev_embed_viewer id="<b>123</b>" show_author="<b>yes</b>" show_download="<b>no</b>"]</code>
    <button type="button" class="copy-btn" data-copy="[pdfev_embed_viewer id=&quot;123&quot; show_author=&quot;yes&quot; show_download=&quot;no&quot;]">Copy</button>
  </div>
</section>

<!-- ===== Reviews — real WordPress.org reviews, quoted as written. ===== -->
<section class="section">
  <div class="eyebrow">[ From WordPress.org ]</div>
  <h2 class="section-title">Readers stay. <span class="serif-i">Publishers notice.</span></h2>
  <div class="review-grid">
    <figure class="review reveal">
      <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
      <blockquote>“The plugin works flawlessly and is very stable. The developer took one of my suggestions and implemented it in an update to the plugin. That's what I call customer service.”</blockquote>
      <figcaption><span class="avatar avatar--violet" aria-hidden="true">T</span><div><strong>Thobie</strong><span>WordPress.org review</span></div></figcaption>
    </figure>
    <figure class="review reveal">
      <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
      <blockquote>“The interface is really easy to use, so embedding and showcasing PDFs in a visually appealing, interactive 3D flipbook format is a breeze! Perfect for presenting e-books, manuals and reports.”</blockquote>
      <figcaption><span class="avatar avatar--gold" aria-hidden="true">Y</span><div><strong>yuseyhan</strong><span>WordPress.org review</span></div></figcaption>
    </figure>
    <figure class="review reveal">
      <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
      <blockquote>“Very simple to use and fast in scrolling pages. The support is super.”</blockquote>
      <figcaption><span class="avatar avatar--sky" aria-hidden="true">F</span><div><strong>fabriziolaneve</strong><span>WordPress.org review</span></div></figcaption>
    </figure>
  </div>
  <p class="review-more"><a href="<?php echo esc_url( $reviews_url ); ?>">Read all reviews on WordPress.org →</a></p>
</section>

<!-- ===== Pricing ===== -->
<section class="section" id="pricing">
  <div class="eyebrow eyebrow--center">[ Pricing ]</div>
  <h2 class="centered-title">Free forever. <span class="serif-i">Pro when you want more.</span></h2>
  <div class="pricing-grid">
    <div class="price-card reveal">
      <div class="price-name">Free</div>
      <div class="price-value"><strong>$0</strong><span>/ forever</span></div>
      <p class="price-desc">Everything you need to publish flipbooks on any WordPress site.</p>
      <ul class="price-features">
        <li>✓&nbsp; Unlimited PDFs</li>
        <li>✓&nbsp; All 4 archive layouts</li>
        <li>✓&nbsp; Elementor widgets</li>
        <li>✓&nbsp; Read &amp; download counters</li>
        <li>✓&nbsp; Community support</li>
      </ul>
      <a class="btn btn--outline btn--block" href="<?php echo esc_url( $download_url ); ?>">Download free</a>
    </div>
    <div class="price-card price-card--dark reveal">
      <div class="price-top"><span class="price-name">Pro</span><span class="price-badge">One-time</span></div>
      <div class="price-value"><strong>$22</strong><span>/ one-time</span></div>
      <p class="price-desc">For sites that want a premium, on-brand reading experience.</p>
      <ul class="price-features">
        <li>✓&nbsp; Everything in Free</li>
        <li>✓&nbsp; Premium toolbar skins</li>
        <li>✓&nbsp; Custom brand colors</li>
        <li>✓&nbsp; Download button control</li>
        <li>✓&nbsp; Lifetime updates &amp; support</li>
      </ul>
      <a class="btn btn--light btn--block" href="<?php echo esc_url( $purchase_url ); ?>">Buy Pro on Lieusoft</a>
    </div>
  </div>
  <p class="pricing-note">One-time payment · Lifetime updates and support · Checkout on <a href="<?php echo esc_url( $purchase_url ); ?>">lieusoft.com</a></p>
</section>

<!-- ===== CTA ===== -->
<section class="cta">
  <div class="scene scene--violet cta-scene">
    <div class="cta-card">
      <h2>Your next flipbook is<br><span class="serif-i">one upload away.</span></h2>
      <p>Free on WordPress.org. Works with WordPress 6.0+, GPLv2 or later.</p>
      <div class="btn-row btn-row--center">
        <a class="btn btn--primary btn--lg" href="<?php echo esc_url( $download_url ); ?>">Download free plugin</a>
        <a class="btn btn--outline btn--lg" href="<?php echo esc_url( $contact_url ); ?>">Contact support</a>
      </div>
    </div>
  </div>
</section>

</main>
<?php
get_footer();
