<?php

use Alksily\Support\Crypta;
use Alksily\Support\Form;
use Alksily\Support\Str;

if (!function_exists('pre')) {
    /**
     * Function wrapper around var_dump for debugging
     *
     * @param mixed ...$args
     */
    function pre(...$args)
    {
        echo '<pre>';
        foreach ($args as $obj) {
            var_dump($obj);
        }
        echo '</pre>';
    }
}

if (!function_exists('str_after')) {
    /**
     * Return the remainder of a string after a given value.
     *
     * @param string $subject
     * @param string $search
     *
     * @return string
     */
    function str_after(string $subject, string $search): string
    {
        return Str::after($subject, $search);
    }
}

if (!function_exists('str_before')) {
    /**
     * Get the portion of a string before a given value.
     *
     * @param string $subject
     * @param string $search
     *
     * @return string
     */
    function str_before(string $subject, string $search): string
    {
        return Str::before($subject, $search);
    }
}

if (!function_exists('str_contains')) {
    /**
     * Determine if a given string contains a given substring.
     *
     * @param string       $haystack
     * @param array|string $needles
     *
     * @return bool
     */
    function str_contains(string $haystack, array|string $needles): bool
    {
        return Str::contains($haystack, $needles);
    }
}

if (!function_exists('str_starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string       $haystack
     * @param array|string $needles
     *
     * @return bool
     */
    function str_starts_with(string $haystack, array|string $needles): bool
    {
        return Str::start($haystack, $needles);
    }
}

if (!function_exists('str_ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string       $haystack
     * @param array|string $needles
     *
     * @return bool
     */
    function str_ends_with(string $haystack, array|string $needles): bool
    {
        return Str::end($haystack, $needles);
    }
}

if (!function_exists('str_truncate')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param string $value
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    function str_truncate(string $value, int $limit = 100, string $end = '...'): string
    {
        return Str::truncate($value, $limit, $end);
    }
}

if (!function_exists('str_eos')) {
    /**
     * Slope of the word, depending on the number
     *
     * @param int    $count
     * @param string $one
     * @param string $two
     * @param string $five
     *
     * @return string
     */
    function str_eos(int $count, string $one, string $two, string $five): string
    {
        return Str::eos($count, $one, $two, $five);
    }
}

if (!function_exists('str_title_case')) {
    /**
     * Convert a value to title case.
     *
     * @param string $value
     *
     * @return string
     */
    function str_title_case(string $value): string
    {
        return Str::title($value);
    }
}

if (!function_exists('str_escape')) {
    /**
     * Escape a string or an array of strings
     *
     * @param array|string $input
     *
     * @return array|string;
     */
    function str_escape(array|string $input): array|string
    {
        return Str::escape($input);
    }
}

if (!function_exists('str_un_escape')) {
    /**
     * Remove the screening in a row or an array of strings
     *
     * @param array|string $input
     *
     * @return array|string;
     */
    function str_un_escape(array|string $input): array|string
    {
        return Str::unEscape($input);
    }
}

if (!function_exists('str_convert_size')) {
    /**
     * Returns a string representation of the data size
     *
     * @param int $size
     *
     * @return string
     */
    function str_convert_size(int $size): string
    {
        return Str::convertSize($size);
    }
}

if (!function_exists('form')) {
    /**
     * Generate HTML5 form
     *
     * @param string $type
     * @param string $name
     * @param array  $args
     *
     * @return string
     */
    function form(string $type, string $name, array $args = []): string
    {
        return Form::__callStatic($type, [$name, $args]);
    }
}

if (!function_exists('crypta_encrypt')) {
    /**
     * Encrypt transmitted string
     *
     * @param string $input
     * @param string $secret
     *
     * @return string
     */
    function crypta_encrypt(string $input, string $secret = ''): string
    {
        return Crypta::encrypt($input, $secret);
    }
}

if (!function_exists('crypta_decrypt')) {
    /**
     * Decrypt passed string
     *
     * @param string $input
     * @param string $secret
     *
     * @return string
     */
    function crypta_decrypt(string $input, string $secret = ''): string
    {
        return Crypta::decrypt($input, $secret);
    }
}

if (!function_exists('crypta_hash')) {
    /**
     * Generate hash sum for a row
     *
     * @param string $string
     * @param string $secret
     *
     * @return string
     */
    function crypta_hash(string $string, string $secret = ''): string
    {
        return Crypta::hash($string, $secret);
    }
}

if (!function_exists('crypta_hash_check')) {
    /**
     * Check string against the hash sum
     *
     * @param string $string
     * @param string $hashString
     *
     * @return bool
     */
    function crypta_hash_check(string $string, string $hashString): bool
    {
        return Crypta::check($string, $hashString);
    }
}
