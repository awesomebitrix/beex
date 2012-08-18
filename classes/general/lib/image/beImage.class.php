<?php
class beImage {

    protected $fileId = null;

    protected $attributes = null;

    protected $originalData = null;

    public static function create($fileId, $loadOriginalData = false) {

        $image = new self();
        $image->setFileId($fileId, $loadOriginalData);
        return $image;

    }

    public function __toString() {

        return $this->render();

    }

    public function getOriginalWidth() {

        return beArray::get($this->originalData, 'WIDTH');

    }

    public function getOriginalHeight() {

        return beArray::get($this->originalData, 'HEIGHT');

    }

    public function getOriginalSrc() {

        return beArray::get($this->originalData, 'SRC');

    }

    public function getOriginalData($name) {

        return beArray::get($this->originalData, $name);

    }

    public function setFileId($fileId, $loadOriginalData = false) {

        if (is_array($fileId)) {

            $this->originalData = $fileId;

            $fileId = beArray::get($this->originalData, 'ID');

        }
        elseif(loadOriginalData) {

            $this->originalData = CFile::GetFileArray($fileId);

        }

        $this->fileId = $fileId;

    }

    public function setAttributes($attributes) {

        $this->attributes = $attributes;

        return $this;

    }

    public function size($width, $height = 999999) {

        $this->width($width);
        $this->height($height);

        return $this;

    }

    public function width($width) {

        $this->width = $width;

        return $this;

    }

    public function height($height) {

        $this->height = $height;

        return $this;

    }

    public function render() {
        $html = '';
        if ($this->fileId) {
            $arFileTmp = CFile::ResizeImageGet(
                $this->fileId,
                array("width" => $this->width, "height" => $this->height),
                BX_RESIZE_IMAGE_PROPORTIONAL,
                true,
                array()
            );
            if ($arFileTmp["width"] && $arFileTmp["height"] && $arFileTmp["src"]) {
                $html = '
                    <img
                        width="'.$arFileTmp["width"].'"
                        height="'.$arFileTmp["height"].'"
                        src="'.$arFileTmp["src"].'"
                        '.$this->attributes.'
                    >
                ';
            }
        }
        return $html;
    }
}