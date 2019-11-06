<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/19
 * Time: 15:31
 */

use BinaryStream\Exception\BinaryException;
use BinaryStream\BinaryWriter;
use BinaryStream\BinaryReader;
require_once __DIR__ . "/../autoload.php";

$file_name = __DIR__ . "/binary/buffer.dat";    //store binary file path
$writer = new BinaryWriter($file_name);
try{

    $writer->writeUTFString("it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! it`s a long string! ");
    $writer->writeUTFString("");
    $writer->writeInt32(-90);
    $writer->writeDouble(157);
    $writer->writeDouble(800);
    $writer->writeFloat(3.88511321334343434324443324321);
    $writer->writeDouble(148.3243413243132134343213244313132);
    $writer->writeChar("s");
    $write_sequence = $writer->store();
    var_dump($writer->getWriteStream());        //get binary stream

    $reader = new BinaryReader($writer->getWriteStream());
    $res[] = $reader->readUTFString();
    $res[] = $reader->readUTFString();
    $res[] = $reader->readInt32();
    $res[] = $reader->readDouble();
    $res[] = $reader->readDouble();
    $res[] = $reader->readFloat();
    $res[] = $reader->readDouble();
    $res[] = $reader->readChar();

    var_dump($res);
}catch (BinaryException $exception){
    var_dump($exception->getMessage());
}