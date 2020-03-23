### PHP Read AND Write Binary Stream Package 
二进制流读写工具，封装了一些二进制常用的读写方法

- #### [English Version](https://github.com/eouna/pack-binary/blob/master/README.md)

- #### 使用说明
  
  - ##### 读取二进制流的相关方法

  ````php
    use BinaryStream\BinaryWriter;
    $writer = new BinaryWriter();
    $writer->writeUTFString( str_repeat("It`s long string,", 200) );
    $writer->writeUTFString("");
    $writer->writeInt32(-90);
    $writer->writeDouble(800);
    $writer->writeFloat(3.88511321334343434324443324321);
    $writer->writeDouble(148.3243413243132134343213244313132);
    $writer->writeChar("s");
    $byteWriter = new ByteWriter();
    $byteWriter->writeByte(120);
    $byteWriter->writeInt16ToByte(65530);
    $byteWriter->writeInt32ToByte(1526456146);
    $writer->writeByteObject($byteWriter);
  ````
 
 
  - **注：**
        
    1. 程序默认的字节序是大端字节序你可以使用
       ***<u>*setBinaryModel()*</u>*** 方法修改字节序
    
     ````php
      $write->setBinaryModel(BinaryCode::LITTLE_ENDIAN | BinaryCode::BIG_ENDIAN);
    `````
    2. 程序默认存储本地流文件的方式是 ***FILE_BINARY*** 你可以使用
       ***<u>*store()*</u>*** 改变存储模式
 
    ````php
       $writer->store(FILE_APPEND);
      //or 
      $writer->store(FILE_TEXT);
      //or
      $writer->store(FILE_APPEND | LOCK_EX);
    `````

  - ##### 读取二进制流的方式
    
    ###### 注：读取顺序一定要匹配写入的顺序
    
    ````
    $reader = new BinaryReader($writer->getWriteStream());
    $res[] = $reader->readUTFString();
    $res[] = $reader->readUTFString();
    $res[] = $reader->readInt32();
    $res[] = $reader- >readDouble();
    $res[] = $reader->readDouble();
    $res[] = $reader->readFloat();
    $res[] = $reader->readDouble();
    $res[] =  $reader->readChar();
    $byteReader = $reader->readByByteReader();
    $res[] = $byteReader->readByte();
    $res[] = $byteReader->readBytesToShort();
    $res[] = $byteReader->readByteToInt32();
    ````

- #### 如何使用
>    可以通过Composer命令 <p
>    style="fontsize:16px;color:#156b39;background-color:#2e2e2e">***composer
>    require eouna/pack-binary***</p> 安装此工具包 

