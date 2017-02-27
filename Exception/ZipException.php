<?php
namespace ExtractCompress\Exception;
class ZipException extends \Exception
{
    const FILE_NOT_EXIST = 0x1000;
    const FILE_SUFFIX_ERROR = 0x1001;
    const OPEN_FAILED = 0x1002;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__ . ":[Line:{$this->Line}][Code:{$this->code}]:{$this->message}\n";
    }
}