<?php
namespace Mgcodeur\SuperTranslator;
use Mgcodeur\SuperTranslator\Traits\HasTranslation;

/**
 * GoogleTranslate.class.php
 *
 * Class to translate text using Google Translate for free.
 *
 * @package GoogleTranslate PHP Class for free
 * @category Translation
 * @author ANDRIANAMBININA Iharena Jimmy Raphaël (Mgcodeur)
 * @author Antananarivo Madagascar <mgcodeur@panera.mg>
 * @copyright copyright (c) 2023 Mgcodeur
 * @license https://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 * @link https://mgcodeur.panera.mg
 */
class GoogleTranslate
{
    use HasTranslation;

    protected static $curl_options = [
        CURLOPT_URL => "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => '',
        CURLOPT_USERAGENT => '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'UTF-8',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];

    /**
     * Translate text from a language to another
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string $to (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string $text (Text to translate)
     * @throws \Exception
     * @return string
     */
    public static function translate($from, $to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        $response = self::requestTranslation($from, $to, $text);

        $translation = self::getGoogleTranslationResult($response);

        return $translation;
    }

    public static function translateAuto($to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        $response = self::requestTranslation('auto', $to, $text);

        $translation = self::getGoogleTranslationResult($response);

        return $translation;
    }
}
