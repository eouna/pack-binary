<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2019/8/19
 * Time: 15:31
 */

require_once __DIR__ . "/../autoload.php";
use BinaryStream\Exception\BinaryException;
use BinaryStream\BinaryReader;

$file_name = __DIR__ . "/binary/buffer.dat";
$reader = new BinaryReader(file_get_contents($file_name));
$decode_data = [];
$decode_data[] = $reader->readShort();
$decode_data[] = $reader->readInt16();
$decode_data[] = $reader->readInt32();
//$decode_data[] = $reader->readInt64();
$decode_data[] = $reader->readChar();
$decode_data[] = $reader->readString();
$decode_data[] = $reader->readUTFString();
var_dump($decode_data);