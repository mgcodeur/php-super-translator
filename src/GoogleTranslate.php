<?php
namespace Mgcodeur\SuperTranslator;
use Mgcodeur\SuperTranslator\Traits\TranslatorTrait;

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
    use TranslatorTrait;

    /**
     * Translate text from a language to another
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string|array $to (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string $text (Text to translate)
     * @throws \Exception
     * @return string|array
     */
    public static function translate($from, $to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        if(is_array($to)) {
            $result = [];
            foreach($to as $t) {
                $response = self::requestTranslation($from, $t, $text);
                $translatedText = self::getGoogleTranslationResult($response);
                $result[$t] = $translatedText;
            }
            return $result;
        }

        $response = self::requestTranslation($from, $to, $text);
        $translatedText = self::getGoogleTranslationResult($response);
        return $translatedText;
    }

    /**
     * Translate text from a language to another
     * @param string|array $to (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string $text (Text to translate)
     * @throws \Exception
     * @return string|array
     */
    public static function translateAuto($to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        if(is_array($to)) {
            $result = [];
            foreach($to as $t) {
                $response = self::requestTranslation('auto', $t, $text);
                $translatedText = self::getGoogleTranslationResult($response);
                $result[$t] = $translatedText;
            }
            return $result;
        }

        $response = self::requestTranslation('auto', $to, $text);
        $translatedText = self::getGoogleTranslationResult($response);
        return $translatedText;
    }
}
