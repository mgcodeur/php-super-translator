[![Run Tests](https://github.com/mgcodeur/php-super-translator/actions/workflows/test.yml/badge.svg)](https://github.com/mgcodeur/php-super-translator/actions/workflows/test.yml)
![Packagist Downloads (custom server)](https://img.shields.io/packagist/dt/mgcodeur/super-translator?style=flat-square&logo=packagist&logoColor=white&labelColor=blue&color=orange)

## About SuperTranslator

SuperTranslator is a PHP package that allows you to translate text from one language to another using the Google Translate API.

## Installation

Install the package via composer:

```bash
composer require mgcodeur/super-translator
```

## Basic Usage

``` php
require_once 'vendor/autoload.php'; // if you don't use autoloading
use Mgcodeur\SuperTranslator\GoogleTranslate;

$from = 'en';
$to = 'fr';
$text = 'Hello World!';

$translatedText = GoogleTranslate::translate($from, $to, $text);
echo $translatedText;
// Output: Bonjour le monde!
```
<br/>

## Automatic language detection

If you want to automatically detect the language of the text to translate, you can use the `translateAuto` method of the `GoogleTranslate` class like this:

``` php
require_once 'vendor/autoload.php'; // if you don't use autoloading
use Mgcodeur\SuperTranslator\GoogleTranslate;

$to = 'fr';
$text = 'Hello World!';

$translatedText = GoogleTranslate::translateAuto($to, $text);
echo $translatedText;
// Output: Bonjour le monde!
```

You can alse use 'auto' as the value of the `$from` parameter:

``` php
require_once 'vendor/autoload.php'; // if you don't use autoloading
use Mgcodeur\SuperTranslator\GoogleTranslate;

$from = 'auto';
$to = 'fr';
$text = 'Hello World!';

$translatedText = GoogleTranslate::translate($from, $to, $text);
echo $translatedText;
// Output: Bonjour le monde!
```
<br/>

## Translate multiple languages

If you want to translate a text into multiple languages, you just have to pass an array of languages to the `translate` or `translateAuto` method of the `GoogleTranslate` class like this:

``` php
require_once 'vendor/autoload.php'; // if you don't use autoloading
use Mgcodeur\SuperTranslator\GoogleTranslate;

$from = 'en';
$to = ['fr', 'es', 'de'];

$text = 'Hello World!';

$translatedText = GoogleTranslate::translate($from, $to, $text);

//Nb: the $translatedText variable is an array

# Output: [
#    'fr' => 'Bonjour le monde!',
#    'es' => '¡Hola Mundo!',
#    'de' => 'Hallo Welt!'
# ]
```

<div>
    <a href="https://buymeacoffee.com/mgcodeur">
        <img src="https://img.buymeacoffee.com/button-api/?text=Buy%20me%20a%20coffee&emoji=&slug=mgcodeur&button_colour=FF5F5F&font_colour=ffffff&font_family=Poppins&outline_colour=000000&coffee_colour=FFDD00"/>
    </a>
</div>

## Contributors ✨
Thanks go to these wonderful people ✨:

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END --