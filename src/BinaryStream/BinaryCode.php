<?php
/**
 * Created by PhpStorm.;
 * User: ccl;
 * Date: 2019/3/7;
 * Time: 14:35;
 */

namespace BinaryStream;


class BinaryCode{

    /** 大端字节序*/
    const BIG_ENDIAN = false;

    /** 小端字节序*/
    const LITTLE_ENDIAN = true;

    /**
    const a = "以NUL字节填充字符串空白";
    const A = "以SPACE(空格)填充字符串";
    const h = "十六进制字符串，低位在前";
    const H = "十六进制字符串，高位在前";
    const c = "有符号字符";
    const C = "无符号字符";
    const s = "有符号短整型(16位，主机字节序)";
    const S = "无符号短整型(16位，主机字节序)";
    const n = "无符号短整型(16位，大端字节序)";
    const v = "无符号短整型(16位，小端字节序)";
    const i = "有符号整型(机器相关大小字节序)";
    const I = "无符号整型(机器相关大小字节序)";
    const l = "有符号长整型(32位，主机字节序)";
    const L = "无符号长整型(32位，主机字节序)";
    const N = "无符号长整型(32位，大端字节序)";
    const V = "无符号长整型(32位，小端字节序)";
    const q = "有符号长长整型(64位，主机字节序)";
    const Q = "无符号长长整型(64位，主机字节序)";
    const J = "无符号长长整型(64位，大端字节序)";
    const P = "无符号长长整型(64位，小端字节序)";
    const f = "单精度浮点型(机器相关大小)";
    const d = "双精度浮点型(机器相关大小)";
    const x = "NUL字节";
    const X = "回退一字节";
     */


    const a = "以NUL字节填充字符串空白";
    const A = "以SPACE(空格)填充字符串";
    const h = "十六进制字符串，低位在前";
    const H = "十六进制字符串，高位在前";
    const c = "有符号字符";
    const C = "无符号字符";
    const s = "有符号短整型(16位，主机字节序)";
    const S = "无符号短整型(16位，主机字节序)";
    const n = "无符号短整型(16位，大端字节序)";
    const v = "无符号短整型(16位，小端字节序)";
    const i = "有符号整型(机器相关大小字节序)";
    const I = "无符号整型(机器相关大小字节序)";
    const l = "有符号长整型(32位，主机字节序)";
    const L = "无符号长整型(32位，主机字节序)";
    const N = "无符号长整型(32位，大端字节序)";
    const V = "无符号长整型(32位，小端字节序)";
    const q = "有符号长长整型(64位，主机字节序)";
    const Q = "无符号长长整型(64位，主机字节序)";
    const J = "无符号长长整型(64位，大端字节序)";
    const P = "无符号长长整型(64位，小端字节序)";
    const f = "单精度浮点型(机器相关大小)";
    const d = "双精度浮点型(机器相关大小)";
    const x = "NUL字节";
    const X = "回退一字节";

    /**
     * @var array $T 字节长度数组
     * */
    public static $T = [
        self::a => 1,
        self::A => 1,
        self::h => 1,
        self::H => 1,
        self::c => 1,
        self::C => 1,
        self::s => 2,
        self::S => 2,
        self::n => 2,
        self::v => 2,
        self::i => 4,
        self::I => 4,
        self::l => 4,
        self::L => 4,
        self::N => 4,
        self::V => 4,
        self::q => 8,
        self::Q => 8,
        self::J => 8,
        self::P => 8,
        self::f => 4,
        self::d => 8,
        self::x => 1,
        self::X => 1,
    ];

    /**
     * @var array 解析名
     * */
    public static $N = [
        self::a => 'a',
        self::A => 'A',
        self::h => 'h',
        self::H => 'H',
        self::c => 'c',
        self::C => 'C',
        self::s => 's',
        self::S => 'S',
        self::n => 'n',
        self::v => 'v',
        self::i => 'i',
        self::I => 'I',
        self::l => 'l',
        self::L => 'L',
        self::N => 'N',
        self::V => 'V',
        self::q => 'q',
        self::Q => 'Q',
        self::J => 'J',
        self::P => 'P',
        self::f => 'f',
        self::d => 'd',
        self::x => 'x',
        self::X => 'X',
    ];
}