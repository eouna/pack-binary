<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/3/7
 * Time: 15:33
 */

namespace BinaryStream;

class BinaryReader
{

    /**
     * binary reader model
     * @var bool $binary_model
     * */
    private $binary_model = BinaryCode::BIG_ENDIAN;

    /**
     * read stream
     * @var string $stream
     * */
    private $read_stream = '';

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
     * @param string $read_stream
     * */
    public function __construct(string $read_stream){
        $this->read_stream = $read_stream;
    }

    /**
     * @param bool binary_model
     */
    public function setBinaryModel(bool $binary_model): void{

        $this->binary_model = $binary_model;
    }

    /**
     * read a 16 byte integer
     * @return int
     * */
    public function readInt16():int {
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::v : BinaryCode::n;
        return $this->readBinary($method);
    }

    /**
     * read a short
     * @return int
     * */
    public function readShort():int {
        return self::readInt16();
    }

    /**
     * read a 32 byte integer
     * @return int
     * */
    public function readInt32():int {
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::V : BinaryCode::N;
        return $this->readBinary($method);
    }

    /**
     * read a 64 byte integer
     * @return float
     * */
    public function readInt64():float {
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::J : BinaryCode::P;
        return $this->readBinary($method);
    }


    /**
     * read a float
     * @return float
     * */
    public function readFloat():float {
        $this->readSequence .= $method = BinaryCode::f;
        return $this->readBinary($method);

    }

    /**
     * read a float
     * */
    public function readDouble() {
        $this->readSequence .= $method = BinaryCode::d;
        return $this->readBinary($method);
    }

    /**
     * read a char
     * @return string
     * */
    public function readChar(){
        $this->readSequence .= $method = BinaryCode::a;
        return $this->readBinary($method);
    }

    /**
     * read string
     * @param int $str_len
     * @return string
     * */
    public function readString(int $str_len = 0){
        return self::readUTFString($str_len);
    }

    /**
     * read utf string
     * @param int $str_len
     * @return string
     * */
    public function readUTFString(int $str_len = 0){
        $short_len = ($str_len ? $str_len : self::readShort());
        $this->readSequence .= $method = BinaryCode::a;
        return $this->readBinary($method , $short_len);
    }

    /**
     * read byte
     * @throws
     * @param string $method
     * @param int $len
     * @return string $data
     * */
    private function readBinary(string $method, int $len = 0){

        $binary_data = substr($this->read_stream, $this->pos, ($len ? $len : BinaryCode::$T[$method]));

        if($method == BinaryCode::d || $method == BinaryCode::f)
            $binary_data = strrev($binary_data);

        $this->pos += $len ? $len : BinaryCode::$T[$method];
        $binary_data = unpack(BinaryCode::$N[$method] . ($len != 0 ? $len : ''), $binary_data);

        return is_array($binary_data) ? (empty($binary_data) ? '' : $binary_data[1]) : $binary_data;
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

        return $this->read_stream;
    }

}
