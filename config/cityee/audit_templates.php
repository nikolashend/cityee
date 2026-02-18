<?php

/**
 * CityEE Audit Templates — structured report configurations.
 *
 * Each template defines sections, scoring criteria, and output format
 * for automated or manual SEO/UX/technical audit reports.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Audit Template
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'name'        => 'Technical SEO Audit',
        'description' => 'Full technical SEO audit with category scoring and recommendations.',
        'categories'  => [
            [
                'id'     => 'crawlability',
                'name'   => 'Crawlability & Indexation',
                'weight' => 20,
                'checks' => [
                    ['id' => 'robots_txt', 'label' => 'robots.txt valid & up-to-date', 'target' => 'No blocked important resources'],
                    ['id' => 'sitemap', 'label' => 'XML Sitemap (index, dynamic, lastmod)', 'target' => 'All published pages in sitemap'],
                    ['id' => 'canonicals', 'label' => 'Canonical tags (self-referencing)', 'target' => 'Every page has a canonical'],
                    ['id' => 'noindex', 'label' => 'NoIndex audit (no false positives)', 'target' => '0 important pages noindexed'],
                    ['id' => 'crawl_budget', 'label' => 'Crawl budget efficiency', 'target' => '<5% wasted crawls'],
                    ['id' => 'redirects', 'label' => 'Redirect chains (max 1 hop)', 'target' => '0 chains > 1 hop'],
                ],
            ],
            [
                'id'     => 'performance',
                'name'   => 'Performance & Core Web Vitals',
                'weight' => 25,
                'checks' => [
                    ['id' => 'lcp', 'label' => 'LCP (Largest Contentful Paint)', 'target' => '< 2.5 seconds'],
                    ['id' => 'inp', 'label' => 'INP (Interaction to Next Paint)', 'target' => '< 200 ms'],
                    ['id' => 'cls', 'label' => 'CLS (Cumulative Layout Shift)', 'target' => '< 0.1'],
                    ['id' => 'ttfb', 'label' => 'TTFB (Time to First Byte)', 'target' => '< 800 ms'],
                    ['id' => 'images', 'label' => 'Image optimization (WebP, lazy)', 'target' => '100% optimized'],
                    ['id' => 'css_js', 'label' => 'Critical CSS inline + JS defer', 'target' => 'All non-critical deferred'],
                ],
            ],
            [
                'id'     => 'on_page',
                'name'   => 'On-Page SEO',
                'weight' => 20,
                'checks' => [
                    ['id' => 'titles', 'label' => 'Unique titles (<60 chars, keyword-first)', 'target' => '100% unique, optimized'],
                    ['id' => 'meta_desc', 'label' => 'Meta descriptions (<155 chars, CTA)', 'target' => '100% unique, compelling'],
                    ['id' => 'h1', 'label' => 'Single H1, logical H2→H3 hierarchy', 'target' => 'Correct on all pages'],
                    ['id' => 'internal_links', 'label' => 'Internal linking structure', 'target' => 'No orphan pages'],
                    ['id' => 'alt_texts', 'label' => 'Image alt texts (descriptive)', 'target' => '100% coverage'],
                    ['id' => 'urls', 'label' => 'Clean, localized URL structure', 'target' => 'No parameters, path-based'],
                ],
            ],
            [
                'id'     => 'schema',
                'name'   => 'Structured Data / Schema',
                'weight' => 15,
                'checks' => [
                    ['id' => 'schema_valid', 'label' => 'Schema passes Rich Results Test', 'target' => '0 errors, 0 warnings'],
                    ['id' => 'schema_types', 'label' => 'Required types implemented', 'target' => 'Organization, Article, FAQ, HowTo, LocalBusiness'],
                    ['id' => 'json_ld', 'label' => 'JSON-LD (not microdata)', 'target' => 'All Schema via JSON-LD'],
                    ['id' => 'schema_match', 'label' => 'Schema matches visible content', 'target' => '100% match'],
                ],
            ],
            [
                'id'     => 'security_a11y',
                'name'   => 'Security & Accessibility',
                'weight' => 10,
                'checks' => [
                    ['id' => 'https', 'label' => 'HTTPS everywhere + HSTS', 'target' => 'Enforced'],
                    ['id' => 'mixed_content', 'label' => 'No mixed content', 'target' => '0 issues'],
                    ['id' => 'contrast', 'label' => 'Color contrast ≥ 4.5:1', 'target' => 'WCAG AA'],
                    ['id' => 'keyboard', 'label' => 'Keyboard nav + skip-to-content', 'target' => 'All interactive elements'],
                    ['id' => 'headings', 'label' => 'Logical heading hierarchy', 'target' => 'H1→H2→H3 valid'],
                ],
            ],
            [
                'id'     => 'i18n',
                'name'   => 'Internationalization',
                'weight' => 10,
                'checks' => [
                    ['id' => 'hreflang', 'label' => 'hreflang implementation', 'target' => 'Correct with x-default'],
                    ['id' => 'lang_urls', 'label' => 'Path-based language URLs', 'target' => '/et/, /ru/, /en/'],
                    ['id' => 'no_dupes', 'label' => 'No duplicate content across locales', 'target' => 'Unique per locale'],
                ],
            ],
        ],
        'output_format' => [
            'executive_summary' => '3-5 sentences: overall score, critical issues, priority fix.',
            'scorecard_table'   => 'Category | Score | Weight | Weighted | Status',
            'top_issues'        => 'Top 10 priority issues with fix recommendations.',
            'quick_wins'        => 'Issues fixable in < 1 hour.',
            'roadmap'           => 'Prioritized by impact: P1 (this week), P2 (this month), P3 (this quarter).',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | GEO / AI Visibility Audit Template
    |--------------------------------------------------------------------------
    */
    'geo' => [
        'name'        => 'GEO / AI Visibility Audit',
        'description' => 'Audit for AI answer engine visibility (Google SGE, ChatGPT, Perplexity).',
        'categories'  => [
            [
                'id'     => 'snippet_readiness',
                'name'   => 'Snippet-Ready Content',
                'weight' => 30,
                'checks' => [
                    ['id' => 'direct_answer', 'label' => 'Direct answer in first paragraph', 'target' => '50-80 words per page'],
                    ['id' => 'faq_presence', 'label' => 'FAQ section with JSON-LD', 'target' => 'On all informational pages'],
                    ['id' => 'howto_presence', 'label' => 'HowTo section with JSON-LD', 'target' => 'On all procedural pages'],
                    ['id' => 'quick_answer', 'label' => 'Quick answer blocks', 'target' => 'On all guide pages'],
                    ['id' => 'tables_lists', 'label' => 'Structured lists and tables', 'target' => 'At least 1 per page'],
                ],
            ],
            [
                'id'     => 'schema_ai',
                'name'   => 'AI-Relevant Schema',
                'weight' => 25,
                'checks' => [
                    ['id' => 'faq_schema', 'label' => 'FAQPage JSON-LD', 'target' => 'Valid on FAQ pages'],
                    ['id' => 'howto_schema', 'label' => 'HowTo JSON-LD', 'target' => 'Valid on step-by-step pages'],
                    ['id' => 'qa_schema', 'label' => 'QAPage JSON-LD', 'target' => 'On Q&A focused pages'],
                    ['id' => 'article_schema', 'label' => 'Article JSON-LD (author, dates)', 'target' => 'On all article pages'],
                    ['id' => 'speakable', 'label' => 'Speakable schema', 'target' => 'On key content sections'],
                ],
            ],
            [
                'id'     => 'eeat_signals',
                'name'   => 'EEAT for AI Trust',
                'weight' => 25,
                'checks' => [
                    ['id' => 'author_present', 'label' => 'Author credentials visible', 'target' => 'Name, title, expertise'],
                    ['id' => 'sources', 'label' => 'Authoritative sources cited', 'target' => '≥ 3 per article'],
                    ['id' => 'unique_data', 'label' => 'Unique/original data', 'target' => 'At least 1 unique insight'],
                    ['id' => 'freshness', 'label' => 'Content freshness (dateModified)', 'target' => 'Updated < 90 days'],
                ],
            ],
            [
                'id'     => 'voice_search',
                'name'   => 'Voice Search Readiness',
                'weight' => 20,
                'checks' => [
                    ['id' => 'natural_lang', 'label' => 'Natural language answers', 'target' => 'Conversational tone'],
                    ['id' => 'question_format', 'label' => 'Question-based headings', 'target' => '≥ 3 per page'],
                    ['id' => 'short_answers', 'label' => 'Short answers < 29 words', 'target' => 'For voice assistant extraction'],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | UX / CWV Audit Template
    |--------------------------------------------------------------------------
    */
    'ux' => [
        'name'        => 'UX & Core Web Vitals Audit',
        'description' => 'User experience and performance audit with Nielsen-Norman heuristics.',
        'categories'  => [
            [
                'id'     => 'cwv',
                'name'   => 'Core Web Vitals',
                'weight' => 30,
                'checks' => [
                    ['id' => 'lcp', 'label' => 'LCP (p75)', 'target' => '< 2.5 seconds'],
                    ['id' => 'inp', 'label' => 'INP (p75)', 'target' => '< 200 ms'],
                    ['id' => 'cls', 'label' => 'CLS (p75)', 'target' => '< 0.1'],
                    ['id' => 'fcp', 'label' => 'FCP (First Contentful Paint)', 'target' => '< 1.8 seconds'],
                    ['id' => 'lighthouse', 'label' => 'Lighthouse Performance Score', 'target' => '> 90'],
                ],
            ],
            [
                'id'     => 'nielsen',
                'name'   => 'Nielsen-Norman Heuristics',
                'weight' => 30,
                'checks' => [
                    ['id' => 'nh_1', 'label' => '1. Visibility of system status', 'target' => 'Breadcrumbs, progress, loading states'],
                    ['id' => 'nh_2', 'label' => '2. Match between system and real world', 'target' => 'Familiar language, no jargon'],
                    ['id' => 'nh_3', 'label' => '3. User control & freedom', 'target' => 'Back buttons, undo, cancel'],
                    ['id' => 'nh_4', 'label' => '4. Consistency & standards', 'target' => 'Uniform design patterns'],
                    ['id' => 'nh_5', 'label' => '5. Error prevention', 'target' => 'Validation before submission'],
                    ['id' => 'nh_6', 'label' => '6. Recognition over recall', 'target' => 'Visible options, tooltips'],
                    ['id' => 'nh_7', 'label' => '7. Flexibility & efficiency', 'target' => 'Shortcuts for experts'],
                    ['id' => 'nh_8', 'label' => '8. Aesthetic & minimal design', 'target' => 'No excess information'],
                    ['id' => 'nh_9', 'label' => '9. Help with errors', 'target' => 'Clear error messages'],
                    ['id' => 'nh_10', 'label' => '10. Help & documentation', 'target' => 'Easily accessible help'],
                ],
            ],
            [
                'id'     => 'accessibility',
                'name'   => 'Accessibility (WCAG 2.1 AA)',
                'weight' => 20,
                'checks' => [
                    ['id' => 'contrast', 'label' => 'Color contrast ≥ 4.5:1', 'target' => 'Text + interactive elements'],
                    ['id' => 'alt_texts', 'label' => 'All images have alt text', 'target' => '100% coverage'],
                    ['id' => 'keyboard', 'label' => 'Full keyboard navigation', 'target' => 'Tab, Enter, Escape work'],
                    ['id' => 'skip_nav', 'label' => 'Skip-to-content link', 'target' => 'First focusable element'],
                    ['id' => 'focus', 'label' => 'Visible focus indicators', 'target' => 'On all interactive elements'],
                    ['id' => 'aria', 'label' => 'ARIA attributes for dynamics', 'target' => 'Modals, dropdowns, tabs'],
                ],
            ],
            [
                'id'     => 'behavioral',
                'name'   => 'Behavioral UX Signals',
                'weight' => 20,
                'checks' => [
                    ['id' => 'bounce', 'label' => 'Bounce rate', 'target' => '< 40%'],
                    ['id' => 'session', 'label' => 'Avg session duration', 'target' => '> 2 minutes'],
                    ['id' => 'scroll', 'label' => 'Avg scroll depth', 'target' => '> 75%'],
                    ['id' => 'pages', 'label' => 'Pages per session', 'target' => '> 2.5'],
                    ['id' => 'ctr', 'label' => 'Organic CTR', 'target' => '> 3.5%'],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | EEAT Audit Template
    |--------------------------------------------------------------------------
    */
    'eeat' => [
        'name'        => 'EEAT Trust Signal Audit',
        'description' => 'Experience, Expertise, Authoritativeness, Trustworthiness assessment.',
        'categories'  => [
            [
                'id'     => 'experience',
                'name'   => 'Experience',
                'weight' => 25,
                'checks' => [
                    ['id' => 'years', 'label' => 'Years of experience stated', 'target' => 'Visible on author bio'],
                    ['id' => 'cases', 'label' => 'Case studies / examples', 'target' => '≥ 3 real examples'],
                    ['id' => 'metrics', 'label' => 'Quantified results', 'target' => 'Specific numbers (300+ deals)'],
                    ['id' => 'media', 'label' => 'Photo/video of work', 'target' => 'Real professional photos'],
                ],
            ],
            [
                'id'     => 'expertise',
                'name'   => 'Expertise',
                'weight' => 25,
                'checks' => [
                    ['id' => 'bio', 'label' => 'Author bio with credentials', 'target' => 'Name, title, qualifications'],
                    ['id' => 'data', 'label' => 'Original data and analysis', 'target' => 'Market statistics, insights'],
                    ['id' => 'certs', 'label' => 'Certifications / licenses', 'target' => 'Professional affiliations'],
                    ['id' => 'depth', 'label' => 'Content depth and accuracy', 'target' => 'Expert-level detail'],
                ],
            ],
            [
                'id'     => 'authoritativeness',
                'name'   => 'Authoritativeness',
                'weight' => 25,
                'checks' => [
                    ['id' => 'citations', 'label' => 'Citations by other sources', 'target' => 'External references exist'],
                    ['id' => 'backlinks', 'label' => 'Quality backlink profile', 'target' => 'DR > 30 average'],
                    ['id' => 'mentions', 'label' => 'Media/industry mentions', 'target' => '≥ 3 external mentions'],
                    ['id' => 'partnerships', 'label' => 'Industry partnerships', 'target' => 'Visible partner logos'],
                ],
            ],
            [
                'id'     => 'trust',
                'name'   => 'Trustworthiness',
                'weight' => 25,
                'checks' => [
                    ['id' => 'reviews', 'label' => 'Client testimonials/reviews', 'target' => '≥ 10 real reviews'],
                    ['id' => 'ratings', 'label' => 'AggregateRating schema', 'target' => '≥ 4.5 stars'],
                    ['id' => 'contact', 'label' => 'Full contact information', 'target' => 'Phone, email, address, socials'],
                    ['id' => 'ssl', 'label' => 'HTTPS + privacy policy', 'target' => 'Enforced, visible policy'],
                    ['id' => 'transparency', 'label' => 'Transparent pricing/process', 'target' => 'Visible on site'],
                ],
            ],
        ],
    ],
];
