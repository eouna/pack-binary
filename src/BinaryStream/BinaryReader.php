<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/3/7
 * Time: 15:33
 */

namespace BinaryStream;

class BinaryReader implements IStreamReader
{

    /**
     * binary reader model
     * @var bool $binaryModel
     * */
    private $binaryModel = BinaryCode::BIG_ENDIAN;

    /**
     * read stream
     * @var string $stream
     * */
    private $readStream = '';

    /**
     * unpack binary sequence
     * @var string $readSequence
     * */
    private $readSequence = null;

    /**
     * decode pos
     * @var int $pos
     * */
    private $pos = 0;

    /**
     * handle binary string
     * @param string $readStream
     */
    public function __construct(string $readStream){

        $this->readStream = $readStream;
    }

    /**
     * @param bool binary_model
     */
    public function setBinaryModel(bool $binaryModel){

        $this->binaryModel = $binaryModel;
    }

    /**
     * read a byte
     * @return int
     */
    public function readByte(): int{
        $this->readSequence .= $method = BinaryCode::C;
        return $this->read($method) & 0xff;
    }

    /**
     * read a byte to char
     * @return int
     */
    public function readByteToChar(): int{
        return chr($this->readByte());
    }

    /**
     * @return ByteStreamReader
     */
    public function readByByteReader(){
        return new ByteStreamReader($this);
    }

    /**
     * read a 16 byte integer
     * @return int
     * */
    public function readInt16(): int{

        $this->readSequence .= $method = $this->binaryModel ? BinaryCode::v : BinaryCode::n;
        return $this->read($method);
    }

    /**
     * read a short
     * @return int
     * */
    public function readShort(): int{

        return self::readInt16();
    }

    /**
     * read a 32 byte integer
     * @return int
     * */
    public function readInt32(): int{

        $this->readSequence .= $method = $this->binaryModel ? BinaryCode::V : BinaryCode::N;
        return $this->read($method);
    }

    /**
     * read a 64 byte integer
     * @return float
     * */
    public function readInt64(): float{

        $this->readSequence .= $method = $this->binaryModel ? BinaryCode::J : BinaryCode::P;
        return $this->read($method);
    }


    /**
     * read a float
     * @return float
     * */
    public function readFloat(): float{

        $this->readSequence .= $method = BinaryCode::f;
        return $this->read($method);

    }

    /**
     * read a float
     * */
    public function readDouble(){

        $this->readSequence .= $method = BinaryCode::d;
        return $this->read($method);
    }

    /**
     * read a char
     * @return string
     * */
    public function readChar(){

        $this->readSequence .= $method = BinaryCode::a;
        return $this->read($method);
    }

    /**
     * read string
     * @param int $strLen
     * @return string
     * */
    public function readString(int $strLen = 0){

        return self::readUTFString($strLen);
    }

    /**
     * read utf string
     * @param int $strLen
     * @return string
     * */
    public function readUTFString(int $strLen = 0){

        $shortLen = ($strLen ? $strLen : self::readShort());
        $this->readSequence .= $method = BinaryCode::a;
        return $this->read($method, $shortLen);
    }

    /**
     * read byte
     * @param string $method
     * @param int $len
     * @return string $data
     * *@throws
     */
    public function read($method, int $len = 0){

        $binaryData = substr($this->readStream, $this->pos, ($len ? $len : BinaryCode::$T[$method]));

        if ($method == BinaryCode::d || $method == BinaryCode::f)
            $binaryData = strrev($binaryData);

        $this->pos += $len ? $len : BinaryCode::$T[$method];
        $binaryData = unpack(BinaryCode::$N[$method] . ($len != 0 ? $len : ''), $binaryData);

        return is_array($binaryData) ? (empty($binaryData) ? '' : $binaryData[1]) : $binaryData;
    }

    /**
     * @return string
     */
    public function getReadSequence(): string{

        return $this->readSequence;
    }

    /**
     * @return string
     */
    public function getReadStream(): string{

        return $this->readStream;
    }

    /**
     * @param int $pos
     */
    public function setPos(int $pos)
    {
        $this->pos = $pos;
    }

    /**
     * @return int
     */
    public function getPos(): int
    {
        return $this->pos;
    }
}
