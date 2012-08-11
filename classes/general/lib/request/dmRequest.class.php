<?php
class dmRequest {

    public function isHomepage() {
    
        global $APPLICATION;
        
        return $APPLICATION->GetCurDir() == '/';
    
    }

}