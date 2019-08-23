<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/19
 * Time: 15:31
 */

use BinaryStream\Exception\BinaryException;
use BinaryStream\BinaryWriter;
require_once __DIR__ . "/../autoload.php";

$file_name = __DIR__ . "/binary/buffer.dat";
$writer = new BinaryWriter($file_name);
try{
    $writer->writeShort(((2 << 14) - 1));
    $writer->writeInt16(((2 << 14) - 1));
    $writer->writeInt32(((-1) * (2 << 30) - 1));
    $writer->writeFloat(.12345678);
    $writer->writeDouble(.123456789123456);
    $writer->writeChar("H");
    $writer->writeString("Hello World!");
    $writer->writeUTFString("你好！");
    $write_sequence = $writer->store();
}catch (BinaryException $exception){
    var_dump($exception->getMessage());
}