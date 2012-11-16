<?php
class beFormWidgetBitrixCaptcha extends beFormWidget {

    public function renderCaptcha() {
    
        global $APPLICATION;
    
        $captchaCode = htmlspecialchars($APPLICATION->CaptchaGetCode());
        
        $html = '<input type="hidden" name="captcha_sid" value="'.$captchaCode.'" />
        <img src="/bitrix/tools/captcha.php?captcha_sid='.$captchaCode.'" width="180" height="40" />';    
        
        return $html;
        
    }


}