<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/17
 * Time: 19:56
 */

namespace BinaryStream;


class ByteReader
{

    const BYTE_BIT = 8;
    const SHORT_BIT = 16;
    const INT32_BIT = 32;
    const INT64_BIT = 64;

    /**
     * @var string $recordSequence
     */
    protected $recordSequence = '';

    /**
     * @var string
     */
    protected $readStream;

    /**
     * read pos
     * @var int $pos
     */
    protected $pos = 0;

    /**
     * ByteReader constructor.
     * @param $byteStream
     */
    public function __construct($byteStream)
    {
        $this->readStream = $byteStream;
    }

    /**
     * ascii code to char string
     * @return array
     */
    public function readByteString() {
        $binaryReader = new BinaryReader($this->readStream);
        $byteString = $binaryReader->readUTFString();
        array_map(function ($byte) use (&$bytesArray) {
            $bytesArray[] = $this->read($byte, self::BYTE_BIT);
        }, str_split($byteString));
        $this->pos += strlen($byteString) + 1;
        return $bytesArray;
    }

    /**
     * @return int
     */
    public function readByte(){
        $byte = substr($this->readStream, $this->pos, BinaryCode::$T[BinaryCode::C]);
        $this->pos += BinaryCode::$T[BinaryCode::C];
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C] . BinaryCode::$T[BinaryCode::S];
        return $this->read($byte, self::BYTE_BIT);
    }

    /**
     * @return int
     */
    public function readShortToByte(){
        return $this->readInt16ToByte();
    }

    /**
     * @return int
     */
    public function readInt16ToByte(){
        $byte = substr($this->readStream, $this->pos, BinaryCode::$T[BinaryCode::S]);
        $this->pos += BinaryCode::$T[BinaryCode::S];
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C] . BinaryCode::$T[BinaryCode::S];
        return $this->read($byte, self::SHORT_BIT);
    }

    /**
     * @return int
     */
    public function readInt32ToByte(){
        $byte = substr($this->readStream, $this->pos, BinaryCode::$T[BinaryCode::V]);
        $this->pos += BinaryCode::$T[BinaryCode::V];
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C] . BinaryCode::$T[BinaryCode::V];
        return $this->read($byte, self::INT32_BIT);
    }

    /**
     * @return int
     */
    public function readInt64ToByte(){
        $byte = substr($this->readStream, $this->pos, BinaryCode::$T[BinaryCode::Q]);
        $this->pos += BinaryCode::$T[BinaryCode::Q];
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C] . BinaryCode::$T[BinaryCode::Q];
        return $this->read($byte, self::INT64_BIT);
    }

    /**
     * @param $bytes
     * @param int $bit
     * @param int $position
     * @return int
     */
    protected function read($bytes, int $bit, $position = 0){
        $val = $i = 0;
        !is_string($bytes) ?: $bytes = str_split($bytes);
        if($bit % 8 == 0 && is_int($byteNumber = $bit % 8)){
            var_dump($byteNumber);
            $val = $bytes[0] & 0xff;
            while ($byteNumber++ < $byteNumber){
                $val |= $bytes[$position + $byteNumber] & 0xff;
            }
        }
        return $val;
    }

    /**
     * ascii code to char string
     * @param string $byteString
     * @return array
     */
    public static function readByteStringToArray(string $byteString) {
        $bytesArray = [];
        array_map(function ($byte) use (&$bytesArray) {
            $bytesArray[] = $this->read($byte, self::BYTE_BIT);
        }, str_split($byteString));
        return $bytesArray;
    }
}
