<?php
class beImage {

    protected $fileId = null;

    protected $attributes = null;

    protected $originalData = null;
    
    protected $resizedData = array();

    public static function create($fileId, $loadOriginalData = false) {

        $image = new self();
        $image->setFileId($fileId, $loadOriginalData);
        return $image;

    }

    public function __toString() {

        return $this->render();

    }

    public function getOriginalWidth() {

        return beCoreArray::get($this->originalData, 'WIDTH');

    }

    public function getOriginalHeight() {

        return beCoreArray::get($this->originalData, 'HEIGHT');

    }

    public function getOriginalSrc() {

        return beCoreArray::get($this->originalData, 'SRC');

    }

    public function getOriginalData($name) {

        return beCoreArray::get($this->originalData, $name);

    }

    public function setFileId($fileId, $loadOriginalData = false) {

        if (is_array($fileId)) {

            $this->originalData = $fileId;

            $fileId = beCoreArray::get($this->originalData, 'ID');

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
    
        $this->resize();
    
        $html = '';
        if ($this->fileId) {
        
            $data = $this->resizedData;
            $width = beArray::get($data, 'width');
            $height = beArray::get($data, 'height');
            $src = $this->getSrc();
            
            if ($width && $height && $src) {
                $html = '
                    <img
                        width="'.$width.'"
                        height="'.$height.'"
                        src="'.$src.'"
                        '.$this->attributes.'
                    >
                ';
            }
            
        }
        return $html;
    }
    
    public function resize() {
    
        if (!$this->fileId) return $this;
        
        $this->resizedData = CFile::ResizeImageGet(
            $this->fileId,
            array("width" => $this->width, "height" => $this->height),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true,
            array()
        );
        
        return $this;
        
    }
    
    public function getSrc() {
                
        return beArray::get($this->resizedData, 'src');
        
    }
}