<?php
class beFormValidator extends beConfigurable {

    protected $messages = array();
    protected $errors = array();

    public function __construct($options = array()) {
        $this->configure($options);
        $this->messages = array(
            'required' => 'Обязательно для заполнения',
            'invalid' => 'Ошибка заполнения',
        );
    }
    
    public function getDefaultOptions() {
        return array(
            'required' => true,
        );
    }
    
    public function setMessage($name, $message) {
        $this->messages[$name] = $message;
        return $this;
    }
    
    public function execute($value) {
        $this->resetErrors();
        $this->validateRequired($value);
        $this->doValidate($value);
    }
    
    protected function resetErrors() {
        $this->errors = array();
    }
    
    protected function validateRequired($value) {
        if (!$this->getOption('required')) return;        
        if (trim($value)) return;
        $this->errors[] = beArray::get($this->messages, 'required');
    }
    
    protected function doValidate($value) {
        
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
}