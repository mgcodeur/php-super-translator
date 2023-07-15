<?php
namespace Mgcodeur\SuperTranslator;

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

/**
 * Main class GoogleTranslate
 * @package GoogleTranslate
 */
class GoogleTranslate
{
    protected static $curl_options = [
        CURLOPT_URL => "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => '',
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

        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    public static function translateAuto($to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        $response = self::requestTranslation('auto', $to, $text);

        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    /**
     * make the request to the translator service
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     */
    protected static function requestTranslation($from, $to, $text)
    {
        if (strlen($text) >= 5000) {
            throw new \Exception("Maximum number of characters exceeded, max: 5000");
        };

        $fields_string = self::generateQueryString([
            'sl' => urlencode($from),
            'tl' => urlencode($to),
            'q' => urlencode($text)
        ]);

        $ch = curl_init();
        $options = self::setCurlOptionByKey(CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * parse the translation json response
     * @param string $json (json response from Google Translate API)
     * @throws \Exception
     * @return string
     */
    protected static function getSentencesFromJSON($json)
    {
        $sentencesArray = json_decode($json, true);
        $sentences = "";

        if (!$sentencesArray || !isset($sentencesArray[0])) 
        {
            throw new \Exception("Invalid response from Google Translate API.");
        }

        foreach ($sentencesArray[0] as $s) {
            $sentences .= isset($s[0]) ? $s[0] : '';
        }

        return $sentences;
    }

    /**
     * generate the query string
     * @param array $params
     * @return string $query (generated query string)
     */
    private static function generateQueryString(array $params) {
        $query = '';
        foreach ($params as $key => $value) {
            $query .= '&' . $key . '=' . $value;
        }
        rtrim($query, '&');

        return $query;
    }

    /**
     * set curl option by key
     * @param string $key (CURLOPT_*)
     * @param string $value (value of the CURLOPT_*)
     * @return array $curl_options (array of curl options)
     */
    private static function setCurlOptionByKey($key, $value) {
        self::$curl_options[$key] = $value;

        return self::$curl_options;
    }
}
