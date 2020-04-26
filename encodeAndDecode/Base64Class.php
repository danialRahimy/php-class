<?php

/**
 * Class Base64
 *
 * date created: 2020/04/11
 * author: Danial Rahimi
 * email: daniel_rahimi@outlook.com
 * github page: https://github.com/danialRahimy
 * repository page on github: https://github.com/danialRahimy/php-class
 */


class Base64Class
{

    private $imageExtension;

    /**
     * Base64 constructor.
     */
    public function __construct()
    {
        $this->setImageExtension();
    }

    private function setImageExtension()
    {
        $extension = array("jpg", "jpeg", "png", "gif");
        $this->imageExtension = $extension;
    }

    /**
     * @param ( array or string ) $imageExtension
     *
     * add your extension to identify the images, defaults are in "setImageExtension" method
     */
    public function addImageExtension($imageExtension)
    {
        if (is_array($imageExtension)) {
            $this->imageExtension = array_merge($this->imageExtension, $imageExtension);
        } else {
            $this->imageExtension[] = $imageExtension;
        }
    }

    /**
     * @param ( array or string ) $imageExtension
     *
     * remove the specific image extension, defaults are in "setImageExtension" method
     */
    public function removeImageExtension($imageExtension)
    {
        if (is_array($imageExtension) and count($imageExtension) > 0) {
            for ($i = 0; $i < count($imageExtension); $i++) {
                for ($j = 0; $j < count($this->imageExtension); $j++) {
                    if ($imageExtension[$i] === $this->imageExtension[$j]) {
                        array_splice($this->imageExtension, $j, 1);
                    }
                }
            }
        }

        if (is_string($imageExtension)) {
            for ($i = 0; $i < count($this->imageExtension); $i++) {
                if ($imageExtension === $this->imageExtension[$i]) {
                    array_splice($this->imageExtension, $i, 1);
                }
            }
        }
    }

    /**
     * @param ( array or string ) $url
     *
     * @return array, each image is an array that contains =>
     * "all"=>      example: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAB4AAAA
     * "code"=>     example: iVBORw0KGgoAAAANSUhEUgAAB4AAAA
     * "category"=> example: image
     * "type"=>     example: png
     */
    public function imageToBase64($url)
    {
        $outPut = array();

        if (is_array($url) and count($url) > 0) {
            for ($i = 0; $i < count($url); $i++) {
                $outPut[] = $this->imageToBase64Core($url[$i]);
            }
        }

        if (!is_array($url)) {
            $outPut[] = $this->imageToBase64Core($url);
        }

        return $outPut;
    }

    /**
     * @param $url
     *
     * relative to "imageToBase64" method
     *
     * @return array
     */
    private function imageToBase64Core($url)
    {
        $outPut = array();

        if (file_exists($url)) {
            $type = pathinfo($url, PATHINFO_EXTENSION);

            if (in_array($type, $this->imageExtension)) {
                $data = file_get_contents($url);
                $encode = base64_encode($data);
                $category = "image";
                $base64 = "data:{$category}/" . $type . ";base64," . $encode;
                $outPut[$url] = array(
                    "all" => $base64, "code" => $encode, "category" => $category, "type" => $type,
                );
            }
        }

        return $outPut;
    }

}