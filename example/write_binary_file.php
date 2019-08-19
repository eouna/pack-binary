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
    $writer->writeShort(16);
    $writer->writeInt16(166);
    $writer->writeInt32(1666666);
    //$writer->writeInt64(1666666666666);
    $writer->writeChar("H");
    $writer->writeString("Hello World!");
    $writer->writeUTFString("你好！");
    $write_sequence = $writer->store();
}catch (BinaryException $exception){
    var_dump($exception);
}