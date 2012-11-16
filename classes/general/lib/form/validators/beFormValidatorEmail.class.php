<?php
class beFormValidatorEmail extends beFormValidator {
        
    protected function doValidate($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) return;
        $this->errors[] = beArray::get($this->messages, 'invalid');
    }
    

}