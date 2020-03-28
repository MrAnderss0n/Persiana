<?php

namespace Anderss0n\Persiana\Tests;

use PHPUnit\Framework\TestCase;
use Anderss0n\Persiana\Normalizer;

final class NormalizerTest extends TestCase
{
    private $utf8Chars = '';

    private function uft8_chr($hex)
    {
        $text = str_pad((string)dechex($hex), 4, 0, STR_PAD_LEFT);

        return mb_convert_encoding(pack('H*', $text), 'UTF-8', 'UTF-16BE');
    }

    private function makeFullUnicode()
    {
        $last = 0xFFFF;

        for ($i = 0; $i <= (int)hexdec($last); $i++) {
            $this->utf8Chars .= $this->uft8_chr(dechex($i));
        }
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->makeFullUnicode();
    }

    public function testTidySpaces()
    {
        $sample = 'persiana  package      test';

        preg_match('/\s{2,}/u', Normalizer::tidySpaces($sample), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testDropBreakingLines()
    {
        $sample = "persiana \n package " . PHP_EOL . 'test' . PHP_EOL;

        preg_match('/\s\s+/u', Normalizer::dropBreakingLines($sample), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testDropPersianPhonemes()
    {
        $sample = implode('\\', Normalizer::INVALID_PERSIAN_PHONEME_LIST);

        preg_match('/[\\' . $sample . ']/u', Normalizer::dropPersianPhonemes($sample), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testNormalizePersianNumbers()
    {
        $sample = implode('\\', array_keys(Normalizer::INVALID_PERSIAN_NUMBERS_MAPPER));

        preg_match('/[\\' . $sample . ']/u', Normalizer::normalizePersianNumbers($sample), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testNormalizePersianLetters()
    {
        $count = 0;
        $delimiter = '-';

        $sample = implode($delimiter, array_keys(Normalizer::INVALID_PERSIAN_LETTERS_MAPPER));
        $result = Normalizer::normalizePersianLetters($sample);

        foreach (explode($delimiter, $sample) as $key) {
            foreach (explode($delimiter, $result) as $value) {
                if ($key === $value) {
                    $count++;
                }
            }
        }

        $this->assertEquals(0, $count);
    }

    public function testNormalizeEnglishLetters()
    {
        $sample = implode('\\', array_keys(Normalizer::INVALID_ENGLISH_LETTERS_MAPPER));

        preg_match('/[\\' . $sample . ']/u', Normalizer::normalizeEnglishLetters($sample), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testNormalizeWhiteSpaces()
    {
        $characters = [
            0x0009, 0x00A0, 0x1680, 0x180E, 0x2000, 0x2001, 0x2002, 0x2003,
            0x2004, 0x2005, 0x2006, 0x2007, 0x2008, 0x2009, 0x200A, 0x200B,
            0x200C, 0x200D, 0x202F, 0x205F, 0x3000, 0x180E, 0x2060, 0xFEFF,
        ];

        $count = 0;
        $result = Normalizer::normalizeWhiteSpaces($this->utf8Chars);

        foreach ($characters as $character) {
            if (mb_strpos($result, $this->uft8_chr($character), 0, 'UTF-8')) {
                $count++;
            }
        }

        $this->assertEquals(0, $count);
    }

    public function testFetchValidLetters()
    {
        $pattern = '/[^\s' . Normalizer::VALID_PERSIAN_ENGLISH_PATTERN . ']/u';

        preg_match($pattern, Normalizer::fetchValidLetters($this->utf8Chars), $matches);

        $this->assertEquals(0, count($matches));
    }

    public function testFetchInvalidCharacters()
    {
        $pattern = '/[!^\s' . Normalizer::VALID_PERSIAN_ENGLISH_PATTERN . ']/u';

        preg_match($pattern, Normalizer::fetchInvalidCharacters($this->utf8Chars), $matches);

        $this->assertEquals(0, count($matches));
    }
}

