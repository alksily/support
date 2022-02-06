<?php

namespace Alksily\Support;

use Alksily\Support\Traits\Macroable;

class Crypta
{
    use Macroable;

    /**
     * Encrypt transmitted string
     *
     * @param string $input
     * @param string $secret
     *
     * @return string
     */
    public static function encrypt(string $input, string $secret = ''): string
    {
        return base64_encode(static::crypt($input, $secret));
    }

    /**
     * Decrypt passed string
     *
     * @param string $input
     * @param string $secret
     *
     * @return string
     */
    public static function decrypt(string $input, string $secret = ''): string
    {
        return static::crypt(base64_decode($input), $secret);
    }

    /**
     * Helper method to work with a string line
     *
     * @param string $input
     * @param string $secret
     *
     * @return string
     */
    protected static function crypt(string $input, string $secret): string
    {
        $salt = md5($secret);
        $len = mb_strlen($input);
        $gamma = '';
        $n = $len > 100 ? 8 : 2;
        while (mb_strlen($gamma) < $len) {
            $gamma .= substr(pack('H*', sha1($gamma . $salt)), 0, $n);
        }

        return $input ^ $gamma;
    }

    /**
     * Generate hash sum for a row
     *
     * @param string $string
     * @param string $secret
     *
     * @return string
     */
    public static function hash(string $string, string $secret = ''): string
    {
        $salt = substr(hash('whirlpool', uniqid(mt_rand() . $secret, true)), 0, 12);
        $hash = hash('whirlpool', $salt . $string);
        $saltPos = min(mb_strlen($string), mb_strlen($hash));

        return substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
    }

    /**
     * Check string against the hash sum
     *
     * @param string $string
     * @param string $hashString
     *
     * @return bool
     */
    public static function check(string $string, string $hashString): bool
    {
        $saltPos = min(mb_strlen($string), mb_strlen($hashString));
        $salt = substr($hashString, $saltPos, 12);
        $hash = hash('whirlpool', $salt . $string);

        return $hashString == substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
    }

}
