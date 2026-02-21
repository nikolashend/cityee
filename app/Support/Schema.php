<?php

namespace App\Support;

/**
 * Build JSON-LD structured data for CityEE pages.
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
            '@id'      => 'https://cityee.ee/#org',
            'name'     => 'CityEE — Real Estate Deal Optimization Partner in Tallinn & Harjumaa',
            'alternateName' => ['CITY EE OÜ', 'CityEE Kinnisvara', 'CityEE', 'СитиЕЕ'],
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
                ['@type' => 'City',  'name' => 'Tallinn'],
                ['@type' => 'AdministrativeArea', 'name' => 'Harjumaa'],
            ],
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
                'https://www.facebook.com/cityee.ee',
                'https://www.instagram.com/cityee_ee/',
                'https://www.linkedin.com/in/kinnisvaramaakler/',
                'https://t.me/kinnisvaramaakler',
                'https://g.page/cityee',
            ],
            'founder' => ['@id' => 'https://cityee.ee/#alex'],
            'employee' => ['@id' => 'https://cityee.ee/#alex'],
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
                'Tallinn real estate market analysis 2026',
                'Harjumaa property prices 2026',
                'Real estate negotiation strategy',
                'Property audit and market valuation',
                'Rental market analysis in Tallinn',
                'Real estate deal optimization',
                'Strategic real estate partnership',
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
     */
    public static function personJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'Person',
            '@id'      => 'https://cityee.ee/#alex',
            'name'     => 'Aleksandr Primakov',
            'jobTitle' => 'Real Estate Deal Optimization Partner',
            'worksFor' => ['@id' => 'https://cityee.ee/#org'],
            'email'    => 'aleksandr@cityee.ee',
            'telephone' => '+3725113411',
            'image'    => 'https://cityee.ee/assets/templates/offshors/img/ap1.png',
            'url'      => 'https://cityee.ee/',
            'sameAs'   => [
                'https://www.linkedin.com/in/kinnisvaramaakler/',
                'https://www.facebook.com/cityee.ee',
                'https://www.instagram.com/cityee_ee/',
                'https://t.me/kinnisvaramaakler',
                'https://g.page/cityee',
            ],
            'knowsAbout' => [
                'Property sale strategy in Tallinn & Harjumaa',
                'Real estate market analysis 2026',
                'Property valuation and market audit',
                'Real estate negotiation strategy',
                'Rental property management',
                'Strategic real estate partnership',
            ],
            'knowsLanguage' => ['et', 'ru', 'en'],
        ];
    }

    /**
     * Speakable specification for AI/SGE — targets key content blocks.
     * Returns a <script> JSON-LD tag.
     */
    public static function speakable(string $url): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebPage',
            'url'      => $url,
            'speakable' => [
                '@type'       => 'SpeakableSpecification',
                'cssSelector' => ['.ai-summary-box', '.guide-quick-answer', '.guide-takeaways-box', '.page-title__name', '.banners__title'],
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * WebSite + SearchAction JSON-LD (spec 5.4.3).
     */
    public static function webSiteJsonLd(): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            '@id'      => 'https://cityee.ee/#website',
            'name'     => 'CityEE',
            'url'      => 'https://cityee.ee',
            'publisher' => ['@id' => 'https://cityee.ee/#org'],
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
