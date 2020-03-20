### PHP Read AND Write Binary Stream Package 
Binary Stream Packager - a tools to handle binary data or stream

- #### Manual
  
  - ##### Write Stream Method


  ````php
    use BinaryStream\BinaryWriter;
    $writer = new BinaryWriter();
    $writer->writeUTFString(  "it`s a sort string");
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
 
  - **note**
        
    1. the default encode method is BIG ENDIAN you can use method ***<u>*setBinaryModel*</u>*** to change it
    
     ````php
      $write->setBinaryModel(BinaryCode::LITTLE_ENDIAN | BinaryCode::BIG_ENDIAN);
    `````
    2. the  default wite flag to store file is ***FILE_BINARY*** you can use method ***<u>*store*</u>*** to change it
 
    ````php
       $writer->store(FILE_APPEND);
      //or 
      $writer->store(FILE_TEXT);
      //or
      $writer->store(FILE_APPEND | LOCK_EX);
    `````


    - ##### Read Stream Method
    - the read sequence must match with the write sequence
    
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

- #### How To Use It
>    use <p
>    style="fontsize:16px;color:#156b39;background-color:#2e2e2e">***composer
>    require eouna/pack-binary***</p> to install this package

