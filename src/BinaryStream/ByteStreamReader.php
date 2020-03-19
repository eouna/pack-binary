<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/18
 * Time: 12:37
 */

namespace BinaryStream;


class ByteStreamReader extends ByteReader
{
    /**
     * @var BinaryReader $readStream
     */
    protected $binaryReaderEntity;

    /**
     * ByteStreamReader constructor.
     * @param BinaryReader $byteStream
     */
    public function __construct(BinaryReader &$byteStream)
    {
        parent::__construct($byteStream);
        $this->binaryReaderEntity = $byteStream;
        $this->readStream = substr($byteStream->getReadStream(), 0, $byteStream->getPos());
    }

    /**
     * set parent read stream pos
     */
    public function __destruct()
    {
        $this->binaryReaderEntity->setPos($this->pos);
        unset($this->binaryReaderEntity);
    }

    /**
     * @return void
     */
    public function updatePos(){ $this->binaryReaderEntity->setPos($this->pos);}
}
