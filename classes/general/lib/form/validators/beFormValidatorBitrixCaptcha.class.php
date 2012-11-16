<?php
class beFormValidatorBitrixCaptcha extends beFormValidator {
        
    protected function doValidate($value) {
    
        global $APPLICATION;
    
        if ($APPLICATION->CaptchaCheckCode($value, $_REQUEST["captcha_sid"])) return;
        
        $this->errors[] = beArray::get($this->messages, 'invalid');
    }
    

}