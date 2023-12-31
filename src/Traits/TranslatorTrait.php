<?php

namespace Mgcodeur\SuperTranslator\Traits;

// use Campo\UserAgent;
use Mgcodeur\SuperTranslator\DataTransfertObject\TranslationResultData;

trait TranslatorTrait
{
    protected static $curl_options = [
        CURLOPT_URL => "https://translate.googleapis.com/translate_a/single?client=gtx&dt=t",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => '',
        // CURLOPT_USERAGENT => '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'UTF-8',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];

    /**
     * make the request to the translator service
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     */
    protected static function requestTranslation($from, $to, $text)
    {
        if (mb_strlen($text) > 5000) {
            $textChunked = self::splitAtClosestDot($text, 5000);

            $result = [];
            
            foreach($textChunked as $t) {
                array_push($result, self::requestTranslation($from, $to, $t));
            }
            
            return TranslationResultData::fromArray([
                'isChunked' => true,
                'result' => $result
            ]);
        };

        $fields_string = self::generateQueryString([
            'sl' => urlencode($from),
            'tl' => urlencode($to),
            'q' => urlencode($text)
        ]);

        $ch = curl_init();
        $options = self::setCurlOptionByKey(CURLOPT_POSTFIELDS, $fields_string);
        
        //TODO: add fake user agent
        // $options = self::setCurlOptionByKey(CURLOPT_USERAGENT, UserAgent::random([
        //     'os_type' => UserAgent::getOSTypes(),
        //     'device_type' => UserAgent::getDeviceTypes()
        // ]));

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
    protected static function getGoogleTranslationResult($json)
    {
        $result = "";
        
        $objectIsChunked = gettype($json) === 'object' && $json->isChunked;

        if ($objectIsChunked) {
            foreach ($json->result as $sentence) {
                $result .= self::formatResult($sentence);
            }
        } 
        else {
            $result = self::formatResult($json);
        }
        
        return $result;
    }

    protected static function validateAndFormatResponseSentence($sentencesArray) {
        if (!$sentencesArray || !isset($sentencesArray[0])) {
            throw new \Exception("Invalid response from Google Translate API.");
        }
    
        $processedResult = "";
        foreach ($sentencesArray[0] as $s) {
            $processedResult .= isset($s[0]) ? $s[0] : '';
        }
    
        return $processedResult;
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

    /**
     * Split a string at the closest dot to the specified chunk size
     * @param string $input (String to split)
     * @param int $chunkSize (Maximum size of each chunk)
     * @return array
     */
    private static function splitAtClosestDot($input, $chunkSize = 5000) {
        $chunks = [];
        $length = strlen($input);
    
        // Initial position
        $start = 0;
    
        while ($start < $length) {
            // Calculate the end position of the chunk
            $end = min($start + $chunkSize, $length);
    
            // Find the closest dot to the calculated end position
            $dotPosition = strrpos(substr($input, $start, $end - $start), '.');
    
            if ($dotPosition !== false) {
                // Adjust the end position to the closest dot
                $end = $start + $dotPosition + 1;
            }
    
            // Extract the chunk and add it to the result array
            $chunk = substr($input, $start, $end - $start);
            $chunks[] = $chunk;
    
            // Update the start position for the next iteration
            $start = $end;
        }
    
        return $chunks;
    }
    
    /**
     * Run translation process
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string|array $to (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string|array $text (Text to translate)
     * @return string|array
     */
    private static function runTranslation($from, $to, $text)
    {
        $response = self::requestTranslation($from, $to, $text);
        $translatedText = self::getGoogleTranslationResult($response);

        return $translatedText;
    }

    /**
     * Translate text from a language to another
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string|array $to (ISO 639-1 code eg. en, fr, it, es, pt)
     * @param string $text (Text to translate)
     * @throws \Exception
     * @return string|array
     */
    private static function translateText($from, $to, $text)
    {
        if (empty($text)) {
            throw new \Exception("Text cannot be empty");
        }

        if(is_array($to)) {
            $result = [];
            foreach($to as $t) {
                $result[$t] = self::translateAuto($t, $text);
            }
            return $result;
        }

        return self::runTranslation($from, $to, $text);
    }
    
    private static function formatResult($sentence) {
        $sentencesArray = json_decode($sentence, true);
        return self::validateAndFormatResponseSentence($sentencesArray);
    }
}
