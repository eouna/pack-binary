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
     * 二进制读写模式
     * @var bool $binary_model
     * */
    private $binary_model = BinaryCode::LITTLE_ENDIAN;

    /**
     * 二进制写文件
     * @var string $stream
     * */
    private $write_stream = '';

    /**
     * 加包
     * @var string $writeSequence
     * */
    private $writeSequence = null;

    /**
     * 加包顺序
     * @var string $writeSequence
     * */
    private $record_sequence = null;

    /**
     * 存储地址
     * */
    private $store_path = '';

    /**
     * 初始化
     * @param string $store_path
     * */
    public function __construct(string $store_path = ''){
        $this->store_path = $store_path;
    }

    /**
     * 设置短整型 默认小端字节序
     * @param int $integer
     * @throws BinaryException
     * */
    public function writeInt16(int $integer){

        if($integer > 0x7FFF || $integer < -0x8000 )
            throw new BinaryException(BinaryException::SHORT_VALUE_EXCEED_LIMIT);

        $this->writeSequence = $this->binary_model ? BinaryCode::$N[BinaryCode::v] : BinaryCode::$N[BinaryCode::n];
        $this->write_stream .= $this->write($integer);
        $this->record_sequence .= $this->writeSequence;
    }

    /**
     * 设置短整型 默认小端字节序
     * @throws BinaryException
     * @param int $integer
     * */
    public function writeShort(int $integer){

        if($integer > 0x7FFF || $integer < -0x8000 )
            throw new BinaryException(BinaryException::SHORT_VALUE_EXCEED_LIMIT);

        self::writeInt16($integer);
    }

    /**
     * 设置32位数字 默认小端字节序
     * @throws BinaryException
     * @param int $integer
     * */
    public function writeInt32(int $integer){

        if($integer > 0x7FFFFFFF || $integer < -0x80000000 )
            throw new BinaryException(BinaryException::INT32_VALUE_EXCEED_LIMIT);

        $this->writeSequence = $this->binary_model ? BinaryCode::$N[BinaryCode::V] : BinaryCode::$N[BinaryCode::N];
        $this->record_sequence .= $this->writeSequence;
        $this->write_stream .= $this->write($integer);
    }

    /**
     * 设置64位数字 默认小端字节序
     * @param float $integer
     * @throws
     * */
    public function writeInt64(float $integer){

        if($integer > 0x7FFFFFFFFFFFFFFF || $integer < -0x8000000000000000 )
            throw new BinaryException(BinaryException::INT64_VALUE_EXCEED_LIMIT);

        if(PHP_INT_SIZE * 8 != 64)
            throw new BinaryException(BinaryException::NOT_AVAILABLE_64BITE_FORMAT);

        $this->writeSequence = $this->binary_model ? BinaryCode::$N[BinaryCode::J] : BinaryCode::$N[BinaryCode::P];
        $this->record_sequence .= $this->writeSequence;
        $this->write_stream .= $this->write($integer);
    }

    /**
     * 设置字符
     * @param string $char
     * */
    public function writeChar(string $char){
        $this->writeSequence = BinaryCode::$N[BinaryCode::a];
        $this->record_sequence .= $this->writeSequence;
        $this->write_stream .= $this->write($char{0});
    }

    /**
     * 设置字符窜
     * @throws
     * @param string $string
     * */
    public function writeString(string $string){
        self::writeUTFString($string);
    }

    /**
     * 设置UTF字符
     * @param string $uftString
     * @throws BinaryException
     * */
    public function writeUTFString(string $uftString){

        $string_len = strlen($uftString);
        self::writeShort($string_len);

        $this->writeSequence = BinaryCode::$N[BinaryCode::a] . "*";
        $this->record_sequence .= $this->writeSequence;
        $this->write_stream .= $this->write($uftString);
    }

    /**
     * 返回写的字符串
     * @param $data
     * @return string
     * */
    protected function write($data){
        return pack($this->writeSequence, $data);
    }

    /**
     * save binary string to file
     * */
    public function store(){

        if(empty($this->store_path) && !empty($this->write_stream))
            return file_put_contents(__DIR__, $this->write_stream);

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

        return $this->writeSequence;
    }
}