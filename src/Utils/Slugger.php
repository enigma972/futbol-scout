<?php

namespace App\Utils;

/**
 * @author Joel Lusavuvu <lusavuvujoel39@gmail.com>
 */
class Slugger
{
    public static function slugify(string $string, string $replacement): string
    {
        return preg_replace('/\s+/', $replacement, mb_strtolower(trim(strip_tags($string)), 'UTF-8'));
    }
}
