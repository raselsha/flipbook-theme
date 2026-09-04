<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

/**
 * Every live shortcode embed lives on its own /demo/ sub-page now (each
 * page's real post_content has the shortcode, so the plugin's own
 * has_shortcode() asset-loading check finds it natively — see functions.php).
 * The homepage only links out to them; it renders no shortcode itself.
 */
$demo_flipbook    = get_page_by_path( 'demo/flipbook' );
$demo_grid        = get_page_by_path( 'demo/grid' );
$demo_list        = get_page_by_path( 'demo/list' );
$demo_newsletter  = get_page_by_path( 'demo/newsletter' );
$demo_ebook       = get_page_by_path( 'demo/ebook' );
$demo_flipbook_url   = $demo_flipbook ? get_permalink( $demo_flipbook ) : '#';
$demo_grid_url       = $demo_grid ? get_permalink( $demo_grid ) : '#';
$demo_list_url       = $demo_list ? get_permalink( $demo_list ) : '#';
$demo_newsletter_url = $demo_newsletter ? get_permalink( $demo_newsletter ) : '#';
$demo_ebook_url      = $demo_ebook ? get_permalink( $demo_ebook ) : '#';
?>
<section class="hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-glow"></div>
  <div class="u-container">
    <div class="hero-copy animate-fade-up">
      <div class="eyebrow" style="margin-bottom:18px;"><span class="dot"></span>WordPress Plugin</div>
      <h1>Turn any PDF into a book people actually <em>flip</em> through.</h1>
      <p class="lede">Drop in a PDF and get a realistic, page-turning 3D flipbook &mdash; no design work, no code, just a shortcode.</p>
      <div class="btn-row">
        <a class="btn btn--primary" href="https://wordpress.org/plugins/pdf-embed-viewer/">Download Free <span aria-hidden="true">&darr;</span></a>
        <a class="btn btn--ghost" href="#formats">See every format &rarr;</a>
      </div>
      <div class="hero-checks">
        <span><span class="tick">&check;</span> Works with WP 6.0+</span>
        <span><span class="tick">&check;</span> No coding required</span>
        <span><span class="tick">&check;</span> Free on WordPress.org</span>
      </div>
    </div>
    <div class="hero-demo reveal">
      <div class="hero-demo-label"><span class="dot"></span> A real PDF, turned into a book</div>
      <div class="hero-demo-visual">
        <a class="hero-mock-book" href="<?php echo esc_url( $demo_flipbook_url ); ?>" aria-label="View the live flipbook demo">
          <div class="hero-mock-page hero-mock-page--left">
            <div class="hero-mock-brand">Flipbook PDF</div>
          </div>
          <div class="hero-mock-page hero-mock-page--right">
            <div class="hero-mock-tag">PAGE 2</div>
            <div class="hero-mock-rule"></div>
            <div class="hero-mock-title">From the Field</div>
            <div class="hero-mock-sub">Real reader notes, real pages</div>
            <div class="hero-mock-lines">
              <span style="width:70%"></span>
              <span style="width:45%"></span>
              <span style="width:82%"></span>
              <span style="width:58%"></span>
            </div>
            <div class="hero-mock-cta">View live demo <span aria-hidden="true">&rarr;</span></div>
          </div>
        </a>
        <div class="hero-badge-row">
          <div class="hero-badge hero-badge--top">
            <div class="num">10,000+</div>
            <div class="lbl">active installs</div>
          </div>
          <div class="hero-badge hero-badge--bottom">
            <div class="lbl" style="margin-bottom:2px;">Avg. rating</div>
            <div class="num">&starf;&starf;&starf;&starf;&starf; 4.9</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Placeholder trust row — swap for real customer names before this goes live. -->
<div class="logo-bar">
  <div class="u-container">
    <div class="logo-bar-label">Trusted by publishers, agencies &amp; creators worldwide</div>
    <div class="logo-row">
      <span>[Publisher name]</span>
      <span>[Agency name]</span>
      <span>[Press name]</span>
      <span>[Studio name]</span>
      <span>[NGO name]</span>
      <span>[Gazette name]</span>
    </div>
  </div>
</div>

<section class="section" id="features">
  <div class="u-container">
    <div class="section-split reveal">
      <div>
        <div class="eyebrow" style="margin-bottom:12px;"><span class="dot"></span>What the plugin does</div>
        <h2>Every feature your<br><span class="accent-italic">readers expect.</span></h2>
      </div>
      <p>Built specifically for WordPress. Nothing extra. Nothing missing. Just a flipbook that works.</p>
    </div>

    <div class="feature-grid">
      <div class="feature-card">
        <div class="feature-icon">&#10227;</div>
        <h3>Realistic Page-Turn</h3>
        <p>A physics-based curl animation that mimics the feel of turning a real page &mdash; your readers stay immersed.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#9633;</div>
        <h3>Four Archive Layouts</h3>
        <p>List, Grid, Newsletter, and Ebook shortcodes for browsing a whole library &mdash; pick the one that fits your content.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#9889;</div>
        <h3>One-Shortcode Embed</h3>
        <p>Upload a PDF, drop <code>[pdfev_embed_viewer]</code> anywhere on your site, and it's live &mdash; no conversion step.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#9678;</div>
        <h3>Elementor Widgets</h3>
        <p>Drag-and-drop Archive View and Single View widgets with full support for every shortcode attribute.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#9635;</div>
        <h3>Read &amp; Download Counters</h3>
        <p>Every document tracks its own view and download counts automatically &mdash; no extra setup.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#9670;</div>
        <h3>Manual Drag-and-Drop Ordering</h3>
        <p>Reorder your library exactly how you want it, right from the admin list &mdash; no more sorting by upload date.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" id="formats" style="border-top:1px solid var(--line);background:var(--surface-alt);">
  <div class="u-container">
    <div class="section-head reveal">
      <div class="eyebrow" style="margin-bottom:12px;"><span class="dot"></span>One plugin, every layout</div>
      <h2>A dimensional book, not a thumbnail.</h2>
      <p class="lede">Every layout is a live, working page &mdash; the plugin's own shortcode output, unstyled by us.</p>
    </div>

    <div class="format-link-grid">
      <a class="format-link-card reveal" href="<?php echo esc_url( $demo_flipbook_url ); ?>">
        <h3>Single Flipbook</h3>
        <p>One PDF, embedded as a page-turning 3D book.</p>
        <span class="format-link-cta">View demo <span aria-hidden="true">&rarr;</span></span>
      </a>
      <a class="format-link-card reveal" href="<?php echo esc_url( $demo_grid_url ); ?>">
        <h3>Grid</h3>
        <p>A tiled shelf of covers &mdash; built for a catalog, a lookbook, or a library of reports.</p>
        <span class="format-link-cta">View demo <span aria-hidden="true">&rarr;</span></span>
      </a>
      <a class="format-link-card reveal" href="<?php echo esc_url( $demo_list_url ); ?>">
        <h3>List</h3>
        <p>A scannable line-up with description and metadata &mdash; built for documentation and manuals.</p>
        <span class="format-link-cta">View demo <span aria-hidden="true">&rarr;</span></span>
      </a>
      <a class="format-link-card reveal" href="<?php echo esc_url( $demo_newsletter_url ); ?>">
        <h3>Newsletter</h3>
        <p>A compact digest row &mdash; built for recurring issues, reports, or bulletins.</p>
        <span class="format-link-cta">View demo <span aria-hidden="true">&rarr;</span></span>
      </a>
      <a class="format-link-card reveal" href="<?php echo esc_url( $demo_ebook_url ); ?>">
        <h3>Ebook</h3>
        <p>Each cover opens on hover with a real preview of the next page, not just a placeholder.</p>
        <span class="format-link-cta">View demo <span aria-hidden="true">&rarr;</span></span>
      </a>
    </div>
  </div>
</section>

<div class="image-break">
  <img src="https://images.unsplash.com/photo-1591951425600-d09958978584?w=1600&amp;h=500&amp;fit=crop&amp;auto=format" alt="Open book with fanned pages" loading="lazy">
  <div class="image-break-caption">Every page, a statement.</div>
</div>

<section class="section" id="how-it-works">
  <div class="u-container">
    <div class="section-head centered reveal">
      <div class="eyebrow" style="margin-bottom:12px;justify-content:center;"><span class="dot"></span>Setup in minutes</div>
      <h2>How it works</h2>
    </div>

    <div class="how-steps">
      <div class="how-step reveal">
        <div class="how-step-num">01</div>
        <div class="how-step-rule"></div>
        <h3>Install the Plugin</h3>
        <p>Search &ldquo;3D Flipbook PDF Viewer &amp; Embedder&rdquo; in Plugins &rarr; Add New, or grab it free from WordPress.org.</p>
      </div>
      <div class="how-step reveal">
        <div class="how-step-num">02</div>
        <div class="how-step-rule"></div>
        <h3>Upload Your PDF</h3>
        <p>Add a new PDF Embed entry and attach your file. It renders live in the browser &mdash; no separate conversion step.</p>
      </div>
      <div class="how-step reveal">
        <div class="how-step-num">03</div>
        <div class="how-step-rule"></div>
        <h3>Drop In the Shortcode</h3>
        <p>Paste the shortcode anywhere on your site, or use the Elementor widget for a drag-and-drop setup.</p>
      </div>
    </div>

    <div class="code-demo reveal">
      <div class="code-demo-bar">
        <span class="dot"></span><span class="dot"></span><span class="dot"></span>
        <span class="lbl">WordPress editor</span>
      </div>
      <div class="code-demo-body">
        <code><span class="cm">// Embed your flipbook anywhere</span>
<span class="tag">[pdfev_embed_viewer </span><span class="attr">id</span><span class="eq">=</span><span class="val">"123"</span> <span class="attr">show_author</span><span class="eq">=</span><span class="val">"yes"</span> <span class="attr">show_year</span><span class="eq">=</span><span class="val">"yes"</span><span class="tag">]</span></code>
      </div>
    </div>
  </div>
</section>

<!-- Placeholder testimonials — swap for real customer quotes before this goes live. -->
<section class="section" style="border-top:1px solid var(--line);">
  <div class="u-container">
    <div class="section-head centered reveal">
      <div class="eyebrow" style="margin-bottom:12px;justify-content:center;"><span class="dot"></span>What users say</div>
      <h2>Words from the field</h2>
    </div>

    <div class="testimonial-grid">
      <div class="testimonial-card reveal">
        <div>
          <div class="testimonial-mark">&ldquo;</div>
          <p>Our PDF catalogue finally feels like something people want to open &mdash; readers spend far longer with it than they ever did with a flat PDF link.</p>
        </div>
        <div class="testimonial-person">
          <div class="testimonial-avatar">?</div>
          <div><strong>[Customer name]</strong><span>[Role, company]</span></div>
        </div>
      </div>
      <div class="testimonial-card reveal">
        <div>
          <div class="testimonial-mark">&ldquo;</div>
          <p>The shortcode system is refreshingly simple. I had a full report published as a flipbook in minutes, no developer needed.</p>
        </div>
        <div class="testimonial-person">
          <div class="testimonial-avatar">?</div>
          <div><strong>[Customer name]</strong><span>[Role, company]</span></div>
        </div>
      </div>
      <div class="testimonial-card reveal">
        <div>
          <div class="testimonial-mark">&ldquo;</div>
          <p>It's the first WordPress flipbook plugin I've used that still feels good to read on a phone.</p>
        </div>
        <div class="testimonial-person">
          <div class="testimonial-avatar">?</div>
          <div><strong>[Customer name]</strong><span>[Role, company]</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Placeholder pricing — Pro/Business figures are not final, swap before this goes live. -->
<section class="section" id="pricing" style="border-top:1px solid var(--line);background:var(--surface-alt);">
  <div class="u-container">
    <div class="section-head centered reveal">
      <div class="eyebrow" style="margin-bottom:12px;justify-content:center;"><span class="dot"></span>Transparent pricing</div>
      <h2>Pick your plan</h2>
      <p class="lede" style="margin-inline:auto;">The core plugin is free, forever. Pro unlocks premium viewer styling and priority support.</p>
    </div>

    <div class="pricing-grid">
      <div class="price-card reveal">
        <div class="price-name">Free</div>
        <div class="price-value"><strong>$0</strong><span>/forever</span></div>
        <p class="price-desc">Everything you need to publish flipbooks on any WordPress site.</p>
        <ul class="price-features">
          <li><span class="tick">&check;</span> Unlimited PDFs</li>
          <li><span class="tick">&check;</span> All 4 archive layouts</li>
          <li><span class="tick">&check;</span> Elementor widgets</li>
          <li><span class="tick">&check;</span> Read &amp; download counters</li>
          <li><span class="tick">&check;</span> Community support</li>
        </ul>
        <a class="price-cta price-cta--outline" href="https://wordpress.org/plugins/pdf-embed-viewer/">Get for Free</a>
      </div>
      <div class="price-card price-card--highlight reveal">
        <div class="price-badge">Most Popular</div>
        <div class="price-name">Pro</div>
        <div class="price-value"><strong>[Price]</strong><span>/year</span></div>
        <p class="price-desc">For sites that want a premium, on-brand reading experience.</p>
        <ul class="price-features">
          <li><span class="tick">&check;</span> Everything in Free</li>
          <li><span class="tick">&check;</span> Premium toolbar skins</li>
          <li><span class="tick">&check;</span> Custom brand colors</li>
          <li><span class="tick">&check;</span> Download button control</li>
          <li><span class="tick">&check;</span> Priority email support</li>
        </ul>
        <a class="price-cta price-cta--primary" href="<?php echo esc_url( home_url( '/contact-support/' ) ); ?>">Start with Pro</a>
      </div>
      <div class="price-card reveal">
        <div class="price-name">Business</div>
        <div class="price-value"><strong>[Price]</strong><span>/year</span></div>
        <p class="price-desc">For agencies publishing across multiple client sites.</p>
        <ul class="price-features">
          <li><span class="tick">&check;</span> Everything in Pro</li>
          <li><span class="tick">&check;</span> Multiple site licenses</li>
          <li><span class="tick">&check;</span> White-label branding</li>
          <li><span class="tick">&check;</span> Dedicated support channel</li>
        </ul>
        <a class="price-cta price-cta--outline" href="<?php echo esc_url( home_url( '/contact-support/' ) ); ?>">Contact Sales</a>
      </div>
    </div>
    <p class="pricing-note">Pro and Business pricing shown here is a placeholder &mdash; final figures aren't set yet.</p>
  </div>
</section>

<div class="cta-dark">
  <div class="cta-dark-grid"></div>
  <div class="cta-dark-glow"></div>
  <div class="u-container">
    <div class="eyebrow" style="justify-content:center;margin-bottom:16px;"><span class="dot"></span>Start for free today</div>
    <h2>Your next flipbook<br><span class="accent-italic">is one upload away.</span></h2>
    <p class="lede">Join thousands of WordPress publishers who trust Flipbook PDF to make their content shine.</p>
    <div class="btn-row">
      <a class="btn btn--primary" href="https://wordpress.org/plugins/pdf-embed-viewer/">Download Free Plugin <span aria-hidden="true">&darr;</span></a>
      <a class="btn btn--dark" href="<?php echo esc_url( home_url( '/contact-support/' ) ); ?>">Contact Support &rarr;</a>
    </div>
    <p class="cta-dark-note">No account required &middot; Works with WordPress 6.0+ &middot; GPLv2 or later</p>
  </div>
</div>
<?php
get_footer();
