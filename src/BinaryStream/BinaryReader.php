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
     * 二进制读写模式
     * @var bool $binary_model
     * */
    private $binary_model = BinaryCode::LITTLE_ENDIAN;

    /**
     * 二进制读文件
     * @var string $stream
     * */
    private $read_stream = '';

    /**
     * 解包顺序
     * @var string $readSequence
     * */
    private $readSequence = null;

    /**
     * 解析指针
     * @var int $pos
     * */
    private $pos = 0;

    /**
     * 初始化
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
     * 读取16位数字 默认小端字节序
     * @return mixed
     * */
    public function readInt16(){
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::v : BinaryCode::n;
        return $this->readBinary($method);
    }

    /**
     * 读取16位数字 默认小端字节序
     * @return mixed
     * */
    public function readShort(){
        return self::readInt16();
    }

    /**
     * 读取32位数字 默认小端字节序
     * @return mixed
     * */
    public function readInt32(){
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::V : BinaryCode::N;
        return $this->readBinary($method);
    }

    /**
     * 读取64位数字 默认小端字节序
     * @return mixed
     * */
    public function readInt64(){
        $this->readSequence .= $method = $this->binary_model ? BinaryCode::J : BinaryCode::P;
        return $this->readBinary($method);
    }

    /**
     * 读取单个字符
     * */
    public function readChar(){
        $this->readSequence .= $method = BinaryCode::a;
        return $this->readBinary($method);
    }

    /**
     * 读取字符串
     * @return mixed
     * */
    public function readString(){
        return self::readUTFString();
    }

    /**
     * 读取UTF字符
     * @return string
     * */
    public function readUTFString(){
        $short = self::readShort();
        $this->readSequence .= $method = BinaryCode::a;
        return $this->readBinary($method , $short);
    }

    /**
     * 读取字节
     * @param string $method
     * @param int $len
     * @return string $data
     * */
    private function readBinary(string $method,int $len = 0){

        $binary_data = substr($this->read_stream, $this->pos, ($len ? $len : BinaryCode::$T[$method]));
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