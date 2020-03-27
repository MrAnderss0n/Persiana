<?php

namespace Anderss0n\Persiana;

class Normalizer
{
    /**
     * Valid Persian and English letters based on UTF-8 unicode table.
     */
    const PERSIAN_ENGLISH_PATTER = '\x{0622}-\x{063A}'
        . '\x{0641}-\x{064A}' . '\x{0660}-\x{0669}'
        . '\x{06C0}-\x{06C3}' . '\x{06F0}-\x{06F9}'
        . '\x{067E}' . '\x{0686}' . '\x{0698}'
        . '\x{06A9}' . '\x{06AA}' . '\x{06AF}'
        . '\x{06BE}' . '\x{06CC}' . '\x{06D2}'
        . '\x{06D5}' . 'a-zA-Z0-9';

    /**
     * Convert sequence of spaces to single space and trim it.
     *
     * @param string $text
     *
     * @return string
     */
    public static function tidySpaces(string $text): string
    {
        $text = preg_replace('/\s{2,}/u', ' ', $text);

        return trim($text);
    }

    /**
     * Drop breaking line to make sequence of text without new lines.
     *
     * @param string $text
     *
     * @return string
     */
    public static function dropBreakingLines(string $text): string
    {
        $text = preg_replace('/\s\s+/', ' ', $text);

        return self::tidySpaces($text);
    }

    /**
     * Drop general Persian vowel phonemes.
     *
     * @param string $text
     *
     * @return string
     */
    public static function dropPersianPhonemes(string $text): string
    {
        $signs = ['ـ', 'َ', 'ُ', 'ِ', 'ً', 'ٌ', 'ٍ', 'ّ'];

        return str_replace($signs, null, $text);
    }

    /**
     * Convert Arabic letters to Persian one.
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizePersianLetters(string $text): string
    {
        $mapping = [
            'أ' => 'ا', 'إ' => 'ا', 'ؤ' => 'و', 'ي' => 'ی', 'ى' => 'ی',
            'ے' => 'ی', 'ة' => 'ت', 'ۃ' => 'ت', 'ۀ' => 'ه', 'ہ' => 'ه',
            'ۂ' => 'ه', 'ھ' => 'ه', 'ە' => 'ه', 'ك' => 'ک', 'ڪ' => 'ک',
        ];

        return str_replace(array_keys($mapping), array_values($mapping), $text);
    }

    /**
     * Convert Latin letters to English one.
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizeEnglishLetters(string $text): string
    {
        $mapping = [
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A',
            'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
            'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I',
            'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O',
            'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a',
            'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a',
            'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i',
            'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o',
            'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y',
            'ƒ' => 'f',
        ];

        return str_replace(array_keys($mapping), array_values($mapping), $text);
    }

    /**
     * Convert Persian numbers to its English form.
     *
     * @param string $text
     *
     * @return string
     */
    public static function convertPersianNumbers(string $text): string
    {
        $mapping = [
            '٠' => '0', '۰' => '0', '١' => '1', '۱' => '1', '٢' => '2', '۲' => '2',
            '٣' => '3', '۳' => '3', '٤' => '4', '۴' => '4', '٥' => '5', '۵' => '5',
            '٦' => '6', '۶' => '6', '٧' => '7', '۷' => '7', '٨' => '8', '۸' => '8',
            '٩' => '9', '۹' => '9',
        ];

        return str_replace(array_keys($mapping), array_values($mapping), $text);
    }

    /**
     * Convert all type of spaces to standard one.
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizeSpaces(string $text): string
    {
        $pattern = '/[\s'
            . '\x{00A0}' . '\x{1680}' . '\x{180E}' . '\x{2000}'
            . '\x{2001}' . '\x{2002}' . '\x{2003}' . '\x{2004}'
            . '\x{2005}' . '\x{2006}' . '\x{2007}' . '\x{2008}'
            . '\x{2009}' . '\x{200A}' . '\x{200B}' . '\x{202F}'
            . '\x{205F}' . '\x{3000}' . '\x{FEFF}'
            . ']/u';

        $text = preg_replace($pattern, ' ', $text);

        return self::tidySpaces($text);
    }

    /**
     * Fetch only Persian and English letters then tidy spaces.
     *
     * @param string $text
     *
     * @return string
     */
    public static function fetchLetters(string $text): string
    {
        $pattern = '/[^\s' . self::PERSIAN_ENGLISH_PATTER . ']/u';

        $text = preg_replace($pattern, ' ', $text);

        return self::tidySpaces($text);
    }

    /**
     * Fetch all thing instead of Persian and English letters.
     *
     * @param string $text
     *
     * @return string
     */
    public static function fetchSigns(string $text): string
    {
        $pattern = '/[!^\s' . self::PERSIAN_ENGLISH_PATTER . ']/u';

        $text = preg_replace($pattern, null, $text);

        return self::tidySpaces($text);
    }

    /**
     * Full normalize uses this class functionality to prevent repeating usage.
     *
     * @param string $text
     * @param bool $dropLines Pass true to making url slug for example.
     *
     * @return string
     */
    public static function fullNormalize(string $text, bool $dropLines = false): string
    {
        $text = self::normalizeEnglishLetters($text);
        $text = self::normalizePersianLetters($text);
        $text = self::convertPersianNumbers($text);
        $text = self::dropPersianPhonemes($text);
        $text = self::normalizeSpaces($text);
        $text = self::fetchLetters($text);

        if ($dropLines) {
            $text = self::dropBreakingLines($text);
        }

        return self::tidySpaces($text);
    }
}
