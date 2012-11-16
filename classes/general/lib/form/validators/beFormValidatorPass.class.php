<?php
class beFormValidatorPass extends beFormValidator {
    
    public function configure($options = array()) {
        parent::configure($options);
        $this->setOption('required', false);
    }

}