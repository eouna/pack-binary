<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/19
 * Time: 16:32
 */

namespace BinaryStream\Exception;

use Throwable;

class BinaryException extends \Exception{

    const SHORT_VALUE_EXCEED_LIMIT = 'THE SHORT VALUE EXCEED LIMIT';
    const INT32_VALUE_EXCEED_LIMIT = 'THE INTEGER 32 BIT VALUE EXCEED LIMIT';
    const INT64_VALUE_EXCEED_LIMIT = 'THE INTEGER 64 BIT VALUE EXCEED LIMIT';
    const NOT_AVAILABLE_64BITE_FORMAT = '64BIT FORMAT CODES ARE NOT AVAILABLE FOR 32BIT';
    const NOT_A_DOUBLE_VARIABLE = 'NOT A DOUBLE VARIABLE';

    private $code_list = [
        self::NOT_AVAILABLE_64BITE_FORMAT => 0x000001,
        self::NOT_A_DOUBLE_VARIABLE => 0x000002,
        self::SHORT_VALUE_EXCEED_LIMIT => 0x7FFF,
        self::INT32_VALUE_EXCEED_LIMIT => 0x7FFFFFFF,
        self::INT64_VALUE_EXCEED_LIMIT => 0x7FFFFFFFFFFFFFFF,
    ];

    function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $code = !empty($message) ? ($this->code_list[$message] ?? $code) : $code;
        parent::__construct($message, $code, $previous);
    }

}