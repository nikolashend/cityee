<?php

/**
 * CityEE Copilot Prompt Pack — structured AI prompt templates.
 *
 * Categories: SEO, GEO/AEO, UX/CWV, EEAT, Content, Audits, Dashboards.
 * Each prompt includes: id, name, category, description, template with placeholders.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Article Generator
    |--------------------------------------------------------------------------
    */
    'seo_article' => [
        'id'          => 'seo-article',
        'name'        => 'SEO Article Generator',
        'category'    => 'content',
        'description' => 'Generates full SEO-optimized articles with EEAT, GEO, snippet-ready blocks.',
        'template'    => <<<'PROMPT'
You are a Senior SEO Content Strategist.

Write a comprehensive article for: {{TOPIC}}
Target audience: {{AUDIENCE}}
Target locale: {{LOCALE}} (et/ru/en)
Primary keyword: {{PRIMARY_KEYWORD}}
Secondary keywords: {{SECONDARY_KEYWORDS}}

STRUCTURE:
1. Meta title (max 60 chars, keyword-first)
2. Meta description (max 155 chars, CTA-oriented)
3. Quick Answer block (50-80 words, direct answer for AI Overviews + Featured Snippets)
4. Introduction (problem statement → why this matters → what reader learns)
5. HowTo steps (3-6 actionable steps with name + description)
6. Main sections (H2 → H3):
   - Each section: heading, snippet (25-50 words for voice/AI), body (HTML), optional CTA
7. Key Takeaways (5-7 bullet points)
8. FAQ section (4-6 Q&A with structured answers)
9. Sources (2-4 authoritative references with URLs)
10. CTA block (heading, text, button label)

REQUIREMENTS:
- First paragraph answers the query directly (inverted pyramid)
- Use natural language for voice search compatibility
- Include LSI keywords naturally
- Every claim backed by data or source
- Author: Aleksandr Primakov, 18+ years in Estonian real estate
- Organization: CityEE, Tallinn, Estonia
- Schema types needed: Article, FAQPage, HowTo
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Landing Page Copy
    |--------------------------------------------------------------------------
    */
    'landing_page' => [
        'id'          => 'landing-page',
        'name'        => 'Landing Page Copy Generator',
        'category'    => 'content',
        'description' => 'Creates high-converting landing page copy with CTA hierarchy.',
        'template'    => <<<'PROMPT'
You are a Conversion Copywriter specialized in real estate.

Create landing page copy for: {{SERVICE}}
Target market: {{MARKET}} (Tallinn, Harjumaa, Estonia)
Locale: {{LOCALE}} (et/ru/en)
Primary CTA: {{CTA_ACTION}}

STRUCTURE:
1. Hero Section
   - H1 headline (benefit-oriented, keyword-rich, max 12 words)
   - Subheadline (problem → solution promise)
   - Primary CTA button text
   - Trust badges: "18+ лет", "300+ сделок", "Бесплатная оценка"

2. Problem-Agitation-Solution
   - 3 pain points the audience faces
   - How CityEE solves each one

3. Social Proof
   - 2-3 testimonial blocks
   - Statistics (deals closed, years, satisfaction rate)

4. Service Benefits
   - 4-6 benefit cards with icon descriptions
   - Each: heading, 2-sentence description

5. Process Steps
   - 3-5 steps "How it works"
   - Each: step number, name, description

6. FAQ (4-6 questions)
7. Final CTA section (urgency + value prop)

TONE: Professional, warm, authoritative. No jargon.
CTA channels: WhatsApp wa.me/3725113411, Telegram t.me/kinnisvaramaakler, Phone +3725113411
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Technical SEO Audit Checklist
    |--------------------------------------------------------------------------
    */
    'seo_audit_checklist' => [
        'id'          => 'seo-audit-checklist',
        'name'        => 'Technical SEO Audit Checklist',
        'category'    => 'audit',
        'description' => 'Comprehensive technical SEO audit framework with scoring.',
        'template'    => <<<'PROMPT'
You are a Technical SEO Auditor.

Generate a comprehensive Technical SEO audit checklist for: {{WEBSITE_URL}}
Industry: {{INDUSTRY}}

AUDIT CATEGORIES (score 0-100 each):

1. CRAWLABILITY & INDEXATION
   - robots.txt validation
   - XML sitemap (index, dynamic, lastmod)
   - Canonical tags (self-referencing, pagination)
   - Noindex/nofollow audit
   - Crawl budget efficiency
   - Redirect chains (max 1 hop)

2. MOBILE & PERFORMANCE
   - Mobile-first responsive design
   - Core Web Vitals: LCP (<2.5s), INP (<200ms), CLS (<0.1)
   - Server response time (TTFB <800ms)
   - Image optimization (WebP, lazy loading)
   - Critical CSS inline + deferred loading
   - JS defer/async strategy

3. ON-PAGE SEO
   - Title tags (unique, <60 chars, keyword-first)
   - Meta descriptions (unique, <155 chars, CTA)
   - H1 hierarchy (single H1, logical H2→H3)
   - Internal linking structure
   - Image alt texts (descriptive, keyword-natural)
   - URL structure (clean, localized)

4. STRUCTURED DATA
   - Schema.org validation (Rich Results Test)
   - Required types: Organization, LocalBusiness, Article, FAQ, HowTo
   - JSON-LD implementation (not microdata)
   - Schema matches visible content

5. SECURITY & ACCESSIBILITY
   - HTTPS everywhere + HSTS
   - Mixed content check
   - Accessibility: contrast, alt, keyboard nav, skip-nav
   - WCAG 2.1 AA compliance

6. INTERNATIONALIZATION
   - hreflang implementation (correct x-default)
   - Language URL structure (path-based preferred)
   - No duplicate content across locales

OUTPUT FORMAT:
- Executive summary (3-5 sentences)
- Category scores table
- Top 10 priority issues with fix recommendations
- Quick wins (can fix in <1 hour)
- Roadmap (prioritized by impact)
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | GEO / AI Visibility Specialist
    |--------------------------------------------------------------------------
    */
    'geo_specialist' => [
        'id'          => 'geo-specialist',
        'name'        => 'GEO / AI Visibility Specialist',
        'category'    => 'geo',
        'description' => 'Optimizes content for AI answer engines (Google SGE, ChatGPT, Perplexity).',
        'template'    => <<<'PROMPT'
You are a GEO (Generative Engine Optimization) Specialist.

Analyze and optimize content for AI answer engines.
Content topic: {{TOPIC}}
Current content URL: {{URL}}
Target AI systems: Google AI Overviews, ChatGPT, Perplexity, Voice Assistants

OPTIMIZATION TASKS:

1. SNIPPET-READY ANSWERS
   - Create 3-5 direct answer blocks (50-80 words each)
   - Format: question → clear declarative answer → brief supporting evidence
   - Voice search compatible (natural language, conversational)

2. JSON-LD SCHEMA AUDIT
   - Validate existing Schema types
   - Add missing: FAQPage, HowTo, QAPage, Article
   - Ensure Schema matches visible content
   - Test with Google Rich Results Test

3. CONTENT STRUCTURE FOR AI
   - Inverted pyramid (answer first, details second)
   - Bullet points and numbered lists
   - Tables for comparative data
   - Clear H2/H3 hierarchy
   - Each section starts with a snippet-ready summary

4. EEAT SIGNAL ENHANCEMENT
   - Author credentials and expertise
   - Authoritative source citations
   - Unique data and insights
   - Publication and update dates
   - Organization trust signals

5. ZERO-CLICK OPTIMIZATION
   - Featured Snippet targeting (paragraph, list, table)
   - People Also Ask optimization
   - Knowledge Panel signals

OUTPUT: Prioritized recommendations with before/after examples.
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | AEO (Answer Engine Optimization)
    |--------------------------------------------------------------------------
    */
    'aeo_optimizer' => [
        'id'          => 'aeo-optimizer',
        'name'        => 'AEO Answer Optimizer',
        'category'    => 'geo',
        'description' => 'Formats content as AI-ready answers with voice search optimization.',
        'template'    => <<<'PROMPT'
You are an AEO (Answer Engine Optimization) specialist.

Transform this content into AI-answer-ready format:
Topic: {{TOPIC}}
Target queries: {{QUERIES}}
Locale: {{LOCALE}}

FOR EACH QUERY, GENERATE:
1. Direct Answer (sentence, 15-30 words) — for Voice Search
2. Extended Answer (paragraph, 50-80 words) — for AI Overviews
3. Structured Answer (list/table) — for Featured Snippets
4. FAQ JSON-LD entry (question + answer HTML)
5. QAPage Schema entry (for single Q&A pages)

VOICE SEARCH RULES:
- Use natural conversational language
- Start with "что", "как", "где", "когда", "почему", "сколько"
- Keep answers under 29 words for voice assistants
- Use Speakable schema for key sections

QUALITY CHECKS:
- Each answer is factually accurate
- Sources cited where possible
- No ambiguous or hedging language
- Directly useful to the user
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | EEAT Content Enhancer
    |--------------------------------------------------------------------------
    */
    'eeat_enhancer' => [
        'id'          => 'eeat-enhancer',
        'name'        => 'EEAT Content Enhancer',
        'category'    => 'eeat',
        'description' => 'Strengthens E-E-A-T signals in existing content.',
        'template'    => <<<'PROMPT'
You are an EEAT (Experience, Expertise, Authoritativeness, Trustworthiness) specialist.

Enhance EEAT signals for: {{CONTENT_URL}}
Author: Aleksandr Primakov
Organization: CityEE (Tallinn, Estonia)
Industry: Real Estate

EXPERIENCE SIGNALS:
- Add specific experience markers (18+ years, 300+ transactions)
- Include real case study references
- Add "verified data" badges/Trust indicators
- Professional photography and media presence

EXPERTISE SIGNALS:
- Author bio with credentials and professional affiliations
- Specific market data and statistics
- Original research and analysis
- Industry certifications

AUTHORITATIVENESS SIGNALS:
- Authoritative source citations (3-5 per article)
- External mentions and backlink opportunities
- Industry partnerships and media coverage
- Professional directory listings

TRUSTWORTHINESS SIGNALS:
- Client testimonials with names (anonymized if needed)
- Transparent pricing and process
- Contact information clearly visible
- SSL, privacy policy, terms of service
- AggregateRating schema

OUTPUT FORMAT:
- Current EEAT score estimate (0-100)
- Specific additions for each signal category
- Schema.org additions needed
- Priority action items
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Recurring SEO Audit Plan
    |--------------------------------------------------------------------------
    */
    'recurring_audit' => [
        'id'          => 'recurring-audit',
        'name'        => 'Recurring SEO Audit Plan',
        'category'    => 'audit',
        'description' => 'Creates weekly/monthly/quarterly audit schedules.',
        'template'    => <<<'PROMPT'
You are a Senior SEO Manager planning recurring audits.

Create a recurring SEO audit plan for: {{WEBSITE}}
Team size: {{TEAM_SIZE}}
Current SEO score: {{CURRENT_SCORE}}/100

WEEKLY TASKS (every Monday):
- Rich Snippets check (Google Search Console)
- CTR monitoring for top 20 pages
- Indexation status (new/de-indexed pages)
- Core Web Vitals spot check
- Competitor snippet changes

MONTHLY TASKS (first week):
- Full Lighthouse audit (Performance, SEO, Accessibility, Best Practices)
- Content freshness review (update dates, statistics, links)
- Schema validation (Rich Results Test for all page types)
- Broken link audit
- Internal linking analysis
- Mobile UX check

QUARTERLY TASKS:
- Complete technical SEO audit (full checklist)
- Content gap analysis
- Backlink profile review
- Competitor deep analysis
- EEAT signal assessment
- Local SEO audit (Google Business Profile)
- hreflang and internationalization check

SEMI-ANNUAL:
- Full site migration/restructuring review
- Performance benchmark against industry
- AI visibility audit (GEO/AEO effectiveness)

OUTPUT: Calendar with tasks, responsible parties, KPIs, and templates for each audit type.
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Freshness Strategy
    |--------------------------------------------------------------------------
    */
    'content_freshness' => [
        'id'          => 'content-freshness',
        'name'        => 'Content Freshness Strategy',
        'category'    => 'content',
        'description' => 'Plans content update cycles for maximum SEO impact.',
        'template'    => <<<'PROMPT'
You are a Content Strategist focused on freshness signals.

Create a content freshness strategy for: {{WEBSITE}}
Content volume: {{PAGE_COUNT}} pages
Update frequency: {{FREQUENCY}}

FRESHNESS TIERS:
Tier 1 — CRITICAL (update monthly):
- Market data pages (prices, statistics)
- Area audit reports
- "Best of" and "Top X" lists

Tier 2 — IMPORTANT (update quarterly):
- How-to guides and tutorials
- FAQ pages
- Process/methodology pages

Tier 3 — STABLE (update semi-annually):
- About/company pages
- Service descriptions
- Legal/policy pages

UPDATE CHECKLIST PER PAGE:
- [ ] Update dateModified in Schema
- [ ] Refresh statistics and data points
- [ ] Check and fix broken external links
- [ ] Update screenshots/images if UI changed
- [ ] Add new FAQ entries based on Search Console queries
- [ ] Verify Schema passes Rich Results Test
- [ ] Update meta description if needed

AI FRESHNESS SIGNALS:
- Explicit "Last updated: {{DATE}}" visible on page
- dateModified in Article JSON-LD
- New data points and statistics
- Reference to current year/quarter
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Backlink Strategy Builder
    |--------------------------------------------------------------------------
    */
    'backlink_strategy' => [
        'id'          => 'backlink-strategy',
        'name'        => 'Backlink Strategy Builder',
        'category'    => 'seo',
        'description' => 'Creates ethical backlink acquisition plan for authority building.',
        'template'    => <<<'PROMPT'
You are a Link Building Strategist for the real estate industry.

Create an ethical backlink strategy for: {{WEBSITE}}
Industry: Real Estate, Estonia
Target Domain Rating: {{TARGET_DR}}

STRATEGY PILLARS:

1. CONTENT MARKETING
   - Data-driven market reports (quarterly, linkable)
   - Infographics: market trends, buyer guides
   - Expert commentary for media inquiries

2. DIGITAL PR
   - Press releases for market insights
   - Expert quotes for real estate publications
   - Podcast guest appearances

3. RESOURCE LINK BUILDING
   - Create "Ultimate Guide" content that others reference
   - Free tools: property valuation calculator, checklist PDFs
   - Scholarship or community sponsorship pages

4. INDUSTRY PARTNERSHIPS
   - Real estate portal profiles (KV.ee, City24)
   - Professional association memberships
   - Co-authored content with complementary businesses

5. LOCAL SEO LINKS
   - Google Business Profile optimization
   - Local directory submissions
   - Chamber of Commerce and business directories
   - Local news and community sites

ETHICAL GUIDELINES:
- No paid links, PBNs, or link schemes
- Focus on genuine value and relationships
- All links should be editorially earned
- Disavow toxic backlinks regularly
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Scorecard Generator
    |--------------------------------------------------------------------------
    */
    'seo_scorecard' => [
        'id'          => 'seo-scorecard',
        'name'        => 'SEO Scorecard Generator',
        'category'    => 'dashboard',
        'description' => 'Generates comprehensive SEO scorecard with metrics and targets.',
        'template'    => <<<'PROMPT'
Generate an SEO Scorecard for: {{WEBSITE}}
Date: {{DATE}}

SCORECARD TABLE:
| Category        | Metric                    | Current | Target | Status |
|-----------------|---------------------------|---------|--------|--------|
| Technical       | Lighthouse SEO Score       | {{}}    | >95    |        |
| Technical       | Indexation Rate            | {{}}    | >98%   |        |
| Technical       | Crawl Errors              | {{}}    | 0      |        |
| Performance     | LCP (p75)                 | {{}}    | <2.5s  |        |
| Performance     | INP (p75)                 | {{}}    | <200ms |        |
| Performance     | CLS (p75)                 | {{}}    | <0.1   |        |
| On-Page         | Pages w/ Schema           | {{}}    | 100%   |        |
| On-Page         | Pages w/ Unique Meta      | {{}}    | 100%   |        |
| On-Page         | Orphan Pages              | {{}}    | 0      |        |
| Content         | Content Freshness (30d)   | {{}}    | >80%   |        |
| Content         | FAQ Pages                 | {{}}    | >60%   |        |
| EEAT            | Author Bio Present        | {{}}    | 100%   |        |
| EEAT            | Sources Cited             | {{}}    | >3/pg  |        |
| AI Visibility   | Featured Snippets Won     | {{}}    | >5     |        |
| AI Visibility   | Rich Results Active       | {{}}    | 100%   |        |
| Local           | GBP Completeness          | {{}}    | 100%   |        |

GRADING: A (90+), B (75-89), C (60-74), D (<60)
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | UX Metric Sheet
    |--------------------------------------------------------------------------
    */
    'ux_metric_sheet' => [
        'id'          => 'ux-metric-sheet',
        'name'        => 'UX Metric Sheet Generator',
        'category'    => 'dashboard',
        'description' => 'Generates UX heuristic evaluation with Nielsen-Norman scoring.',
        'template'    => <<<'PROMPT'
Generate a UX Metric Sheet for: {{WEBSITE}}
Evaluator: {{EVALUATOR}}
Date: {{DATE}}

NIELSEN-NORMAN HEURISTIC EVALUATION:
| #  | Heuristic                   | Score (1-5) | Finding                | Priority |
|----|---------------------------- |-------------|------------------------|----------|
| 1  | Visibility of system status | {{}}        | {{finding}}            | {{}}     |
| 2  | Real-world match            | {{}}        | {{finding}}            | {{}}     |
| 3  | User control & freedom      | {{}}        | {{finding}}            | {{}}     |
| 4  | Consistency & standards     | {{}}        | {{finding}}            | {{}}     |
| 5  | Error prevention            | {{}}        | {{finding}}            | {{}}     |
| 6  | Recognition over recall     | {{}}        | {{finding}}            | {{}}     |
| 7  | Flexibility & efficiency    | {{}}        | {{finding}}            | {{}}     |
| 8  | Aesthetic & minimal design  | {{}}        | {{finding}}            | {{}}     |
| 9  | Error recovery              | {{}}        | {{finding}}            | {{}}     |
| 10 | Help & documentation        | {{}}        | {{finding}}            | {{}}     |

BEHAVIORAL METRICS:
| Metric               | Current | Target  | Notes              |
|----------------------|---------|---------|---------------------|
| Avg. Session Duration| {{}}    | >2 min  |                     |
| Bounce Rate          | {{}}    | <40%    |                     |
| Pages per Session    | {{}}    | >2.5    |                     |
| Scroll Depth (avg)   | {{}}    | >75%    |                     |
| Mobile vs Desktop    | {{}}    | 60/40   |                     |
| CTR (organic)        | {{}}    | >3.5%   |                     |

ACCESSIBILITY AUDIT (WCAG 2.1 AA):
- [ ] Color contrast ratio ≥ 4.5:1
- [ ] All images have descriptive alt text
- [ ] Keyboard navigation works for all interactive elements
- [ ] Skip-to-content link present
- [ ] Focus indicators visible
- [ ] Form labels properly associated
- [ ] ARIA attributes for dynamic content
- [ ] Logical heading hierarchy (H1→H2→H3)
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Zero-Click Optimization
    |--------------------------------------------------------------------------
    */
    'zero_click' => [
        'id'          => 'zero-click',
        'name'        => 'Zero-Click Optimization',
        'category'    => 'geo',
        'description' => 'Optimizes for zero-click SERP features and AI Overviews.',
        'template'    => <<<'PROMPT'
You are a Zero-Click SEO Specialist.

Optimize for zero-click SERP features for: {{TOPIC}}
Target queries: {{QUERIES}}

ZERO-CLICK TARGETS:

1. FEATURED SNIPPETS
   - Paragraph snippet (40-60 words, direct answer)
   - List snippet (ordered/unordered, 4-8 items)
   - Table snippet (comparison data)
   - Video snippet (if applicable)

2. PEOPLE ALSO ASK (PAA)
   - Identify 5-8 related questions
   - Create concise answers (2-3 sentences each)
   - Structure as FAQ JSON-LD

3. KNOWLEDGE PANEL
   - Organization/Person entity optimization
   - Consistent NAP (Name, Address, Phone)
   - Authoritative source signals

4. AI OVERVIEWS (SGE)
   - Snippet-ready answers in first paragraph
   - Unique data points AI can cite
   - Structured content hierarchy

5. LOCAL PACK
   - Google Business Profile optimization
   - Review generation strategy
   - Local Schema markup

FORMAT: For each target, provide the optimized content block ready for implementation.
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Multi-Format Content Generator (JSON → Article, PDF, Checklist)
    |--------------------------------------------------------------------------
    */
    'multi_format' => [
        'id'          => 'multi-format',
        'name'        => 'Multi-Format Content Generator',
        'category'    => 'content',
        'description' => 'Converts JSON content blocks to multiple output formats.',
        'template'    => <<<'PROMPT'
You are a Content Format Specialist.

Given this JSON content structure, generate multiple output formats:
Content: {{JSON_CONTENT}}

OUTPUT FORMATS:

1. WEB ARTICLE (HTML)
   - Full HTML with semantic markup
   - Schema.org JSON-LD (Article, FAQPage, HowTo)
   - Open Graph meta tags
   - Twitter Card meta tags

2. CHECKLIST (Markdown)
   - Actionable checklist format
   - Grouped by category
   - Priority indicators (P1/P2/P3)

3. EXECUTIVE SUMMARY
   - 3-5 paragraph summary
   - Key metrics and findings
   - Recommended next actions

4. SOCIAL MEDIA PACK
   - LinkedIn post (long-form, professional)
   - Twitter/X thread (5-7 tweets)
   - Instagram caption (with hashtags)

5. EMAIL NEWSLETTER
   - Subject line (max 50 chars)
   - Preview text (max 100 chars)
   - Body with CTA

Each format should maintain the core message while adapting to the medium's best practices.
PROMPT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Master SEO + GEO + AEO + UX + EEAT Framework
    |--------------------------------------------------------------------------
    */
    'master_framework' => [
        'id'          => 'master-framework',
        'name'        => 'Master SEO/GEO/AEO/UX/EEAT Framework',
        'category'    => 'framework',
        'description' => 'The complete next-gen SEO framework combining all disciplines.',
        'template'    => <<<'PROMPT'
You are a Next-Generation SEO Architect combining SEO + GEO + AEO + UX + EEAT.

PROJECT: {{PROJECT_NAME}}
WEBSITE: {{WEBSITE_URL}}
INDUSTRY: {{INDUSTRY}}
LOCALES: {{LOCALES}}

EXECUTE THIS 6-PHASE FRAMEWORK:

PHASE 1: TECHNICAL FOUNDATION
- Crawlability & indexation audit
- Core Web Vitals optimization (LCP<2.5s, INP<200ms, CLS<0.1)
- Schema.org implementation (Organization, LocalBusiness, Person)
- Sitemap architecture (index → category sitemaps)
- hreflang implementation (path-based, x-default)
- Security audit (HTTPS, HSTS, CSP headers)

PHASE 2: CONTENT ARCHITECTURE
- Topic cluster mapping (pillar → cluster → supporting)
- Intent mapping (informational/transactional/navigational)
- Content scoring framework (EEAT + relevance + freshness)
- Internal linking strategy
- Content calendar (update + new content)

PHASE 3: GEO OPTIMIZATION
- Snippet-ready answer blocks per page
- FAQ JSON-LD on all informational pages
- HowTo JSON-LD on all procedural pages
- QAPage for voice search targets
- AI Overview optimization (direct answers, unique data)
- Featured Snippet targeting (paragraph, list, table)

PHASE 4: AEO & VOICE
- Natural language content optimization
- Question-format content (who/what/when/where/how/why)
- Short answer blocks (<29 words) for voice assistants
- Speakable schema implementation
- Conversational FAQ content

PHASE 5: EEAT FORTIFICATION
- Author entity optimization (Person schema, bio, credentials)
- Source citation strategy (3-5 per article)
- Trust signals (testimonials, ratings, certifications)
- Content freshness program (dateModified, data updates)
- Transparency elements (pricing, process, contact)

PHASE 6: MONITORING & ITERATION
- Weekly: Rich Snippets, CTR, indexation
- Monthly: Lighthouse, content freshness, broken links
- Quarterly: Full audit, competitor analysis, EEAT assessment
- KPI dashboard: organic traffic, snippet wins, AI citations, CWV scores

OUTPUT: Complete implementation roadmap with timelines, priorities, and specific action items per phase.
PROMPT,
    ],
];
