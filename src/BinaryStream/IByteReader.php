<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/19
 * Time: 13:33
 */

namespace BinaryStream;


interface IByteReader extends IStreamReader
{

    /**
     * @return mixed
     */
    public function updatePos();

    /**
     * @param $bytes
     * @param int $bit
     * @param int $position
     * @return mixed
     */
    public function byteReader($bytes, int $bit, $position = 0);
}
