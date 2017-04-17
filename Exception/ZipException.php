<?php
namespace ExtractCompress\Exception;
class ZipException extends \Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__ . ":[Line:{$this->getLine()}][Code:{$this->getCode()}]:{$this->getMessage()}\n";
    }
}