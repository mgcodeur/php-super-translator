<?php

namespace Mgcodeur\SuperTranslator\Traits;

use Mgcodeur\SuperTranslator\DataTransfertObject\TranslationResultData;

trait HasTranslation
{
    /**
     * make the request to the translator service
     * @param string $from (ISO 639-1 code eg. en, fr, it, es, pt)
     */
    protected static function requestTranslation($from, $to, $text)
    {
        if (mb_strlen($text) > 5000) {
            $textChunked = self::chunkSplitAtClosestDot($text, 5000);

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
        if ($json->isChunked) {
            foreach ($json->result as $sentence) {
                $sentencesArray = json_decode($sentence, true);
                $result .= self::validateAndFormatResponseSentence($sentencesArray);
            }
        } 
        else {
            $sentencesArray = json_decode($json, true);
            $result .= self::validateAndFormatResponseSentence($sentencesArray);
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

    private static function chunkSplitAtClosestDot($input, $chunkSize = 5000) {
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
}
