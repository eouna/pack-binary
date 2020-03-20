<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/19
 * Time: 15:31
 */

use BinaryStream\ByteWriter;
use BinaryStream\Exception\BinaryException;
use BinaryStream\BinaryWriter;
use BinaryStream\BinaryReader;
use BinaryStream\BinaryCode;

require_once __DIR__ . "/../autoload.php";
header("Content-type:text/html;charset=utf-8");
$file_name = __DIR__ . "/../example/binary/buffer.dat";    //store binary file path
try{

    $writer = new BinaryWriter($file_name);
    $writer->setBinaryModel(BinaryCode::BIG_ENDIAN);
    $writer->writeUTFString("it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! ");
    $writer->writeUTFString("");
    $writer->writeChar("s");
    $writer->writeByte(123);
    $writer->writeShort(2566);
    $writer->writeInt32(-9000);
    $writer->writeInt32(8000);
    //$writer->writeInt64(156443131321);
    //$writer->writeInt64(-156443131321);
    $writer->writeFloat(157);
    $writer->writeDouble(800);
    $writer->writeFloat(3.88511321334343434324443324321);
    $writer->writeDouble(148.3243413243132134343213244313132);
    $writer->writeUTFString("Begin Write Byte Data!");
    $byteWriter = new ByteWriter();
    $byteWriter->writeByte(120);
    $byteWriter->writeInt16ToByte(65530);
    $byteWriter->writeInt32ToByte(1526456146);
    $writer->writeByteObject($byteWriter);
    $writer->writeUTFString("End Write");

    $write_sequence = $writer->store();
    ////With File Append
    //$write_sequence = $writer->store(FILE_APPEND | LOCK_EX);

    //var_dump($writer->getWriteStream());        //get binary stream
    //var_dump($writer->getRecordSequence());     //get encode proceed string

    //$binary_stream = file_get_contents($file_name);
    //$reader = new BinaryReader($binary_stream);
    /////OR
    $reader = new BinaryReader($writer->getWriteStream());
    $reader->setBinaryModel(BinaryCode::BIG_ENDIAN);
    $res[] = $reader->readUTFString();
    $res[] = $reader->readUTFString();
    $res[] = $reader->readChar();
    $res[] = $reader->readByte();
    $res[] = $reader->readShort();
    $res[] = $reader->readInt32();
    $res[] = $reader->readInt32();
    //$res[] = $reader->readInt64();
    //$res[] = $reader->readInt64();
    $res[] = $reader->readFloat();
    $res[] = $reader->readDouble();
    $res[] = $reader->readFloat();
    $res[] = $reader->readDouble();

    $res[] = $reader->readUTFString();
    //read byte object
    $byteReader = $reader->readByByteReader();
    $res[] = $byteReader->readByte();
    $res[] = $byteReader->readBytesToShort();
    $res[] = $byteReader->readByteToInt32();
    $res[] = $reader->readUTFString();

    var_dump($res);

}catch (BinaryException $exception){
    var_dump($exception->getMessage());
}
