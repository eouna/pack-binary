<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/17
 * Time: 19:56
 */

namespace BinaryStream;


class ByteReader implements IByteReader
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
    public function readByteString()
    {
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
    public function readByte()
    {
        return $this->read(self::BYTE_BIT, BinaryCode::$T[BinaryCode::C]);
    }

    /**
     * @return int
     */
    public function readShortToByte()
    {
        return $this->readInt16ToByte();
    }

    /**
     * @return int
     */
    public function readInt16ToByte()
    {
        return $this->read(self::SHORT_BIT, BinaryCode::$T[BinaryCode::S]);
    }

    /**
     * @return int
     */
    public function readInt32ToByte()
    {
        return $this->read(self::INT32_BIT, BinaryCode::$T[BinaryCode::V]);
    }

    /**
     * @return int
     */
    public function readInt64ToByte()
    {
        return $this->read(self::INT64_BIT, BinaryCode::$T[BinaryCode::Q]);
    }

    /**
     * @param mixed $method
     * @param $len
     * @return mixed
     */
    public function read($method, int $len = self::BYTE_BIT)
    {
        $bytes = substr($this->readStream, $this->pos, $len);
        $this->pos += $len;
        $this->recordSequence .= BinaryCode::$N[BinaryCode::C] . $len;
        return $this->byteReader($bytes, $method);
    }

    /**
     * @param $bytes
     * @param int $bit
     * @param int $position
     * @return int
     */
    public function byteReader($bytes, int $bit, $position = 0)
    {
        $val = $i = 0;
        !is_string($bytes) ?: $bytes = str_split($bytes);
        if ($bit % 8 == 0 && is_int($byteNumber = $bit % 8)) {
            var_dump($byteNumber);
            $val = $bytes[0] & 0xff;
            while ($byteNumber++ < $byteNumber) {
                $val |= $bytes[$position + $byteNumber] & 0xff;
            }
        }
        $this->updatePos();
        return $val;
    }

    /**
     * ascii code to char string
     * @param string $byteString
     * @return array
     */
    public static function readByteStringToArray(string $byteString)
    {
        $bytesArray = [];
        array_map(function ($byte) use (&$bytesArray) {
            $bytesArray[] = $this->read($byte, self::BYTE_BIT);
        }, str_split($byteString));
        return $bytesArray;
    }

    /**
     * @return void
     */
    public function updatePos()
    {
        // TODO: Implement getReadStream() method.
    }

    /**
     * @return string
     */
    public function getReadSequence(): string
    {
        // TODO: Implement getReadSequence() method.
    }

    /**
     * @return string
     */
    public function getReadStream(): string
    {
        // TODO: Implement getReadStream() method.
    }
}
