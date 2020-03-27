<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use MrAnderss0n\Persiana\Normalizer;

echo Normalizer::tidySpaces('test the  new     package.');
