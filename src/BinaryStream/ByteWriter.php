<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/17
 * Time: 18:48
 */

namespace BinaryStream;


class ByteWriter implements StreamWriter
{

    const BYTE_BIT = 8;
    const SHORT_BIT = 16;
    const INT32_BIT = 32;
    const INT64_BIT = 64;

    /**
     * @var string $binaryStream
     */
    private $binaryStream = '';

    /**
     * @var string $recordSequence
     */
    private $recordSequence = '';

    /**
     * ascii code to char string
     * @param array $bytesArray
     * @return self
     * @throws Exception\BinaryException
     */
    public function writeBytes(array $bytesArray) {
        $binaryWriter = new BinaryWriter();
        array_map(function ($byte) use (&$outByteStr) {
            $outByteStr .= $this->writeByte($byte)->getWriteStream();
        }, $bytesArray);
        $this->binaryStream .= $binaryWriter->writeUTFString($outByteStr);
        return $this;
    }

    /**
     * @param int|string $byte
     * @return self
     */
    public function writeByte($byte){
        return is_string($byte) ? $this->writeByteChar($byte)
            : $this->writeIntToByte($byte, self::BYTE_BIT);
    }

    /**
     * @param string $char
     * @return self
     */
    private function writeByteChar(string $char){
        $this->binaryStream .= pack(BinaryCode::$N[BinaryCode::C], $char);
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C];
        return $this;
    }

    /**
     * @param int $byte
     * @return self
     */
    public function writeShortToByte($byte){
        return $this->writeInt16ToByte($byte);
    }

    /**
     * @param int $byte
     * @return self
     */
    public function writeInt16ToByte($byte){
        return $this->writeIntToByte($byte, self::SHORT_BIT);
    }

    /**
     * @param int $byte
     * @return self
     */
    public function writeInt32ToByte($byte){
        return $this->writeIntToByte($byte, self::INT32_BIT);
    }

    /**
     * @param int $byte
     * @return self
     */
    public function writeInt64ToByte($byte){
        return $this->writeIntToByte($byte, self::INT64_BIT);
    }

    /**
     * @param $number
     * @param int $bit
     * @return self
     */
    private function writeIntToByte($number, int $bit){
        $i = 0;
        if($bit % 8 == 0 && is_int($byteNumber = $bit / 8)){
            do{
                $this->binaryStream .= pack(BinaryCode::$N[BinaryCode::C], (($number >> ($i * 8)) & 0xff));
                $this->recordSequence .= BinaryCode::$N[BinaryCode::C];
            }while (++$i < $byteNumber);
        }
        return $this;
    }

    /**
     * @param $data
     * @return self
     */
    public function write($data){
        return $this->writeByte($data);
    }

    /**
     * @return string
     */
    public function getWriteStream(): string{
        return $this->binaryStream;
    }

    /**
     * @return string
     */
    public function getRecordSequence(): string
    {
        return $this->recordSequence;
    }

    /**
     * ascii code to char string
     * @param array $bytesArray
     * @return self
     */
    public static function getBytesString(array $bytesArray) {
        array_map(function ($byte) use (&$outByteStr) {
            $outByteStr .= pack(BinaryCode::$N[BinaryCode::C], $byte & 0xff);
        }, $bytesArray);
        return $outByteStr;
    }
}
