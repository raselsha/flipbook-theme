<?php
/**
 * SEO: titles, meta descriptions, Open Graph / Twitter cards, JSON-LD
 * (Organization, WebSite, SoftwareApplication, FAQPage, Book, BreadcrumbList),
 * noindex for legacy/duplicate pages, and a leaner core sitemap.
 *
 * Steps aside entirely when a dedicated SEO plugin is active, so the head
 * never carries two sets of tags.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

const FLIPBOOK_THEME_WHATSAPP = 'https://wa.me/8801521255463';

/** Single source for the homepage FAQ and its FAQPage schema. */
function flipbook_theme_faqs() {
    $wa = FLIPBOOK_THEME_WHATSAPP . '?text=' . rawurlencode( 'Hi, I need help with Flipbook PDF.' );
    return array(
        array( 'Is the free plugin really free?', "Yes. It's on WordPress.org with no limit on the number of PDFs, and includes the 3D flipbook, the scroll reader, all four archive layouts and the Elementor widgets." ),
        array( 'Do I need Pro to show a flipbook?', 'No. Every viewer feature works in the free plugin. Pro adds file protection, the premium skin and toolbar, extra flipbook controls and the phone layout.' ),
        array( 'Can visitors download my PDFs?', "With the free plugin you switch the Download button on or off for each PDF. With Pro's Hide File URL, downloads still work but go through one-time links and the real file path stays hidden. With Lockdown nobody can download at all." ),
        array( "What's the difference between Hide File URL and Lockdown?", 'Both keep the file path out of the page. Hide File URL still lets readers download through a short-lived link. Lockdown removes downloads completely, moves the original into a locked folder, scrambles the file in transit and blocks print, save and right-click on the book.' ),
        array( 'Does Lockdown make copying impossible?', 'It stops downloads, shared links, download managers and saving the page. Anything shown on a screen can still be screenshotted, so no web viewer can promise 100% — but Lockdown closes every easy route.' ),
        array( 'What happens if I turn Pro off or my licence ends?', 'Your books keep working with the free plugin, like before. Protection and the other Pro options switch off until Pro is active again, and Lockdown comes back on its own when it is.' ),
        array( 'Does it work on phones?', 'Yes. The scroll reader fits the screen on any phone, and Pro opens the flipbook one page at a time in a tall reading stage with the toolbar underneath.' ),
        array( 'Are Arabic, Urdu and Hebrew books supported?', "Yes. Mark a PDF as right-to-left and its pages turn the other way. This site's demo pages show Arabic, Urdu and Hebrew books." ),
        array( 'Does it work with Elementor?', 'Yes. Use the Archive and Single View widgets, build your own single PDF page from the Title, Cover, Details, Description, Download and Navigation widgets, and pick it as the template for every PDF. Elementor Pro Theme Builder templates work too.' ),
        array( 'Where are my files stored?', "In your own WordPress media library. PDFs render in the reader's browser — nothing is converted or uploaded to another service." ),
        array( 'How do I get support?', 'Message us on <a href="' . esc_url( $wa ) . '" target="_blank" rel="noopener">WhatsApp (+880 1521-255463)</a> — that\'s the fastest way to reach us for setup help, questions or Pro licences.' ),
        array( 'How do I get Pro?', 'Choose a plan on lieusoft.com. You get a licence key; install the Pro add-on next to the free plugin and enter the key in PDF Embed → Settings.' ),
    );
}

function flipbook_theme_seo_plugin_active() {
    return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/** Legacy/duplicate pages kept reachable but out of search results. */
function flipbook_theme_noindex_slugs() {
    return array( 'sample-page', 'pdf-list-view', 'pdf-grid-view', 'pdf-newsletter-view', 'pdf-ebook-view', 'single-pdf-short-code', 'rtl' );
}

function flipbook_theme_is_noindexed() {
    if ( ! is_page() ) {
        return false;
    }
    return in_array( get_post_field( 'post_name', get_queried_object_id() ), flipbook_theme_noindex_slugs(), true );
}

/** Page descriptions for the static pages, keyed by slug. */
function flipbook_theme_page_descriptions() {
    return array(
        'demo'            => 'Live demos of the Flipbook PDF WordPress plugin: 3D flipbook, grid, list, ebook and newsletter layouts, including Arabic, Urdu and Hebrew books.',
        'flipbook'        => 'Live 3D flipbook demo: turn the pages of real magazines and books, including right-to-left Arabic, Urdu and Hebrew titles.',
        'grid'            => 'Live grid layout demo of the Flipbook PDF plugin — a PDF library as cards with covers, details and Read/Download buttons.',
        'list'            => 'Live list layout demo of the Flipbook PDF plugin — PDFs in a scannable list with cover, description and buttons.',
        'newsletter'      => 'Live newsletter layout demo — publish PDF issues by year and month with the Flipbook PDF WordPress plugin.',
        'ebook'           => 'Live ebook shelf demo — 3D book covers that open on hover to preview the next page, built with Flipbook PDF.',
        'contact-support' => 'Get help with the Flipbook PDF WordPress plugin on WhatsApp, and watch the video guide on how to use it.',
    );
}

function flipbook_theme_meta_description() {
    if ( is_front_page() ) {
        return 'Turn any PDF into a realistic 3D flipbook on WordPress. Free plugin with grid, list, ebook and newsletter layouts, Elementor widgets and RTL books; Pro adds download protection.';
    }
    if ( is_singular( 'pdfev_embed_viewer' ) ) {
        $desc = get_post_meta( get_queried_object_id(), 'pdfev_meta_description', true );
        if ( $desc ) {
            return wp_strip_all_tags( $desc );
        }
        return sprintf( 'Read "%s" as an interactive 3D flipbook.', wp_strip_all_tags( get_the_title() ) );
    }
    if ( is_page() ) {
        $map  = flipbook_theme_page_descriptions();
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        if ( isset( $map[ $slug ] ) ) {
            return $map[ $slug ];
        }
    }
    if ( is_tax( array( 'pdfev_category', 'pdfev_author', 'pdfev_publisher' ) ) ) {
        $term = get_queried_object();
        return $term->description ? wp_strip_all_tags( $term->description ) : sprintf( '%s — PDFs shown as interactive 3D flipbooks.', $term->name );
    }
    return get_bloginfo( 'description' );
}

function flipbook_theme_share_image() {
    if ( is_singular() && has_post_thumbnail() ) {
        $src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        if ( $src ) {
            return array( $src[0], $src[1], $src[2] );
        }
    }
    return array( get_template_directory_uri() . '/assets/img/og-image.jpg', 1200, 630 );
}

function flipbook_theme_canonical() {
    if ( is_front_page() ) {
        return home_url( '/' );
    }
    if ( is_singular() ) {
        return get_permalink( get_queried_object_id() );
    }
    if ( is_tax() || is_category() ) {
        return get_term_link( get_queried_object() );
    }
    return home_url( add_query_arg( array() ) );
}

/* ------------------------------------------------------------------ titles */

add_filter( 'document_title_parts', function ( $parts ) {
    if ( flipbook_theme_seo_plugin_active() ) {
        return $parts;
    }
    if ( is_front_page() ) {
        return array( 'title' => 'Flipbook PDF — 3D Flipbook PDF Viewer & Embedder for WordPress' );
    }
    $parts['site'] = 'Flipbook PDF';
    if ( is_singular( 'pdfev_embed_viewer' ) ) {
        $parts['title'] .= ' — Flipbook Demo';
    }
    if ( is_page() ) {
        $titles = array(
            'demo'            => 'Live Demo — PDF Flipbook Layouts',
            'flipbook'        => '3D Flipbook Demo — Live PDF Page Turning',
            'grid'            => 'Grid Layout Demo — PDF Library as Cards',
            'list'            => 'List Layout Demo — PDF Library',
            'newsletter'      => 'Newsletter Layout Demo — PDF Issues by Year',
            'ebook'           => 'Ebook Shelf Demo — 3D Book Covers',
            'contact-support' => 'Support on WhatsApp',
        );
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        if ( isset( $titles[ $slug ] ) ) {
            $parts['title'] = $titles[ $slug ];
        }
    }
    unset( $parts['tagline'] );
    return $parts;
} );

add_filter( 'document_title_separator', function () {
    return '|';
} );

/* ------------------------------------------------------------------ robots */

add_filter( 'wp_robots', function ( $robots ) {
    if ( ! flipbook_theme_seo_plugin_active() && flipbook_theme_is_noindexed() ) {
        $robots['noindex'] = true;
        $robots['follow']  = true;
        unset( $robots['max-image-preview'] );
    } elseif ( ! is_admin() ) {
        $robots['max-image-preview'] = 'large';
    }
    return $robots;
} );

/* ------------------------------------------------------------------ sitemap */

add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
    return 'users' === $name ? false : $provider; // don't publish usernames
}, 10, 2 );

add_filter( 'wp_sitemaps_taxonomies', function ( $taxonomies ) {
    unset( $taxonomies['pdfev_author'], $taxonomies['pdfev_publisher'], $taxonomies['post_tag'] );
    return $taxonomies;
} );

add_filter( 'wp_sitemaps_posts_query_args', function ( $args, $post_type ) {
    if ( 'page' === $post_type ) {
        $exclude = array();
        foreach ( flipbook_theme_noindex_slugs() as $slug ) {
            $found = get_posts( array( 'post_type' => 'page', 'name' => $slug, 'fields' => 'ids', 'posts_per_page' => -1 ) );
            $exclude = array_merge( $exclude, $found );
        }
        $args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? $args['post__not_in'] : array(), $exclude );
    }
    return $args;
}, 10, 2 );

/* ------------------------------------------------------------------ head */

add_action( 'wp_head', function () {
    if ( flipbook_theme_seo_plugin_active() || is_404() || is_search() ) {
        return;
    }
    $title = wp_get_document_title();
    $desc  = flipbook_theme_meta_description();
    $url   = flipbook_theme_canonical();
    $img   = flipbook_theme_share_image();
    $type  = is_singular( 'pdfev_embed_viewer' ) ? 'book' : ( is_front_page() ? 'website' : 'article' );

    echo "\n<!-- Flipbook PDF theme SEO -->\n";
    if ( $desc ) {
        printf( '<meta name="description" content="%s">' . "\n", esc_attr( wp_html_excerpt( $desc, 300, '…' ) ) );
    }
    $og = array(
        'og:site_name'    => 'Flipbook PDF',
        'og:locale'       => str_replace( '-', '_', get_bloginfo( 'language' ) ),
        'og:type'         => $type,
        'og:title'        => $title,
        'og:description'  => $desc,
        'og:url'          => $url,
        'og:image'        => $img[0],
        'og:image:width'  => $img[1],
        'og:image:height' => $img[2],
        'og:image:alt'    => is_front_page() ? 'Flipbook PDF — 3D flipbook viewer for WordPress' : wp_strip_all_tags( get_the_title() ),
    );
    foreach ( $og as $prop => $value ) {
        if ( '' !== (string) $value ) {
            printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $prop ), esc_attr( $value ) );
        }
    }
    printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
    printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
    printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
    printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $img[0] ) );
    printf( '<meta name="theme-color" content="#16151a">' . "\n" );

    $graph = flipbook_theme_schema_graph( $desc, $url, $img );
    if ( $graph ) {
        echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
    }
    echo "<!-- / Flipbook PDF theme SEO -->\n";
}, 3 );

function flipbook_theme_schema_graph( $desc, $url, $img ) {
    $home = home_url( '/' );
    $org  = array(
        '@type' => 'Organization',
        '@id'   => 'https://lieusoft.com/#organization',
        'name'  => 'Lieusoft',
        'url'   => 'https://lieusoft.com/',
        'logo'  => get_template_directory_uri() . '/assets/img/favicon-270.png',
        'contactPoint' => array(
            '@type'       => 'ContactPoint',
            'contactType' => 'customer support',
            'url'         => FLIPBOOK_THEME_WHATSAPP,
            'telephone'   => '+8801521255463',
        ),
    );
    $site = array(
        '@type'     => 'WebSite',
        '@id'       => $home . '#website',
        'url'       => $home,
        'name'      => 'Flipbook PDF',
        'publisher' => array( '@id' => 'https://lieusoft.com/#organization' ),
        'inLanguage' => get_bloginfo( 'language' ),
    );
    $graph = array( $org, $site );

    if ( is_front_page() ) {
        $graph[] = array(
            '@type'               => 'SoftwareApplication',
            '@id'                 => $home . '#software',
            'name'                => 'Flipbook PDF Viewer & Embedder',
            'applicationCategory' => 'BusinessApplication',
            'applicationSubCategory' => 'WordPress plugin',
            'operatingSystem'     => 'WordPress 6.0+',
            'description'         => $desc,
            'url'                 => $home,
            'downloadUrl'         => 'https://downloads.wordpress.org/plugin/pdf-embed-viewer.zip',
            'image'               => $img[0],
            'author'              => array( '@id' => 'https://lieusoft.com/#organization' ),
            'offers'              => array(
                array( '@type' => 'Offer', 'name' => 'Free', 'price' => '0', 'priceCurrency' => 'USD', 'url' => 'https://wordpress.org/plugins/pdf-embed-viewer/' ),
                array( '@type' => 'Offer', 'name' => 'Pro Single (1 domain, yearly)', 'price' => '22', 'priceCurrency' => 'USD', 'url' => 'https://lieusoft.com/pdf-embed-viewer/#pricing' ),
                array( '@type' => 'Offer', 'name' => 'Pro 10 (10 domains, yearly)', 'price' => '49', 'priceCurrency' => 'USD', 'url' => 'https://lieusoft.com/pdf-embed-viewer/#pricing' ),
                array( '@type' => 'Offer', 'name' => 'Lifetime (1 domain)', 'price' => '79', 'priceCurrency' => 'USD', 'url' => 'https://lieusoft.com/pdf-embed-viewer/#pricing' ),
            ),
            // Real WordPress.org rating at the time of writing.
            'aggregateRating'     => array( '@type' => 'AggregateRating', 'ratingValue' => '5', 'ratingCount' => '6', 'bestRating' => '5' ),
        );
        $faq = array();
        foreach ( flipbook_theme_faqs() as $item ) {
            $faq[] = array(
                '@type'          => 'Question',
                'name'           => $item[0],
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $item[1] ) ),
            );
        }
        $graph[] = array( '@type' => 'FAQPage', '@id' => $home . '#faq', 'mainEntity' => $faq );
        return $graph;
    }

    $crumbs = array( array( 'Home', $home ) );
    $demo   = get_page_by_path( 'demo' );
    if ( is_singular( 'pdfev_embed_viewer' ) ) {
        $id    = get_queried_object_id();
        $terms = function ( $tax ) use ( $id ) {
            $names = wp_get_post_terms( $id, $tax, array( 'fields' => 'names' ) );
            return is_wp_error( $names ) ? array() : $names;
        };
        $book = array(
            '@type'       => 'Book',
            '@id'         => $url . '#book',
            'name'        => wp_strip_all_tags( get_the_title( $id ) ),
            'url'         => $url,
            'description' => $desc,
            'image'       => $img[0],
            'bookFormat'  => 'https://schema.org/EBook',
        );
        $authors = $terms( 'pdfev_author' );
        if ( $authors ) {
            $book['author'] = array_map( function ( $n ) { return array( '@type' => 'Person', 'name' => $n ); }, $authors );
        }
        $publishers = $terms( 'pdfev_publisher' );
        if ( $publishers ) {
            $book['publisher'] = array( '@type' => 'Organization', 'name' => $publishers[0] );
        }
        $pages = (int) get_post_meta( $id, 'pdfev_meta_total_pages', true );
        if ( $pages ) {
            $book['numberOfPages'] = $pages;
        }
        $year = get_post_meta( $id, 'pdfev_meta_published_year', true );
        if ( preg_match( '/^\d{4}$/', (string) $year ) ) {
            $book['datePublished'] = $year;
        }
        $genres = $terms( 'pdfev_category' );
        if ( $genres ) {
            $book['genre'] = $genres;
        }
        $lang = class_exists( 'PDFEV_Functions' ) && method_exists( 'PDFEV_Functions', 'item_lang_attrs' ) ? PDFEV_Functions::item_lang_attrs( $id ) : '';
        $book['inLanguage'] = preg_match( '/lang="([a-z]+)"/', $lang, $m ) ? $m[1] : 'en';
        $graph[] = $book;
        if ( $demo ) {
            $crumbs[] = array( 'Live Demo', get_permalink( $demo ) );
        }
        $crumbs[] = array( wp_strip_all_tags( get_the_title( $id ) ), $url );
    } elseif ( is_page() ) {
        $id     = get_queried_object_id();
        $parent = wp_get_post_parent_id( $id );
        if ( $parent ) {
            $crumbs[] = array( 'demo' === get_post_field( 'post_name', $parent ) ? 'Live Demo' : get_the_title( $parent ), get_permalink( $parent ) );
        }
        $crumbs[] = array( wp_strip_all_tags( get_the_title( $id ) ), $url );
    } else {
        return $graph;
    }

    $list = array();
    foreach ( $crumbs as $i => $c ) {
        $list[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => $c[0], 'item' => $c[1] );
    }
    $graph[] = array( '@type' => 'BreadcrumbList', '@id' => $url . '#breadcrumb', 'itemListElement' => $list );
    return $graph;
}
