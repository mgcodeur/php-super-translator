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

<div>
    <a href="https://buymeacoffee.com/mgcodeur">
        <img src="https://img.buymeacoffee.com/button-api/?text=Buy%20me%20a%20coffee&emoji=&slug=mgcodeur&button_colour=FF5F5F&font_colour=ffffff&font_family=Poppins&outline_colour=000000&coffee_colour=FFDD00"/>
    </a>
</div>
