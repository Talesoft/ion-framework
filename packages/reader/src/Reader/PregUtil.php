<?php
declare(strict_types=1);

namespace Ion\Reader;

class PregUtil
{

    private static $errorTexts = [
        'default' => 'Unknown error',
        PREG_NO_ERROR => 'No error occured',
        PREG_INTERNAL_ERROR => 'An internal error occured',
        PREG_BACKTRACK_LIMIT_ERROR => 'The backtrack limit was exhausted (Increase pcre.backtrack_limit in php.ini)',
        PREG_RECURSION_LIMIT_ERROR => 'Recursion limit was exhausted (Increase pcre.recursion_limit in php.ini)',
        PREG_BAD_UTF8_ERROR => 'Bad UTF8 error!',
        PREG_BAD_UTF8_OFFSET_ERROR => 'Bad UTF8 offset error'
    ];

    private function __construct()
    {
    }

    public static function setErrorText(int $code, string $text)
    {

        self::$errorTexts[$code] = $text;
    }

    public static function getErrorText(int $code): string
    {

        return self::$errorTexts[$code] ?? self::$errorTexts['default'];
    }

    public static function setDefaultErrorText(string $text)
    {

        self::setErrorText('default', $text);
    }

    public static function getLastErrorText(): string
    {

        $code = preg_last_error();
        $text = self::getErrorText($code);

        return "$text ($code)";
    }
}