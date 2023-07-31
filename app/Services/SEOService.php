<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;

class SEOService
{
    /**
     * Generate a SEO meta description from HTML content.
     *
     * @param  string  $htmlContent
     * @return string
     */
    public static function generateFromHtml(string $htmlContent): string
    {
        return strip_tags(Str::limit($htmlContent, 160));
    }
}
