[![Build Status](https://travis-ci.com/MrAnderss0n/Persiana.svg?branch=master)](https://travis-ci.com/MrAnderss0n/Persiana)
[![codecov.io](https://codecov.io/github/MrAnderss0n/Persiana/coverage.svg?branch=master)](https://codecov.io/github/MrAnderss0n/Persiana?branch=master)
[![Latest Stable Version](https://poser.pugx.org/anderss0n/persiana/v/stable?format=flat-square)](https://packagist.org/packages/anderss0n/persiana)
[![Total Downloads](https://poser.pugx.org/anderss0n/persiana/downloads?format=flat-square)](https://packagist.org/packages/anderss0n/persiana)
[![Latest Unstable Version](https://poser.pugx.org/anderss0n/persiana/v/unstable?format=flat-square)](https://packagist.org/packages/anderss0n/persiana)
[![License](https://poser.pugx.org/anderss0n/persiana/license?format=flat-square)](https://packagist.org/packages/anderss0n/persiana)

# Persiana
Persiana is a Persian text normalizer utility that support English for every day usage with texts.

## Install
### by Composer
```
composer require anderss0n/persiana
```

### by Git
```
git clone git@github.com:MrAnderss0n/Persiana.git
```

## How to use
Use the following class into your PHP code:
```php
use Anderss0n\Persiana\Normalizer;
```

Simple example:
```php
echo Normalizer::tidySpaces('test the  new     package.'); // OUTPUT: test the new package.
```

### List of methods
<!-- TABLE_GENERATE_START -->

| Static Methods 			| Description																|
| ------------------------- | ------------------------------------------------------------------------- |
| tidySpaces  				| Convert sequence of spaces to single space and trim it. 					|
| dropBreakingLines 		| Drop breaking line to make sequence of text without new lines.			|
| dropPersianPhonemes 		| Drop general Persian vowel phonemes.										|
| normalizePersianNumbers 	| Convert Persian numbers to its English form.								|
| normalizePersianLetters 	| Convert Arabic letters to Persian one.									|
| normalizeEnglishLetters 	| Convert Latin letters to English one.										|
| normalizeWhiteSpaces      | Convert all type of spaces to standard one.								|
| fetchValidLetters         | Fetch only Persian and English letters then tidy spaces.					|
| fetchInvalidCharacters    | Fetch all thing instead of Persian and English letters. 					|
| normalize     			| Full normalize uses this class functionality to prevent repeating usage. 	|
| slug           			| Make a slug for url usage.                                             	|

<!-- TABLE_GENERATE_END -->


