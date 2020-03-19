<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/3/7
 * Time: 15:33
 */

namespace BinaryStream;
use BinaryStream\Exception\BinaryException;

class BinaryWriter implements IStreamWriter
{
    /**
     * binary write or read model
     * @var bool $binaryModel
     * */
    private $binaryModel = BinaryCode::BIG_ENDIAN;

    /**
     * buffer write stream
     * @var string $stream
     * */
    private $writeStream = '';

    /**
     * buffer write sequence
     * @var string $writeSequence
     * */
    private $writeSequence = null;

    /**
     * record buffer write sequence
     * @var string $writeSequence
     * */
    private $recordSequence = null;

    /**
     * store path string
     * @var string $storePath
     * */
    private $storePath = '';

    /**
     * initial store path
     * @param string $storePath
     * */
    public function __construct(string $storePath = ''){
        $this->storePath = $storePath;
    }

    /**
     * @param bool binaryModel
     */
    public function setBinaryModel(bool $binaryModel){

        $this->binaryModel = $binaryModel;
    }

    /**
     * @param $byte
     * @throws BinaryException
     */
    public function writeByte($byte){

        if($byte > 0x7FFF)
            throw new BinaryException(BinaryException::BYTE_VALUE_EXCEED_LIMIT);

        $this->writeSequence = BinaryCode::$N[BinaryCode::C];
        $this->writeStream .= $this->write($byte);
        $this->recordSequence .= $this->writeSequence;
    }

    /**
     * @param ByteWriter $byteWriter
     */
    public function writeByteObject(ByteWriter $byteWriter){

        if($byteWriter instanceof ByteWriter){
            $this->writeStream .= $byteWriter->getWriteStream();
            $this->recordSequence .= $byteWriter->getRecordSequence();
        }
    }

    /**
     * write a 16 byte integer
     * @param int $integer
     * @throws BinaryException
     * */
    public function writeInt16(int $integer){

        if($integer > 0x7FFF || $integer < -0x8000 )
            throw new BinaryException(BinaryException::SHORT_VALUE_EXCEED_LIMIT);

        $this->writeSequence = $this->binaryModel ? BinaryCode::$N[BinaryCode::v] : BinaryCode::$N[BinaryCode::n];
        $this->writeStream .= $this->write($integer);
        $this->recordSequence .= $this->writeSequence;
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

        $this->writeSequence = $this->binaryModel ? BinaryCode::$N[BinaryCode::V] : BinaryCode::$N[BinaryCode::N];
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= $this->write($integer);
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

        $this->writeSequence = $this->binaryModel ? BinaryCode::$N[BinaryCode::J] : BinaryCode::$N[BinaryCode::P];
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= $this->write($integer);
    }

    /**
     * write a float
     * @param float $float
     * @throws
     * */
    public function writeFloat(float $float){

        if($float < -3.4e+38 || $float > 3.4e+38)
            throw new BinaryException(BinaryException::NOT_A_FLOAT_VARIABLE);

        $this->writeSequence = BinaryCode::$N[BinaryCode::f];
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= strrev($this->write($float));
    }

    /**
     * write a float
     * @param double $double
     * @throws
     * */
    public function writeDouble($double){

        if($double < -1.7E-308 || $double > 1.7E+308)
            throw new BinaryException(BinaryException::NOT_A_DOUBLE_VARIABLE);

        $this->writeSequence = BinaryCode::$N[BinaryCode::d];
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= strrev($this->write($double));
    }

    /**
     * write a char
     * @param string $char
     * */
    public function writeChar(string $char){

        $this->writeSequence = BinaryCode::$N[BinaryCode::a];
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= $this->write($char{0});
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
     * @param string $utfString
     * @throws BinaryException
     * */
    public function writeUTFString(string $utfString){

        $stringLen = strlen($utfString);
        if($stringLen == 0){$stringLen = 1; $utfString = ' ';}
        self::writeShort($stringLen);

        $this->writeSequence = BinaryCode::$N[BinaryCode::a] . "*";
        $this->recordSequence .= $this->writeSequence;
        $this->writeStream .= $this->write($utfString);
    }

    /**
     * return pack binary string
     * @param $data
     * @return string
     * */
    public function write($data){

        return pack($this->writeSequence, $data);
    }

    /**
     * save binary string to file
     * @param int $writeModel
     * @return int | bool
     */
    public function store(int $writeModel = FILE_BINARY){

        if(empty($this->storePath) && !empty($this->writeStream))
            return file_put_contents(__DIR__ . '/out.dat', $this->writeStream, $writeModel);

        $baseDir = dirname($this->storePath);
        if(!is_dir($baseDir))
            mkdir($baseDir, 655, true);

        return file_put_contents($this->storePath, $this->writeStream, $writeModel);
    }

    /**
     * @return string
     */
    public function getRecordSequence(): string{

        return $this->recordSequence;
    }

    /**
     * @return string
     */
    public function getWriteStream(): string{

        return $this->writeStream;
    }
}
