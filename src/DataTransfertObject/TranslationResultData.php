<?php

namespace Mgcodeur\SuperTranslator\DataTransfertObject;

class TranslationResultData
{
    public $isChunked;
    public $result;

    public function __construct(
        bool $isChunked,
        array $result
    )
    {
        $this->isChunked = $isChunked;
        $this->result = $result;
    }

    public static function fromArray(array $data)
    {
        if(!isset($data['isChunked']) || !isset($data['result']))
        {
            throw new \Exception("Invalid data");
        }
             
        return new self(
            $data['isChunked'],
            $data['result']
        );
    }
}
