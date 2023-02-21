<?php

namespace Alksily\Support;

use Alksily\Support\Traits\Macroable;

class Str
{
    use Macroable;

    /**
     * It is safe to truncate to the specified value, without losing the last word
     *
     * @param string $value
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    public static function truncate(string $value, int $limit, string $end = '...'): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

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
    public static function eos(int $count, string $one, string $two, string $five): string
    {
        if (str_ends_with($count, '1') && !str_ends_with($count, '11')) {
            return $one;
        } else {
            if (substr($count, -2, 1) != 1 && substr($count, -1, 1) > 1 && substr($count, -1, 1) < 5) {
                return $two;
            } else {
                return $five;
            }
        }
    }

    /**
     * Convert Arabic number to Roman
     *
     * @param integer $int
     *
     * @return string
     */
    public static function int2roman(int $int): string
    {
        $romanNumerals = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        $result = '';
        foreach ($romanNumerals as $roman => $number) {
            $result .= str_repeat($roman, intval($int / $number));
            $int = $int % $number;
        }

        return $result;
    }

    /**
     * Returns a string representation of the data size
     *
     * @param int $size
     *
     * @return string
     */
    public static function convertSize(int $size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[(int) $i];
    }
}
