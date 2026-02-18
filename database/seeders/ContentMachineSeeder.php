<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\AreaAudit;
use Illuminate\Database\Seeder;

/**
 * Full SEO/GEO/UX Knowledge Machine — all guides and area audits.
 * Covers: SEO Strategy 2026, GEO/AEO Optimization, UX/CWV, EEAT.
 */
class ContentMachineSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSeoStrategyGuide();
        $this->seedGeoAeoGuide();
        $this->seedUxCwvGuide();
        $this->seedEeatGuide();
        $this->seedSellGuide();
        $this->seedKesklinnAudit();
    }

    // ═══════════════════════════════════════════════════════════
    // GUIDE: SEO Strategies 2026 (3 languages)
    // ═══════════════════════════════════════════════════════════
    private function seedSeoStrategyGuide(): void
    {
        // ── Russian ──
        Guide::updateOrCreate(
            ['slug' => 'seo-strategii-2026', 'locale' => 'ru'],
            [
                'title' => 'SEO стратегии 2026: пошаговое руководство',
                'meta_title' => 'SEO стратегии 2026 — полное руководство | CityEE',
                'meta_description' => 'Полное руководство по SEO-стратегиям 2026: технический SEO, контент, UX, AI-видимость, GEO-оптимизация, EEAT-сигналы.',
                'excerpt' => 'Ваш полный SEO checklist 2026 — от технического аудита до AI-ответов. Пошаговая стратегия, включая GEO, AEO, EEAT и Core Web Vitals.',
                'content_blocks' => [
                    'quick_answer' => 'SEO в 2026 — это не только позиции в Google, а комплексная стратегия: техническая оптимизация, контент под AI-ответы (GEO/AEO), EEAT-сигналы доверия, Core Web Vitals и UX-вовлечение. Фокус сместился с ключевых слов на intent-модели и структурированные данные.',
                    'intro' => '<p>SEO в 2026 году кардинально изменилось. Google использует AI Overviews, ChatGPT и Perplexity отвечают пользователям напрямую, а Featured Snippets стали главным каналом трафика. В этом руководстве — полная стратегия, которая работает прямо сейчас.</p><p><strong>Главный принцип:</strong> оптимизируйте не для поисковика, а для пользователя и ИИ — они теперь одна аудитория.</p>',
                    'howto_steps' => [
                        ['name' => 'Технический аудит сайта', 'text' => 'Проверьте crawlability, индексацию, мобильный рендеринг, скорость загрузки и schema markup через Google Search Console и ScreamingFrog.'],
                        ['name' => 'Анализ конкурентов и интентов', 'text' => 'Определите поисковые интенты (informational, transactional, navigational) и проанализируйте сниппеты конкурентов.'],
                        ['name' => 'Контент-стратегия под AI/GEO', 'text' => 'Создайте контент с прямыми ответами в первом абзаце, FAQ-секциями и JSON-LD разметкой для AI-систем.'],
                        ['name' => 'EEAT-сигналы', 'text' => 'Добавьте авторские данные, экспертные credentials, ссылки на авторитетные источники, кейсы и отзывы.'],
                        ['name' => 'Core Web Vitals оптимизация', 'text' => 'Нацеливайтесь на LCP < 2.5s, INP < 200ms, CLS < 0.1. Используйте lazy loading, критический CSS, defer для JS.'],
                        ['name' => 'Мониторинг и обновление', 'text' => 'Еженедельно проверяйте Rich Snippets, ежемесячно — Lighthouse audit, ежеквартально — полный SEO + UX обзор.'],
                    ],
                    'sections' => [
                        [
                            'heading' => 'Аудит сайта — точка старта',
                            'snippet' => 'Технический SEO аудит включает проверку индексации, crawl budget, мобильности, скорости и Schema разметки. Начните с Google Search Console и ScreamingFrog.',
                            'body' => '<p>Каждая SEO-стратегия начинается с аудита. Без понимания текущего состояния невозможно планировать улучшения.</p><h3>Technical SEO Checklist</h3><ul><li><strong>Crawlability:</strong> robots.txt, sitemap.xml, каноникалы</li><li><strong>Индексация:</strong> проверка через GSC, отсутствие noindex на важных страницах</li><li><strong>Mobile-first:</strong> адаптивная верстка, отсутствие горизонтального скролла</li><li><strong>Core Web Vitals:</strong> LCP, CLS, INP (бывший FID)</li><li><strong>Schema.org:</strong> Article, FAQ, HowTo, LocalBusiness, Organization</li><li><strong>HTTPS & Security:</strong> SSL, HSTS, SRI для CDN ресурсов</li></ul>',
                            'cta_text' => 'Заказать технический аудит →',
                        ],
                        [
                            'heading' => 'Контент как ключевой фактор',
                            'snippet' => 'Контент в 2026 оптимизируется не только для ключевых слов, но и для intent-моделей, AI-ответов и EEAT-сигналов экспертности.',
                            'body' => '<p>Контент-стратегия 2026 — это инвертированная пирамида: сначала ответ, потом объяснение, потом детали.</p><h3>Content Scoring (E-A-T оценка)</h3><ul><li><strong>Экспертиза:</strong> автор с подтверждённым опытом (credentials, био)</li><li><strong>Авторитетность:</strong> ссылки на исследования, официальные источники</li><li><strong>Достоверность:</strong> факты, статистика, кейсы, актуальные данные</li><li><strong>Польза:</strong> решает конкретную проблему пользователя</li></ul><h3>Плотность ключей + LSI</h3><p>SEO-контент = не только плотность ключевых слов, но контекстная связь с intent-моделями. Используйте LSI-ключи (латентно-семантические), synonyms и related terms естественным образом.</p>',
                        ],
                        [
                            'heading' => 'UX и его влияние на ранжирование',
                            'snippet' => 'UX-сигналы (CTR, bounce rate, время на странице, глубина скролла) напрямую влияют на SEO-позиции и AI-приоритизацию.',
                            'body' => '<p>Связь SEO и UX в 2026 стала неразрывной. Google и AI оценивают качество страницы не только по тексту, но и по поведению пользователей.</p><h3>UX-сигналы для ранжирования</h3><ul><li>Высокий CTR сниппетов (структурированные мета + schema)</li><li>Низкий bounce rate</li><li>Время на странице > 2 минут</li><li>Глубина скролла > 75%</li><li>Возвратные визиты</li></ul><h3>Юзабилити по эвристикам Нильсена</h3><ul><li><strong>Видимость статуса:</strong> пользователь понимает, где находится (breadcrumbs, навигация)</li><li><strong>Предотвращение ошибок:</strong> валидация форм, подтверждения действий</li><li><strong>Доступность (a11y):</strong> контрастность, alt-тексты, keyboard navigation, skip-nav</li><li><strong>Когнитивная нагрузка:</strong> минимум отвлечений, чёткая иерархия</li></ul>',
                        ],
                        [
                            'heading' => 'Генерация ответов ИИ-системам (GEO)',
                            'snippet' => 'GEO (Generative Engine Optimization) — оптимизация контента для попадания в AI-ответы Google SGE, ChatGPT, Perplexity и голосовых ассистентов.',
                            'body' => '<p><strong>GEO — это новый уровень SEO.</strong> Цель — не только быть в топе, а быть цитируемым ИИ как источник ответа.</p><h3>Как оптимизировать под AI</h3><ul><li>Давайте прямой ответ в первом абзаце (50-80 слов)</li><li>Используйте Q&A формат с Schema FAQ JSON-LD</li><li>Структурируйте контент: от простого к глубокому</li><li>Включайте уникальные данные и инсайты</li><li>Обновляйте контент регулярно</li></ul><h3>JSON-LD для AI-видимости</h3><p>Обязательные schema: Article, FAQPage, HowTo, QAPage. Валидируйте через Google Rich Results Test и отслеживайте через Search Console.</p>',
                            'cta_text' => 'Оптимизировать сайт под AI →',
                        ],
                    ],
                    'takeaways' => [
                        'Начинайте с технического аудита — это фундамент.',
                        'Контент должен давать ответ в первом абзаце (для AI и Featured Snippets).',
                        'EEAT — не рекомендация, а обязательный сигнал качества.',
                        'Core Web Vitals влияют на SEO и UX одновременно.',
                        'JSON-LD Schema обязательна: Article, FAQ, HowTo, LocalBusiness.',
                        'Регулярные аудиты: еженедельно, ежемесячно, ежеквартально.',
                    ],
                    'faq' => [
                        ['question' => 'Что такое GEO-оптимизация?', 'answer' => '<p>GEO (Generative Engine Optimization) — это оптимизация сайта для генеративных ИИ и структурированных данных, чтобы контент попадал в AI-ответы Google SGE, ChatGPT, Perplexity.</p>'],
                        ['question' => 'Как часто нужно проводить SEO-аудит?', 'answer' => '<p>Еженедельно — проверка Rich Snippets и CTR. Ежемесячно — Lighthouse аудит и обзор контента. Ежеквартально — полный технический SEO + UX обзор.</p>'],
                        ['question' => 'Что важнее — позиция в Google или попадание в AI-ответы?', 'answer' => '<p>В 2026 оба важны, но AI-ответы растут: более 40% пользователей получают ответ через AI Overviews. Оптимизируйте под оба канала одновременно.</p>'],
                        ['question' => 'Как улучшить Core Web Vitals?', 'answer' => '<p>LCP: используйте preload для hero image, критический CSS inline. CLS: задайте width/height для изображений. INP: defer JS файлы, минимизируйте main thread блокировки.</p>'],
                        ['question' => 'Что такое EEAT и почему это важно?', 'answer' => '<p>EEAT — Experience, Expertise, Authoritativeness, Trustworthiness. Это основной сигнал качества для Google и AI. Включает: авторские данные, экспертные credentials, ссылки на авторитетные источники.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Google Search Central — Structured Data', 'url' => 'https://developers.google.com/search/docs/appearance/structured-data', 'note' => 'Официальная документация Google по Schema.org'],
                        ['title' => 'Core Web Vitals — web.dev', 'url' => 'https://web.dev/vitals/', 'note' => 'Стандарты Google по производительности'],
                        ['title' => 'Nielsen Norman Group — UX Heuristics', 'url' => 'https://www.nngroup.com/articles/ten-usability-heuristics/', 'note' => '10 эвристик юзабилити'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите SEO-аудит вашего сайта?',
                        'text' => 'Бесплатный анализ: технический SEO, контент, UX и AI-видимость за 24 часа.',
                        'button' => 'Заказать бесплатный аудит',
                    ],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );

        // ── English ──
        Guide::updateOrCreate(
            ['slug' => 'seo-strategii-2026', 'locale' => 'en'],
            [
                'title' => 'SEO Strategies 2026: Complete Step-by-Step Guide',
                'meta_title' => 'SEO Strategies 2026 — Complete Guide | CityEE',
                'meta_description' => 'Complete 2026 SEO guide: technical SEO, content, UX, AI visibility, GEO optimization, EEAT signals, Core Web Vitals.',
                'excerpt' => 'Your complete 2026 SEO checklist — from technical audit to AI answers. Step-by-step strategy including GEO, AEO, EEAT and Core Web Vitals.',
                'content_blocks' => [
                    'quick_answer' => 'SEO in 2026 is a comprehensive strategy: technical optimization, AI-ready content (GEO/AEO), EEAT trust signals, Core Web Vitals, and UX engagement. Focus has shifted from keywords to intent models and structured data.',
                    'intro' => '<p>SEO in 2026 has fundamentally changed. Google uses AI Overviews, ChatGPT and Perplexity answer users directly, and Featured Snippets have become the primary traffic channel. This guide covers the complete strategy that works right now.</p><p><strong>Core principle:</strong> optimize for the user and AI — they are now the same audience.</p>',
                    'howto_steps' => [
                        ['name' => 'Technical Site Audit', 'text' => 'Check crawlability, indexation, mobile rendering, page speed and schema markup using Google Search Console and ScreamingFrog.'],
                        ['name' => 'Competitor & Intent Analysis', 'text' => 'Identify search intents (informational, transactional, navigational) and analyze competitor snippets.'],
                        ['name' => 'AI/GEO Content Strategy', 'text' => 'Create content with direct answers in the first paragraph, FAQ sections and JSON-LD markup for AI systems.'],
                        ['name' => 'EEAT Signals', 'text' => 'Add author credentials, expert bio, authoritative source citations, case studies and testimonials.'],
                        ['name' => 'Core Web Vitals Optimization', 'text' => 'Target LCP < 2.5s, INP < 200ms, CLS < 0.1. Use lazy loading, critical CSS, defer for JS.'],
                        ['name' => 'Monitor & Update', 'text' => 'Weekly: check Rich Snippets. Monthly: Lighthouse audit. Quarterly: full SEO + UX review.'],
                    ],
                    'sections' => [
                        [
                            'heading' => 'Site Audit — The Starting Point',
                            'snippet' => 'A technical SEO audit covers indexation, crawl budget, mobile-first, page speed and Schema markup. Start with Google Search Console and ScreamingFrog.',
                            'body' => '<p>Every SEO strategy starts with an audit. Without understanding the current state, improvement planning is impossible.</p><h3>Technical SEO Checklist</h3><ul><li><strong>Crawlability:</strong> robots.txt, sitemap.xml, canonicals</li><li><strong>Indexation:</strong> GSC check, no noindex on important pages</li><li><strong>Mobile-first:</strong> responsive layout, no horizontal scroll</li><li><strong>Core Web Vitals:</strong> LCP, CLS, INP</li><li><strong>Schema.org:</strong> Article, FAQ, HowTo, LocalBusiness, Organization</li></ul>',
                            'cta_text' => 'Order a technical audit →',
                        ],
                        [
                            'heading' => 'Content as the Key Factor',
                            'snippet' => 'Content in 2026 is optimized not just for keywords, but for intent models, AI answers and EEAT expertise signals.',
                            'body' => '<p>Content strategy 2026 uses the inverted pyramid: answer first, explanation second, details third.</p><h3>Content Scoring (E-A-T Assessment)</h3><ul><li><strong>Expertise:</strong> author with verified experience</li><li><strong>Authoritativeness:</strong> links to research, official sources</li><li><strong>Trustworthiness:</strong> facts, statistics, case studies</li><li><strong>Usefulness:</strong> solves a specific user problem</li></ul>',
                        ],
                        [
                            'heading' => 'UX Impact on Rankings',
                            'snippet' => 'UX signals (CTR, bounce rate, time on page, scroll depth) directly affect SEO positions and AI prioritization.',
                            'body' => '<p>The connection between SEO and UX in 2026 is inseparable. Google and AI evaluate page quality not just by text, but by user behavior.</p><h3>UX Signals for Rankings</h3><ul><li>High snippet CTR (structured meta + schema)</li><li>Low bounce rate</li><li>Time on page > 2 minutes</li><li>Scroll depth > 75%</li></ul>',
                        ],
                        [
                            'heading' => 'Generative Engine Optimization (GEO)',
                            'snippet' => 'GEO optimizes content so AI systems like Google SGE, ChatGPT and Perplexity cite it as their answer source.',
                            'body' => '<p><strong>GEO is the next level of SEO.</strong> The goal: not just ranking high, but being cited by AI as the answer source.</p><h3>How to Optimize for AI</h3><ul><li>Give a direct answer in the first paragraph (50-80 words)</li><li>Use Q&A format with Schema FAQ JSON-LD</li><li>Structure content: simple to deep</li><li>Include unique data and insights</li><li>Update content regularly</li></ul>',
                            'cta_text' => 'Optimize your site for AI →',
                        ],
                    ],
                    'takeaways' => [
                        'Start with a technical audit — it\'s the foundation.',
                        'Content must answer in the first paragraph (for AI and Featured Snippets).',
                        'EEAT is not optional — it\'s a mandatory quality signal.',
                        'Core Web Vitals affect both SEO and UX.',
                        'JSON-LD Schema is required: Article, FAQ, HowTo, LocalBusiness.',
                        'Regular audits: weekly, monthly, quarterly.',
                    ],
                    'faq' => [
                        ['question' => 'What is GEO optimization?', 'answer' => '<p>GEO (Generative Engine Optimization) is optimizing your site for generative AI systems so your content appears in AI answers from Google SGE, ChatGPT, Perplexity.</p>'],
                        ['question' => 'How often should you do an SEO audit?', 'answer' => '<p>Weekly: check Rich Snippets and CTR. Monthly: Lighthouse audit and content review. Quarterly: full technical SEO + UX overhaul.</p>'],
                        ['question' => 'What is more important — Google ranking or AI answer inclusion?', 'answer' => '<p>In 2026 both matter, but AI answers are growing: over 40% of users get answers through AI Overviews. Optimize for both channels simultaneously.</p>'],
                        ['question' => 'How to improve Core Web Vitals?', 'answer' => '<p>LCP: preload hero image, inline critical CSS. CLS: set width/height for images. INP: defer JS, minimize main thread blocking.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Google Search Central — Structured Data', 'url' => 'https://developers.google.com/search/docs/appearance/structured-data'],
                        ['title' => 'Core Web Vitals — web.dev', 'url' => 'https://web.dev/vitals/'],
                        ['title' => 'Nielsen Norman Group — UX Heuristics', 'url' => 'https://www.nngroup.com/articles/ten-usability-heuristics/'],
                    ],
                    'cta' => [
                        'heading' => 'Want a full SEO audit for your site?',
                        'text' => 'Free analysis: technical SEO, content, UX and AI visibility within 24 hours.',
                        'button' => 'Order Free Audit',
                    ],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );

        // ── Estonian ──
        Guide::updateOrCreate(
            ['slug' => 'seo-strategii-2026', 'locale' => 'et'],
            [
                'title' => 'SEO strateegiad 2026: täielik samm-sammuline juhend',
                'meta_title' => 'SEO strateegiad 2026 — täielik juhend | CityEE',
                'meta_description' => 'Täielik SEO-strateegiate juhend 2026: tehniline SEO, sisu, UX, AI-nähtavus, GEO-optimeerimine, EEAT-signaalid.',
                'excerpt' => 'Teie täielik SEO checklist 2026 — tehnilisest auditist kuni AI-vastusteni. Samm-sammuline strateegia, sealhulgas GEO, AEO, EEAT ja Core Web Vitals.',
                'content_blocks' => [
                    'quick_answer' => 'SEO 2026 on terviklik strateegia: tehniline optimeerimine, AI-sisule orienteeritud sisu (GEO/AEO), EEAT usaldusväärsuse signaalid, Core Web Vitals ja UX-kaasamine.',
                    'intro' => '<p>SEO 2026. aastal on põhjalikult muutunud. Google kasutab AI Overviews, ChatGPT ja Perplexity vastavad kasutajatele otse ning Featured Snippets on peamine liikluse kanal.</p>',
                    'howto_steps' => [
                        ['name' => 'Tehniline veebisaidi audit', 'text' => 'Kontrollige crawlability, indekseerimine, mobiilne renderdamine ja Schema markup Google Search Console ja ScreamingFrog abil.'],
                        ['name' => 'Konkurentide ja kavatsuste analüüs', 'text' => 'Tuvastage otsingukavatsused ja analüüsige konkurentide snippette.'],
                        ['name' => 'AI/GEO sisustrateegia', 'text' => 'Looge sisu otseste vastustega esimeses lõigus ja FAQ-sektsionidega.'],
                        ['name' => 'EEAT-signaalid', 'text' => 'Lisage autori andmed, eksperdi credentials ja viited autoriteetsetele allikatele.'],
                        ['name' => 'Core Web Vitals optimeerimine', 'text' => 'Sihtmärk LCP < 2.5s, INP < 200ms, CLS < 0.1.'],
                        ['name' => 'Jälgimine ja uuendamine', 'text' => 'Iganädalane: Rich Snippets kontroll. Igakuine: Lighthouse audit. Kvartaalne: täielik SEO + UX ülevaade.'],
                    ],
                    'sections' => [
                        [
                            'heading' => 'Saidi audit — alguspunkt',
                            'snippet' => 'Tehniline SEO audit hõlmab indekseerimist, crawl budget, mobiilsust, kiirust ja Schema märgistamist.',
                            'body' => '<p>Iga SEO-strateegia algab auditist.</p><h3>Tehniline SEO Checklist</h3><ul><li><strong>Crawlability:</strong> robots.txt, sitemap.xml, kanonaalsed</li><li><strong>Indekseerimine:</strong> GSC kontroll</li><li><strong>Mobile-first:</strong> kohanduv paigutus</li><li><strong>Core Web Vitals:</strong> LCP, CLS, INP</li><li><strong>Schema.org:</strong> Article, FAQ, HowTo, LocalBusiness</li></ul>',
                        ],
                    ],
                    'takeaways' => [
                        'Alustage tehnilise auditiga — see on alusmüür.',
                        'Sisu peab vastama esimeses lõigus.',
                        'EEAT on kohustuslik kvaliteedisignaal.',
                        'Core Web Vitals mõjutavad nii SEO kui UX.',
                        'JSON-LD Schema on kohustuslik.',
                    ],
                    'faq' => [
                        ['question' => 'Mis on GEO-optimeerimine?', 'answer' => '<p>GEO on saidi optimeerimine generatiivsete AI süsteemide jaoks, et sisu ilmuks AI-vastustes.</p>'],
                        ['question' => 'Kui tihti tuleks SEO-audit teha?', 'answer' => '<p>Iganädalane: Rich Snippets. Igakuine: Lighthouse. Kvartaalne: täielik SEO + UX.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Soovid SEO-auditit?',
                        'text' => 'Tasuta analüüs 24 tunni jooksul.',
                        'button' => 'Telli tasuta audit',
                    ],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }

    // ═══════════════════════════════════════════════════════════
    // GUIDE: GEO/AEO — AI Answer Optimization (RU + EN)
    // ═══════════════════════════════════════════════════════════
    private function seedGeoAeoGuide(): void
    {
        Guide::updateOrCreate(
            ['slug' => 'geo-aeo-ai-optimizatsiya', 'locale' => 'ru'],
            [
                'title' => 'GEO и AEO: как попасть в ответы ИИ — полный гайд 2026',
                'meta_title' => 'GEO / AEO оптимизация — ответы ИИ 2026 | CityEE',
                'meta_description' => 'Как оптимизировать сайт для AI-ответов Google SGE, ChatGPT, Perplexity. GEO, AEO, Schema JSON-LD, EEAT, Voice Search.',
                'excerpt' => 'Полное руководство по GEO (Generative Engine Optimization) и AEO (Answer Engine Optimization) — как сделать ваш контент источником ответов для ИИ.',
                'content_blocks' => [
                    'quick_answer' => 'GEO (Generative Engine Optimization) — это оптимизация контента для генеративных ИИ (Google AI, ChatGPT, Perplexity), чтобы именно ваш контент цитировался как источник ответа. AEO (Answer Engine Optimization) формирует контент так, чтобы давать чёткий, прямой ответ на запрос пользователя.',
                    'intro' => '<p>В 2026 году более 40% поисковых запросов получают ответ через AI Overviews. Это означает, что оптимизация только под традиционный SERP уже недостаточна. Вам нужна GEO/AEO стратегия.</p><p><strong>Ключевая идея:</strong> ИИ анализирует не только слова, но структуру смысла, последовательность логики и точность фрагментов.</p>',
                    'howto_steps' => [
                        ['name' => 'Структурируйте контент для AI', 'text' => 'Давайте прямой ответ в первом абзаце (50-80 слов), затем расширяйте. Используйте инвертированную пирамиду.'],
                        ['name' => 'Добавьте Schema JSON-LD', 'text' => 'Обязательные типы: Article, FAQPage, HowTo, QAPage. Валидируйте через Google Rich Results Test.'],
                        ['name' => 'Оптимизируйте под Voice Search', 'text' => 'Используйте естественный язык, вопросные форматы (что, как, где, когда, почему), короткие ответы.'],
                        ['name' => 'Усильте EEAT-сигналы', 'text' => 'Добавьте авторские credentials, ссылки на авторитетные источники, уникальные данные и кейсы.'],
                        ['name' => 'Создайте snippet-ready блоки', 'text' => 'Генерируйте короткие ответы до 50 слов, структурированные списки, таблицы, пошаговые инструкции.'],
                        ['name' => 'Регулярно обновляйте контент', 'text' => 'AI-системы предпочитают свежие данные. Обновляйте FAQ, Schema и статистику ежеквартально.'],
                    ],
                    'sections' => [
                        [
                            'heading' => 'Что такое GEO (Generative Engine Optimization)',
                            'snippet' => 'GEO — это оптимизация контента для попадания в AI-ответы Google SGE, ChatGPT, Perplexity и голосовых ассистентов.',
                            'body' => '<p>GEO — это новый смысл SEO, ориентированный на ответы ИИ-систем, а не только позиции в выдаче. ИИ часто берёт ответы напрямую из текста, который имеет:</p><ul><li>Структурированные ответы (FAQ JSON-LD)</li><li>Прямые блиц-ответы на вопросы</li><li>Уникальные данные и инсайты</li><li>Актуальную информацию</li></ul><p><strong>Позиция в AI-ответах сейчас важнее традиционной позиции №1.</strong></p>',
                        ],
                        [
                            'heading' => 'AEO — Answer Engine Optimization',
                            'snippet' => 'AEO формирует контент так, чтобы он давал однозначный, точный ответ на запрос пользователя и был выбран AI-ответом.',
                            'body' => '<p>AEO критична, потому что всё больше поисков происходит через AI-ассистенты и ответные карусели.</p><h3>Структура AEO-контента</h3><ol><li>Предисловие с ответом (direct answer)</li><li>H2 → основные вопросы с конкретными ответами</li><li>H3 → расширенные ответы с фактическими примерами</li><li>FAQ в JSON-LD</li><li>Quick Answer snippets (bullet points до 25 слов)</li><li>Обязательные Schema.org структуры</li></ol>',
                        ],
                        [
                            'heading' => 'Voice Search Optimization',
                            'snippet' => 'Voice SEO — это оптимизация под естественный, разговорный язык с вопросными форматами.',
                            'body' => '<p>Voice Search — это не про голосовые команды, а про естественный разговорный язык.</p><h3>Оптимизация включает</h3><ul><li>Ключи в вопросном формате: что, как, где, когда, почему</li><li>Короткие и быстрые первые абзацы-ответы</li><li>FAQ-формат и нативная структура «вопрос-ответ»</li><li>Schema.org QAPage JSON-LD</li></ul><p>Voice SEO напрямую влияет на традиционные позиции Google и на то, что AI-ассистенты выбирают один ответ за тебя.</p>',
                        ],
                        [
                            'heading' => 'Featured Snippets и Zero-Click доминирование',
                            'snippet' => 'Featured snippets дают позицию ноль, а в 2026 это ещё и доступ в AI-ответы и Voice Search.',
                            'body' => '<p>Featured snippets растут по частоте — Google всё чаще даёт ответы пользователю без клика на сайт.</p><h3>Как захватить Featured Snippet</h3><ul><li>Генерируйте короткие ответы до 50 слов</li><li>Включайте структурированные списки и таблицы</li><li>Пишите прямые ответы на вопросы</li><li>Создавайте логическую перевёрнутую пирамиду (от простого к глубокому)</li></ul><p>Эти блоки часто захватываются Google SGE, AI Overviews и голосовыми ассистентами.</p>',
                        ],
                        [
                            'heading' => 'JSON-LD шаблоны для AI-видимости',
                            'snippet' => 'Обязательные JSON-LD типы: FAQPage, HowTo, Article, QAPage, LocalBusiness. Schema должна соответствовать видимому контенту.',
                            'body' => '<p>JSON-LD — ключ к AI-пониманию сайта и rich results. Структурированные данные помогают поисковикам и AI понимать контент как набор объектов.</p><h3>Обязательные типы Schema</h3><ul><li><strong>FAQPage</strong> — для секций вопросов-ответов</li><li><strong>HowTo</strong> — для пошаговых инструкций</li><li><strong>Article</strong> — для гайдов и статей</li><li><strong>QAPage</strong> — для одного Q&A (voice search)</li><li><strong>LocalBusiness</strong> — для локальных компаний</li></ul><p>⚠️ Schema должна соответствовать видимому содержимому страницы — несоответствие приведёт к исключению из rich features.</p>',
                        ],
                    ],
                    'takeaways' => [
                        'GEO + AEO = попадание в AI-ответы, не только в SERP.',
                        'Прямой ответ в первом абзаце — для Featured Snippets, Voice и AI.',
                        'JSON-LD обязательна: FAQPage, HowTo, Article, QAPage.',
                        'Voice Search = естественный язык + вопросные форматы.',
                        'Featured Snippets = списки + таблицы + короткие ответы.',
                        'EEAT-сигналы усиливают доверие AI к вашему контенту.',
                    ],
                    'faq' => [
                        ['question' => 'Как ИИ выбирает источник для ответа?', 'answer' => '<p>ИИ анализирует структуру контента, наличие Schema JSON-LD, уникальность данных, авторитетность источника (EEAT) и свежесть информации.</p>'],
                        ['question' => 'Какие Schema типы нужны для AI-видимости?', 'answer' => '<p>Обязательные: Article, FAQPage, HowTo, QAPage. Для локального бизнеса — LocalBusiness. Все должны соответствовать видимому контенту.</p>'],
                        ['question' => 'Что такое zero-click оптимизация?', 'answer' => '<p>Zero-click — это когда пользователь получает ответ прямо на странице поиска, не кликая на сайт. Оптимизация включает short answers, списки, таблицы.</p>'],
                        ['question' => 'Voice SEO — это отдельная стратегия?', 'answer' => '<p>Нет, это часть общей SEO стратегии. Но требует естественного языка, вопросных форматов и коротких ответов — что усиливает и традиционный SEO.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Google AI Overviews Documentation', 'url' => 'https://developers.google.com/search/docs/appearance/ai-overviews'],
                        ['title' => 'Schema.org — Full Type Reference', 'url' => 'https://schema.org/docs/full.html'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите попасть в AI-ответы?',
                        'text' => 'Бесплатный GEO-аудит вашего сайта за 24 часа.',
                        'button' => 'Заказать GEO-аудит',
                    ],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'geo-aeo-ai-optimizatsiya', 'locale' => 'en'],
            [
                'title' => 'GEO & AEO: How to Get Into AI Answers — Complete 2026 Guide',
                'meta_title' => 'GEO / AEO Optimization — AI Answer Engines 2026 | CityEE',
                'meta_description' => 'How to optimize for AI answers: Google SGE, ChatGPT, Perplexity. GEO, AEO, Schema JSON-LD, EEAT, Voice Search optimization guide.',
                'excerpt' => 'Complete guide to GEO (Generative Engine Optimization) and AEO (Answer Engine Optimization) — making your content the answer source for AI systems.',
                'content_blocks' => [
                    'quick_answer' => 'GEO (Generative Engine Optimization) optimizes content so AI systems (Google SGE, ChatGPT, Perplexity) cite your content as their answer source. AEO (Answer Engine Optimization) structures content to provide clear, direct answers to user queries.',
                    'intro' => '<p>In 2026, over 40% of search queries receive AI-generated answers. This means optimizing only for traditional SERP is no longer sufficient. You need a GEO/AEO strategy.</p>',
                    'sections' => [
                        ['heading' => 'What is GEO (Generative Engine Optimization)', 'snippet' => 'GEO optimizes content for inclusion in AI answers from Google SGE, ChatGPT, Perplexity and voice assistants.', 'body' => '<p>GEO is the new meaning of SEO — focused on being cited by AI as the answer source, not just ranking high.</p>'],
                        ['heading' => 'AEO — Answer Engine Optimization', 'snippet' => 'AEO structures content to provide unambiguous, precise answers that AI selects as its response.', 'body' => '<p>AEO is critical because more searches happen through AI assistants and answer carousels.</p>'],
                        ['heading' => 'Voice Search Optimization', 'snippet' => 'Voice SEO uses natural conversational language with question formats (who, what, when, where, how).', 'body' => '<p>Voice Search is about natural conversational language, not just voice commands.</p>'],
                        ['heading' => 'JSON-LD Templates for AI Visibility', 'snippet' => 'Required JSON-LD types: FAQPage, HowTo, Article, QAPage, LocalBusiness. Schema must match visible content.', 'body' => '<p>JSON-LD is the key to AI understanding your site and generating rich results.</p>'],
                    ],
                    'faq' => [
                        ['question' => 'How does AI choose an answer source?', 'answer' => '<p>AI analyzes content structure, Schema JSON-LD presence, data uniqueness, source authority (EEAT) and information freshness.</p>'],
                        ['question' => 'Which Schema types are needed for AI visibility?', 'answer' => '<p>Required: Article, FAQPage, HowTo, QAPage. For local business: LocalBusiness. All must match visible content.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to appear in AI answers?', 'text' => 'Free GEO audit within 24 hours.', 'button' => 'Order GEO Audit'],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'geo-aeo-ai-optimizatsiya', 'locale' => 'et'],
            [
                'title' => 'GEO ja AEO: kuidas pääseda AI vastustesse — täielik juhend 2026',
                'meta_title' => 'GEO / AEO optimeerimine — AI vastused 2026 | CityEE',
                'meta_description' => 'Kuidas optimeerida saiti AI-vastuste jaoks: Google SGE, ChatGPT, Perplexity. GEO, AEO, Schema JSON-LD juhend.',
                'excerpt' => 'Täielik juhend GEO ja AEO kohta — kuidas teha oma sisu AI-süsteemide vastuse allikaks.',
                'content_blocks' => [
                    'quick_answer' => 'GEO optimeerib sisu nii, et AI-süsteemid (Google SGE, ChatGPT) tsiteerivad seda vastuse allikana.',
                    'intro' => '<p>2026. aastal saab üle 40% otsingupäringuid AI-vastuse. See tähendab, et ainult traditsioonilise SERP optimeerimine ei piisa.</p>',
                    'faq' => [
                        ['question' => 'Mis on GEO?', 'answer' => '<p>GEO on sisu optimeerimine generatiivsete AI-süsteemide jaoks.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovid AI-vastustesse pääseda?', 'text' => 'Tasuta GEO-audit 24 tunni jooksul.', 'button' => 'Telli GEO-audit'],
                ],
                'priority' => 0.9,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }

    // ═══════════════════════════════════════════════════════════
    // GUIDE: UX + CWV + Performance
    // ═══════════════════════════════════════════════════════════
    private function seedUxCwvGuide(): void
    {
        Guide::updateOrCreate(
            ['slug' => 'ux-core-web-vitals-2026', 'locale' => 'ru'],
            [
                'title' => 'UX и Core Web Vitals: как UX влияет на SEO в 2026',
                'meta_title' => 'UX + Core Web Vitals — SEO влияние 2026 | CityEE',
                'meta_description' => 'Как UX-параметры влияют на SEO: Core Web Vitals, поведенческие сигналы, доступность, навигация. Полный гайд с чек-листами.',
                'excerpt' => 'SEO и UX — неразрывная связь. Как Core Web Vitals, поведенческие сигналы и юзабилити влияют на ранжирование и AI-приоритизацию.',
                'content_blocks' => [
                    'quick_answer' => 'В 2026 UX напрямую влияет на SEO через Core Web Vitals (LCP < 2.5s, INP < 200ms, CLS < 0.1) и поведенческие сигналы (CTR, bounce rate, время на странице). ИИ отслеживает взаимодействие пользователей для приоритизации контента.',
                    'intro' => '<p>Страницы с быстрым временем загрузки, стабильной версткой и хорошими UX-сигналами ранжируются выше. ИИ тоже отслеживает, каким контентом люди чаще взаимодействуют.</p>',
                    'howto_steps' => [
                        ['name' => 'Оптимизируйте LCP (Largest Contentful Paint)', 'text' => 'Предзагружайте hero image, используйте критический CSS inline, уменьшите размер шрифтов. Цель: < 2.5 секунд.'],
                        ['name' => 'Устраните CLS (Cumulative Layout Shift)', 'text' => 'Задайте width/height для всех изображений, резервируйте пространство для рекламы и динамического контента. Цель: < 0.1.'],
                        ['name' => 'Улучшите INP (Interaction to Next Paint)', 'text' => 'Минимизируйте main thread блокировки, defer тяжёлый JS, разбейте long tasks. Цель: < 200ms.'],
                        ['name' => 'Проведите юзабилити-аудит по Нильсену', 'text' => 'Проверьте: видимость статуса, предотвращение ошибок, гибкость, эстетику, помощь. 10 эвристик.'],
                        ['name' => 'Обеспечьте доступность (a11y)', 'text' => 'Контрастность, alt-тексты, keyboard navigation, skip-nav, ARIA-атрибуты, логическая структура заголовков.'],
                        ['name' => 'Добавьте поведенческие триггеры', 'text' => 'Micro-CTA в секциях, FAQ-интерактив, engagement блоки (вопросы, профиль автора). Повышает CTR и время на странице.'],
                    ],
                    'sections' => [
                        [
                            'heading' => 'Core Web Vitals — таргеты 2026',
                            'snippet' => 'Core Web Vitals 2026: LCP < 2.5s, INP < 200ms, CLS < 0.1. Влияют на SEO-ранжирование и AI-приоритизацию.',
                            'body' => '<table><thead><tr><th>Метрика</th><th>Хорошо</th><th>Нуждается в улучшении</th><th>Плохо</th></tr></thead><tbody><tr><td>LCP</td><td>&lt; 2.5s</td><td>2.5–4.0s</td><td>&gt; 4.0s</td></tr><tr><td>INP</td><td>&lt; 200ms</td><td>200–500ms</td><td>&gt; 500ms</td></tr><tr><td>CLS</td><td>&lt; 0.1</td><td>0.1–0.25</td><td>&gt; 0.25</td></tr></tbody></table>',
                        ],
                        [
                            'heading' => 'Юзабилити-аудит по эвристикам Нильсена',
                            'snippet' => '10 эвристик юзабилити Nielsen-Norman — обязательный чек-лист для UX-аудита любого сайта.',
                            'body' => '<ol><li><strong>Видимость статуса системы</strong> — пользователь знает, где он (breadcrumbs, прогресс)</li><li><strong>Соответствие реальному миру</strong> — знакомый язык, без жаргона</li><li><strong>Свобода и контроль</strong> — кнопки назад, отмена действий</li><li><strong>Последовательность</strong> — единый стиль элементов</li><li><strong>Предотвращение ошибок</strong> — валидация до отправки</li><li><strong>Узнавание, не запоминание</strong> — подсказки, видимые опции</li><li><strong>Гибкость</strong> — горячие клавиши для опытных</li><li><strong>Минимализм</strong> — нет лишней информации</li><li><strong>Помощь при ошибках</strong> — понятные сообщения</li><li><strong>Документация</strong> — помощь доступна</li></ol>',
                        ],
                        [
                            'heading' => 'Доступность (a11y) как UX-показатель',
                            'snippet' => 'Доступность — обязательный параметр UX: контрастность, alt-тексты, keyboard nav, skip-nav, ARIA-атрибуты.',
                            'body' => '<p>Доступность (a11y) — это не только этика, но и SEO-сигнал. Google оценивает accessibility как фактор качества.</p><ul><li>Контрастность текста минимум 4.5:1</li><li>Alt-тексты для всех информативных изображений</li><li>Keyboard navigation для всех интерактивных элементов</li><li>Skip-to-content ссылка</li><li>Логическая структура H1 → H2 → H3</li><li>ARIA-атрибуты для динамических элементов</li></ul>',
                        ],
                        [
                            'heading' => 'Поведенческие UX-сигналы для SEO',
                            'snippet' => 'Высокий CTR, низкий bounce, время на странице > 2 мин, глубина скролла > 75% — ключевые поведенческие сигналы.',
                            'body' => '<h3>UX-Signaling Triggers</h3><ul><li>✔ Высокие CTR сниппеты (Featured Snippets + структурированное мета)</li><li>✔ Низкий bounce rate</li><li>✔ Время на странице > 2 минут</li><li>✔ Скроллы до глубины > 75%</li><li>✔ Положительные поведенческие сигналы</li></ul><p><strong>Совет:</strong> добавьте CTA + микровзаимодействия (FAQ, кнопки, ссылки на профиль автора) — это повышает вовлечение, которое читают Google и AI.</p>',
                            'cta_text' => 'Заказать UX-аудит →',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Как UX влияет на SEO?', 'answer' => '<p>UX влияет через поведенческие факторы: CTR, bounce rate, время на странице. Google и AI используют эти сигналы для ранжирования и приоритизации.</p>'],
                        ['question' => 'Что такое Core Web Vitals?', 'answer' => '<p>Три метрики Google: LCP (скорость загрузки), INP (интерактивность), CLS (визуальная стабильность). Таргеты: LCP < 2.5s, INP < 200ms, CLS < 0.1.</p>'],
                        ['question' => 'Нужна ли доступность для SEO?', 'answer' => '<p>Да! Accessibility — фактор качества для Google. Alt-тексты, семантика заголовков и keyboard nav улучшают и SEO, и UX.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите UX-аудит вашего сайта?',
                        'text' => 'Бесплатный анализ Core Web Vitals + юзабилити за 24 часа.',
                        'button' => 'Заказать UX-аудит',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'ux-core-web-vitals-2026', 'locale' => 'en'],
            [
                'title' => 'UX & Core Web Vitals: How UX Impacts SEO in 2026',
                'meta_title' => 'UX + Core Web Vitals — SEO Impact 2026 | CityEE',
                'meta_description' => 'How UX impacts SEO: Core Web Vitals, behavioral signals, accessibility, navigation. Complete guide with checklists.',
                'excerpt' => 'SEO and UX are inseparable. How Core Web Vitals, behavioral signals and usability affect rankings.',
                'content_blocks' => [
                    'quick_answer' => 'In 2026, UX directly impacts SEO through Core Web Vitals (LCP < 2.5s, INP < 200ms, CLS < 0.1) and behavioral signals (CTR, bounce rate, time on page).',
                    'intro' => '<p>Pages with fast load times, stable layouts and good UX signals rank higher. AI also tracks user engagement for content prioritization.</p>',
                    'howto_steps' => [
                        ['name' => 'Optimize LCP', 'text' => 'Preload hero image, inline critical CSS, optimize fonts. Target: < 2.5 seconds.'],
                        ['name' => 'Eliminate CLS', 'text' => 'Set width/height for all images, reserve space for dynamic content. Target: < 0.1.'],
                        ['name' => 'Improve INP', 'text' => 'Minimize main thread blocking, defer heavy JS. Target: < 200ms.'],
                    ],
                    'faq' => [
                        ['question' => 'How does UX affect SEO?', 'answer' => '<p>UX impacts through behavioral factors: CTR, bounce rate, time on page. Google and AI use these signals for ranking.</p>'],
                        ['question' => 'What are Core Web Vitals?', 'answer' => '<p>Three Google metrics: LCP (loading speed), INP (interactivity), CLS (visual stability). Targets: LCP < 2.5s, INP < 200ms, CLS < 0.1.</p>'],
                    ],
                    'cta' => ['heading' => 'Want a UX audit?', 'text' => 'Free CWV + usability analysis within 24 hours.', 'button' => 'Order UX Audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'ux-core-web-vitals-2026', 'locale' => 'et'],
            [
                'title' => 'UX ja Core Web Vitals: kuidas UX mõjutab SEO-d 2026',
                'meta_title' => 'UX + Core Web Vitals — SEO mõju 2026 | CityEE',
                'meta_description' => 'Kuidas UX mõjutab SEO-d: Core Web Vitals, käitumissignaalid, ligipääsetavus. Täielik juhend checkliste.',
                'excerpt' => 'SEO ja UX on lahutamatud. Kuidas Core Web Vitals ja kasutuskvaliteet mõjutavad rankingut.',
                'content_blocks' => [
                    'quick_answer' => 'UX mõjutab SEO-d otseselt Core Web Vitals (LCP < 2.5s, INP < 200ms, CLS < 0.1) ja käitumissignaalide kaudu.',
                    'intro' => '<p>Kiire laadimisajaga ja stabiilse paigutusega lehed saavad kõrgemad positsioonid.</p>',
                    'faq' => [
                        ['question' => 'Kuidas UX mõjutab SEO-d?', 'answer' => '<p>UX mõjutab käitumistegurite kaudu: CTR, põrkemäär, lehel viibimise aeg.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovid UX-auditi?', 'text' => 'Tasuta analüüs 24 tunni jooksul.', 'button' => 'Telli UX-audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }

    // ═══════════════════════════════════════════════════════════
    // GUIDE: EEAT — Experience, Expertise, Authoritativeness, Trust
    // ═══════════════════════════════════════════════════════════
    private function seedEeatGuide(): void
    {
        Guide::updateOrCreate(
            ['slug' => 'eeat-ekspertiza-doverie-2026', 'locale' => 'ru'],
            [
                'title' => 'EEAT в 2026: как построить доверие для Google и AI',
                'meta_title' => 'EEAT — доверие и экспертиза для SEO 2026 | CityEE',
                'meta_description' => 'EEAT (Experience, Expertise, Authoritativeness, Trustworthiness) — ключевой фактор SEO 2026. Как усилить сигналы доверия для Google и AI.',
                'excerpt' => 'EEAT стал основным сигналом качества в 2026. Как авторитет, экспертиза и доверие влияют на ранжирование и AI-цитирование.',
                'content_blocks' => [
                    'quick_answer' => 'EEAT (Experience, Expertise, Authoritativeness, Trustworthiness) — основной сигнал качества для Google и AI в 2026. Включает: реальный опыт автора, экспертные credentials, авторитетные ссылки и прозрачные подтверждения компетенции.',
                    'intro' => '<p>В 2026 году SEO стало бренд-ориентированным. Google и AI уделяют возрастающее внимание EEAT-сигналам. Алгоритмы учитывают не только информацию на странице, но её достоверность, авторитет источника и профессиональную репутацию.</p>',
                    'sections' => [
                        [
                            'heading' => 'Experience — реальный опыт',
                            'snippet' => 'Google ценит контент от авторов с реальным, подтверждённым опытом в теме.',
                            'body' => '<p>Секция "Experience" — это демонстрация того, что автор имеет практический опыт. Для недвижимости: количество сделок, стаж работы, реальные кейсы.</p><ul><li>Указание стажа: "18+ лет на рынке"</li><li>Конкретные цифры: "300+ успешных сделок"</li><li>Кейсы с результатами</li><li>Фото работы, объектов, встреч</li></ul>',
                        ],
                        [
                            'heading' => 'Expertise — экспертиза',
                            'snippet' => 'Экспертиза подтверждается авторскими credentials, цитатами, статистикой и аналитикой.',
                            'body' => '<p>Кодируйте в контенте:</p><ul><li>Автор с подтверждённым опытом (имя, должность, credentials)</li><li>Фактические данные и статистика</li><li>Уникальные инсайты и аналитика рынка</li><li>Профессиональные сертификаты и лицензии</li></ul>',
                        ],
                        [
                            'heading' => 'Authoritativeness — авторитетность',
                            'snippet' => 'Авторитетность = качественные обратные ссылки + цитирование другими экспертами + внешний контекст.',
                            'body' => '<p>ИИ-системы используют внешний контекст (другие авторитетные источники), поэтому ссылки — не "SEO для ссылок", а реальные авторитетные источники → сильный сигнал доверия.</p><h3>Стратегия обратных ссылок</h3><ul><li>Контент-маркетинг (гайды, исследования)</li><li>PR и экспертные комментарии</li><li>Партнёрства с отраслевыми порталами</li><li>Guest content на авторитетных ресурсах</li></ul>',
                        ],
                        [
                            'heading' => 'Trustworthiness — доверие',
                            'snippet' => 'Доверие = прозрачность, отзывы клиентов, SSL, контактная информация, политика конфиденциальности.',
                            'body' => '<p>Компоненты доверия:</p><ul><li>Отзывы реальных клиентов с именами</li><li>Рейтинг и агрегированные оценки (schema AggregateRating)</li><li>Полная контактная информация</li><li>SSL сертификат и HTTPS</li><li>Прозрачная политика конфиденциальности</li></ul>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Что такое EEAT?', 'answer' => '<p>EEAT — Experience, Expertise, Authoritativeness, Trustworthiness. Четыре компонента оценки качества контента алгоритмами Google и AI.</p>'],
                        ['question' => 'Как быстро усилить EEAT-сигналы?', 'answer' => '<p>Добавьте авторскую био с credentials, ссылки на авторитетные источники, отзывы клиентов, AggregateRating schema и актуальные данные.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите усилить EEAT вашего сайта?',
                        'text' => 'Бесплатный аудит сигналов доверия.',
                        'button' => 'Заказать EEAT-аудит',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'eeat-ekspertiza-doverie-2026', 'locale' => 'en'],
            [
                'title' => 'EEAT in 2026: How to Build Trust for Google and AI',
                'meta_title' => 'EEAT — Trust & Expertise for SEO 2026 | CityEE',
                'meta_description' => 'EEAT (Experience, Expertise, Authoritativeness, Trustworthiness) — the key SEO factor in 2026. How to strengthen trust signals.',
                'excerpt' => 'EEAT is the primary quality signal in 2026. How authority, expertise and trust affect ranking and AI citations.',
                'content_blocks' => [
                    'quick_answer' => 'EEAT (Experience, Expertise, Authoritativeness, Trustworthiness) is the primary quality signal for Google and AI in 2026.',
                    'intro' => '<p>SEO in 2026 has become brand-oriented. Google and AI pay increasing attention to EEAT signals.</p>',
                    'faq' => [
                        ['question' => 'What is EEAT?', 'answer' => '<p>Experience, Expertise, Authoritativeness, Trustworthiness — four components of content quality assessment by Google and AI.</p>'],
                    ],
                    'cta' => ['heading' => 'Strengthen your EEAT?', 'text' => 'Free trust signal audit.', 'button' => 'Order EEAT Audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'eeat-ekspertiza-doverie-2026', 'locale' => 'et'],
            [
                'title' => 'EEAT 2026: kuidas ehitada usaldust Google ja AI jaoks',
                'meta_title' => 'EEAT — usaldus ja ekspertiis 2026 | CityEE',
                'meta_description' => 'EEAT — peamine kvaliteedisignaal SEO 2026. Kuidas tugevdada usaldusväärsuse signaale.',
                'excerpt' => 'EEAT on 2026 peamine kvaliteedisignaal.',
                'content_blocks' => [
                    'quick_answer' => 'EEAT on peamine kvaliteedisignaal Google ja AI jaoks 2026. aastal.',
                    'intro' => '<p>SEO 2026 on brändi-orienteeritud. Google ja AI pööravad üha enam tähelepanu EEAT-signaalidele.</p>',
                    'faq' => [
                        ['question' => 'Mis on EEAT?', 'answer' => '<p>Experience, Expertise, Authoritativeness, Trustworthiness — neli sisu kvaliteedi hindamise komponenti.</p>'],
                    ],
                    'cta' => ['heading' => 'Tugevda EEAT?', 'text' => 'Tasuta audit.', 'button' => 'Telli EEAT-audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }

    // ═══════════════════════════════════════════════════════════
    // GUIDE: How to Sell Property in Tallinn (existing, preserved)
    // ═══════════════════════════════════════════════════════════
    private function seedSellGuide(): void
    {
        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'ru'],
            [
                'title' => 'Как продать недвижимость в Таллинне — полное руководство 2025',
                'meta_title' => 'Как продать недвижимость в Таллинне 2025 | CityEE Гид',
                'meta_description' => 'Профессиональное руководство по продаже недвижимости в Таллинне: ценообразование, подготовка, переговоры. Александр Примаков, 18+ лет.',
                'excerpt' => 'Пошаговое руководство по успешной продаже недвижимости в Таллинне и Харьюмаа.',
                'content_blocks' => [
                    'quick_answer' => 'Для успешной продажи недвижимости в Таллинне: оцените реальную рыночную цену (сравнительный метод), подготовьте объект (фото + staging), запустите мультиканальный маркетинг и работайте с профессиональным маклером для переговоров. Средний срок продажи: 30-45 дней.',
                    'intro' => '<p>Продажа недвижимости в Таллинне требует профессионального подхода. В этом руководстве делюсь опытом 18+ лет.</p>',
                    'howto_steps' => [
                        ['name' => 'Определите рыночную цену', 'text' => 'Используйте сравнительный метод: анализ сделок за последние 6 месяцев в вашем районе. Переоценка > 10% = потеря "золотого окна" первых 14 дней.'],
                        ['name' => 'Подготовьте объект', 'text' => 'Профессиональная фотосъёмка + home staging. Инвестиция 200-500 €, результат — тысячи.'],
                        ['name' => 'Запустите маркетинг', 'text' => 'KV.ee, City24, соцсети + прямой маркетинг из базы 500+ покупателей.'],
                        ['name' => 'Проведите переговоры', 'text' => 'Стратегия: разумная стартовая цена → интерес → несколько предложений. Результат: 97-103% рынка.'],
                    ],
                    'sections' => [
                        [
                            'heading' => '1. Определение рыночной цены',
                            'snippet' => 'Правильное ценообразование — основа успешной продажи. 95% покупателей ищут через порталы.',
                            'body' => '<p>Правильная цена — фундамент. Переоценка на >10% означает потерю "золотого окна" первых 14 дней.</p>',
                            'cta_text' => 'Получить оценку →',
                        ],
                        [
                            'heading' => '2. Подготовка объекта',
                            'body' => '<p>Профессиональная фотосъёмка и home staging повышают привлекательность на 30-40%.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Сколько времени занимает продажа в Таллинне?', 'answer' => '<p>Правильно оценённый объект продаётся за 30-45 дней. Переоценённые стоят 90-180 дней.</p>'],
                        ['question' => 'Какова комиссия маклера?', 'answer' => '<p>CityEE: 2-3% от сделки (минимум 2000 €). Оплата только при успехе.</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите продать по лучшей цене?', 'text' => 'Бесплатная консультация за 24 часа.', 'button' => 'Получить консультацию'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'en'],
            [
                'title' => 'How to Sell Property in Tallinn — Complete Guide 2025',
                'meta_title' => 'How to Sell Property in Tallinn 2025 | CityEE Guide',
                'meta_description' => 'Professional guide to selling property in Tallinn: pricing, preparation, negotiations. Aleksandr Primakov, 18+ years.',
                'excerpt' => 'Step-by-step guide to successfully selling property in Tallinn & Harjumaa.',
                'content_blocks' => [
                    'quick_answer' => 'To sell property in Tallinn successfully: assess real market value, prepare the property (photos + staging), launch multi-channel marketing, negotiate with a professional broker. Average selling time: 30-45 days.',
                    'intro' => '<p>Selling property in Tallinn requires a professional approach. 18+ years of experience shared here.</p>',
                    'howto_steps' => [
                        ['name' => 'Assess Market Price', 'text' => 'Use the comparative method: analyze transactions from the last 6 months. Overpricing >10% = losing the golden window.'],
                        ['name' => 'Prepare Property', 'text' => 'Professional photography + home staging. Investment €200-500, returns thousands.'],
                        ['name' => 'Launch Marketing', 'text' => 'KV.ee, City24, social media + direct marketing from 500+ buyer database.'],
                        ['name' => 'Negotiate', 'text' => 'Strategy: reasonable start price → interest → multiple offers. Result: 97-103% of market.'],
                    ],
                    'faq' => [
                        ['question' => 'How long to sell in Tallinn?', 'answer' => '<p>Properly priced: 30-45 days. Overpriced: 90-180 days.</p>'],
                        ['question' => 'What is broker commission?', 'answer' => '<p>CityEE: 2-3% (minimum €2,000). Payment only on success.</p>'],
                    ],
                    'cta' => ['heading' => 'Sell at the best price?', 'text' => 'Free consultation within 24 hours.', 'button' => 'Get Consultation'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'et'],
            [
                'title' => 'Kuidas müüa kinnisvara Tallinnas — täielik juhend 2025',
                'meta_title' => 'Kuidas müüa kinnisvara Tallinnas 2025 | CityEE',
                'meta_description' => 'Professionaalne juhend kinnisvara müügiks Tallinnas. Aleksandr Primakov, 18+ aastat.',
                'excerpt' => 'Samm-sammuline juhend eduka kinnisvara müügi jaoks Tallinnas.',
                'content_blocks' => [
                    'quick_answer' => 'Edukaks müügiks Tallinnas: hinnake reaalne turuhind, valmistage objekt ette (fotod + staging), käivitage turundus mitmekanaliliselt.',
                    'intro' => '<p>Kinnisvara müük Tallinnas nõuab professionaalset lähenemist. 18+ aastat kogemust.</p>',
                    'howto_steps' => [
                        ['name' => 'Määrake turuhind', 'text' => 'Kasutage võrdlusmeetodit: analüüsige viimase 6 kuu tehinguid.'],
                        ['name' => 'Valmistage objekt ette', 'text' => 'Professionaalne pildistamine + home staging.'],
                        ['name' => 'Käivitage turundus', 'text' => 'KV.ee, City24, sotsiaalmeedia + otseturundus.'],
                    ],
                    'faq' => [
                        ['question' => 'Kui kaua müük kestab?', 'answer' => '<p>Õige hinnaga: 30-45 päeva.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovid müüa?', 'text' => 'Tasuta konsultatsioon.', 'button' => 'Soovin konsultatsiooni'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }

    // ═══════════════════════════════════════════════════════════
    // AREA AUDIT: Kesklinn / Tallinn City Centre (preserved from original)
    // ═══════════════════════════════════════════════════════════
    private function seedKesklinnAudit(): void
    {
        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'ru'],
            [
                'title' => 'Аудит недвижимости: Таллинн Кесклинн — анализ рынка 2025',
                'meta_title' => 'Кесклинн Таллинн аудит недвижимости 2025 | CityEE',
                'meta_description' => 'Аудит рынка Tallinn Кесклинн: медианные цены, динамика, прогноз. Экспертный анализ Александра Примакова.',
                'excerpt' => 'Полный анализ рынка недвижимости Таллинна Кесклинн.',
                'content_blocks' => [
                    'summary' => '<p>Кесклинн — премиальный сегмент. Q1 2025: медиана 3200 €/м², 42 дня, активный спрос на 2-3-комнатные.</p>',
                    'market_data' => '<ul><li><strong>Медиана:</strong> 3200 €/м²</li><li><strong>Динамика:</strong> +5.2% г/г</li><li><strong>Среднее время:</strong> 42 дня</li><li><strong>Доходность:</strong> 5.1-6.3% брутто</li></ul>',
                    'sections' => [
                        ['heading' => 'Стратегия продажи', 'body' => '<p>Мультиязычный маркетинг (3 языка) покрывает 100% аудитории.</p>'],
                    ],
                    'faq' => [
                        ['question' => 'Средняя цена в Кесклинне?', 'answer' => '<p>Медиана 3200 €/м². Новостройки 4500-6000 €/м².</p>'],
                    ],
                    'cta' => ['heading' => 'Продать в Кесклинне?', 'text' => 'Бесплатный анализ.', 'button' => 'Заказать аудит'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'en'],
            [
                'title' => 'Property Audit: Tallinn City Centre — Market Analysis 2025',
                'meta_title' => 'Tallinn City Centre Audit 2025 | CityEE',
                'meta_description' => 'Tallinn City Centre market audit: prices, dynamics, forecast. Expert analysis.',
                'excerpt' => 'Comprehensive Tallinn City Centre property market analysis.',
                'content_blocks' => [
                    'summary' => '<p>City Centre: premium segment. Median €3,200/m², 42 days, strong demand for 2-3 bed.</p>',
                    'faq' => [
                        ['question' => 'Average price in City Centre?', 'answer' => '<p>Median €3,200/m². New builds €4,500-6,000/m².</p>'],
                    ],
                    'cta' => ['heading' => 'Sell in City Centre?', 'text' => 'Free analysis.', 'button' => 'Order Audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'et'],
            [
                'title' => 'Kinnisvara audit: Tallinn Kesklinn — turuanalüüs 2025',
                'meta_title' => 'Kesklinn Tallinn audit 2025 | CityEE',
                'meta_description' => 'Tallinna Kesklinna turu audit: hinnad, dünaamika, prognoos.',
                'excerpt' => 'Põhjalik Kesklinna turuanalüüs.',
                'content_blocks' => [
                    'summary' => '<p>Kesklinn: premium-segment. Mediaan 3200 €/m², 42 päeva, aktiivne nõudlus.</p>',
                    'faq' => [
                        ['question' => 'Keskmine hind Kesklinnas?', 'answer' => '<p>Mediaan 3200 €/m². Uusarendused 4500-6000 €/m².</p>'],
                    ],
                    'cta' => ['heading' => 'Müüa Kesklinnas?', 'text' => 'Tasuta analüüs.', 'button' => 'Telli audit'],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }
}
