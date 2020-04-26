<?php


class JsonClass
{

    private $fileAddress = "";

    /**
     * JsonClass constructor.
     * @param $fileAddress
     */
    public function __construct($fileAddress)
    {
        $this->fileAddress = $fileAddress;
    }

    /**
     * @return mixed
     */
    public function getData (){

        return json_decode(file_get_contents($this->fileAddress),JSON_UNESCAPED_UNICODE | JSON_OBJECT_AS_ARRAY);

    }

    /**
     * @param $data
     */
    public function putData ($data){

        file_put_contents($this->fileAddress,json_encode($data,JSON_UNESCAPED_UNICODE | JSON_OBJECT_AS_ARRAY | JSON_PRETTY_PRINT));

    }
}