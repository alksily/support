<?php

use Alksily\Support\Crypta;
use Alksily\Support\Form;
use Alksily\Support\Str;

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
