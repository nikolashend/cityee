<?php

namespace App\Support;

/**
 * Build JSON-LD structured data for CityEE pages.
 *
 * Master Entity Graph:
 *   #organization  — RealEstateAgent / Organization / LocalBusiness
 *   #aleksandr     — Person (founder)
 *   #website       — WebSite
 *   #sell-service, #rent-service, #consultation-service, #audit-service — Service nodes
 */
class Schema
{
    /**
     * Organization + RealEstateAgent + LocalBusiness base JSON-LD.
     */
    public static function orgJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => ['Organization', 'RealEstateAgent', 'LocalBusiness'],
            '@id'      => 'https://cityee.ee/#organization',
            'name'     => 'CityEE',
            'legalName' => 'CITY EE OÜ',
            'alternateName' => ['CITY EE OÜ', 'CityEE Kinnisvara', 'СитиЕЕ'],
            'description' => 'Real estate deal optimization partner in Tallinn & Harjumaa — property sale strategy, rental management, market audit and negotiation.',
            'url'      => 'https://cityee.ee',
            'logo'     => [
                '@type'    => 'ImageObject',
                'url'      => 'https://cityee.ee/assets/templates/offshors/img/logo.png',
                'width'    => 200,
                'height'   => 60,
            ],
            'image' => 'https://cityee.ee/assets/templates/offshors/img/about-foto.jpg',
            'telephone' => '+3725113411',
            'email'     => 'info@cityee.ee',
            'address'   => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Viru väljak 2',
                'addressLocality' => 'Tallinn',
                'postalCode'      => '10111',
                'addressRegion'   => 'Harjumaa',
                'addressCountry'  => 'EE',
            ],
            'geo' => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => 59.4361,
                'longitude' => 24.7537,
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'Estonia'],
                ['@type' => 'City',  'name' => 'Tallinn'],
                ['@type' => 'AdministrativeArea', 'name' => 'Harjumaa'],
            ],
            'foundingDate' => '2014',
            'priceRange'   => '€€',
            'currenciesAccepted' => 'EUR',
            'paymentAccepted' => 'Bank Transfer, Invoice',
            'openingHours' => 'Mo-Su 10:00-22:00',
            'openingHoursSpecification' => [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
                'opens'     => '10:00',
                'closes'    => '22:00',
            ],
            'sameAs' => [
                'https://www.instagram.com/cityee_ee',
                'https://www.linkedin.com/in/kinnisvaramaakler/',
                'https://www.facebook.com/cityee.ee',
                'https://www.threads.com/@cityee_ee',
                'https://t.me/cityee_tallinn',
            ],
            'founder'  => ['@id' => 'https://cityee.ee/#aleksandr'],
            'employee' => [['@id' => 'https://cityee.ee/#aleksandr']],
            'numberOfEmployees' => [
                '@type'    => 'QuantitativeValue',
                'value'    => 1,
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => 'Real Estate Services',
                'itemListElement' => [
                    ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://cityee.ee/#sell-service']],
                    ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://cityee.ee/#rent-service']],
                    ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://cityee.ee/#consultation-service']],
                    ['@type' => 'Offer', 'itemOffered' => ['@id' => 'https://cityee.ee/#audit-service']],
                ],
            ],
            'contactPoint' => [
                '@type'             => 'ContactPoint',
                'telephone'         => '+3725113411',
                'contactType'       => 'customer service',
                'availableLanguage' => ['Estonian', 'Russian', 'English'],
                'areaServed'        => 'EE',
            ],
            'knowsLanguage' => ['et', 'ru', 'en'],
            'knowsAbout' => [
                'Property sale strategy in Tallinn & Harjumaa',
                'Tallinn real estate market analysis',
                'Harjumaa property valuation',
                'Real estate negotiation strategy',
                'Property audit and market valuation',
                'Rental market analysis in Tallinn',
                'Real estate deal optimization',
            ],
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => '5.0',
                'bestRating'  => '5',
                'worstRating' => '1',
                'ratingCount' => '12',
            ],
        ];
    }

    /**
     * Person JSON-LD for Aleksandr Primakov (AI entity anchor).
     *
     * Covers: name, jobTitle (array), worksFor, image, url,
     * knowsLanguage, knowsAbout, areaServed, sameAs, credentials.
     */
    public static function personJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'Person',
            '@id'      => 'https://cityee.ee/#aleksandr',
            'name'     => 'Aleksandr Primakov',
            'jobTitle' => [
                'Real Estate Agent',
                'Property Sales Strategist',
                'Real Estate Deal Optimization Partner',
            ],
            'worksFor' => ['@id' => 'https://cityee.ee/#organization'],
            'memberOf' => ['@id' => 'https://cityee.ee/#organization'],
            'email'    => 'aleksandr@cityee.ee',
            'telephone' => '+3725113411',
            'image'    => 'https://cityee.ee/assets/templates/offshors/img/ap1.png',
            'url'      => 'https://cityee.ee/aleksandr-primakov/',
            'sameAs'   => [
                'https://www.instagram.com/cityee_ee',
                'https://www.linkedin.com/in/kinnisvaramaakler/',
                'https://www.facebook.com/cityee.ee',
                'https://www.threads.com/@cityee_ee',
                'https://t.me/cityee_tallinn',
            ],
            'knowsAbout' => [
                'Apartment sales in Tallinn',
                'Rental management in Tallinn',
                'Property pricing and market analysis',
                'Real estate negotiation strategy',
                'Listing audit and deal optimization',
                'District-level pricing in Tallinn',
                'Tallinn & Harjumaa real estate market',
            ],
            'knowsLanguage' => ['et', 'ru', 'en'],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Tallinn'],
                ['@type' => 'AdministrativeArea', 'name' => 'Harjumaa'],
            ],
            'hasCredential' => [
                [
                    '@type' => 'EducationalOccupationalCredential',
                    'credentialCategory' => 'Professional Experience',
                    'name' => '10+ years in Tallinn & Harjumaa real estate market',
                ],
            ],
        ];
    }

    /**
     * Speakable specification for AI/SGE — targets key content blocks.
     * Returns a <script> JSON-LD tag with SpeakableSpecification inside a WebPage.
     * Uses @id reference so Google merges it with any other WebPage on the page.
     */
    public static function speakable(string $url): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebPage',
            '@id'      => $url . '#webpage',
            'url'      => $url,
            'isPartOf' => ['@id' => 'https://cityee.ee/#website'],
            'about'    => ['@id' => 'https://cityee.ee/#organization'],
            'speakable' => [
                '@type'       => 'SpeakableSpecification',
                'cssSelector' => [
                    '.ai-summary',
                    '.ai-summary-box',
                    '.phase3-ai-answer',
                    '.guide-quick-answer',
                    '.guide-takeaways-box',
                    '.page-title__name',
                    '.banners__title',
                    '.intent-hero-summary',
                    '.zero-click-card',
                ],
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * WebSite + SearchAction JSON-LD (global, every page).
     */
    public static function webSiteJsonLd(): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            '@id'      => 'https://cityee.ee/#website',
            'name'     => 'CityEE',
            'url'      => 'https://cityee.ee',
            'publisher' => ['@id' => 'https://cityee.ee/#organization'],
            'inLanguage' => ['et', 'ru', 'en'],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => 'https://cityee.ee/guides?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
