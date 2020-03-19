<?php
/**
 * Created by PhpStorm.
 * User: ccl
 * Date: 2020/3/18
 * Time: 10:39
 */

namespace BinaryStream;


interface IStreamWriter
{
    /**
     * @param $data
     * @return mixed
     */
    public function write($data);

    /**
     * @return string
     */
    public function getWriteStream(): string;

    /**
     * @return string
     */
    public function getRecordSequence(): string;
}
