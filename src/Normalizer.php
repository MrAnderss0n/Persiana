<?php

namespace Anderss0n\Persiana;

class Normalizer
{
    const ASCII_SPACE_CHARACTER_CODE = 32;

    const INVALID_PERSIAN_PHONEME_LIST = [
        'ـ', 'َ', 'ُ', 'ِ', 'ً', 'ٌ', 'ٍ', 'ّ',
    ];

    const INVALID_PERSIAN_LETTERS_MAPPER = [
        'أ' => 'ا', 'إ' => 'ا', 'ؤ' => 'و', 'ي' => 'ی', 'ى' => 'ی',
        'ے' => 'ی', 'ة' => 'ت', 'ۃ' => 'ت', 'ۀ' => 'ه', 'ہ' => 'ه',
        'ۂ' => 'ه', 'ھ' => 'ه', 'ە' => 'ه', 'ك' => 'ک', 'ڪ' => 'ک',
    ];

    const INVALID_ENGLISH_LETTERS_MAPPER = [
        'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'ƒ' => 'f',
    ];

    const INVALID_PERSIAN_NUMBERS_MAPPER = [
        '٠' => '0', '۰' => '0', '١' => '1', '۱' => '1',
        '٢' => '2', '۲' => '2', '٣' => '3', '۳' => '3',
        '٤' => '4', '۴' => '4', '٥' => '5', '۵' => '5',
        '٦' => '6', '۶' => '6', '٧' => '7', '۷' => '7',
        '٨' => '8', '۸' => '8', '٩' => '9', '۹' => '9',
    ];

    const INVALID_SPACES_PATTERN = '\x{0009}' . '\x{00A0}'
        . '\x{1680}' . '\x{180E}' . '\x{2000}-\x{200D}'
        . '\x{202F}' . '\x{205F}' . '\x{3000}'
        . '\x{180E}' . '\x{2060}' . '\x{FEFF}';

    const VALID_PERSIAN_ENGLISH_PATTERN = '\x{0622}-\x{063A}'
        . '\x{0641}-\x{064A}' . '\x{0660}-\x{0669}'
        . '\x{06C0}-\x{06C3}' . '\x{06F0}-\x{06F9}'
        . '\x{067E}' . '\x{0686}' . '\x{0698}'
        . '\x{06A9}' . '\x{06AA}' . '\x{06AF}'
        . '\x{06BE}' . '\x{06CC}' . '\x{06D2}'
        . '\x{06D5}' . 'a-zA-Z0-9';

    /**
     * Replace mapper keys with its values in the given text.
     *
     * @param string $text
     * @param array $mapper
     *
     * @return string
     */
    private static function replaceMapper(string $text, array $mapper): string
    {
        return str_replace(array_keys($mapper), array_values($mapper), $text);
    }

    /**
     * Replace the given replacement in the given text over when pattern matched.
     *
     * @param string $text
     * @param string $pattern
     * @param string|null $replacement
     *
     * @return string
     */
    private static function replacePatten(string $text, string $pattern, $replacement = null): string
    {
        $text = preg_replace($pattern, $replacement, $text);

        return self::tidySpaces($text);
    }

    /**
     * Convert sequence of spaces to single space and trim it.
     *
     * @param string $text
     *
     * @return string
     */
    public static function tidySpaces(string $text): string
    {
        $text = preg_replace('/\s{2,}/u', chr(self::ASCII_SPACE_CHARACTER_CODE), $text);

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
        $text = preg_replace('/\s\s+/u', chr(self::ASCII_SPACE_CHARACTER_CODE), $text);

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
        return str_replace(self::INVALID_PERSIAN_PHONEME_LIST, null, $text);
    }

    /**
     * Convert Persian numbers to its English form.
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizePersianNumbers(string $text): string
    {
        return self::replaceMapper($text, self::INVALID_PERSIAN_NUMBERS_MAPPER);
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
        return self::replaceMapper($text, self::INVALID_PERSIAN_LETTERS_MAPPER);
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
        return self::replaceMapper($text, self::INVALID_ENGLISH_LETTERS_MAPPER);
    }

    /**
     * Convert all type of spaces to standard one.
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizeWhiteSpaces(string $text): string
    {
        return self::replacePatten(
            $text,
            '/[\s' . self::INVALID_SPACES_PATTERN . ']/u',
            chr(self::ASCII_SPACE_CHARACTER_CODE)
        );
    }

    /**
     * Fetch only Persian and English letters then tidy spaces.
     *
     * @param string $text
     *
     * @return string
     */
    public static function fetchValidLetters(string $text): string
    {
        return self::replacePatten(
            $text,
            '/[^\s' . self::VALID_PERSIAN_ENGLISH_PATTERN . ']/u',
            chr(self::ASCII_SPACE_CHARACTER_CODE)
        );
    }

    /**
     * Fetch all thing instead of Persian and English letters.
     *
     * @param string $text
     *
     * @return string
     */
    public static function fetchInvalidCharacters(string $text): string
    {
        return self::replacePatten(
            $text,
            '/[!^\s' . self::VALID_PERSIAN_ENGLISH_PATTERN . ']/u'
        );
    }

    /**
     * Full normalize uses this class functionality to prevent repeating usage.
     *
     * @param string $text
     * @param bool $dropLines Pass true to making url slug for example.
     *
     * @return string
     */
    public static function normalize(string $text, bool $dropLines = false): string
    {
        $text = self::normalizeEnglishLetters($text);
        $text = self::normalizePersianLetters($text);
        $text = self::normalizePersianNumbers($text);
        $text = self::dropPersianPhonemes($text);
        $text = self::normalizeWhiteSpaces($text);
        $text = self::fetchValidLetters($text);

        if ($dropLines) {
            $text = self::dropBreakingLines($text);
        }

        return self::tidySpaces($text);
    }

    /**
     * Make a slug for url usage.
     *
     * @param string $text
     * @param string $glue
     *
     * @return string
     */
    public static function slug(string $text, string $glue = '-'): string
    {
        $text = self::normalize($text, true);

        return str_replace(chr(self::ASCII_SPACE_CHARACTER_CODE), $glue, $text);
    }
}
