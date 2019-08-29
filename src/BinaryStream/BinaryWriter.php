<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/3/7
 * Time: 15:33
 */

namespace BinaryStream;
use BinaryStream\Exception\BinaryException;

class BinaryWriter
{
    /**
     * binary write or read model
     * @var bool $binary_model
     * */
    private $binary_model = BinaryCode::BIG_ENDIAN;

    /**
     * buffer write stream
     * @var string $stream
     * */
    private $write_stream = '';

    /**
     * buffer write sequence
     * @var string $write_sequence
     * */
    private $write_sequence = null;

    /**
     * record buffer write sequence
     * @var string $writeSequence
     * */
    private $record_sequence = null;

    /**
     * store path string
     * @var string $store_path
     * */
    private $store_path = '';

    /**
     * initial store path
     * @param string $store_path
     * */
    public function __construct(string $store_path = ''){
        $this->store_path = $store_path;
    }

    /**
     * write a 16 byte integer
     * @param int $integer
     * @throws BinaryException
     * */
    public function writeInt16(int $integer){

        if($integer > 0x7FFF || $integer < -0x8000 )
            throw new BinaryException(BinaryException::SHORT_VALUE_EXCEED_LIMIT);

        $this->write_sequence = $this->binary_model ? BinaryCode::$N[BinaryCode::v] : BinaryCode::$N[BinaryCode::n];
        $this->write_stream .= $this->write($integer);
        $this->record_sequence .= $this->write_sequence;
    }

    /**
     * write a short integer
     * @throws BinaryException
     * @param int $integer
     * */
    public function writeShort(int $integer){

        if($integer > 0x7FFF || $integer < -0x8000 )
            throw new BinaryException(BinaryException::SHORT_VALUE_EXCEED_LIMIT);

        self::writeInt16($integer);
    }

    /**
     * write a 32 byte integer
     * @throws BinaryException
     * @param int $integer
     * */
    public function writeInt32(int $integer){

        if($integer > 0x7FFFFFFF || $integer < -0x80000000 )
            throw new BinaryException(BinaryException::INT32_VALUE_EXCEED_LIMIT);

        $this->write_sequence = $this->binary_model ? BinaryCode::$N[BinaryCode::V] : BinaryCode::$N[BinaryCode::N];
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= $this->write($integer);
    }

    /**
     * write a 64 byte integer
     * @param float $integer
     * @throws
     * */
    public function writeInt64(float $integer){

        if($integer > 0x7FFFFFFFFFFFFFFF || $integer < -0x8000000000000000 )
            throw new BinaryException(BinaryException::INT64_VALUE_EXCEED_LIMIT);

        if(PHP_INT_SIZE * 8 != 64)
            throw new BinaryException(BinaryException::NOT_AVAILABLE_64BITE_FORMAT);

        $this->write_sequence = $this->binary_model ? BinaryCode::$N[BinaryCode::J] : BinaryCode::$N[BinaryCode::P];
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= $this->write($integer);
    }

    /**
     * write a float
     * @param float $float
     * @throws
     * */
    public function writeFloat(float $float){
        $this->write_sequence = BinaryCode::$N[BinaryCode::f];
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= strrev($this->write($float));
    }

    /**
     * write a float
     * @param double $double
     * @throws
     * */
    public function writeDouble($double){

        if(!is_double($double))
            throw new BinaryException(BinaryException::NOT_A_DOUBLE_VARIABLE);

        $this->write_sequence = BinaryCode::$N[BinaryCode::d];
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= strrev($this->write($double));
    }

    /**
     * write a char
     * @param string $char
     * */
    public function writeChar(string $char){
        $this->write_sequence = BinaryCode::$N[BinaryCode::a];
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= $this->write($char{0});
    }

    /**
     * write string
     * @throws
     * @param string $string
     * */
    public function writeString(string $string){
        self::writeUTFString($string);
    }

    /**
     * write utf string
     * @param string $uftString
     * @throws BinaryException
     * */
    public function writeUTFString(string $uftString){

        $string_len = strlen($uftString);
        self::writeShort($string_len);

        $this->write_sequence = BinaryCode::$N[BinaryCode::a] . "*";
        $this->record_sequence .= $this->write_sequence;
        $this->write_stream .= $this->write($uftString);
    }

    /**
     * return pack binary string
     * @param $data
     * @return string
     * */
    protected function write($data){
        return pack($this->write_sequence, $data);
    }

    /**
     * save binary string to file
     * */
    public function store(){

        if(empty($this->store_path) && !empty($this->write_stream))
            return file_put_contents(__DIR__ . '/out.dat', $this->write_stream);

        $base_dir = dirname($this->store_path);
        if(!is_dir($base_dir))
            mkdir($base_dir, 655, true);

        return file_put_contents($this->store_path, $this->write_stream);
    }

    /**
     * @return string
     */
    public function getRecordSequence(): string{

        return $this->record_sequence;
    }

    /**
     * @return string
     */
    public function getWriteStream(): string{

        return $this->write_stream;
    }

    /**
     * @return string
     */
    public function getWriteSequence(): string{

        return $this->write_sequence;
    }
}