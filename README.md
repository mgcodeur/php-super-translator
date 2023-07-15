## About SuperTranslator

SuperTranslator is a PHP package that allows you to translate text from one language to another using the Google Translate API.

## Installation

Install the package via composer:

```bash
composer require mgcodeur/super-translator
```

## Basic Usage

``` php
require_once 'vendor/autoload.php';
use Mgcodeur\SuperTranslator\GoogleTranslate;

$from = 'en';
$to = 'fr';
$text = 'Hello World!';

$translatedText = GoogleTranslate::translate($from, $to, $text);
echo $translatedText;
// Output: Bonjour le monde!
```

## Automatic language detection

If you want to automatically detect the language of the text to translate, you can use the `translateAuto` method of the `GoogleTranslate` class like this:

``` php
require_once 'vendor/autoload.php';
use Mgcodeur\SuperTranslator\GoogleTranslate;

$to = 'fr';
$text = 'Hello World!';

$translatedText = GoogleTranslate::translateAuto($to, $text);
echo $translatedText;
// Output: Bonjour le monde!
```