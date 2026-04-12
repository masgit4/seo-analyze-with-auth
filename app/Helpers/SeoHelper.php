<?php

namespace App\Helpers;

class SeoHelper
{
    public static function checkHttps($url)
    {
        return str_starts_with($url, 'https');
    }

    public static function checkSitemap($url)
    {
        return @file_get_contents($url . '/sitemap.xml') ? true : false;
    }

    public static function checkRobots($url)
    {
        return @file_get_contents($url . '/robots.txt') ? true : false;
    }

    public static function keywordDensity($html, $keyword)
    {
        if (!$keyword) return 0;

        $text = strtolower(strip_tags($html));
        $words = str_word_count($text, 1);

        if (count($words) === 0) return 0;

        $count = substr_count($text, strtolower($keyword));
        return ($count / count($words)) * 100;
    }
}
