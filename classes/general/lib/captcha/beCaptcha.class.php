<?php

class beCaptcha extends CCaptcha {

    private $bgImage = '';

    public function __construct() {
        parent::__construct();
        $this->SetBgImage($_SERVER["DOCUMENT_ROOT"]."/bg_captcha.jpg");
    }

   public function SetBgImage($imgPath) {

      if(file_exists($imgPath)) {
         $bgImgProp = getimagesize($imgPath);

         $this->bgImage = $imgPath;
         $this->imageWidth = $bgImgProp[0];
         $this->imageHeight = $bgImgProp[1];
      }
   }

   function InitImage($width = false, $height = false)
   {
      if(!$width) $width = $this->imageWidth;
      if(!$height) $height = $this->imageHeight;

      $image = false;
      if(strlen($this->bgImage) > 0) {
         $image = @imagecreatefromjpeg($this->bgImage);
      }
      if(!$image) {

         $image = imagecreatetruecolor($width, $height);
         if(!$this->arRealBGColor)
         {
            $this->arRealBGColor = $this->GetColor($this->arBGColor);
         }
         $bgColor = imagecolorallocate($image, $this->arRealBGColor[0], $this->arRealBGColor[1], $this->arRealBGColor[2]);
         imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $bgColor);
      }
      return $image;
   }

    function DrawEllipses() {
    }

    function DrawLines() {
    }

		function CreateImage()
		{
			$this->image = $this->InitImage();

			$this->DrawEllipses();

			if (!$this->bLinesOverText)
				$this->DrawLines();

			$right_border = $this->DrawText();
//			if($right_border < ($this->imageWidth - $this->textStartX))
//			{
//				$img2 = $this->InitImage();
//				imagecopy($img2, $this->image,
//					$this->textStartX + rand(0, $this->imageWidth - $right_border - $this->textStartX), 0,
//					$this->textStartX, 0,
//					$right_border - $this->textStartX, $this->imageHeight
//				);
//				$this->image = $img2;
//			}

			if ($this->bLinesOverText)
				$this->DrawLines();

			if($this->bWaveTransformation)
			{
				$this->Wave();
			}

		}


}
